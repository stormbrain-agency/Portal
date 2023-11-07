<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

use App\Models\W9Upload;
use Carbon\Carbon;

use GeoIp2\Database\Reader;
use Stevebauman\Location\Facades\Location;
use Stevebauman\Location\Facades\Location as FacadesLocation;

class W9_Upload_Controller extends Controller
{
    public function getUploadedFiles()
    {
        $uploadedFiles = W9Upload::all();
        return $uploadedFiles;
    }
    public function getCountry(Request $request)
    {
        $location = Location::get($request->ip);

        if ($location) {
            $country = $location->regionName;
            // dd($country);
        } else {
            $country = 'Unknown Country';
        }
        return $country;
    }

    public function showUploadForm(Request $request)
    {
        $uploadedFiles = $this->getUploadedFiles();
        $month = $request->input('month');
        $year = $request->input('year');

        $startDate = Carbon::create($year, $month, 1)->startOfDay();
        $endDate = $startDate->copy()->endOfMonth();

        $filteredFiles = $uploadedFiles->whereBetween('created_at', [$startDate, $endDate]);

        return view('upload_form', [
            'uploadedFiles' => $filteredFiles,
            'selectedMonth' => $month,
            'selectedYear' => $year,
        ]);
    }
    public function uploadFile(Request $request)
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
                $firstname = auth()->user()->first_name;
                $lastname = auth()->user()->last_name;
                $user = $firstname .''. $lastname;
                $country = $this->getCountry($request);

                $newFile = new W9Upload();
                $newFile->date = now();
                $newFile->country = $country;
                $newFile->user = $user;
                $newFile->comments = $request->input('comments');
                $newFile->original_name = $uniqueName;
                $newFile->save();
                return redirect('/dashboard/w9_upload')->with('success', 'File uploaded successfully.');
            } else {
                return redirect('/dashboard/w9_upload')->with('error', 'Invalid file format. Only ZIP files are allowed.');
            }
        } else {
            return redirect('/dashboard/w9_upload')->with('error', 'No file selected.');
        }
    }
    public function downloadFile($filename)
    {
        $file = storage_path('app/uploads/' . $filename);
        if (file_exists($file)) {
            return response()->download($file);
        } else {
            return redirect('/dashboard/w9_upload')->with('error', 'File not found.');
        }
    }
    
    public function exportCsv()
{
    $uploadedFiles = W9Upload::all();

    // Create a CSV writer instance
    $csv = Writer::createFromFileObject(new \SplTempFileObject());

    // Add CSV header
    $csv->insertOne(['Upload Date', 'Upload Time', 'Uploaded By', 'File Name', 'Comment']);

    // Add data rows to CSV
    foreach ($uploadedFiles as $file) {
        $csv->insertOne([
            \Carbon\Carbon::parse($file->created_at)->toDateString(),
            \Carbon\Carbon::parse($file->created_at)->toTimeString(),
            $file->uploaded_by,
            $file->file_name,
            $file->comment,
        ]);
    }

    // Set response headers for CSV file download
    $headers = [
        'Content-Type' => 'text/csv',
        'Content-Disposition' => 'attachment; filename="export.csv"',
        'Pragma' => 'no-cache',
        'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
        'Expires' => '0',
    ];

    // Create a response with CSV content and headers
    $response = response($csv->output(), 200, $headers);

    return $response;
}
}