<x-default-layout>
    {{-- @section('title')
    Monthly Payment notifications_ Submission
    @endsection --}}
    {{-- @if(session('success'))
       <div class="alert alert-success">
           {{ session('success') }}
       </div>
   @endif --}}
    <div class="card" wire:ignore.self>
        <!--begin::Card header-->
        <div class="card-header border-0 pt-6">
            <!--begin::Card title-->
            <div class="card-title">
                <a href="{{ route('notification-management.email.index') }}" class="d-flex text-center">
                    {!! getIcon('arrow-left', 'fs-2', '', 'i') !!}
                </a>
                <div class="ms-1">Edit Notification</div>
            </div>
            <!--begin::Card toolbar-->
            <div class="card-toolbar gx-10 d-flex" style="gap: 20px">
            </div>
        </div>
        <!--end::Card header-->

        <!--begin::Card body-->
        <div class="card-body py-4">
            <hr>
            @if(session('success'))
                @if (auth()->user()->hasRole('admin'))
                    <div class="alert bg-light-success border-success d-flex align-items-center p-5">
                        <i class="ki-duotone ki-shield-tick fs-2hx text-success me-4"><span class="path1"></span><span class="path2"></span></i>
                        <div class="d-flex flex-column">
                            <h4 class="mb-1 text-dark">Success</h4>
                            <span>{{ session('success') }}</span>
                        </div>
                        <button type="button" class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto" data-bs-dismiss="alert">
                            <i class="ki-duotone ki-cross fs-1 text-success"><span class="path1"></span><span class="path2"></span></i>
                        </button>
                    </div>
                @endif
            @endif
            <form method="POST" action="{{ route('notification-management.email.update', ['id' => $notification->id]) }}" class="form form-edit-notification w-50">
                @csrf
                @method('PUT')
                <div class="mt-10">
                    <div class="mt-10">
                        <!-- Input Name Form -->
                        <div class="mb-7">
                            <label for="name_form" class="form-label">Name Form:</label>
                            <input type="text" name="name_form" class="form-control" value="{{ $notification->name_form }}" required>
                        </div>

                        <!-- Input Body -->
                        <div class="mb-7">
                            <label for="body" class="form-label">Body:</label>
                            <textarea class="form-control" name="body" rows="3" value="{{ $notification->body }}" required>{{ $notification->body }}</textarea>
                        </div>

                        <!-- Input Subject -->
                        <div class="mb-7">
                            <label for="subject" class="form-label">Subject:</label>
                            <textarea class="form-control" name="subject" rows="3" value="{{ $notification->subject }}" required>{{ $notification->subject }}</textarea>
                        </div>

                        <!-- Input Button Title -->
                        <div class="mb-7">
                            <label for="button_title" class="form-label">Button Title:</label>
                            <input type="text" name="button_title" class="form-control" value="{{ $notification->button_title }}" required>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="d-flex justify-content-between">
                    <!-- DELETE Button -->
                    <button type="submit" id="delete-button" class="alert alert-danger mt-3 mb-8" data-notification-id="{{ $notification->id }}">
                        <span class="fs-5 fw-bold indicator-label text-danger">Delete Notification Email</span>
                    </button>
                    <div class="d-flex">
                        <!-- DISCARD Button -->
                        <button type="button" id="discard-button" class="btn btn-secondary mt-3 mb-8">
                            <span class="indicator-label">DISCARD CHANGES</span>
                        </button>
                        <!-- SAVE CHANGES Button -->
                        <button type="submit" id="submit-button" class="btn btn-primary mt-3 mb-8 ms-3">
                            <span class="indicator-label">SAVE CHANGES</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <!--end::Card body-->
    </div>
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var scheduleSelect = document.getElementById('schedule');
                var scheduleStartInput = document.getElementById('schedule_start');
                var scheduleEndInput = document.getElementById('schedule_end');

                scheduleSelect.addEventListener('change', function () {
                    if (scheduleSelect.value === 'No') {
                        scheduleStartInput.disabled = true;
                        scheduleEndInput.disabled = true;
                    } else {
                        scheduleStartInput.disabled = false;
                        scheduleEndInput.disabled = false;
                    }
                });

                if (scheduleSelect.value === 'No') {
                    scheduleStartInput.disabled = true;
                    scheduleEndInput.disabled = true;
                }
            });
            $(document).ready(function () {
                $('#discard-button').on('click', function () {
                    var confirmDiscard = confirm('Are you sure you want to discard changes?');

                    if (confirmDiscard) {
                        window.location.href = '/notification-management/email';
                    }
                });

                $('#delete-button').on('click', function () {
                    var notificationId = $(this).data('notification-id');

                    $.ajax({
                        url: '/notification-management/email/delete/' + notificationId,
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (data) {
                            console.log(data);
                            window.location.href = '/notification-management/email';
                        },
                        error: function (error) {
                            console.error(error);
                        }
                    });
                });
            });
        </script>
    @endpush
</x-default-layout>
