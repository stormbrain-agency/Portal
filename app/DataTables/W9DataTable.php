<?php

namespace App\DataTables;

use App\Models\W9Upload;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\DataTableAbstract;
use Yajra\DataTables\Html\Builder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;

class W9DataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->editColumn('id', function (W9Upload $upload) {
                return '#'.$upload->id.''; 
            })

            ->editColumn('user', function (W9Upload $upload) {
                return view('pages.apps.provider-w9.columns._user', compact('upload'));
            })

            ->editColumn('created_at', function (W9Upload $upload) {
                return $upload->created_at->toDateString();
            })
            ->editColumn('updated_at', function (W9Upload $upload) {
                return $upload->created_at->toTimeString();
            })
            ->addColumn('w9_county_fips', function (W9Upload $upload) {
                return $upload->county;
            })
            ->editColumn('comment', function (W9Upload $upload) {
                return $upload->comments;
            })
            ->editColumn('filename', function (W9Upload $upload) {
                return $upload->original_name;
            })

            ->editColumn('w9_file_path', function(W9Upload $upload) {
                return '<a href="' . route('w9_upload.w9_download', ['w9_id' => $upload->id, 'filename' => $upload->original_name]) . '" class="btn btn-primary">Download</a>';
            })
 
            ->addColumn('user_first_name', function (W9Upload $upload) {
                return $upload->user->first_name;
            })

            ->addColumn('email', function (W9Upload $upload) {
                return $upload->user->email;
            })
            ->editColumn('view', function (W9Upload $upload) {
                return view('pages.apps.provider-w9.columns._view-action', compact('upload'));
            })
            ->rawColumns(['user_first_name', 'w9_file_path'])
            ->setRowId('id');
    }
    /**
     * Get the query source of dataTable.
     */
    public function query(W9Upload $model): QueryBuilder
    {
        $query = $model->newQuery();
        
        $query->join('users', 'w9_upload.user_id', '=', 'users.id')
              ->join('counties', 'w9_upload.w9_county_fips', '=', 'counties.county_fips') 
              ->where('users.status', 1)
              ->select('w9_upload.*','w9_upload.created_at', 'counties.county','w9_upload.id'); 
        
        if (auth()->user()->hasRole('county user')) {
            $query->where('users.id', auth()->user()->id);
        }
        
        return $query;
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('w9-upload-table')

            ->columns($this->getColumns())
            ->minifiedAjax()
            ->addTableClass('table align-middle table-row-dashed fs-6 gy-5 dataTable no-footer text-gray-600 fw-semibold')
            ->setTableHeadClass('text-start text-muted fw-bold fs-7 text-uppercase gs-0')
            ->orderBy(1)
            ->drawCallback("function() {" . file_get_contents(resource_path('views/pages/apps/provider-w9/columns/_draw-scripts.js')) . "}")
            ->buttons([
                [
                    'extend' => 'csv',
                    'text' => 'Export CSV',
                    'filename' => 'County Provide W-9',
                    'exportOptions' => [
                        'columns' => ':visible:not(.export-hidden)',
                        'page' => 'all',
                    ],
                ]
            ])
            ->lengthMenu([10, 25, 50, -1], [10, 25, 50, 'All']);;
    }
    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {        
        //view layout
        if (auth()->user()->hasRole('view only')) {
            return [
                Column::make('id')->name("w9_upload.id")->title('ID'),
                Column::make('created_at')->name("w9_upload.created_at")->title('Date')->orderable(true)->searchable(true),
                Column::make('updated_at')->title('Time')->name('w9_upload.created_at')->orderable(true)->searchable(true),
                Column::make('w9_county_fips')->title('Country Designation')->name('counties.county')->orderable(true)->searchable(true),
                Column::make('user')->title('USER WHO SUBMITTED')->name('users.first_name')->orderable(true),
                Column::make('email')->name("users.email")->visible(false),
                Column::make('comment')->title('Comment')->searchable(false)->orderable(false)->width(200),
                // Column::make('w9_file_path')->name("hideexport")->title('Download')->searchable(false)->orderable(false)->visible(false),
                Column::computed('view')
                    ->addClass('text-center text-nowrap')
                    ->exportable(false)
                    ->printable(false)
                    ->width(60),
            ];
        } 
        if (auth()->user()->hasRole('county user')) {
            return [
                Column::make('id')->name("w9_upload.id")->title('ID'),
                Column::make('created_at')->name("w9_upload.created_at")->title('Date')->orderable(true)->searchable(true),
                Column::make('updated_at')->title('Time')->name('w9_upload.created_at')->orderable(true),
                Column::make('w9_county_fips')->title('Country Designation')->name('counties.county')->orderable(true)->searchable(true),
                Column::make('user')->title('USER WHO SUBMITTED')->name('users.first_name')->orderable(true),
                Column::make('email')->name("users.email")->visible(false),
                Column::make('comment')->title('Comment')->searchable(false)->orderable(false)->width(200),
                // Column::make('w9_file_path')->name("hidedownload")->title('Download')->searchable(false)->orderable(false)->visible(false),
            ];
        }else {
            return [
                Column::make('id')->name("w9_upload.id")->title('ID'),
                Column::make('created_at')->name("w9_upload.created_at")->title('Date')->orderable(true)->searchable(true),
                Column::make('updated_at')->title('Time')->name('w9_upload.created_at')->orderable(true),
                Column::make('w9_county_fips')->title('Country Designation')->name('counties.county')->orderable(true)->searchable(true),
                Column::make('user')->title('USER WHO SUBMITTED')->name('users.first_name')->orderable(true),
                Column::make('email')->name("users.email")->visible(false),
                Column::make('comment')->title('Comment')->searchable(false)->orderable(false)->width(200),
                Column::make('w9_file_path')->addClass('export-hidden')->title('Download')->searchable(false)->orderable(false)->visible(true)->exportable(false),
                Column::computed('view')
                    ->addClass('text-center text-nowrap')
                    ->addClass('export-hidden')
                    ->exportable(false)
                    ->printable(false)
                    ->width(60),
            ];
        }
    }
}