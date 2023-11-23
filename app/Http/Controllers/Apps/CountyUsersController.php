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

class CountyUsersController extends Controller
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

    /**
     * Show the form for creating a new resource.
     */
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
                'mrac_arac_id' => $MracArac->id,
                'file_path' => $uniqueFileName,
            ]);
        } else {
            // Handle file upload error
            return redirect('/county-provider-payment-report/create')->with('error', 'File upload failed.');
        }
    }

    return redirect('/county-provider-payment-report/create')->with('success', 'Files uploaded successfully.');
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
        $file = storage_path('app/uploads/mrac_arac/'. $filename);
        if (file_exists($file)) {
            return response()->download($file);
        } else {
            return redirect('/county-provider-payment-report')->with('error', 'File not found.');
        }
    }
}
