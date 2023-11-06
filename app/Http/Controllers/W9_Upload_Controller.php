<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\W9Upload;
use League\Csv\Writer;
use Stevebauman\Location\Facades\Location;

class W9_Upload_Controller extends Controller
{
    public function getCountry(Request $request)
    {
        $location = Location::get($request->ip);
        if ($location) {
            $country = $location->countryName;
        } else {
            $country = 'Unknown Country';
        }
        return $country;
    }

    public function showUploadForm()
    {
        $uploadedFiles = W9Upload::all();
        return view('upload_form', ['uploadedFiles' => $uploadedFiles]);
    }
    public function uploadFile(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $uploaded_by = auth()->user()->name;
            $filename =  $file->getClientOriginalName();
            $comment = $request->input('comment');
            $country = $this->getCountry($request);
            
            //check comment null
            $commentToSave = $comment ?? '';
            // Save folder upload
            $path = $file->storeAs('uploads', $filename, 'local');
    
            // Save information to database
            $fileRecord = new W9Upload();
            $fileRecord->country = $country;
            $fileRecord->uploaded_by = $uploaded_by;
            $fileRecord->file_name = $filename;
            $fileRecord->comment = $commentToSave;
            $fileRecord->save();
    
            return redirect('/dashboard/w9_upload')->with('success', 'File uploaded successfully.');
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