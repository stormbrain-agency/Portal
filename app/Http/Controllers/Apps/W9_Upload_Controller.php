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
                    'check' => 'true',
                    'link' => url('/w9_upload'),
                    'subjectUser' => 'Alert: W-9 Submission Received',
                    'subjectAdmin' => 'Confirmation: W-9 Submission Received',
                ];
                $mailAdmin = $data['list_mail_admin'];
                $mailUser = $data['user_email_address'];
                foreach($mailAdmin as $emailAdress){
                    Mail::send('mail.emailW9Upload', $data, function ($message) use ($emailAdress){
                        $message->to($emailAdress);
                        $message->subject('Confirmation: W-9 Submission Received');
                    });
                }
                $data['check'] = true;
                Mail::send('mail.emailW9Upload', $data, function ($message) use ($mailUser){
                    $message->to($mailUser);
                    $message->subject('Alert: W-9 Submission Received');
                });
                return redirect('/w9_upload')->with('success', 'File uploaded successfully.');
            } else {
                return redirect('/w9_upload')->with('error', 'Invalid file format. Only ZIP files are allowed.');
            }
        } else {
            return redirect('/w9_upload')->with('error', 'No file selected.');
        }
    }


}