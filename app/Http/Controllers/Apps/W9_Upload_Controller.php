<?php

namespace App\Http\Controllers\Apps;

use App\DataTables\UsersDataTable;
use App\DataTables\UsersPendingDataTable;
use App\DataTables\W9DataTable;
use App\Http\Controllers\Controller;
use App\Models\W9Upload;
use App\Models\County; 
use Illuminate\Http\Request;
use League\Csv\Writer;
use App\Models\User;
use App\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;



class W9_Upload_Controller extends Controller
{
    public function wp_upload_index(W9DataTable $dataTable)
    {
        return $dataTable->with([
            'user' => auth()->user(),
        ])->render('pages.apps.provider-w9.w9provider');
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
                $user = auth()->user();
                $newFile = new W9Upload();
                $newFile->date = now();

                $newFile->user_id = $user->id; 
                $newFile->comments = $request->input('comments');
                $newFile->original_name = $uniqueName;
                $newFile->save();
                // Send Mail
                $adminEmails = User::whereHas('roles', function ($query) {
                $query->where('name', 'admin');
                })->pluck('email');
                $user = User::find($newFile->user_id);
                $w9Upload = User::where('user_id', $newFile->user_id);
                if($w9Upload){
                    $submitted = 'submitted';
                }else{
                    $submitted = 'unsubmitted';
                }
                $data = [
                    'data_time_submission' => $newFile->updated_at,
                    'submitted' => $submitted,
                    'user_email_address' => $user->email,
                    'county_designation' => "update",
                    'list_mail_admin' => $adminEmails,
                    'link' => url('/w9_upload'),
                ];
                $dataMail = $user->email;
                $dataMail = $data['list_mail_admin'];
                foreach($dataMail as $emailAdress){
                    Mail::send('mail.emailW9Upload', $data, function ($message) use ($emailAdress) {
                        $message->to($emailAdress);
                        $message->subject('Alert: W-9 Submission Received');
                    });
                }

                $mailUser = $data['user_email_address'];
                Mail::send('mail.emailW9Upload', $data, function ($message) use ($mailUser) {
                    $message->to($mailUser);
                    $message->subject('Confirmation: W-9 Submission Received');
                    $message->body('We have received your W-9 submission. 
                    The details of the submission are as follows: ');
                });

                return redirect('/w9_upload')->with('success', 'File uploaded successfully.');
            } else {
                return redirect('/w9_upload')->with('error', 'Invalid file format. Only ZIP files are allowed.');
            }
        } else {
            return redirect('/w9_upload')->with('error', 'No file selected.');
        }
    }

    public function exportCsv()
    {
        $uploadedFiles = W9Upload::all();

        // Create a CSV writer instance
        $csv = Writer::createFromFileObject(new \SplTempFileObject());

        // Add CSV header
        $csv->insertOne(['Date of Submission', 'Time of Submission','County Designation', 'User who submitted', 'Comment', 'File Name']);

        // Add data rows to CSV
        foreach ($uploadedFiles as $file) {
            $csv->insertOne([
                \Carbon\Carbon::parse($file->created_at)->toDateString(),
                \Carbon\Carbon::parse($file->created_at)->toTimeString(),
                $file->country,
                $file->user,
                $file->comment,
                $file->original_name,
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