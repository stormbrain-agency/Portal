<x-default-layout>
<!-- Add these lines to include DataTables buttons extension -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>

    @section('title')
        County MRAC/ARAC Submissions
    @endsection

    {{-- @section('breadcrumbs')
        {{ Breadcrumbs::render('county-provider-mrac_arac.index') }}
    @endsection --}}

     <div class="card">
        <!--begin::Card header-->
        <div class="card-header border-0 pt-6">
            <!--begin::Card title-->
            <div class="card-title">
                <!--begin::Search-->
                <div class="d-flex align-items-center position-relative my-1">
                    {!! getIcon('magnifier', 'fs-3 position-absolute ms-5') !!}
                    <input type="text" data-kt-user-table-filter="search" class="form-control form-control-solid w-250px ps-13" placeholder="Search user" id="mySearchInput"/>
                </div>
                 {{-- @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif --}}
                <!--end::Search-->
            </div>
            <!--begin::Card title-->

            <!--begin::Card toolbar-->
            <div class="card-toolbar gx-10 d-flex justify-content-end" style="gap: 20px">
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
                <a href="{{route("county-mrac-arac.create")}}" class="btn btn-primary">
                    {!! getIcon('file', 'fs-2', '', 'i') !!}
                    Submit File
                </a>
                @endif
                <!--end::Add user-->
            </div>
            <!--end::Toolbar-->

            <!--end::Card toolbar-->
        </div>
        <!--end::Card header-->

        <!--begin::Card body-->
        <livewire:mrac_arac.view-mrac-arac></livewire:mrac_arac.view-mrac-arac>
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
                    window.LaravelDataTables['mrac_arac-table'].ajax.reload();
                });
                document.getElementById('month_year').addEventListener('change', function() {
                    var month_year = this.value;
                    window.LaravelDataTables['mrac_arac-table'].column('month_year:name').search(month_year).draw();
                });
            });
            document.getElementById('mySearchInput').addEventListener('keyup', function () {
                window.LaravelDataTables['mrac_arac-table'].search(this.value).draw();
            });
              
        </script>
        <script>
         $(document).ready(function () {
            $("#kt_daterangepicker_1").daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                minYear: 2022,
                maxYear: 2026,
                locale: {
                    placeholder: 'Pick a day'
                }
                }, function(start, end) {
                    window.LaravelDataTables['mrac_arac-table'].column('created_at:name').search(start.format('YYYY-MM-DD')).draw();            
            });

            function clearDateFilter() {
                window.LaravelDataTables['mrac_arac-table'].column('created_at:name').search('').draw();
            }

            $('.daterangepicker .cancelBtn').on('click', function(){
                clearDateFilter();
            });
            $('#county-filter').on('select2:select', function (e) {
                var value = e.params.data.text;
                if (value == "All County") {
                    value = "";
                }
                window.LaravelDataTables['mrac_arac-table'].column('counties.county:name').search(value).draw();
            });
            $('#user-filter').on('select2:select', function (e) {
                var value = e.params.data.id;
                if (value == "0") {
                    value = '';
                }
                window.LaravelDataTables['mrac_arac-table'].column('users.email:name').search(value).draw();
            });
            $("#export_csv").on('click', function(e) {
                var table = window.LaravelDataTables['mrac_arac-table'];
                table.button('.buttons-csv').trigger();
            })
        })
    </script>
    @endpush

</x-default-layout>