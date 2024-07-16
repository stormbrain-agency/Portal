<?php

namespace App\Http\Controllers\Apps;

use App\DataTables\PaymentReportDataTable;
use App\Http\Controllers\Controller;
use App\Models\PaymentReport;
use App\Models\PaymentReportFiles;
use App\Models\TemplateFiles;
use App\Models\PaymentReportDownloadHistory;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\County;
use Illuminate\Http\Request;
use League\Csv\Writer;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Mail\PaymentReportMailAdmin;
use App\Mail\PaymentReportMailUser;

class PaymentReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(PaymentReportDataTable $dataTable)
    {
        return $dataTable->with([
            'user' => auth()->user(),
        ])->render('pages.apps.payment-report.list');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("pages.apps.payment-report.create");
    }

    /**
     * Store a newly created resource in storage.
     */
   public function store(Request $request)
    {
        $request->validate([
            'month_year' => 'required',
            'payment_report_files' => 'required|array',
            'payment_report_files.*' => 'required|file|max:20480',
            'comment' => 'nullable|max:150',
        ], [
            'month_year.required' => 'The month and year field is required.',
            'payment_report_files.required' => 'The payment report files field is required.',
            'payment_report_files.*.file' => 'Each payment report file must be a file.',
            // 'payment_report_files.*.mimes' => 'Each payment report file must be of type: .csv',
            'payment_report_files.*.max' => 'Each payment report file may not be greater than 20MB.',
            'comment.max' => 'The comment field must not exceed 150 characters.',
        ]);

        foreach ($request->file('payment_report_files') as $uploadedFile) {
            if ($uploadedFile->isValid()) {
                $extension = $uploadedFile->getClientOriginalExtension();
                if ($extension !== 'csv') {
                    return redirect('county-provider-payment-report/create')->with('error', 'Only CSV files are allowed.');
                }
            }else{
                return redirect('/county-provider-payment-report/create')->with('error', 'File upload failed.');
            }

        }

        $user = Auth::user();
        $countyFips = $user ? ($user->county_designation ?? '') : '';

        $paymentReport = PaymentReport::create([
            'month_year' => $request->month_year,
            'county_fips' => $countyFips,
            'user_id' => $user->id,
            'comments' => $request->comment,
        ]);

        foreach ($request->file('payment_report_files') as $uploadedFile) {
            if ($uploadedFile->isValid()) {
                $extension = $uploadedFile->getClientOriginalExtension();
                $currentDateTime = date('Ymd_His');
                $uniqueFileName = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME) . "_$currentDateTime.$extension";

                $path_name = $uploadedFile->storeAs('uploads/payment_reports', $uniqueFileName);

                PaymentReportFiles::create([
                    'payment_report_id' => $paymentReport->id,
                    'file_path' => $uniqueFileName,
                ]);
            } else {
                // Handle file upload error
                return redirect('/county-provider-payment-report/create')->with('error', 'File upload failed.');
            }
        }

        $adminEmails = User::whereHas('roles', function ($query) {
            $query->where('name', 'admin');
        })->pluck('email');

        $data = [
            'email' => $user->email,
            'name' => $user->first_name .' ' . $user->last_name,
            'county_designation' => $user->county?->county ?? "",
            'time' => $paymentReport->created_at,
            'month_year' => $paymentReport->month_year,
        ];

        foreach($adminEmails as $adminEmail){
            try {
                Mail::to($adminEmail)->send(new PaymentReportMailAdmin($data));
            } catch (\Exception $e) {
                Log::error('Error sending email to admins: ' . $e->getMessage());
            }

        }
        try {
            $userEmail = $user->email;
            Mail::to($userEmail)->send(new PaymentReportMailUser($data));
        } catch (\Exception $e){
            Log::error('Error sending email to user: ' . $e->getMessage());
        }

        return redirect('/county-provider-payment-report/create')->with('success', 'Files uploaded successfully.');
    }

    public function template()
    {
        return view("pages.apps.payment-report.template");
    }

    public function store_template(Request $request)
    {
        // Validator::validate($request->all(), [
        //     'payment_report_file' => [
        //         'required',
        //         File::types(['csv', 'mp4'])
        //             ->max(12 * 1024),
        //     ]
        // ]);
        $request->validate([
            'payment_report_file' => 'required|file|mimes:zip,doc,docx,xls,xlsx,csv,pdf|max:20480',
        ], [
            'payment_report_file.required' => 'Please choose a file.',
            'payment_report_file.file' => 'The file must be a valid file.',
            'payment_report_file.mimes' => 'The file must be of type: zip, doc, docx, xls, xlsx, csv, pdf.',
            'payment_report_file.max' => 'The file may not be greater than 20MB.',
        ]);



        $uploadedFile = $request->file('payment_report_file');

        if ($uploadedFile->isValid()) {
            $extension = $uploadedFile->getClientOriginalExtension();
            $currentDateTime = date('Ymd_His');
            $uniqueFileName = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME) . "_$currentDateTime.$extension";

            $path_name = $uploadedFile->storeAs('uploads/templates', $uniqueFileName);
            TemplateFiles::where('type', 'payment_report')->delete();
            TemplateFiles::create([
                'type' => "payment_report",
                'file_path' => $uniqueFileName,
            ]);

            return redirect('/county-provider-payment-report/template')->with('success', 'File uploaded successfully.');
        } else {
            return redirect('/county-provider-payment-report/template')->with('error', 'File upload failed.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
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
        if (auth()->user()->hasRole('admin') || auth()->user()->hasRole('manager')) {
            $file = storage_path('app/uploads/payment_reports/'. $filename);
            if (file_exists($file)) {
                return response()->download($file);
            } else {
                return redirect('/county-provider-payment-report')->with('error', 'File not found.');
            }
        }
        else{
            return redirect('/county-provider-payment-report')->with('error', 'No file found to download.');
        }
    }

     public function downloadTemplateFile()
    {
        $latestTemplateFile = TemplateFiles::where('type', 'payment_report')->latest()->first();
        if (isset($latestTemplateFile) && !empty($latestTemplateFile)) {
            $filename = $latestTemplateFile->file_path;
            $file = storage_path('app/uploads/templates/'. $filename);
            if (file_exists($file)) {
                return response()->download($file);
            } else {
                return redirect()->back()->with('error', 'Payment Resport Template File not found.');
            }
        }else {
                return redirect()->back()->with('error', 'Payment Resport Template File not found.');
        }
    }

    public function downloadTemplate()
    {
        $filename = "PaymentReportTemplate.xlsx";
        $path = public_path("libs/templates/{$filename}");

        if (file_exists($path)) {
            return response()->download($path);
        }else {
            return redirect()->back()->with('error', 'mRec/aRec Template File not found.');
        }
    }
    public function downloadAllFiles($payment_id)
    {
        $user_id = Auth::id();
        PaymentReportDownloadHistory::create([
            'payment_report_id'=>$payment_id,
            'user_id'=>$user_id
        ]);
        $payment_report_files = PaymentReportFiles::where("payment_report_id", $payment_id)->get();

        if ($payment_report_files && count($payment_report_files) > 0) {
            foreach($payment_report_files as $payment_report_file){
                $filename = $payment_report_file->file_path;
                $file = storage_path('app/uploads/templates/'. $filename);
                if (file_exists($file)) {
                    $download =  response()->download($file);
                }
            }
        }else {
            return redirect('/county-provider-payment-report')->with('error', 'File not found.');
        }
    }
    public function csv(PaymentReportDataTable $dataTable)
    {
        return $dataTable->csv();
    }

    public function delete(Request $request, $id)
    {
        if (auth()->user()->hasRole('admin')) {
            $payment_report = PaymentReport::findOrFail($id);
            if ($payment_report) {
                $payment_report->delete();
                return response()->json(['success' => 'Payment Report deleted successfully.']);
            } else {
                return response()->json(['error' => 'Payment Report not found.'], 404);
            }
        } else {
            return response()->json(['error' => 'You do not have permission to delete.'], 403);
        }
    }

    public function deleteDownloadHistory(Request $request, $id)
    {
        if (auth()->user()->hasRole('admin')) {
            $payment_report_download_history = PaymentReportDownloadHistory::where('payment_report_id', $id);
            if ($payment_report_download_history) {
                $payment_report_download_history->delete();
                return response()->json(['success' => 'Payment Report deleted successfully.']);
            } else {
                return response()->json(['error' => 'Payment Report not found.'], 404);
            }
        } else {
            return response()->json(['error' => 'You do not have permission to delete.'], 403);
        }
    }
}
