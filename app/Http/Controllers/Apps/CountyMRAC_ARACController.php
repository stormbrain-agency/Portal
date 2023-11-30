<?php

namespace App\Http\Controllers\Apps;

use App\DataTables\MracAracDataTable;
use App\Http\Controllers\Controller;
use App\Models\MracArac;
use App\Models\MracAracFiles;
use App\Models\TemplateFiles;
use App\Models\MracAracDownloadHistory;
use Illuminate\Support\Facades\Auth;
use App\Models\County; 
use App\Models\User; 
use Illuminate\Http\Request;
use League\Csv\Writer;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class CountyMRAC_ARACController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(MracAracDataTable $dataTable)
    {
        return $dataTable->with([
            'user' => auth()->user(),
        ])->render('pages.apps.mrac_arac.list');
    }

    public function create()
    {
        return view("pages.apps.mrac_arac.create");
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'month_year' => 'required',
            'mrac_arac_files' => 'required',
            'comment' => 'nullable|max:150',
        ], [
            'month_year.required' => 'The month and year field is required.',
            'mrac_arac_files.required' => 'The Mrac Arac Files field is required.',
            'comment.max' => 'The comment field must not exceed 150 characters.',
        ]);


        $user = Auth::user();
        $countyFips = $user ? ($user->county_designation ?? '') : '';

        $mracArac = MracArac::create([
            'month_year' => $request->month_year,
            'county_fips' => $countyFips,
            'user_id' => $user->id,
            'comments' => $request->comment,
        ]);

        foreach ($request->file('mrac_arac_files') as $uploadedFile) {
            if ($uploadedFile->isValid()) {
                $extension = $uploadedFile->getClientOriginalExtension();
                $currentDateTime = date('Ymd_His');
                $uniqueFileName = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME) . "_$currentDateTime.$extension";
                
                $path_name = $uploadedFile->storeAs('uploads/mrac_arac', $uniqueFileName);

                MracAracFiles::create([
                    'mrac_arac_id' => $mracArac->id,
                    'file_path' => $uniqueFileName,
                ]);
            } else {
                // Handle file upload error
                return redirect('/county-mrac-arac/create')->with('error', 'File upload failed.');
            }
        }

        $adminEmails = User::whereHas('roles', function ($query) {
            $query->where('name', 'admin')->orWhere('name', 'manager');
        })->pluck('email');

        $data = [
            'email' => $user->email,
            'name' => $user->first_name .' ' . $user->last_name,
            'county_designation' => $user->county->county ?? "",
            'time' => $mracArac->created_at,
        ];

        // foreach($adminEmails as $adminEmail){
        //     try {
        //         Mail::send('mail.admin.mrac-arac', $data, function ($message) use ($adminEmail) {
        //             $message->to($adminEmail);
        //             $message->subject('Alert: MRAC/ARAC Submission Received');
        //         });
        //     } catch (\Exception $e) {
        //         Log::error('Error sending email to admins: ' . $e->getMessage());
        //     }
        // }
        try {
            Mail::send('mail.admin.mrac-arac', $data, function ($message) use ($adminEmails) {
                $message->to($adminEmails);
                $message->subject('Alert: MRAC/ARAC Submission Received');
            });
        } catch (\Exception $e) {
            Log::error('Error sending email to admins: ' . $e->getMessage());
        }

        // try {
        //     $userEmail = $user->email;
        //     Mail::send('mail.user.mrac-arac', $data, function ($message) use ($userEmail) {
        //         $message->to($userEmail);
        //         $message->subject('Confirmation: MRAC/ARAC Submission Received');
        //     });
        // } catch (\Exception $e) {
        //     Log::error('Error sending email to user: ' . $e->getMessage());
        // }

        return redirect('/county-mrac-arac/create')->with('success', 'Files uploaded successfully.');
    }
    public function template()
    {
        return view("pages.apps.mrac_arac.template");
    }

    public function store_template(Request $request)
    {
        $request->validate([
            'payment_report_file' => 'required|file',
        ], [
            'payment_report_file.required' => 'Please choose a file.',
            'payment_report_file.file' => 'The file must be a valid file.',
        ]);

        $uploadedFile = $request->file('payment_report_file');

        if ($uploadedFile->isValid()) {
            $extension = $uploadedFile->getClientOriginalExtension();
            $currentDateTime = date('Ymd_His');
            $uniqueFileName = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME) . "_$currentDateTime.$extension";
            
            $path_name = $uploadedFile->storeAs('uploads/templates', $uniqueFileName);
            TemplateFiles::where('type', 'mrac_arac')->delete();
            TemplateFiles::create([
                'type' => "mrac_arac",
                'file_path' => $uniqueFileName,
            ]);

            return redirect('/county-mrac-arac/template')->with('success', 'File uploaded successfully.');
        } else {
            return redirect('/county-mrac-arac/template')->with('error', 'File upload failed.');
        }
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function downloadFile($filename)
    {
        $file = storage_path('app/uploads/mrac_arac/'. $filename);
        if (file_exists($file)) {
            return response()->download($file);
        } else {
            return redirect('/county-mrac-arac')->with('error', 'File not found.');
        }
    }

     public function downloadTemplateFile()
    {
        $latestTemplateFile = TemplateFiles::where('type', 'mrac_arac')->latest()->first();
        if (isset($latestTemplateFile) && !empty($latestTemplateFile)) {  
            $filename = $latestTemplateFile->file_path;
            $file = storage_path('app/uploads/templates/'. $filename);
            if (file_exists($file)) {
                return response()->download($file);
            } else {
                return redirect()->back()->with('error', 'MRAC/ARAC Template File not found.');
            }
        }else {
                return redirect()->back()->with('error', 'MRAC/ARAC Template File not found.');
            }
    }
}
