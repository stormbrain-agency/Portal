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
use App\Models\W9Upload;
use App\Models\W9DownloadHistory;
use App\Models\PaymentReport;
use App\Models\PaymentReportDownloadHistory;
use App\Models\MracArac;
use App\Models\MracAracDownloadHistory;
class UsersActivityDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query));
    }
    /**
     * Get the query source of dataTable.
     */
    public function query(W9Upload $model): QueryBuilder
    {
        $query = $model->newQuery();
        $query->select('user_id', DB::raw("'submit' AS action"), DB::raw("'w9_upload' AS fc"), 'created_at AS time')
            ->from('w9_upload')
            ->unionAll($model->select('user_id', DB::raw("'submit'"), DB::raw("'payment_report' AS fc"), 'created_at AS time') // Giữ nguyên tên cột
                ->from('payment_report'))
            ->unionAll($model->select('user_id', DB::raw("'submit'"), DB::raw("'mrac_arac' AS fc"), 'created_at AS time') // Giữ nguyên tên cột
                ->from('mrac_arac'))
            ->unionAll($model->select('user_id', DB::raw("'download'"), DB::raw("'w9_download_history' AS fc"), 'created_at AS time') // Giữ nguyên tên cột
                ->from('w9_download_history'))
            ->unionAll($model->select('user_id', DB::raw("'download'"), DB::raw("'payment_report_download_history' AS fc"), 'created_at AS time') // Giữ nguyên tên cột
                ->from('payment_report_download_history'))
            ->unionAll($model->select('user_id', DB::raw("'download'"), DB::raw("'mrac_arac_download_history' AS fc"), 'created_at AS time') // Giữ nguyên tên cột
                ->from('mrac_arac_download_history'))
            ->orderBy('time', 'DESC');
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
            ->addTableClass('table align-middle table-row-dashed fs-6 gy-5 dataTable no-footer text-gray-600 fw-semibold')
            ->setTableHeadClass('text-start text-muted fw-bold fs-7 text-uppercase gs-0')
            ->orderBy(1);
    }
    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('user_id')->title('User ID'),
            Column::make('action')->title('Action'),
            Column::make('fc')->title('Function'),
            Column::make('time')->title('Time'),
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