<x-default-layout>
<!-- Add these lines to include DataTables buttons extension -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.alert.css') }}">

<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>

     <div class="card">
        <!--begin::Card header-->
        <div class="card-header border-0 pt-6">
            <!--begin::Card title-->
            <div class="card-title">
                @if(!auth()->user()->hasRole('county user'))
                County Provider Payment Resports
                @else
                Provider Payment Report | Submission History
                @endif
            </div>
            <!--begin::Card title-->

            <!--begin::Card toolbar-->
            <div class="card-toolbar gx-10 d-flex justify-content-end mt-3" style="gap: 10px; width: 100%">
                <!--begin::Toolbar-->
                @if(!auth()->user()->hasRole('county user'))
                <div style="width: 150px">
                    <input class="form-control form-control-solid" placeholder="Pick date rage" id="kt_daterangepicker_1"/>
                </div>
                @endif
                <div style="width: 150px">
                    <select id="month_year" class="form-select form-select-solid text-center">
                        <option value="">Month/Year</option>
                            @for ($year = 2024; $year <= 2025; $year++)
                                @for ($month = 1; $month <= 12; $month++)
                                    <option value="{{ date('F Y', strtotime($year . '-' . sprintf('%02d', $month) . '-01')) }}">
                                        {{ date('F Y', strtotime($year . '-' . sprintf('%02d', $month) . '-01')) }}
                                    </option>
                                @endfor
                            @endfor
                    </select>
                </div>
                @if(!auth()->user()->hasRole('county user'))
                <livewire:filters.user-list/>
                <livewire:filters.county-list/>
                @endif
                <!--begin::Add user-->
                <button id="export_csv" class="btn btn-outline btn-outline-solid">
                    <i class="ki-duotone ki-exit-down fs-2"><span class="path1"></span><span class="path2"></span></i>
                    EXPORT AS CSV
                </button>
                @if(auth()->user()->hasRole('county user'))
                <a href="{{route("county-provider-payment-report.create")}}" class="btn btn-primary">
                    {!! getIcon('file', 'fs-2', '', 'i') !!}
                    UPLOAD NEW PAYMENT REPORT
                </a>
                @endif
                {{-- @if(auth()->user()->hasRole('admin'))
                    <a href="{{route("county-provider-payment-report.template")}}" class="btn btn-primary">
                        {!! getIcon('file', 'fs-2', '', 'i') !!}
                        TEMPLATE
                    </a>
                @endif --}}
                <!--end::Add user-->
            </div>
            <!--end::Toolbar-->
            <!--begin::Modal-->
            <livewire:payment-report.add-payment-report></livewire:payment-report.add-payment-report>
            <!--end::Modal-->

            <!--end::Card toolbar-->
        </div>
        <!--end::Card header-->

        <!--begin::Card body-->
        <livewire:payment-report.view-payment-report></livewire:payment-report.view-payment-report>
        <div class="card-body py-4">
            <!--begin::Table-->
            <div class="table-responsive">
                {{ $dataTable->table() }}
            </div>
            <!--end::Table-->
        </div>
        <!--end::Card body-->
    </div>

    @push('scripts')
        {{ $dataTable->scripts() }}
        <script>
            document.addEventListener('livewire:load', function () {
                Livewire.on('success', function () {
                    window.LaravelDataTables['payment_report-table'].ajax.reload();
                });
                document.getElementById('month_year').addEventListener('change', function() {
                    var month_year = this.value;
                    window.LaravelDataTables['payment_report-table'].column('month_year:name').search(month_year).draw();
                });
            });
            document.getElementById('mySearchInput').addEventListener('keyup', function () {
                window.LaravelDataTables['payment_report-table'].search(this.value).draw();
            });
              
        </script>
        <script>
         $(document).ready(function () {
            var startDateParam = getParameterByName('startDate');
            var endDateParam = getParameterByName('endDate');

            var startDate = startDateParam ? moment(startDateParam) : moment();
            var endDate = endDateParam ? moment(endDateParam) : moment();
            $("#kt_daterangepicker_1").daterangepicker({
                startDate: startDate,
                endDate: endDate,
                showDropdowns: true,
                minYear: 2022,
                maxYear: 2026,
                locale: {
                    format: 'YYYY-MM-DD', 
                    placeholder: 'Pick a day'
                }
            });
            $('#kt_daterangepicker_1').on('apply.daterangepicker', function(ev, picker) {
                var startDate = picker.startDate.format('YYYY-MM-DD');
                var endDate = picker.endDate.format('YYYY-MM-DD');

                window.location.href = '/county-provider-payment-report/?startDate=' + startDate + '&endDate=' + endDate;
                //  $.ajax({
                //     url: '/county-mrac-arac/',
                //     method: 'GET',
                //     data: {
                //         startDate: startDate,
                //         endDate: endDate
                //     },
                //     success: function (response) {
                //         window.LaravelDataTables['mrac_arac-table'].draw();
                //     },
                //     error: function (error) {
                //         console.error(error);
                //     }
                // });
            });

            function getParameterByName(name, url = window.location.href) {
                name = name.replace(/[\[\]]/g, '\\$&');
                var regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
                    results = regex.exec(url);
                if (!results) return null;
                if (!results[2]) return '';
                return decodeURIComponent(results[2].replace(/\+/g, ' '));
            }

            function updateUrlParams(startDate, endDate) {
                var newUrl = window.location.protocol + "//" + window.location.host + window.location.pathname +
                    '?startDate=' + startDate +
                    '&endDate=' + endDate;

                window.history.pushState({ path: newUrl }, '', newUrl);
            }

            function clearDateFilter() {
                window.location.href = '/county-provider-payment-report/';
            }

            $('.daterangepicker .cancelBtn').on('click', function(){
                clearDateFilter();
            });
            $('#county-filter').on('select2:select', function (e) {
                var value = e.params.data.text;
                if (value == "All County") {
                    value = "";
                }
                window.LaravelDataTables['payment_report-table'].column('counties.county:name').search(value).draw();
            });
            $('#user-filter').on('select2:select', function (e) {
                var value = e.params.data.id;
                if (value == "0") {
                    value = '';
                }
                window.LaravelDataTables['payment_report-table'].column('users.email:name').search(value).draw();
            });
            $("#export_csv").on('click', function(e) {
                var table = window.LaravelDataTables['payment_report-table'];
                table.button('.buttons-csv').trigger();
            })
        })
    </script>
    @endpush

</x-default-layout>