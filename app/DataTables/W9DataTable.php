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
                return $upload->id;
            })

            ->editColumn('user', function (W9Upload $upload) {
                return view('pages.apps.provider-w9.columns._user', compact('upload'));
            })

            ->editColumn('created_at', function (W9Upload $upload) {
                return $upload->created_at->toDateString();;
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

            ->editColumn('w9_file_path', function(W9Upload $user) {
                return '<a href="' . route('w9_upload.w9_download', ['filename' => $user->original_name]) . '" class="btn btn-primary">Download</a>';
            })
 
            ->addColumn('user_first_name', function (W9Upload $upload) {
                return $upload->user->first_name;
            })

            ->addColumn('email', function (W9Upload $upload) {
                return $upload->user->email;
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
              ->select('w9_upload.*', 'counties.*','w9_upload.id'); 
        
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
            ->buttons([
                [
                    'extend' => 'csv',
                    'text' => 'Export CSV',
                    'filename' => 'County Provide W-9',
                    'exportOptions' => [
                        'columns' => ':not(:last-child)',
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
                // Column::make('id')->title('ID'),
                Column::make('created_at')->title('Date of submissions'),
                Column::make('updated_at')->title('Time of submissions')->name('w9_upload.created_at')->orderable(true),
                Column::make('w9_county_fips')->title('Country Designation')->name('counties.county')->orderable(true)->searchable(true),
                Column::make('user')->title('User of submission')->name('users.first_name')->orderable(true),
                Column::make('email')->name("users.email")->visible(false),
                Column::make('comment')->title('Comment')->searchable(false)->orderable(false),
                Column::make('filename')->title('File Name Submitted')->searchable(false)->orderable(false),
            ];
        } else {
            return [
                // Column::make('id')->title('ID'),
                Column::make('created_at')->title('Date of submissions'),
                Column::make('updated_at')->title('Time of submissions')->name('w9_upload.created_at')->orderable(true),
                Column::make('w9_county_fips')->title('Country Designation')->name('counties.county')->orderable(true)->searchable(true),
                Column::make('user')->title('User of submission')->name('users.first_name')->orderable(true),
                Column::make('email')->name("users.email")->visible(false),
                Column::make('comment')->title('Comment')->searchable(false)->orderable(false),
                Column::make('filename')->title('File Name Submitted')->searchable(false)->orderable(false),
                Column::make('w9_file_path')->title('Download')->searchable(false)->orderable(false),
            ];
        }
    }
}