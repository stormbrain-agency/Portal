<x-default-layout>

    @section('title')
        Notification Email Management
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('notification-management.email.index') }}
    @endsection

    <div class="card">
        <!--begin::Card header-->
        <div class="card-header border-0 pt-6">
            <!--begin::Card title-->
            <div class="card-title">
                Notifications
                 {{-- @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif --}}
            </div>
            <!--begin::Card title-->

            <!--begin::Card toolbar-->
            <div class="card-toolbar gx-10 d-flex justify-content-end" style="gap: 20px">
                <!--begin::Toolbar-->
                <a href="{{route("notification-management.email.create")}}" class="btn btn-primary me-2 mb-2">
                    {{-- {!! getIcon('file', 'fs-2', '', 'i') !!} --}}
                    {!! getIcon('plus-circle', 'fs-2', '', 'i') !!}
                    ADD NEW NOTIFICATION EMAIL
                </a>
            </div>
                <!--end::Toolbar-->
                <!--begin::Modal-->
                <livewire:notifications-email.add-notifications></livewire:notifications-email.add-notifications>
                <!--end::Modal-->
            {{-- </div> --}}

            <!--end::Card toolbar-->
        </div>
        <!--end::Card header-->

        <!--begin::Card body-->
        <livewire:notifications-email.view-notifications></livewire:notifications-email.view-notifications>
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
    @endpush

</x-default-layout>
