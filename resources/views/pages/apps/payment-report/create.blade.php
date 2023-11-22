<x-default-layout>
    {{-- @section('title')
    Monthly Payment Report Submission
    @endsection --}}
    {{-- @if(session('success'))
       <div class="alert alert-success">
           {{ session('success') }}
       </div>
   @endif --}}
    <div class="card">
        <!--begin::Card header-->
        <div class="card-header border-0 pt-6">
            <!--begin::Card title-->
            <div class="card-title">
                Monthly Payment Report Submission
            </div>
            <!--begin::Card toolbar-->
            <div class="card-toolbar gx-10 d-flex" style="gap: 20px">
            </div>
        </div>
        <!--end::Card header-->

        <!--begin::Card body-->
        <div class="card-body py-4">
            <span class="text-gray-700 fs-6"><i>If you have any questions, refer to our FAQs or submit a request via our contact us form.</i> </span>
            <br>
            <a href="#" class="btn btn-bg-primary me-6 text-light mt-5">
                <i class="ki-duotone ki-arrow-down text-light">
                    <span class="path1"></span>
                    <span class="path2"></span>
                </i>Download Template</a>
            <hr>

            <form action="{{ route('county-provider-payment-report.store') }}" method="POST" id="myform" class="form" enctype="multipart/form-data">
                @csrf
                 <input type="hidden" name="csrf_token" value="{{ csrf_token() }}">
                <!--begin::Scroll-->
                <div class="d-flex flex-column">
                    <!--begin::Input group-->
                    <div class="fv-row mb-7">
                        <!--begin::Label-->
                        <label class="required fw-bold fs-6 mb-2">Please select Report Period:</label>
                        <div class="row">
                            <div class="col-2">
                                <select name="month_year" id="month_year" class="form-select border border-gray-500 mb-3 mb-lg-0 text-center form-control bg-transparent">
                                    <option value="">Select Month/Year</option>
                                    @for ($year = 2024; $year <= 2025; $year++)
                                        @for ($month = 1; $month <= 12; $month++)
                                            <option value="{{ date('F Y', strtotime($year . '-' . sprintf('%02d', $month) . '-01')) }}">
                                                {{ date('F Y', strtotime($year . '-' . sprintf('%02d', $month) . '-01')) }}
                                            </option>
                                        @endfor
                                    @endfor
                                </select>

                                @error('month_year')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <!--end::Select-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="fv-row mb-7">
                        <!--begin::Label-->
                        <label class="required fw-bold fs-6 mb-2">Document Upload</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                         <!--begin::Dropzone-->
                        <div class="dropzone" id="kt_dropzonejs_example_1" class="justify-content-center">
                            <!--begin::Message-->
                            <div class="dz-message needsclick text-center justify-content-center">
                                <i class="ki-duotone ki-file-up fs-3x text-primary"><span class="path1"></span><span class="path2"></span></i>
                            </div>
                            <div class="dz-message needsclick text-center justify-content-center w-50 mx-auto">
                                <!--begin::Info-->
                                <div class="ms-4">
                                    <h3 class="fs-5 fw-bold text-gray-900 mb-1 mt-3">Upload ZIP File of provider Payment Report Submission (files).</h3>
                                    <p class="fs-7 fw-semibold text-gray-500">Drag & Drop or choose files from computer</p>
                                    <p class="fs-7 fw-semibold text-gray-500 font-italic">
                                        <i>
                                            This portal site is not a storage system, but rather a secure site for transferring documents.
                                            As such, all documents in any folder will be permanently deleted after 30 days</p>
                                        </i>
                                </div>
                                <!--end::Info-->
                            </div>
                        </div>
                        <!--end::Dropzone-->
                       
                        @if($errors->has('payment_report_file'))
                            <span class="text-danger">{{ $errors->first('payment_report_file') }}</span>
                        @endif

                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="fw-bold fs-6 mb-2">Your Comment (max 150 characters): </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <textarea id="comment" placeholder="Please write a comment here" class="border border-gray-500 mb-3 mb-lg-0 form-control bg-transparent" name="comment" id="" cols="30" rows="5s"></textarea>
                            <!--end::Input-->
                            @error('comment')
                            <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <!--end::Input group-->
                </div>
                <!--end::Scroll-->
                <!--begin::Actions-->
                <div class="pt-2">
                    <button type="submit" id="submit-button" class="btn btn-primary">
                        <span class="indicator-label">Upload</span>
                    </button>
                </div>
                <!--end::Actions-->
            </form>
        </div>
        <!--end::Card body-->
    </div>

    @push('scripts')
    {{-- <script>
        var myDropzone = new Dropzone("#kt_dropzonejs_example_1", {
    url: "{{ route('county-provider-payment-report.store') }}",
    paramName: "payment_report_file",
    maxFiles: 10,
    maxFilesize: 10, // MB
    addRemoveLinks: true,
            autoProcessQueue: false,

    accept: function(file, done) {
        done();
    },
    init: function () {
        var submitButton = document.querySelector("#submit-button"); // Thay #submit-button bằng ID của nút submit trong form của bạn

        this.on("sending", function (file, xhr, formData) {
            // Thêm dữ liệu từ các trường form vào formData
             formData.append('_token', document.querySelector('input[name=csrf_token]').value);
            var formFields = {
                month_year: document.querySelector("#month_year").value,
                comment: "ok"
                // Thêm các trường khác nếu cần
            };

            // Thêm dữ liệu từ form vào formData
            for (var key in formFields) {
                formData.append(key, formFields[key]);
            }
        });

        submitButton.addEventListener("click", function () {
            // Kích hoạt quá trình tải lên Dropzone khi nhấn nút submit
            myDropzone.processQueue();
        });
    }
});

    </script> --}}
    <!-- Bao gồm thư viện Dropzone.js -->

