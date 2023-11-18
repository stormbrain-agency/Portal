<?php

namespace App\Http\Controllers\Apps;

use App\DataTables\PaymentReportDataTable;
use App\Http\Controllers\Controller;
use App\Models\PaymentReport;
use App\Models\County; 
use Illuminate\Http\Request;
use League\Csv\Writer;

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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        $file = storage_path('app/uploads/payment-reports/'. $filename);
        if (file_exists($file)) {
            return response()->download($file);
        } else {
            return redirect('/county-provider-payment-report')->with('error', 'File not found.');
        }
    }
}
