<?php

namespace App\Http\Controllers\Apps;

use App\DataTables\W9DataTable;
use App\Http\Controllers\Controller;
use App\Models\W9Upload;
use Illuminate\Http\Request;

class W9_Upload_Controller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(W9DataTable $dataTable)
    {
        return $dataTable->render('pages.apps.provider-w9.w9provider.blade');
    }
}