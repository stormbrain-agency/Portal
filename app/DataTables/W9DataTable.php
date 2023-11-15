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
            ->editColumn('user', function (W9Upload $upload) {
                // return $upload->user->first_name . ' ' . $upload->user->last_name;
                return view('pages.apps.provider-w9.columns._user', compact('upload'));
            })

            ->editColumn('created_at', function (W9Upload $upload) {
                return $upload->created_at->toDateString();;
            })
            ->editColumn('updated_at', function (W9Upload $upload) {
                return $upload->created_at->toTimeString();
            })
            ->addColumn('w9_county_fips', function (W9Upload $upload) {
                return $upload->county_full;
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
              ->select('w9_upload.*', 'counties.county_full'); 
    
        if (auth()->user()->hasRole('county user')) {
            $query->where('users.id', auth()->user()->id);
        }
    
        return $query;
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
        if (auth()->user()->hasRole('view only')) {
            return [
                Column::make('created_at')->title('Date of submissions'),
                Column::make('updated_at')->title('Time of submissions')->name('w9_upload.created_at')->orderable(true),
                Column::make('w9_county_fips')->title('Country Designation')->name('counties.county_full')->orderable(true)->searchable(true),
                Column::make('user')->title('User of submission')->name('users.first_name')->orderable(true),
                Column::make('comment')->title('Comment')->searchable(false)->orderable(false),
                Column::make('filename')->title('File Name Submitted')->searchable(false)->orderable(false),
            ];
        } else {
            return [
                Column::make('created_at')->title('Date of submissions'),
                Column::make('updated_at')->title('Time of submissions')->name('w9_upload.created_at')->orderable(true),
                Column::make('w9_county_fips')->title('Country Designation')->name('counties.county_full')->orderable(true)->searchable(true),
                Column::make('user')->title('User of submission')->name('users.first_name')->orderable(true),
                Column::make('comment')->title('Comment')->searchable(false)->orderable(false),
                Column::make('filename')->title('File Name Submitted')->searchable(false)->orderable(false),
                Column::make('w9_file_path')->title('Download')->searchable(false)->orderable(false),
            ];
        }
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'W9Upload_' . date('YmdHis');
    }
}