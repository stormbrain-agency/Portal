<x-default-layout>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.alert.css') }}">

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
<!-- Add these lines to include DataTables buttons extension -->
     <div class="card">
        <!--begin::Card header-->
        <div class="card-header border-0 pt-6">
            <!--begin::Card title-->
            <div class="card-title">
                Users Activity
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
                <livewire:filters.user-list/>
                <livewire:filters.county-list/>
                {{-- <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base"> --}}
                    <!--begin::Add user-->
                    <button id="export_csv" class="btn btn-outline btn-outline-solid">
                        <i class="ki-duotone ki-exit-down fs-2"><span class="path1"></span><span class="path2"></span></i>
                        EXPORT AS CSV
                    </button>
                    <!--end::Add user-->
                </div>
                <!--end::Toolbar-->
                <!--begin::Modal-->                
                <!--end::Modal-->
            {{-- </div> --}}

            <!--end::Card toolbar-->
        </div>
        <!--end::Card header-->
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
                    window.LaravelDataTables['activity-table'].ajax.reload();
                });
                // document.getElementById('month_year').addEventListener('change', function() {
                //     var month_year = this.value;
                //     window.LaravelDataTables['activity-table'].column('month_year:name').search(month_year).draw();
                // });
            });
            // document.getElementById('mySearchInput').addEventListener('keyup', function () {
            //     window.LaravelDataTables['activity-table'].search(this.value).draw();
            // });
              
        </script>
        <script>
        //  $(document).ready(function () {
        //     $("#kt_daterangepicker_1").daterangepicker({
        //         singleDatePicker: true,
        //         showDropdowns: true,
        //         minYear: 2022,
        //         maxYear: 2026,
        //         locale: {
        //             placeholder: 'Pick a day'
        //         }
        //         }, function(start, end) {
        //             window.LaravelDataTables['activity-table'].column('created_at:name').search(start.format('YYYY-MM-DD')).draw();            
        //     });

        //     function clearDateFilter() {
        //         window.LaravelDataTables['activity-table'].column('created_at:name').search('').draw();
        //     }

        //     $('.daterangepicker .cancelBtn').on('click', function(){
        //         clearDateFilter();
        //     });
        //     $('#county-filter').on('select2:select', function (e) {
        //         var value = e.params.data.text;
        //         if (value == "All County") {
        //             value = "";
        //         }
        //         window.LaravelDataTables['activity-table'].column('counties.county:name').search(value).draw();
        //     });
        //     $('#user-filter').on('select2:select', function (e) {
        //         var value = e.params.data.id;
        //         if (value == "0") {
        //             value = '';
        //         }
        //         window.LaravelDataTables['activity-table'].column('users.email:name').search(value).draw();
        //     });
        //     $("#export_csv").on('click', function(e) {
        //         var table = window.LaravelDataTables['activity-table'];
        //         table.button('.buttons-csv').trigger();
        //     })
        // })
    </script>
    @endpush

</x-default-layout>