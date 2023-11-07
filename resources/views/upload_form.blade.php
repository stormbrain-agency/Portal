<x-default-layout>
    @section('title')
        Provider W-9
    @endsection
    @section('breadcrumbs')
        {{ Breadcrumbs::render('dashboard.upload') }}
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
            <form action="/dashboard/w9_upload" method="post" enctype="multipart/form-data">

                @csrf
                <div class="form-group">
                    <input type="file" class="form-control-file" name="file" id="w9_uploadInput">
                </div>
                <div class="form-group">
                    <textarea name="comments" placeholder="Comments"></textarea>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Upload</button>
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


            <h2>List File Upload</h2>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Date of Submission</th>
                        <th>Time of Submission</th>
                        <th>County Designation</th>
                        <th>User who submitted</th>
                        <th>Comments</th>
                        <th>File name submitted</th>
                        <th>Download</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($uploadedFiles as $file)
                        <tr>
                            <td>{{ $file->created_at->format('Y-m-d') }}</td>
                            <td>{{ substr($file->created_at, 11, 8) }}</td>
                            <td>{{ $file->country }}</td>
                            <td>{{ $file->user }}</td>
                            <td>{{ $file->comments }}</td>
                            <td>{{ $file->original_name }}</td>
                            <td><a href="{{ route('dashboard.w9_download', ['filename' => $file->original_name]) }}" class="btn btn-primary">Download</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!--end::Col-->
    </div>
    <!--end::Row-->
</x-default-layout>