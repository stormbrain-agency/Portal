<x-default-layout>
<style>
.drop-zone {
    max-width: 1091px;
    width: auto;
    height: 200px;
    padding: 25px;
    display: grid;
    align-items: center;
    justify-content: center;
    text-align: center;
    font-family: "Quicksand", sans-serif;
    font-weight: 500;
    font-size: 20px;
    cursor: pointer;
    color: #cccccc;
    border-radius: 7px;
    border: 1px dashed #1973B8;
    background: #F6FBFF;
}

.drop-zone--over {
  border-style: solid;
}

.drop-zone__input {
  display: none;
}

.drop-zone__thumb {
  width: 100%;
  height: 100%;
  border-radius: 10px;
  overflow: hidden;
  background-color: #cccccc;
  background-size: cover;
  position: relative;
}

.drop-zone__thumb::after {
  content: attr(data-label);
  position: absolute;
  bottom: 0;
  left: 0;
  width: 100%;
  padding: 5px 0;
  color: #ffffff;
  background: rgba(0, 0, 0, 0.75);
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
    @section('title')
        W9 List Upload
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('user-management.users.index') }}
    @endsection

    <div class="card">
        <!--begin::Card header-->
        @if(auth()->user()->hasRole('county user'))
        <div class="card-body border-0 pt-6">
        
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
            <!-- <div class="form-group">
                <input type="file" class="form-control-file" name="file" id="w9_uploadInput">
            </div> -->
            <div class="drop-zone">
                <span class="upload-text">Upload ZIP File of provider W-9s (only .zip files)</span>
                <span class="drop-zone__prompt">Drag & Drop or choose files from computer</span>
                <span class="drop-zone__prompt">This portal site is not a storage system, but rather a secure site for transferring documents.
As such, all documents in any folder will be permanently deleted after 30 days</span>
                <input type="file" name="file" class="drop-zone__input form-control-file" id="w9_uploadInput">
            </div>

            <div class="form-group">
                <p>Your Comment (max 150 characters): </p>
                <textarea name="comments" placeholder="Please write a comment here" class="input-comment"></textarea>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">Upload</button>
                <p>This portal site
                is not a storage system, but rather a secure site for
                transferring documents. As such, all documents in
                any folder will be permanently deleted after 30 days
                </p>
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
                    <input type="text" data-kt-user-table-filter="search" class="form-control form-control-solid w-250px ps-13" placeholder="Search" id="mySearchInput"/>
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
        <!--end::Card body-->
    </div>

    @push('scripts')
            {{ $dataTable->scripts() }}
            <script>
                var searchData = '';

                document.getElementById('mySearchInput').addEventListener('keyup', function () {
                    searchData = this.value;
                    window.LaravelDataTables['w9-upload-table'].search(searchData).draw();
                });
                
            </script>
            

            <script>
            document.querySelectorAll(".drop-zone__input").forEach((inputElement) => {
            const dropZoneElement = inputElement.closest(".drop-zone");

            dropZoneElement.addEventListener("click", (e) => {
                inputElement.click();
            });

            inputElement.addEventListener("change", (e) => {
                if (inputElement.files.length) {
                updateThumbnail(dropZoneElement, inputElement.files[0]);
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

                if (e.dataTransfer.files.length) {
                inputElement.files = e.dataTransfer.files;
                updateThumbnail(dropZoneElement, e.dataTransfer.files[0]);
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

            thumbnailElement.dataset.label = file.name;

            // Show thumbnail for image files
            if (file.type.startsWith("image/")) {
                const reader = new FileReader();

                reader.readAsDataURL(file);
                reader.onload = () => {
                thumbnailElement.style.backgroundImage = `url('${reader.result}')`;
                };
            } else {
                thumbnailElement.style.backgroundImage = null;
            }
            }


            </script>
    @endpush

</x-default-layout>
