<?php

namespace App\Http\Controllers\Apps;

use App\DataTables\UsersDataTable;
use App\DataTables\MRACDataTable;
use App\Http\Controllers\Controller;
use App\Models\MRAC;
use Illuminate\Http\Request;

class CountyMRAC_ARACController extends Controller
{

    public function wp_upload_index(MRACDataTable $dataTable)
    {
        return $dataTable->with([
            'user' => auth()->user(),
        ])->render('pages.apps.mrac_arac-submissions.list');
    }

    public function upload()
    {
        return view("pages.apps.mrac_arac-submissions.upload");
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


}