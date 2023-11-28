<x-default-layout>

    @section('title')
        County Users
    @endsection
  
    <div class="card">
        <!--begin::Card header-->
        <div class="card-header flex-column border-0 pt-6">
            <!--begin::Card title-->
            <div class="card-title">
                County Users
            </div>
            <div class="d-flex align-items-center justify-content-between">
                <!--begin::Search-->
                <div class="d-flex align-items-center position-relative my-1">
                    {!! getIcon('magnifier', 'fs-3 position-absolute ms-5') !!}
                    <input type="text" data-kt-user-table-filter="search" class="form-control form-control-solid w-250px ps-13" placeholder="Search user" id="mySearchInput"/>
                </div>
                <!--end::Search-->
                <!--begin::Card title-->
                <div class="card-toolbar gx-10 d-flex justify-content-end" style="gap: 10px">
                    <div style="width: 150px">
                        <select id="select_status" class="form-select form-select-solid text-center">
                            <option value="">Select Status</option>
                            <option value="1">Approved</option>
                            <option value="0">Approval Needed</option>
                            <option value="2">Declined</option>
                        </select>
                    </div>
                    <button id="export_csv" class="btn btn-outline btn-outline-solid">
                        <i class="ki-duotone ki-exit-down fs-2"><span class="path1"></span><span class="path2"></span></i>
                        EXPORT AS CSV
                    </button>
                    @if(auth()->user()->hasRole('admin'))
                    <!--begin::Toolbar-->
                    <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                        <!--begin::Add user-->
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_add_user" data-kt-action="create_view">
                            {!! getIcon('plus', 'fs-2', '', 'i') !!}
                            Add User
                        </button>
                        <!--end::Add user-->
                    </div>
                    <!--end::Toolbar-->
                    <!--begin::Modal-->
                    <livewire:user.add-user-modal></livewire:user.add-user-modal>
                    <!--end::Modal-->
                    @endif
                </div>
            </div>
        </div>
        <!--end::Card header-->

        <!--begin::Card body-->
        <div class="card-body py-4">
            <!--begin::Table-->
            <div class="table-responsive">
                {{ $dataTable->table() }}
            </div>
            <!--end::Table-->
        </div>
        <!--end::Card body-->
    </div>
    <!--begin::Modal-->
    <livewire:user.user-pending></livewire:user.user-pending>
    <!--end::Modal-->
    @push('scripts')
        {{ $dataTable->scripts() }}
        <script>
            document.getElementById('mySearchInput').addEventListener('keyup', function () {
                window.LaravelDataTables['users-county-table'].search(this.value).draw();
            });
            // document.getElementById('mySearchInput').addEventListener('keyup', function () {
            //     window.LaravelDataTables['users-pending-table'].search(this.value).draw();
            // });
            document.addEventListener('livewire:load', function () {
                Livewire.on('success', function () {
                    $('#kt_modal_add_user').modal('hide');
                    window.LaravelDataTables['users-county-table'].ajax.reload();
                });
            
                document.getElementById('select_status').addEventListener('change', function() {
                    var select_status = this.value;
                    window.LaravelDataTables['users-county-table'].column('status:name').search(select_status).draw();
                });
            });
            $("#export_csv").on('click', function(e) {
                var table = window.LaravelDataTables['users-county-table'];
                table.column('w9_file_path:name').visible(false);
                table.column('action:name').visible(false);

                table.button('.buttons-csv').trigger();

                table.column('w9_file_path:name').visible(true);
                table.column('action:name').visible(true);
            })

        </script>
    @endpush

</x-default-layout>
