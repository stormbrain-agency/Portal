<?php

namespace App\Http\Controllers\Apps;

use App\DataTables\MracAracDataTable;
use App\Http\Controllers\Controller;
use App\Models\MracArac;
use App\Models\MracAracFiles;
use App\Models\MracAracDownloadHistory;
use Illuminate\Support\Facades\Auth;
use App\Models\County; 
use Illuminate\Http\Request;
use League\Csv\Writer;
use Illuminate\Http\UploadedFile;

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

        return redirect('/county-mrac-arac/create')->with('success', 'Files uploaded successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
    
            if ($file->getClientOriginalExtension() === 'zip') {
                $originalName = $file->getClientOriginalName();
    
                $counter = 0;
                $uniqueName = $originalName;
    
                while (file_exists(storage_path('app/uploads/' . $uniqueName))) {
                    $counter++;
                    $pathInfo = pathinfo($originalName);
                    $uniqueName = $pathInfo['filename'] . "($counter)." . $pathInfo['extension'];
                }
    
                $path = $file->storeAs('uploads', $uniqueName, 'local');
                $user = auth()->user();
    
                if ($user->county) {
                    $county = County::join('users', 'counties.county_fips', '=', 'users.county_designation')
                                    ->where('users.id', $user->id)
                                    ->select('counties.county')
                                    ->first();
    
                    if ($county) {
                        $newFile = new W9Upload();
                        $newFile->user_id = $user->id;
                        $newFile->comments = $request->input('comments');
                        $newFile->original_name = $uniqueName;
                        $newFile->w9_county_fips = $user->county_designation;
                        $newFile->save();
                        return redirect('/county-w9/upload')->with('success', 'File uploaded successfully.');
                    }
                }
    
                return redirect('/county-w9/upload')->with('error', 'Error retrieving user county information.');
            } else {
                return redirect('/county-w9/upload')->with('error', 'Invalid file format. Only ZIP files are allowed.');
            }
        } else {
            return redirect('/county-w9/upload')->with('error', 'No file selected.');
        }
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
            return redirect('/county-provider-payment-report')->with('error', 'File not found.');
        }
    }
}
