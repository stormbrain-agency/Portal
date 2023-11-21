<x-default-layout>

    @section('title')
        County Provider Payment Resports
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('county-provider-payment-report.index') }}
    @endsection

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

            @if(auth()->user()->hasRole('admin'))
            <!--begin::Card toolbar-->
            <div class="card-toolbar gx-10 d-flex" style="gap: 30px">
                <!--begin::Toolbar-->
                <div class="d-flex justify-content-center row " style="width: 150px">
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
                <livewire:filters.user-list/>
                <livewire:filters.county-list/>
                <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                    <!--begin::Add user-->
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_add_payment_report">
                        {!! getIcon('plus', 'fs-2', '', 'i') !!}
                        Submit File
                    </button>
                    <!--end::Add user-->
                </div>
                <!--end::Toolbar-->
                <!--begin::Modal-->
                <livewire:payment-report.add-payment-report></livewire:payment-report.add-payment-report>
                <!--end::Modal-->
            </div>

            <!--end::Card toolbar-->
            @endif
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
            $('#county-filter').on('select2:select', function (e) {
                var value = e.params.data.text;
                if (value == "County") {
                    value = "";
                }
                window.LaravelDataTables['payment_report-table'].column('counties.county:name').search(value).draw();
            });
            $('#user-filter').on('select2:select', function (e) {
                var value = e.params.data.text;
                if (value == "User") {
                    value = "";
                }
                window.LaravelDataTables['payment_report-table'].column('users.first_name:name').search(value).draw();
            });
        })
    </script>
    @endpush

</x-default-layout>