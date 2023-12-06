<x-default-layout>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.alert.css') }}">

<style>
.drop-zone--over {
  border-style: solid;
}

.drop-zone__input {
  display: none;
}

.drop-zone__thumb {
  width: 100%;
  height: 100%;
  border-radius: 5px;
  overflow: hidden;
  background-color: #ffffff;
  background-size: cover;
  position: relative;
}

.drop-zone__thumb::after {
  content: attr(data-label);
  position: absolute;
  bottom: 0;
  left: 0;
  width: 100%;
  padding: 1px 0;
  color: #ffffff;
  background: #002559;
  font-size: 14px;
  text-align: center;
}

.input-comment{
    display: flex;
    max-width: 1091px;
    width: -webkit-fill-available;
    height: 100px;
    padding: 15px 12px;
    align-items: flex-start;
    gap: 10px;
    border-radius: 6px;
    border: 1px solid #596D87;
}
.upload-text{
    color: #192D50;
font-size: 15px;
font-style: normal;
font-weight: 500;
line-height: 16px;
}
</style>
    {{-- @section('title')
    Monthly Payment Report Submission
    @endsection --}}
    <div class="card">
        <!--begin::Card header-->
        <div class="card-header border-0 pt-6">
            <!--begin::Card title-->
            <div class="card-title">
                Submit MRAC/ARAC
            </div>
            <!--begin::Card toolbar-->
            <div class="card-toolbar gx-10 d-flex" style="gap: 20px">
            </div>
        </div>
        <!--end::Card header-->
        @if(session('success'))
        <div class="card-body py-4 d-flex justify-content-center align-content-center">
            <div class="success-upload d-flex flex-column justify-content-center align-items-center align-content-center h-100" style="height: 70vh !important;">
                <i class="ki-duotone ki-questionnaire-tablet fs-5x text-primary">
                    <span class="path1"></span>
                    <span class="path2"></span>
                </i>
                <p class="fw-semibold fs-2">Nice work!</p>
                <p class="fw-medium text-success fs-4"> {{ session('success') }}</p>
                <a href="{{ route('county-mrac-arac.index') }}" class="btn btn-outline rounded-3 btn-outline-solid btn-outline-dark-subtle text-body-emphasis btn-active-light-dark">VIEW SUBMISSION HISTORY</a>
            </div>
        </div>
        @else
        <!--begin::Card body-->
        <div class="card-body py-4 pt-0">
            <span class="text-gray-700 fs-6"><i>If you have any questions, refer to our <a class="text-gray-700 fs-6 text-decoration-underline" href="{{route('help-faq')}}">FAQs</a> or submit a request via our <a class="text-gray-700 fs-6 text-decoration-underline" target="_blank" href="https://supplementalratepayment.org/contact-us/">contact us</a> form.</i> </span>
            <br>
            <a href="{{ route('county-mrac-arac.download_template') }}" class="btn btn-bg-primary me-6 text-light mt-5">
                <i class="ki-duotone ki-arrow-down text-light">
                    <span class="path1"></span>
                    <span class="path2"></span>
                </i>Download Template</a>
            <hr>

            <form action="{{ route('county-mrac-arac.store') }}" method="POST" id="myform" class="form" enctype="multipart/form-data">
                @csrf
                <!--begin::Scroll-->
                <div class="d-flex flex-column">
                    <!--begin::Input group-->
                    <div class="fv-row mb-7">
                        <!--begin::Label-->
                        <label class="required fw-bold fs-6 mb-2">Please select Report Period:</label>
                        <div class="row">
                            <div class="col-12">
                                <select name="month_year" id="month_year" style="width: 250px;" class="form-select border border-gray-500 mb-3 mb-lg-0 text-center form-control bg-transparent">
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
                        <label class="required fw-bold fs-6 mb-2">Document Upload:</label>
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
                                    <h3 class="fs-5 fw-bold text-gray-900 mb-1 mt-3">Upload MRAC/ARAC Files</h3>
                                    <p class="fs-7 fw-semibold text-gray-500 drop-zone__prompt">Drag & Drop or <span class="text-decoration-underline">choose files</span> from computer</p>
                                    <p class="fs-7 fw-semibold text-gray-500 font-italic">
                                        <i>
                                            This portal site is not a storage system, but rather a secure site for transferring documents.
                                            As such, all documents in any folder will be permanently deleted after 30 days.</p>
                                        </i>
                                </div>
                                <!--end::Info-->
                            </div>
                            <input type="file" multiple name="mrac_arac_files[]" class="drop-zone__input form-control-file" id="mrac_arac_file">

                        </div>
                        <!--end::Dropzone-->
                       @foreach ($errors->get('mrac_arac_files.*') as $error)
                            @foreach ($error as $message)
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @endforeach
                        @endforeach

                        @if($errors->has('mrac_arac_files'))
                            <span class="text-danger">{{ $errors->first('mrac_arac_files') }}</span>
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
                @if(session('error'))
                    <div class="alert alert-danger d-flex align-items-center p-5 mb-1">
                        <i class="ki-duotone ki-shield-tick fs-2hx text-danger me-4"><span class="path1"></span><span class="path2"></span></i>                    <div class="d-flex flex-column">
                            <h4 class="mb-1 text-danger">Error</h4>
                            <span>{{ session('error') }}</span>
                        </div>
                    </div>
                @endif
                <div class="pt-2">
                    <button type="submit" id="submit-button" class="btn btn-primary">
                        <span class="indicator-label">Upload</span>
                    </button>
                </div>
                <!--end::Actions-->
            </form>
        </div>
        <!--end::Card body-->
        @endif
    </div>
    @push('scripts')

