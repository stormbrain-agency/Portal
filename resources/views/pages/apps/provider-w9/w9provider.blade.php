<x-default-layout>

    @section('title')
        W9 List Upload
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('user-management.users.index') }}
    @endsection

    <div class="card">
        <!--begin::Card header-->
        @if(auth()->user()->hasRole('county user'))
        <div class="card-header border-0 pt-6">
        
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            <form action="/w9_upload/w9_upload" method="post" enctype="multipart/form-data">

            @csrf
            <div class="form-group">
                <input type="file" class="form-control-file" name="file" id="w9_uploadInput">
            </div>
            <div class="form-group">
                <textarea name="comments" placeholder="Comments"></textarea>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Upload</button>
                <p>This portal site
                is not a storage system, but rather a secure site for
                transferring documents. As such, all documents in
                any folder will be permanently deleted after 30 days
                </p>
            </div>

            <div class="form-group">
                <a href="/export/csv" class="btn btn-primary">Export CSV</a>
            </div>
            </form>
        </div>
        @endif
        <div class="card-header border-0 pt-6">
            <!--begin::Card title-->
            <div class="card-title">
                <!--begin::Search-->
                <div class="d-flex align-items-center position-relative my-1">
                    {!! getIcon('magnifier', 'fs-3 position-absolute ms-5') !!}
                    <input type="text" data-kt-user-table-filter="search" class="form-control form-control-solid w-250px ps-13" placeholder="Search user" id="mySearchInput"/>
                </div>
                <!--end::Search-->
            </div>
            <!--begin::Card title-->
        </div>
        <!--end::Card header-->

        <!--begin::Card body-->
        <div class="card-body py-4">
            <!--begin::Table-->
            <div class="table-responsive">
                @if(auth()->user()->hasRole('county user')&& auth()->user()->status == 1)
                    {{ $dataTable->table() }}
                @else
                    {{ $dataTable->table() }}
                @endif
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
            });
        </script>
    @endpush

</x-default-layout>
