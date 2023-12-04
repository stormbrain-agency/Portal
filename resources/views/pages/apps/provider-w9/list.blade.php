<x-default-layout>
      @if(session('error'))
        <div class="card-body py-4">
            <div class="alert alert-danger d-flex align-items-center p-5 mb-1">
                <i class="ki-duotone ki-shield-cross fs-2hx text-danger me-4"><span class="path1"></span><span class="path2"></span></i>                    <div class="d-flex flex-column">
                    <h4 class="mb-1 text-danger">Error</h4>
                    <span>{{ session('error') }}</span>
                </div>
            </div>
        </div>
        @endif
     <div class="card">
        <!--begin::Card header-->
        <div class="card-header border-0 pt-6">
            <!--begin::Card title-->
            <div class="card-title">
                @if(!auth()->user()->hasRole('county user'))
                County Provider W-9
                @else
                Provider W-9 | Submission History
                @endif
            </div>
            <!--begin::Card title-->

            <!--begin::Card toolbar-->
            <div class="card-toolbar gx-10 d-flex justify-content-end mt-3" style="gap: 10px; width: 100%">
                <!--begin::Toolbar-->
                <div style="width: 150px">
                    <input class="form-control form-control-solid" placeholder="Pick a day" id="kt_daterangepicker_1"/>
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
                <a href="/county-w9/upload" class="btn btn-primary">
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
        <livewire:w9-provide.view-w9-provide></livewire:w9-provide.view-w9-provide>
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
                    window.LaravelDataTables['w9-upload-table'].ajax.reload();
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
                // table.column('w9_file_path:name').visible(false);
                table.button('.buttons-csv').trigger();
                // table.column('w9_file_path:displaydownload').visible(true);
                // table.column('w9_file_path:hidedownload').visible(false);
            })
        })

    </script>
    @endpush

</x-default-layout>