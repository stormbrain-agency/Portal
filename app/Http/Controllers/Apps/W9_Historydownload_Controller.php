<?php
namespace App\Http\Controllers\Apps;

use App\DataTables\W9DownloadhistoryDataTable;
use App\Models\W9Downloadhistory;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use League\Csv\Writer;

class W9_Historydownload_Controller extends Controller
{

    public function w9_downloadhistory_index(W9DownloadhistoryDataTable $dataTable)
    {
        return $dataTable->render('pages.apps.provider-w9.w9historydownload');
    }
}