<x-default-layout>

    @section('title')
        Notification Management
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('notification-management.index') }}
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

            <!--begin::Card toolbar-->
            <div class="card-toolbar gx-10 d-flex justify-content-end" style="gap: 20px">
                <!--begin::Toolbar-->
                <a href="{{route("notification-management.create")}}" class="btn btn-primary me-2 mb-2">
                    {{-- {!! getIcon('file', 'fs-2', '', 'i') !!} --}}
                    {!! getIcon('plus-circle', 'fs-2', '', 'i') !!}
                    ADD NEW NOTIFICATION
                </a>
            </div>
                <!--end::Toolbar-->
                <!--begin::Modal-->
                <livewire:notifications.add-notifications></livewire:notifications.add-notifications>
                <!--end::Modal-->
            {{-- </div> --}}

            <!--end::Card toolbar-->
        </div>
        <!--end::Card header-->

        <!--begin::Card body-->
        <livewire:notifications.view-notifications></livewire:notifications.view-notifications>
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
                    $('#kt_modal_add_notifications').modal('hide');
                    window.LaravelDataTables['notifications-table'].ajax.reload();
                });
            });
            document.getElementById('mySearchInput').addEventListener('keyup', function () {
                window.LaravelDataTables['notifications-table'].search(this.value).draw();
            });

        </script>
        <script>
         $(document).ready(function () {
            function clearDateFilter() {
                window.LaravelDataTables['notifications-table'].column('created_at:name').search('').draw();
            }

            $('.daterangepicker .cancelBtn').on('click', function(){
                clearDateFilter();
            });
        })
        </script>
    @endpush

</x-default-layout>