<!-- Add this script after including the Dropzone.js library -->
<script>
    document.querySelectorAll(".drop-zone__input").forEach((inputElement) => {
  const dropZoneElement = inputElement.closest(".dropzone");

  dropZoneElement.addEventListener("click", (e) => {
    inputElement.click();
  });

  inputElement.addEventListener("change", (e) => {
      updateThumbnail(dropZoneElement, inputElement.files);
  });

  dropZoneElement.addEventListener("dragover", (e) => {
    e.preventDefault();
    dropZoneElement.classList.add("drop-zone--over");
  });

  ["dragleave", "dragend"].forEach((type) => {
    dropZoneElement.addEventListener(type, (e) => {
      dropZoneElement.classList.remove("drop-zone--over");
    });
  });

  dropZoneElement.addEventListener("drop", (e) => {
    e.preventDefault();

    if (e.dataTransfer.files.length) {
      inputElement.files = e.dataTransfer.files;
      updateThumbnail(dropZoneElement, e.dataTransfer.files);
    }

    dropZoneElement.classList.remove("drop-zone--over");
  });
});

/**
 * Updates the thumbnail on a drop zone element.
 *
 * @param {HTMLElement} dropZoneElement
 * @param {File} file
 */
function updateThumbnail(dropZoneElement, files) {
    let thumbnailElement = dropZoneElement.querySelector(".drop-zone__thumb");
    let promptElement = dropZoneElement.querySelector(".drop-zone__prompt");
    if (thumbnailElement) {
        if (promptElement) {
            if (files.length > 0) {
                promptElement.style.display = 'none';
                thumbnailElement.style.display = 'block';
            } else {
                promptElement.style.display = 'block';
                thumbnailElement.style.display = 'none';
            }
        }
    }

    const fileListElement = document.createElement('ul');
    fileListElement.classList.add('drop-zone__file-list');
    if (!thumbnailElement) {
        thumbnailElement = document.createElement('div');
        thumbnailElement.classList.add('drop-zone__thumb', 'dz-message', 'needsclick', 'justify-content-center', 'w-50', 'mx-auto');
        dropZoneElement.appendChild(thumbnailElement);
    }

    thumbnailElement.innerHTML = '';
    for (const file of files) {
        const listItemElement = document.createElement('li');
        listItemElement.textContent = file.name;
        fileListElement.appendChild(listItemElement);
    }
    thumbnailElement.appendChild(fileListElement);
}

</script>




@endpush

</x-default-layout>