<?php

namespace App\DataTables;

use App\Models\User;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;

class UsersPendingDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->rawColumns(['user', 'last_login_at'])
            ->editColumn('user', function (User $user) {
                return view('pages.apps.user-management.users-pending.columns._user', compact('user'));
            })
            ->editColumn('status', function (User $user) {
                return view('pages.apps.user-management.users-pending.columns._status', compact('user'));
            })
            ->editColumn('w9_file_path', function (User $user) {
                return $user->w9_file_path;
            })

            ->editColumn('created_at', function (User $user) {
                return $user->created_at->format('d M Y, h:i a');
            })
            ->addColumn('action', function (User $user) {
                return view('pages.apps.user-management.users-pending.columns._actions', compact('user'));
            })
            ->setRowId('id');
    }


    /**
     * Get the query source of dataTable.
     */
    public function query(User $model): QueryBuilder
    {
        return $model->newQuery()->where('status', 0)->orWhereNull('email_verified_at');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('users-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('rt' . "<'row'<'col-sm-12 col-md-5'l><'col-sm-12 col-md-7'p>>",)
            ->addTableClass('table align-middle table-row-dashed fs-6 gy-5 dataTable no-footer text-gray-600 fw-semibold')
            ->setTableHeadClass('text-start text-muted fw-bold fs-7 text-uppercase gs-0')
            ->orderBy(2)
            ->drawCallback("function() {" . file_get_contents(resource_path('views/pages//apps/user-management/users-pending/columns/_draw-scripts.js')) . "}");
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        if (auth()->user()->hasRole('admin')) {
            return [
                Column::make('user')->addClass('d-flex align-items-center')->name('first_name'),
                Column::make('status')->addClass('text-nowrap')->name('status'),
                Column::make('business_phone')->title('Business Phone')->addClass('text-nowrap'),
                Column::make('w9_file_path')->title('W-9 File')->searchable(false)->orderable(false),
                Column::make('created_at')->title('Created Date')->addClass('text-nowrap'),
                Column::computed('action')
                    ->addClass('text-end text-nowrap')
                    ->exportable(false)
                    ->printable(false)
                    ->width(60)
            ];
        }else{
             return [
                Column::make('user')->addClass('d-flex align-items-center')->name('first_name'),
                Column::make('status')->addClass('text-nowrap')->name('status'),
                Column::make('business_phone')->title('Business Phone')->addClass('text-nowrap'),
                Column::make('w9_file_path')->title('W-9 File')->searchable(false)->orderable(false),
                Column::make('created_at')->title('Created Date')->addClass('text-nowrap'),
            ];
        }
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Users_' . date('YmdHis');
    }
}
