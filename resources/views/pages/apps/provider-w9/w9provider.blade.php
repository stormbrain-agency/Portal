<x-default-layout>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.alert.css') }}">

    @section('title')
        County Provider W-9
    @endsection

    {{-- @section('breadcrumbs')
        {{ Breadcrumbs::render('county-provider-payment-report.index') }}
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
                <div class="d-flex justify-content-center row" style="width: 150px">
                    <input class="form-control form-control-solid" placeholder="Pick a day" id="kt_daterangepicker_1"/>
                </div>
                <livewire:filters.user-list/>
                <livewire:filters.county-list/>
                {{-- <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base"> --}}
                    <!--begin::Add user-->
                    <button id="export_csv" class="btn btn-outline btn-outline-solid">
                        <i class="ki-duotone ki-exit-down fs-2"><span class="path1"></span><span class="path2"></span></i>
                        EXPORT AS CSV
                    </button>
                    {{-- @if(auth()->user()->hasRole('county user')) --}}
                    {{-- <button type="button" class="btn btn-primary me-2 mb-2" data-bs-toggle="modal" data-bs-target="#kt_modal_add_payment_report">
                        {!! getIcon('plus', 'fs-2', '', 'i') !!}
                        UPLOAD NEW PROVIDER W9
                    </button> --}}
                    <a href="/county-w9/upload" class="btn btn-primary me-2 mb-2">
                        {!! getIcon('file', 'fs-2', '', 'i') !!}
                        UPLOAD NEW PROVIDER W9
                    </a>
                    {{-- @endif --}}
                    <!--end::Add user-->
                </div>
                <!--end::Toolbar-->
                <!--begin::Modal-->
                <livewire:payment-report.add-payment-report></livewire:payment-report.add-payment-report>
                <!--end::Modal-->
            {{-- </div> --}}

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
                    $('#kt_modal_add_payment_report').modal('hide');
                    window.LaravelDataTables['w9-upload-table'].ajax.reload();
                });
                document.getElementById('month_year').addEventListener('change', function() {
                    var month_year = this.value;
                    window.LaravelDataTables['w9-upload-table'].column('month_year:name').search(month_year).draw();
                });
            });
            document.getElementById('mySearchInput').addEventListener('keyup', function () {
                window.LaravelDataTables['w9-upload-table'].search(this.value).draw();
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
                    window.LaravelDataTables['w9-upload-table'].column('created_at:name').search(start.format('YYYY-MM-DD')).draw();
            });

            function clearDateFilter() {
                window.LaravelDataTables['w9-upload-table'].column('created_at:name').search('').draw();
            }

            $('.daterangepicker .cancelBtn').on('click', function(){
                clearDateFilter();
            });

            $('#county-filter').on('select2:select', function (e) {
                var value = e.params.data.text;
                if (value == "County") {
                    value = "";
                }
                window.LaravelDataTables['w9-upload-table'].column('counties.county:name').search(value).draw();
            });

            $('#user-filter').on('select2:select', function (e) {
                var value = e.params.data.id;
                if (value == "0") {
                    value = '';
                }
                window.LaravelDataTables['w9-upload-table'].column('users.email:name').search(value).draw();
            });

            $("#export_csv").on('click', function(e) {
                var table = window.LaravelDataTables['w9-upload-table'];
                table.column('comment:name').visible(false);

                table.button('.buttons-csv').trigger();

                table.column('comment:name').visible(true);

            })
        })
    </script>
    @endpush

</x-default-layout>

