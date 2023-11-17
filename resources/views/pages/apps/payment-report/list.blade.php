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
            <div class="card-toolbar">
                <!--begin::Toolbar-->
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
            });
            document.getElementById('mySearchInput').addEventListener('keyup', function () {
                window.LaravelDataTables['payment_report-table'].search(this.value).draw();
            });
        </script>
    @endpush

</x-default-layout>