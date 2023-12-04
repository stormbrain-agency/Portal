<?php

namespace App\DataTables;

use Carbon\Carbon;
use App\Models\PaymentReport;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Response;


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
                // return $payment_report->user->first_name;
                return view('pages.apps.payment-report.columns._user', compact('payment_report'));
            })
            ->editColumn('id', function (PaymentReport $payment_report) {
                return '#'.$payment_report->id.''; 
            })
            ->editColumn('created_at', function (PaymentReport $payment_report) {
                return $payment_report->created_at->toDateString();
            })
            ->editColumn('updated_at', function (PaymentReport $payment_report) {
                return $payment_report->created_at->toTimeString();
            })
            ->editColumn('county_fips', function (PaymentReport $payment_report) {
                return $payment_report->county->county;
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
              ->select('payment_report.*', 'counties.county_full', 'users.email'); 
    
        if (auth()->user()->hasRole('county user')) {
            $query->where('users.id', auth()->user()->id);
        }

        if (request()->has('county_fips')) {
            $query->where('county_fips', request('county_fips'));
        }

        $startDate = request()->get('startDate');
        $endDate = request()->get('endDate');

        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [
                $startDate,
                $endDate,
            ]);
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
            ->addTableClass('table align-middle table-row-dashed fs-6 gy-5 dataTable no-footer text-gray-600 fw-semibold')
            ->setTableHeadClass('text-start text-muted fw-bold fs-7 text-uppercase gs-0')
            ->orderBy(1)
            ->drawCallback("function() {" . file_get_contents(resource_path('views/pages/apps/payment-report/columns/_draw-scripts.js')) . "}")
            ->buttons([
                [
                    'extend' => 'csv',
                    'text' => 'Export CSV',
                    // 'action' => 'function(e, dt, button, config) {
                    //     window.location = "'.route('county-provider-payment-report.csv').'";
                    // }',
                    'filename' => 'County Provider Payment Reports',
                    'exportOptions' => [
                        'columns' => ':visible:not(:nth-child(8))',
                        'modifier' => [
                            'page' => 'all',
                        ],
                    ],

                ]
                ]);
    }


public function csv()
{
    $paymentReport = new PaymentReport; // Create an instance of PaymentReport
    $dataTable = DataTables::of($this->query($paymentReport))
        ->setRowId('id')
        ->addColumn('user_first_name', function (PaymentReport $payment_report) {
            return $payment_report->user->first_name;
        })
        ->addColumn('created_at', function (PaymentReport $payment_report) {
            return $payment_report->created_at->toDateString();
        })
        ->addColumn('county_name', function (PaymentReport $payment_report) {
            return $payment_report->county->county;
        })
        ->addColumn('comment', function (PaymentReport $payment_report) {
            return $payment_report->comments;
        })
        // Add other necessary columns
        ->rawColumns(['user_first_name', 'document_path'])
        ->make(true);

    $data = $dataTable->getData(true);

    $csvFileName = 'payment_reports_' . date('YmdHis') . '.csv';

    $csvContent = fopen('php://temp', 'w');

    // Output CSV header
    fputcsv($csvContent, array_keys($data['data'][0]));

    // Output CSV rows
    foreach ($data['data'] as $row) {
        fputcsv($csvContent, $row);
    }

    rewind($csvContent);

    $csvContent = stream_get_contents($csvContent);

    return response($csvContent)
        ->header('Content-type', 'text/csv')
        ->header('Content-Disposition', "attachment; filename=$csvFileName");
}






    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        //view layout
        if (!auth()->user()->hasRole('county user')) {
            return [
                Column::make('id')->title('ID'),
                Column::make('created_at')->title('Date'),
                Column::make('updated_at')->title('Time'),
                Column::make('county_fips')->title('County Designation')->name('counties.county')->orderable(true)->searchable(true),
                Column::make('user')->title('User')->name('users.first_name')->orderable(true),
                Column::make('month_year')->title('Month/Year')->name('month_year')->orderable(true)->searchable(true)->addClass('text-center'),
                Column::make('comment')->title('Comments')->searchable(false)->orderable(false)->exportable(false)->width(200),
                Column::computed('view')
                    ->addClass('text-center text-nowrap')
                    ->exportable(false)
                    ->printable(false)
                    ->width(60),
                Column::make('email')->name("users.email")->visible(false),
            ];
        }else{
            return [
                Column::make('id')->title('ID'),
                Column::make('created_at')->title('Date'),
                Column::make('updated_at')->title('Time'),
                Column::make('county_fips')->title('County Designation')->name('counties.county')->orderable(true)->searchable(true),
                Column::make('user')->title('User')->name('users.first_name')->orderable(true),
                Column::make('month_year')->title('Month/Year')->name('month_year')->orderable(true)->searchable(true)->addClass('text-center'),
                Column::make('comment')->title('Comments')->searchable(false)->orderable(false)->exportable(false)->width(200),
                Column::computed('view')->visible(false),
                Column::make('email')->name("users.email")->visible(false),
            ];
        }
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'PaymentReport_' . date('YmdHis');
    }
}