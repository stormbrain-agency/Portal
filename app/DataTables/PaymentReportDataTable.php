<?php

namespace App\DataTables;

use App\Models\PaymentReport;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;

class PaymentReportDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */

    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->editColumn('user', function (PaymentReport $payment_report) {
                return view('pages.apps.payment-report.columns._user', compact('payment_report'));
            })

            ->editColumn('created_at', function (PaymentReport $payment_report) {
                return $payment_report->created_at;
            })
            ->addColumn('county_fips', function (PaymentReport $payment_report) {
                return $payment_report->county_full;
            })
            ->editColumn('comment', function (PaymentReport $payment_report) {
                return $payment_report->comments;
            })
            ->addColumn('user_first_name', function (PaymentReport $payment_report) {
                return $payment_report->user->first_name;
            })
            ->editColumn('view', function (PaymentReport $payment_report) {
                return view('pages.apps.payment-report.columns._view-action', compact('payment_report'));
            })
            ->rawColumns(['user_first_name', 'document_path'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(PaymentReport $model): QueryBuilder
    {
        $query = $model->newQuery();
    
        $query->join('users', 'payment_report.user_id', '=', 'users.id')
              ->join('counties', 'payment_report.county_fips', '=', 'counties.county_fips') 
              ->where('users.status', 1)
              ->select('payment_report.*', 'counties.county_full'); 
    
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
            ->setTableId('payment_report-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('rt' . "<'row'<'col-sm-12 col-md-5'l><'col-sm-12 col-md-7'p>>")
            ->addTableClass('table align-middle table-row-dashed fs-6 gy-5 dataTable no-footer text-gray-600 fw-semibold')
            ->setTableHeadClass('text-start text-muted fw-bold fs-7 text-uppercase gs-0')
            ->orderBy(1)
            ->drawCallback("function() {" . file_get_contents(resource_path('views/pages/apps/payment-report/columns/_draw-scripts.js')) . "}");
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        //view layout
        return [
            Column::make('created_at')->title('Date of submissions'),
            Column::make('user')->title('User of submission')->name('users.first_name')->orderable(true),
            Column::make('county_fips')->title('Country Designation')->name('counties.county_full')->orderable(true)->searchable(true),
            Column::make('month')->title('Month')->name('month')->orderable(true)->searchable(true)->addClass('text-center'),
            Column::make('year')->title('Year')->name('year')->orderable(true)->searchable(true),
            Column::make('comment')->title('Comment')->searchable(false)->orderable(false),
            Column::computed('view')
                ->addClass('text-center text-nowrap')
                ->exportable(false)
                ->printable(false)
                ->width(60)
        ];
        
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'PaymentReport_' . date('YmdHis');
    }
}