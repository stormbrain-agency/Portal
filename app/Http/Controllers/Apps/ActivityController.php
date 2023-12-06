<?php

namespace App\Http\Controllers\Apps;

use App\DataTables\UsersActivityDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request,UsersActivityDataTable $dataTable)
    {
        return $dataTable->render('pages.apps.activity-management.list');
    }

    // public function index()
    // {
    //     return view("pages.apps.activity-management.list3");
    // }

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
    public function show(string $user_id,UsersActivityDataTable $dataTable)
    {
        
       
        return $dataTable->with([
            'user_id' => $user_id,
        ])->render('pages.apps.activity-management.list');
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
}
