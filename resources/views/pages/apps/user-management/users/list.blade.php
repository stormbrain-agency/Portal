<x-default-layout>

    @section('title')
        Users
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('user-management.users.index') }}
    @endsection

    <div class="card">
        <!--begin::Card header-->
        <div class="card-header flex-column border-0 pt-6">
            <!--begin::Card title-->
            <div class="card-title">
                Users
            </div>
            <div class="d-flex align-items-center justify-content-between">
                <!--begin::Card title-->
                <div class="d-flex align-items-center position-relative my-1">
                    {!! getIcon('magnifier', 'fs-3 position-absolute ms-5') !!}
                    <input type="text" data-kt-user-table-filter="search" class="form-control form-control-solid w-250px ps-13" placeholder="Search user" id="mySearchInput"/>
                </div>
                <!--begin::Card toolbar-->
                <div class="card-toolbar gx-10 d-flex justify-content-end" style="gap: 10px">
                    <div style="width: 150px">
                        <select id="select_role" class="form-select form-select-solid text-center">
                            <option value="">Select Role</option>
                            <option value="Admin">Admin</option>
                            <option value="Manager">Manager</option>
                            <option value="View Only">View Only</option>
                            <option value="County User">County User</option>
                        </select>
                    </div>
                    @if(auth()->user()->hasRole('admin'))
                    <!--begin::Toolbar-->
                    <button id="export_csv" class="btn btn-outline btn-outline-solid">
                        <i class="ki-duotone ki-exit-down fs-2"><span class="path1"></span><span class="path2"></span></i>
                        EXPORT AS CSV
                    </button>
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
            <!--end::Card toolbar-->
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

    @push('scripts')
        {{ $dataTable->scripts() }}
        <script>
            document.getElementById('mySearchInput').addEventListener('keyup', function () {
                window.LaravelDataTables['users-table'].search(this.value).draw();
            });
            document.addEventListener('livewire:load', function () {
                Livewire.on('success', function () {
                    $('#kt_modal_add_user').modal('hide');
                    window.LaravelDataTables['users-table'].ajax.reload();
                });
                 document.getElementById('select_role').addEventListener('change', function() {
                    var select_role = this.value;
                    window.LaravelDataTables['users-table'].column('roles.name:name').search(select_role).draw();
                });
            });
            $("#export_csv").on('click', function(e) {
                var table = window.LaravelDataTables['users-table'];
                table.column('last_login_at:name').visible(false);
                table.column('action:name').visible(false);

                table.button('.buttons-csv').trigger();

                table.column('last_login_at:name').visible(true);
                table.column('action:name').visible(true);
            })
        </script>
    @endpush

</x-default-layout>
