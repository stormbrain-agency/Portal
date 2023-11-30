<?php

namespace App\DataTables;

use Carbon\Carbon;
use App\Models\Notifications;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;

class NotificationsDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */

    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->editColumn('id', function (Notifications $notifications) {
                return '#'.$notifications->id.'';
            })
            ->editColumn('title', function (Notifications $notifications) {
                return $notifications->title;
            })
            ->addColumn('location', function (Notifications $notifications) {
                return $notifications->location;
            })
            ->addColumn('schedule', function (Notifications $notifications) {
                $scheduleStart = $notifications->schedule_start ? Carbon::parse($notifications->schedule_start) : null;
                $scheduleEnd = $notifications->schedule_end ? Carbon::parse($notifications->schedule_end) : null;

                if ($scheduleStart === null && $scheduleEnd === null) {
                    return "All time";
                } elseif ($scheduleStart->equalTo($scheduleEnd)) {
                    return $scheduleStart->format('M d Y');
                } else {
                    return $scheduleStart->format('M d Y') . ' - ' . $scheduleEnd->format('M d Y');
                }
            })
            ->addColumn('type', function (Notifications $notifications) {
                return $notifications->type;
            })
            ->editColumn('status', function (Notifications $notifications) {
                return view('livewire.notifications.notification-status', ['notification' => $notifications]);
            })
            ->editColumn('action', function (Notifications $notifications) {
                return view('pages.apps.notifications.columns._edit-action', compact('notifications'));
            })
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Notifications $model): QueryBuilder
    {
        $query = $model->newQuery();
        $query->select('notifications.*');

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
            ->drawCallback("function() {" . file_get_contents(resource_path('views/pages/apps/notifications/columns/_draw-scripts.js')) . "}")
            ->drawCallback("
                function() {
                    $('.status-toggle').on('click', function () {
                        var statusCheckbox = $(this);
                        var status = statusCheckbox.prop('checked') ? 'Active' : 'Unactive';
                        var notificationId = statusCheckbox.data('notification-id');
                        $.ajax({
                            url: '" . route("notification-management.update-status") . "',
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name=\"csrf-token\"]').attr('content')
                            },
                            data: {
                                id: notificationId,
                                status: status
                            },
                            success: function (response) {
                                console.log(response);
                            },
                            error: function (error) {
                                console.log(error);
                            }
                        });
                    });
                    document.querySelectorAll('td.col-type').forEach(function (element) {
                        var test = document.querySelectorAll('td.col-type')
                        var value = element.textContent.trim();
                        switch (value) {
                            case 'Information':
                                element.classList.add('text-primary');
                                break;
                            case 'Success':
                                element.classList.add('text-success');
                                break;
                            case 'Alert':
                                element.classList.add('text-danger');
                                break;
                            case 'Warning':
                                element.classList.add('text-info');
                                break;
                            default:
                                element.classList.add('text-muted');
                                break;
                        }
                    });
                }
            ");
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        //view layout
        return [
            Column::make('id')->title('ID')->orderable(true)->searchable(true)->addClass('fw-bold col-id'),
            Column::make('title')->title('Title')->orderable(true)->searchable(true)->addClass('fw-bold col-title'),
            Column::make('location')->title('Where to show')->orderable(true)->searchable(true)->addClass('fw-bold col-location'),
            Column::make('schedule')->title('Schedule')->orderable(true)->searchable(true)->addClass('fw-bold col-schedule'),
            Column::make('type')->title('Type')->name('type')->orderable(true)->searchable(true)->addClass('fw-bold col-type'),
            Column::make('status')->title('Status')->name('Status')->orderable(true)->searchable(true)->addClass('fw-bold col-status'),
            Column::computed('action')
                ->addClass('text-center text-nowrap col-edit')
                ->exportable(false)
                ->printable(false)
                ->width(60),
        ];

    }
}
