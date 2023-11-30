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
    <script>
        document.querySelectorAll('td.col-type').forEach(function (element) {
            var test = document.querySelectorAll('td.col-type')
            console.log(test);
            var value = element.textContent.trim();
            console.log(value);
            switch (value) {
                case 'Information':
                    element.classList.add('text-info');
                    break;
                case 'Success':
                    element.classList.add('text-success');
                    break;
                case 'Alert':
                    element.classList.add('text-danger');
                    break;
                case 'Warning':
                    element.classList.add('text-warning');
                    break;
                default:
                    element.classList.add('text-muted');
                    break;
            }
        });
    </script>
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
