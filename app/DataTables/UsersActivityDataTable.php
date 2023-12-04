<?php

namespace App\DataTables;

use Carbon\Carbon;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Models\W9Upload;
use App\Models\W9DownloadHistory;
use App\Models\PaymentReport;
use App\Models\PaymentReportDownloadHistory;
use App\Models\MracArac;
use App\Models\MracAracDownloadHistory;
use App\Models\User;

class UsersActivityDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
         ->editColumn('first_name', function ($data) {
            return view('pages.apps.activity-management.columns._user', compact('data'));
        })
        ->editColumn('action', function ($data) {
            return ucfirst($data->action);
        })
        ->editColumn('fc', function ($data) {
            return $data->fc;
        })
        ->editColumn('user_id', function ($data) {
            return optional($data->time)->toDateString();
        });

    }

    /**
     * Get the query source of dataTable.
     */
   public function query(User $model, Request $request): QueryBuilder
{
    $user_id = $request->route('user_id');
    $query = $model->newQuery();
    if (!isset($user_id) || empty($user_id)) {
        $query->select(
        'users.id as user_id',
        'users.email',
        DB::raw("'submit' AS action"),
        DB::raw('CASE WHEN w9_upload.id IS NOT NULL THEN "County W9" WHEN payment_report.id IS NOT NULL THEN "Payment Report" WHEN mrac_arac.id IS NOT NULL THEN "Mrac Arac" END AS fc'),
        'users.first_name',
        'users.last_name',
        'w9_upload.created_at AS time'
    )
        ->from('w9_upload')
        ->leftJoin('users', 'w9_upload.user_id', '=', 'users.id')
        ->leftJoin('payment_report', 'w9_upload.id', '=', 'payment_report.id')
        ->leftJoin('mrac_arac', 'w9_upload.id', '=', 'mrac_arac.id')
        ->unionAll($model->select(
            'users.id as user_id',
            'users.email',
            DB::raw("'submit'"),
            DB::raw("'Payment Report'"),
            'users.first_name',
            'users.last_name',
            'payment_report.created_at AS time'
        )->from('payment_report')
            ->leftJoin('users', 'payment_report.user_id', '=', 'users.id')
            ->leftJoin('w9_upload', 'w9_upload.id', '=', 'payment_report.id')
            ->leftJoin('mrac_arac', 'w9_upload.id', '=', 'mrac_arac.id'))
        ->unionAll($model->select(
            'users.id as user_id',
            'users.email',
            DB::raw("'submit'"),
            DB::raw("'Mrac Arac'"),
            'users.first_name',
            'users.last_name',
            'mrac_arac.created_at AS time'
        )->from('mrac_arac')
            ->leftJoin('users', 'mrac_arac.user_id', '=', 'users.id')
            ->leftJoin('w9_upload', 'w9_upload.id', '=', 'mrac_arac.id')
            ->leftJoin('payment_report', 'w9_upload.id', '=', 'payment_report.id'))
        ->unionAll($model->select(
            'users.id as user_id',
            'users.email',
            DB::raw("'download'"),
            DB::raw("'County W9'"),
            'users.first_name',
            'users.last_name',
            'w9_download_history.created_at AS time'
        )->from('w9_download_history')
            ->leftJoin('users', 'w9_download_history.user_id', '=', 'users.id')
            ->leftJoin('w9_upload', 'w9_upload.id', '=', 'w9_download_history.id')
            ->leftJoin('payment_report', 'w9_upload.id', '=', 'payment_report.id')
            ->leftJoin('mrac_arac', 'w9_upload.id', '=', 'mrac_arac.id'))
        ->unionAll($model->select(
            'users.id as user_id',
            'users.email',
            DB::raw("'download'"),
            DB::raw("'Payment Report'"),
            'users.first_name',
            'users.last_name',
            'payment_report_download_history.created_at AS time'
        )->from('payment_report_download_history')
            ->leftJoin('users', 'payment_report_download_history.user_id', '=', 'users.id')
            ->leftJoin('w9_upload', 'w9_upload.id', '=', 'payment_report_download_history.id')
            ->leftJoin('payment_report', 'w9_upload.id', '=', 'payment_report.id')
            ->leftJoin('mrac_arac', 'w9_upload.id', '=', 'mrac_arac.id'))
        ->unionAll($model->select(
            'users.id as user_id',
            'users.email',
            DB::raw("'download'"),
            DB::raw("'Mrac Arac'"),
            'users.first_name',
            'users.last_name',
            'mrac_arac_download_history.created_at AS time'
        )->from('mrac_arac_download_history')
            ->leftJoin('users', 'mrac_arac_download_history.user_id', '=', 'users.id')
            ->leftJoin('w9_upload', 'w9_upload.id', '=', 'mrac_arac_download_history.id')
            ->leftJoin('payment_report', 'w9_upload.id', '=', 'payment_report.id')
            ->leftJoin('mrac_arac', 'w9_upload.id', '=', 'mrac_arac.id'));
    }else{
        $query->select(
            'users.id as user_id',
            'users.email',
            DB::raw("'submit' AS action"),
            DB::raw('CASE WHEN w9_upload.id IS NOT NULL THEN "County W9" WHEN payment_report.id IS NOT NULL THEN "Payment Report" WHEN mrac_arac.id IS NOT NULL THEN "Mrac Arac" END AS fc'),
            'users.first_name',
            'users.last_name',
            'w9_upload.created_at AS time'
        )
        ->from('w9_upload')
        ->where("users.id", '=', $user_id)
        ->leftJoin('users', 'w9_upload.user_id', '=', 'users.id')
        ->leftJoin('payment_report', 'w9_upload.id', '=', 'payment_report.id')
        ->leftJoin('mrac_arac', 'w9_upload.id', '=', 'mrac_arac.id')
        ->unionAll($model->select(
            'users.id as user_id',
            'users.email',
            DB::raw("'submit'"),
            DB::raw("'Payment Report'"),
            'users.first_name',
            'users.last_name',
            'payment_report.created_at AS time'
        )->from('payment_report')
            ->where("users.id", '=', $user_id)
            ->leftJoin('users', 'payment_report.user_id', '=', 'users.id')
            ->leftJoin('w9_upload', 'w9_upload.id', '=', 'payment_report.id')
            ->leftJoin('mrac_arac', 'w9_upload.id', '=', 'mrac_arac.id'))
        ->unionAll($model->select(
            'users.id as user_id',
            'users.email',
            DB::raw("'submit'"),
            DB::raw("'Mrac Arac'"),
            'users.first_name',
            'users.last_name',
            'mrac_arac.created_at AS time'
        )->from('mrac_arac')
            ->where("users.id", '=', $user_id)
            ->leftJoin('users', 'mrac_arac.user_id', '=', 'users.id')
            ->leftJoin('w9_upload', 'w9_upload.id', '=', 'mrac_arac.id')
            ->leftJoin('payment_report', 'w9_upload.id', '=', 'payment_report.id'))
        ->unionAll($model->select(
            'users.id as user_id',
            'users.email',
            DB::raw("'download'"),
            DB::raw("'County W9'"),
            'users.first_name',
            'users.last_name',
            'w9_download_history.created_at AS time'
        )->from('w9_download_history')
            ->where("users.id", '=', $user_id)
            ->leftJoin('users', 'w9_download_history.user_id', '=', 'users.id')
            ->leftJoin('w9_upload', 'w9_upload.id', '=', 'w9_download_history.id')
            ->leftJoin('payment_report', 'w9_upload.id', '=', 'payment_report.id')
            ->leftJoin('mrac_arac', 'w9_upload.id', '=', 'mrac_arac.id'))
        ->unionAll($model->select(
            'users.id as user_id',
            'users.email',
            DB::raw("'download'"),
            DB::raw("'Payment Report'"),
            'users.first_name',
            'users.last_name',
            'payment_report_download_history.created_at AS time'
        )->from('payment_report_download_history')
            ->where("users.id", '=', $user_id)
            ->leftJoin('users', 'payment_report_download_history.user_id', '=', 'users.id')
            ->leftJoin('w9_upload', 'w9_upload.id', '=', 'payment_report_download_history.id')
            ->leftJoin('payment_report', 'w9_upload.id', '=', 'payment_report.id')
            ->leftJoin('mrac_arac', 'w9_upload.id', '=', 'mrac_arac.id'))
        ->unionAll($model->select(
            'users.id as user_id',
            'users.email',
            DB::raw("'download'"),
            DB::raw("'Mrac Arac'"),
            'users.first_name',
            'users.last_name',
            'mrac_arac_download_history.created_at AS time'
        )->from('mrac_arac_download_history')
            ->where("users.id", '=', $user_id)
            ->leftJoin('users', 'mrac_arac_download_history.user_id', '=', 'users.id')
            ->leftJoin('w9_upload', 'w9_upload.id', '=', 'mrac_arac_download_history.id')
            ->leftJoin('payment_report', 'w9_upload.id', '=', 'payment_report.id')
            ->leftJoin('mrac_arac', 'w9_upload.id', '=', 'mrac_arac.id'));
        // ->where("users.id", '=', '1');
        // ->orderBy('time', 'DESC');
        if ($user_id) {
            $query->where('users.id', '=', $user_id);
        }
    }
    

     \Log::info('SQL:', ['query' => $query->toSql()]);
    \Log::info('Value:', ['bindings' => $query->getBindings()]);
    return $query;
}


    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('activity-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->addTableClass('table align-middle table-row-dashed fs-6 gy-5 dataTable no-footer text-gray-600 fw-semibold')
            ->setTableHeadClass('text-start text-muted fw-bold fs-7 text-uppercase gs-0')
            ->orderBy(3)
            ->buttons([
                [
                    'extend' => 'csv',
                    'text' => 'Export CSV',
                    'filename' => 'Activity of Users',
                    'exportOptions' => [
                        'columns' => ':visible',
                        'modifier' => [
                            'page' => 'all',
                        ],
                    ],

                ]
            ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('first_name')->name('first_name')->title('Full Name')->orderable(true),
            // Column::make('full_name')->name('full_name')->title('Full Name')->orderable(true),
            Column::make('action')->title('Action')->orderable(true),
            Column::make('fc')->title('Function')->orderable(true),
            Column::make('time')->name("time")->title('Time')->orderable(true),
            // Column::make('user_id'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'UsersActivity' . date('YmdHis');
    }
}
