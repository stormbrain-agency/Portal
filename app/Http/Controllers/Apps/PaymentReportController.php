<?php

namespace App\Http\Controllers\Apps;

use App\DataTables\PaymentReportDataTable;
use App\Http\Controllers\Controller;
use App\Models\PaymentReport;
use App\Models\PaymentReportFiles;
use App\Models\TemplateFiles;
use App\Models\PaymentReportDownloadHistory;
use Illuminate\Support\Facades\Auth;
use App\Models\County; 
use Illuminate\Http\Request;
use League\Csv\Writer;
use Illuminate\Http\UploadedFile;

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
            'payment_report_files' => 'required',
            'comment' => 'nullable|max:150',
        ]);

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

        return redirect('/county-provider-payment-report/create')->with('success', 'Files uploaded successfully.');
    }

    public function template()
    {
        return view("pages.apps.payment-report.template");
    }

    public function store_template(Request $request)
    {
        $request->validate([
            'payment_report_file' => 'required|file',
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
        $file = storage_path('app/uploads/payment_reports/'. $filename);
        if (file_exists($file)) {
            return response()->download($file);
        } else {
            return redirect('/county-provider-payment-report')->with('error', 'File not found.');
        }
    }

     public function downloadTemplateFile()
    {
        $latestTemplateFile = TemplateFiles::where('type', 'payment_report')->latest()->first();
        $filename = $latestTemplateFile->file_path;
        $file = storage_path('app/uploads/templates/'. $filename);
        if (file_exists($file)) {
            return response()->download($file);
        } else {
            return redirect()->back()->with('error', 'File not found.');
        }
    }

     public function downloadFile2($filename,$payment_id)
    {
        $user_id = Auth::id();
        PaymentReportDownloadHistory::create([
            'payment_report_id'=>$payment_id,
            'user_id'=>$user_id
        ]);
        $file = storage_path('app/uploads/payment_reports/'. $filename);
        if (file_exists($file)) {
            return response()->download($file);
        } else {
            return redirect('/county-provider-payment-report')->with('error', 'File not found.');
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
}