<!-- Mã HTML của form của bạn -->

{{-- <script>
    document.addEventListener('DOMContentLoaded', function () {
        // Khởi tạo Dropzone
        var myDropzone = new Dropzone("#kt_dropzonejs_example_1", {
            url: "{{ route('county-provider-payment-report.store') }}", 
            paramName: "payment_report_file",
            maxFiles: 10, 
            maxFilesize: 10, 
            addRemoveLinks: true, 
            acceptedFiles: ".zip", 
            parallelUploads: 10, 
            autoProcessQueue: false,
            init: function () {
                var submitButton = document.getElementById("submit-button");

                // Tắt nút submit cho đến khi ít nhất một tệp được thêm vào
                this.on("addedfile", function () {
                    submitButton.removeAttribute("disabled");
                });

                // Xử lý hàng đợi khi nút submit được nhấn
                submitButton.addEventListener("click", function () {
                    myDropzone.processQueue();
                });

                // Sự kiện khi một tệp được tải lên thành công
                this.on("success", function (file, response) {
                    // Xử lý sự kiện thành công nếu cần thiết
                    console.log(response);
                });

                // Sự kiện khi tất cả các tệp đã được tải lên
                this.on("queuecomplete", function () {
                    // Đặt lại form hoặc chuyển hướng đến trang khác sau khi tất cả các tệp được tải lên
                    document.getElementById("myform").submit(); // Thay thế "your-form" bằng ID thực tế của form bạn đang sử dụng
                });
            },
        });
    });
</script> --}}
<!-- Add this script after including the Dropzone.js library -->
<script>
    // Initialize Dropzone
    var myDropzone = new Dropzone("#kt_dropzonejs_example_1", {
        url: "{{ route('county-provider-payment-report.store') }}",
        // Only allow ZIP files to be uploaded
        acceptedFiles: ".zip",
        // Max file size is 10MB
        maxFilesize: 10,
        paramName: "payment_report_file",
        autoProcessQueue: false,

        // Trigger the upload when the form is submitted
        init: function() {
            this.on("submit", function(files) {
                $("#submit-button").prop("disabled", true);
                $("#submit-button").text("Uploading...");
                $("#myform").submit();
            });
        },
        // Show a progress bar when uploading files
        sending: function(files, xhr, formData) {
            $("#progress-bar").show();
            $("#progress-bar").val(0);
        },
        // Update the progress bar as the files are uploaded
        uploadprogress: function(file, progress, bytesSent) {
            $("#progress-bar").val(progress);
        },
        // Hide the progress bar when the upload is complete
        success: function(files, response) {
            $("#progress-bar").hide();
            $("#submit-button").prop("disabled", false);
            $("#submit-button").text("Upload");
            $("#kt_dropzonejs_example_1").removeClass("dz-started dz-dragging");
            $("#kt_dropzonejs_example_1").find(".dz-message").addClass("dz-message-success");
            $("#kt_dropzonejs_example_1").find(".dz-default-message").text("File uploaded successfully!");
        },
        // Show an error message if the upload fails
        error: function(files, response) {
            $("#progress-bar").hide();
            $("#submit-button").prop("disabled", false);
            $("#submit-button").text("Upload");
            alert("Error uploading file: " + response.message);
        }
    });

    // Change the name of the file field
    myDropzone.options.paramName = "payment_report_file";
</script>




    @endpush

</x-default-layout>