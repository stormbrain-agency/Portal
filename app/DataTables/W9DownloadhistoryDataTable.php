<?php

namespace App\DataTables;

use App\Models\W9Downloadhistory;
use App\Models\W9Upload;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;


class W9DownloadhistoryDataTable extends DataTable
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
            ->rawColumns(['user',  'date']) // Add other columns as needed
            ->editColumn('user', function (W9Downloadhistory $upload) {
                return $upload->user->first_name . ' ' . $upload->user->last_name;
            })
            ->editColumn('date', function (W9Downloadhistory $upload) {
                return $upload->created_at->toDateString();
            })
            ->setRowId('id');
    }


    public function query(W9Downloadhistory $model): QueryBuilder
    {
        return $model->newQuery();
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('w9-downloadhistory')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('rt' . "<'row'<'col-sm-12 col-md-5'l><'col-sm-12 col-md-7'p>>")
            ->addTableClass('table align-middle table-row-dashed fs-6 gy-5 dataTable no-footer text-gray-600 fw-semibold')
            ->setTableHeadClass('text-start text-muted fw-bold fs-7 text-uppercase gs-0')
            ->orderBy(1);
    }

    public function getColumns(): array
    {
        return [
            Column::make('user')->title('User'),
            Column::make('original_name')->title('Downloaded File'),
            Column::make('created_at')->title('Downloaded At'),
        ];
    }

    protected function filename(): string
    {
        return 'W9Downloadhistory_' . date('YmdHis');
    }
}
