<x-default-layout>
    @if(auth()->user()->hasRole('county user'))

    <div class="card">
        <div class="card-header border-0 pt-6">
            <!--begin::Card title-->
            <div class="card-title">
                Monthly Payment Report Submission
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
                                    <p class="fs-7 fw-semibold text-gray-500 drop-zone__prompt">Drag & Drop or choose files from computer</p>
                                    <p class="fs-7 fw-semibold text-gray-500 font-italic">
                                        <i>
                                            This portal site is not a storage system, but rather a secure site for transferring documents.
                                            As such, all documents in any folder will be permanently deleted after 30 days.</p>
                                        </i>
                                </div>
                                <!--end::Info-->
                            </div>
                            <input type="file" name="file" class="drop-zone__input form-control-file" id="w9_uploadInput">

                        </div>
                        <!--end::Dropzone-->
                       
                        @if(session('error'))
                            <span class="text-danger">{{ session('error') }}</span>
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
    function updateThumbnail(dropZoneElement, file) {
      let thumbnailElement = dropZoneElement.querySelector(".drop-zone__thumb");
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

      // First time - remove the prompt
      if (dropZoneElement.querySelector(".drop-zone__prompt")) {
        dropZoneElement.querySelector(".drop-zone__prompt").remove();
      }

      // First time - there is no thumbnail element, so lets create it
      if (!thumbnailElement) {
        thumbnailElement = document.createElement("div");
        thumbnailElement.classList.add("drop-zone__thumb");
        dropZoneElement.appendChild(thumbnailElement);
      }

      thumbnailElement.dataset.label = inputElement.files.length;
        thumbnailElement.style.backgroundImage = null;
    }

    </script>




@endpush

</x-default-layout>