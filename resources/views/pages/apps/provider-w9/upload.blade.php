<x-default-layout>
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.alert.css') }}">

    @if(auth()->user()->hasRole('county user'))

    <div class="card">
        <div class="card-header border-0 pt-6">
            <!--begin::Card title-->
            <div class="card-title">
                Submit Provider W-9
            </div>
            <!--begin::Card toolbar-->
            <div class="card-toolbar gx-10 d-flex" style="gap: 20px">
            </div>
        </div>

        @if(session('success'))
        <div class="card-body py-4 d-flex justify-content-center align-content-center">
            <div class="success-upload d-flex flex-column justify-content-center align-items-center align-content-center h-100" style="height: 70vh !important;">
                <i class="ki-duotone ki-questionnaire-tablet fs-5x text-primary">
                    <span class="path1"></span>
                    <span class="path2"></span>
                </i>
                <p class="fw-semibold fs-2">Nice work!</p>
                <p class="fw-medium text-success fs-4"> {{ session('success') }}</p>
                <a href="{{ route('w9_upload.index') }}" class="btn btn-outline rounded-3 btn-outline-solid btn-outline-dark-subtle text-body-emphasis btn-active-light-dark">VIEW SUBMISSION HISTORY</a>
            </div>
        </div>
        @else
        <!--begin::Card body-->
        <div class="card-body py-4 pt-0">
            <!-- <span class="text-gray-700 fs-6"><i>If you have any questions, refer to our FAQs or submit a request via our contact us form.</i> </span> -->
            <form action="/county-w9/upload" method="POST" id="myform" class="form" enctype="multipart/form-data">
                @csrf
                <!--begin::Scroll-->
                <div class="d-flex flex-column">

                    <!--begin::Input group-->
                    <div class="fv-row mb-7">
                        <!--begin::Label-->
                        {{-- <label class="required fw-bold fs-6 mb-2">Document Upload</label> --}}
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
                                    <p class="fs-7 fw-semibold text-gray-500 drop-zone__prompt">Drag & Drop or choose files from computer</p>
                                    <p class="fs-7 fw-semibold text-gray-500 font-italic">
                                        <i>
                                            This portal site is not a storage system, but rather a secure site for transferring documents.
                                            As such, all documents in any folder will be permanently deleted after 30 days.</p>
                                        </i>
                                </div>
                                <!--end::Info-->
                            </div>
                            <input type="file" name="file" style="display:none" class="drop-zone__input form-control-file" id="w9_uploadInput">
                        </div>
                        <!--end::Dropzone-->
                       
                        @if(session('error'))
                            <div class="alert bg-light-danger border-danger d-flex align-items-center p-5 mt-5">
                                <i class="ki-duotone ki-shield-tick fs-2hx text-danger me-4"><span class="path1"></span><span class="path2"></span></i>
                                <div class="d-flex flex-column">
                                    <h4 class="mb-1 text-dark">This is an alert</h4>
                                    <span>The alert component can be used to highlight certain parts of your page for higher content visibility.</span>
                                </div>
                                <button type="button" class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto" data-bs-dismiss="alert">
                                    <i class="ki-duotone ki-cross fs-1 text-danger"><span class="path1"></span><span class="path2"></span></i>
                                </button>
                            </div> 
                        @endif

                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="fw-bold fs-6 mb-2">Your Comment (max 150 characters): </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <textarea id="comment" placeholder="Please write a comment here" class="border border-gray-500 mb-3 mb-lg-0 form-control bg-transparent" name="comments" id="" cols="30" rows="5s"></textarea>
                            <!--end::Input-->
                            @error('comment')
                              <div class="wrap-alert error d-flex align-items-center">
                                {!! getIcon('notification-bing','me-4') !!}
                                <div class="content" style="width: 100%;">
                                    <div class="title mb-2">There is Error Uploading Your File</div>
                                    <div class="sub-title">{{ $message }}</div>
                                </div>
                                {!! getIcon('cross','fs-1 btn-alert') !!}
                            </div> 
                            @enderror
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
        @endif
    </div>
    @endif
    @push('scripts')

    <!-- Add this script after including the Dropzone.js library -->
    <script>
        document.querySelectorAll(".drop-zone__input").forEach((inputElement) => {
        const dropZoneElement = inputElement.closest(".dropzone");

        dropZoneElement.addEventListener("click", (e) => {
            inputElement.click();
        });

        inputElement.addEventListener("change", (e) => {
            if (inputElement.files.length) {
            console.log(inputElement.files.length);
            updateThumbnail(dropZoneElement, inputElement.files);
            }
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
            
            if (e.dataTransfer.files.length > 1) {
              dropZoneElement.classList.remove("drop-zone--over");
              return;
            }

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