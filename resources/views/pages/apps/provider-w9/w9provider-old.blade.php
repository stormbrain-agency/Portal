<x-default-layout>
    @section('title')
        Provider W-9
    @endsection
    @section('breadcrumbs')
        {{ Breadcrumbs::render('county-provider-w9.upload') }}
    @endsection
    <!--begin::Row-->
    <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
        <!--begin::Col-->
        <div class="col-md-12">
            <h1>File Uploads</h1>
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
            <form action="/county-provider-w9/w9_upload" method="post" enctype="multipart/form-data">

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

                <div class="form-group">
                    <label for="month">Select Month:</label>
                    <select name="month" id="month">
                        @for ($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}" {{ $selectedMonth == $i ? 'selected' : '' }}>{{ date("F", mktime(0, 0, 0, $i, 1)) }}</option>
                        @endfor
                    </select>


                    <label for="year">Select Year:</label>
                    <select name="year" id="year">
                        @for ($i = date("Y"); $i >= 2021; $i--)
                            <option value="{{ $i }}" {{ $selectedYear == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                    <button type="submit" class="btn btn-secondary">Filter</button>
                </div>

            </form>


            
            <div class="card">
            <div class="card-header border-0 pt-6"><h2>List File Upload</h2></div>
            <div class="card-body py-4">
            <div class="table-responsive">
            <div class="dataTables_wrapper dt-bootstrap4 no-footer">   
            <table class="table align-middle table-row-dashed fs-6 gy-5 dataTable no-footer text-gray-600 fw-semibold">
                <thead class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                    <tr>
                        <th>Date of Submission</th>
                        <th>Time of Submission</th>
                        <th>County Designation</th>
                        <th>User who submitte1d</th>
                        <th>Comments</th>
                        <th>File name submitted</th>
                        <th>Download</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($uploadedFiles as $file)
                        <tr class="odd">
                            <td>{{ $file->created_at->format('Y-m-d') }}</td>
                            <td>{{ substr($file->created_at, 11, 8) }}</td>
                            <td>{{ $file->country }}</td>
                            <td>{{ $file->user->first_name }} {{ $file->user->last_name }}</td>
                            <td>{{ $file->comments }}</td>
                            <td>{{ $file->original_name }}</td>
                            <td><a href="{{ route('county-provider-w9.w9_download', ['filename' => $file->original_name]) }}" class="btn btn-primary">Download</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
</div></div></div>
        </div>
        <!--end::Col-->
    </div>
    <!--end::Row-->

    
</x-default-layout>