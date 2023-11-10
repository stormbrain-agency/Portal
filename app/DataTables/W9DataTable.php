<?php

namespace App\DataTables;

use App\Models\W9Upload;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
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
        //get db data
            ->rawColumns(['user', 'date', 'country', 'action']) // Add other columns as needed
            ->editColumn('user', function (W9Upload $upload) {
                return $upload->user->first_name . ' ' . $upload->user->last_name;
            })
            ->editColumn('date', function (W9Upload $upload) {
                return $upload->created_at->toDateString();
            })
            ->editColumn('country', function (W9Upload $upload) {
                return $upload->country;
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
 
            ->rawColumns(['w9_file_path'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(W9Upload $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('w9-upload-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('rt' . "<'row'<'col-sm-12 col-md-5'l><'col-sm-12 col-md-7'p>>")
            ->addTableClass('table align-middle table-row-dashed fs-6 gy-5 dataTable no-footer text-gray-600 fw-semibold')
            ->setTableHeadClass('text-start text-muted fw-bold fs-7 text-uppercase gs-0')
            ->orderBy(1);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        //view layout
        return [
            Column::make('date')->title('Date of submissions'),
            Column::make('country')->title('Country Designation'),
            Column::make('user')->title('User of submission'),
            Column::make('comment')->title('Comment'),
            Column::make('filename')->title('File Name Submitted'),
            // add column action
            // Column::computed('action')
            //     ->exportable(false)
            //     ->printable(false)
            //     ->width(60)
            Column::make('w9_file_path')->title('Download')->searchable(false)->orderable(false),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'W9Upload_' . date('YmdHis');
    }
}