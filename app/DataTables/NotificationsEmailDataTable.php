<?php

namespace App\DataTables;

use Carbon\Carbon;
use App\Models\NotificationMail;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;

class NotificationsEmailDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */

    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->editColumn('id', function (NotificationMail $notifications) {
                return '#'.$notifications->id.'';
            })
            ->editColumn('name_form', function (NotificationMail $notifications) {
                return $notifications->name_form;
            })
            ->addColumn('subject', function (NotificationMail $notifications) {
                return $notifications->subject;
            })
            ->addColumn('body', function (NotificationMail $notifications) {
                return $notifications->body;
            })
            ->editColumn('button_title', function (NotificationMail $notifications) {
                return $notifications->button_title;
            })
            ->editColumn('action', function (NotificationMail $notifications) {
                return view('pages.apps.notifications-email.columns._edit-action', compact('notifications'));
            })
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(NotificationMail $model): QueryBuilder
    {
        $query = $model->newQuery();
        $query->select('notification_mails.*');

        return $query;
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('notifications-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->addTableClass('table align-middle table-row-dashed fs-6 gy-5 dataTable no-footer text-gray-600 fw-semibold')
            ->setTableHeadClass('text-start text-muted fw-bold fs-7 text-uppercase gs-0')
            ->orderBy([0, 'asc'])
            ->drawCallback("function() {" . file_get_contents(resource_path('views/pages/apps/notifications/columns/_draw-scripts.js')) . "}");
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        //view layout
        return [
            Column::make('id')->title('ID')->orderable(true)->searchable(true)->addClass('fw-bold col-id'),
            Column::make('name_form')->title('Name Form')->orderable(true)->searchable(true)->addClass('fw-bold col-name-form'),
            Column::make('subject')->title('Subject')->orderable(true)->searchable(true)->addClass('fw-bold col-subject'),
            Column::make('body')->title('Schedule')->orderable(true)->searchable(true)->addClass('fw-bold col-body'),
            Column::make('button_title')->title('Type')->name('type')->orderable(true)->searchable(true)->addClass('fw-bold col-button-title'),
            Column::computed('action')
                ->addClass('text-center text-nowrap col-edit')
                ->exportable(false)
                ->printable(false)
                ->width(60),
        ];

    }
}
