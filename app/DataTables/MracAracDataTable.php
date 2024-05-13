<?php

namespace App\DataTables;

use Carbon\Carbon;
use App\Models\MracArac;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Response;

class MracAracDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */

    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->editColumn('user', function (MracArac $mrac_arac) {
                // return $mrac_arac->user->first_name;
                return view('pages.apps.mrac_arac.columns._user', compact('mrac_arac'));
            })
            ->editColumn('id', function (MracArac $mrac_arac) {
                return '#'.$mrac_arac->id.'';
            })
            ->editColumn('created_at', function (MracArac $mrac_arac) {
                return $mrac_arac->created_at->toDateString();
            })
            ->editColumn('updated_at', function (MracArac $mrac_arac) {
                return $mrac_arac->created_at->toTimeString();
            })
            ->editColumn('county_fips', function (MracArac $mrac_arac) {
                return $mrac_arac->county?->county;
            })
            ->editColumn('comment', function (MracArac $mrac_arac) {
                return $mrac_arac->comments;
            })
            ->editColumn('download', function (MracArac $mrac_arac) {
                return '<button data-kt-action="download_all" data-kt-mrac-arac-id="' . $mrac_arac->id . '" class="btn btn-primary">Download</button>';
            })

            ->editColumn('delete', function (MracArac $mrac_arac) {
                return view('pages.apps.mrac_arac.columns._delete-action', compact('mrac_arac'));
            })

            ->addColumn('user_first_name', function (MracArac $mrac_arac) {
                return $mrac_arac->user->first_name;
            })
            ->editColumn('view', function (MracArac $mrac_arac) {
                return view('pages.apps.mrac_arac.columns._view-action', compact('mrac_arac'));
            })
            ->rawColumns(['user_first_name', 'document_path', 'download'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(MracArac $model): QueryBuilder
    {
        $query = $model->newQuery();
        $query->join('users', 'mrac_arac.user_id', '=', 'users.id')
              ->leftJoin('counties', 'mrac_arac.county_fips', '=', 'counties.county_fips')
              ->where('users.status', 1)
              ->select('mrac_arac.*', 'counties.county_full', 'users.email');

        if (auth()->user()->hasRole('county user') || auth()->user()->hasRole('CDSS')) {
            $query->where('users.id', auth()->user()->id);
        }

        if (request()->has('county_fips')) {
            $query->where('county_fips', request('county_fips'));
        }

        $startDate = request()->query('startDate');
        $endDate = request()->query('endDate');

        if ($startDate) {
            $query->where('mrac_arac.created_at', '>=', $startDate);
        }

        if ($endDate) {
            $query->where('mrac_arac.created_at', '<=', $endDate);
        }

        return $query;
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('mrac_arac-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->addTableClass('table align-middle table-row-dashed fs-6 gy-5 dataTable no-footer text-gray-600 fw-semibold')
            ->setTableHeadClass('text-start text-muted fw-bold fs-7 text-uppercase gs-0')
            ->orderBy(1)
            ->drawCallback("function() {" . file_get_contents(resource_path('views/pages/apps/mrac_arac/columns/_draw-scripts.js')) . "}")
            ->buttons([
                [
                    'extend' => 'csv',
                    'text' => 'Export CSV',
                    'filename' => 'Submit Provider Payment Report',
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
    $MracArac = new MracArac; // Create an instance of MracArac
    $dataTable = DataTables::of($this->query($MracArac))
        ->setRowId('id')
        ->addColumn('user_first_name', function (MracArac $mrac_arac) {
            return $mrac_arac->user->first_name;
        })
        ->addColumn('created_at', function (MracArac $mrac_arac) {
            return $mrac_arac->created_at->toDateString();
        })
        ->addColumn('county_name', function (MracArac $mrac_arac) {
            return $mrac_arac->county->county;
        })
        ->addColumn('comment', function (MracArac $mrac_arac) {
            return $mrac_arac->comments;
        })
        // Add other necessary columns
        ->rawColumns(['user_first_name', 'document_path'])
        ->make(true);

    $data = $dataTable->getData(true);

    $csvFileName = 'mrac_aracs_' . date('YmdHis') . '.csv';

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
        if (auth()->user()->hasRole('admin') || auth()->user()->hasRole('manager')) {
            return [
                Column::make('id')->title('ID'),
                Column::make('created_at')->title('Date'),
                Column::make('updated_at')->title('Time'),
                Column::make('county_fips')->title('County')->name('counties.county')->orderable(true)->searchable(true),
                Column::make('user')->title('User')->name('users.first_name')->orderable(true),
                Column::make('month_year')->title('Month/Year')->name('month_year')->orderable(true)->searchable(true)->addClass('text-center'),
                Column::make('comment')->title('Comments')->searchable(false)->orderable(false)->exportable(false)->width(200),
                Column::make('download')->title('Download')->searchable(false)->orderable(false)->exportable(false)->width(120),
                Column::make('delete')->title('Delete')->searchable(false)->orderable(false)->visible(true)->exportable(false)->width(120),
                Column::computed('view')
                    ->addClass('text-center text-nowrap')
                    ->exportable(false)
                    ->printable(false)
                    ->width(60),
                Column::make('email')->name("users.email")->visible(false),

            ];
        }elseif(auth()->user()->hasRole('view only')){
            return [
                Column::make('id')->title('ID'),
                Column::make('created_at')->title('Date'),
                Column::make('updated_at')->title('Time'),
                Column::make('county_fips')->title('County')->name('counties.county')->orderable(true)->searchable(true),
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
        } else{
            return [
                Column::make('id')->title('ID'),
                Column::make('created_at')->title('Date'),
                Column::make('updated_at')->title('Time'),
                Column::make('county_fips')->title('County')->name('counties.county')->orderable(true)->searchable(true),
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
        return 'MracArac_' . date('YmdHis');
    }
}
