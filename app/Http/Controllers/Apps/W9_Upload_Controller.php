<?php

namespace App\Http\Controllers\Apps;

use App\DataTables\UsersDataTable;
use App\DataTables\UsersPendingDataTable;
use App\DataTables\W9DataTable;
use App\Http\Controllers\Controller;
use App\Models\W9Upload;    
use App\Models\User;
use App\Models\W9DownloadHistory;
use App\Models\County; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\W9MailAdmin;
use App\Mail\W9MailUser;

// use League\Csv\Writer;
// use Illuminate\Support\Facades\Response;


class W9_Upload_Controller extends Controller
{

    public function wp_upload_index(W9DataTable $dataTable)
    {
        return $dataTable->with([
            'user' => auth()->user(),
        ])->render('pages.apps.provider-w9.list');
    }

    public function upload()
    {
        return view("pages.apps.provider-w9.upload");
    }

    public function downloadFile($w9_id, $filename)
    {
        $file = storage_path('app/uploads/' . $filename);
        if (file_exists($file)) {
            $user_id = Auth::id();
            W9DownloadHistory::create([
                'w9_id'=>$w9_id,
                'user_id'=>$user_id
            ]);

            $headers = [
            'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0',
            'Pragma' => 'no-cache',
            'Expires' => 'Sat, 01 Jan 2000 00:00:00 GMT',
        ];
            return response()->download($file, $filename, $headers);
        } else {
            return redirect('/county-w9')->with('error', 'No file found to download.');
        }
    }



    public function uploadFile(Request $request)
    {
        try{
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
    
                            $adminEmails = User::whereHas('roles', function ($query) {
                                $query->where('name', 'admin')->orWhere('name', 'manager');
                            })->pluck('email');
    
                            $data = [
                                'email' => $user->email,
                                'name' => $user->first_name .' ' . $user->last_name,
                                'county_designation' => $user->county->county ? $user->county->county : "",
                                'time' => $newFile->created_at,
                            ];
    
                            foreach($adminEmails as $adminEmail){
                                try {
                                    Mail::to($adminEmail)->send(new W9MailAdmin($data));
                                } catch (\Exception $e) {
                                    Log::error('Error sending email to admins: ' . $e->getMessage());
                                }
                            }
                            try {
                                $userEmail = $user->email;
                                Mail::to($userEmail)->send(new W9MailUser($data));
                            } catch (\Throwable $th) {
                                Log::error('Error sending email to user: ' . $e->getMessage());
                            }
    
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
        } catch (Exception $e) {
            Log::error('Error uploading file: ' . $e->getMessage());
            return redirect('/county-w9/upload')->with('success', 'File uploaded successfully, but there was an error sending emails.');
        }

    }


}