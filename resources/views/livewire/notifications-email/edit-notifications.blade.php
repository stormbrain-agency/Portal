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
                <div class="ms-1">Edit Notification Mail</div>
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
            <form method="POST" action="{{ route('notification-management.email.update', ['id' => $notification->id]) }}" class="form form-edit-notification w-100" style="max-width: 800px;">
                @csrf
                @method('PUT')
                <div class="mt-10">
                    <div class="mt-10">
                        <!-- Input Name Form -->
                        <div class="input-group mb-7 justify-content-between gap-7">
                            <!-- Select Name of Notification -->
                            <div class="d-flex flex-column flex-grow-1">
                                <label for="name_form" class="form-label">Name of notification:</label>
                                <select class="form-select" id="name_form" name="name_form">
                                    <option value="mRec/aRec Admin" @if($notification->name_form == 'mRec/aRec Admin') selected @endif>mRec/aRec Admin</option>
                                    <option value="mRec/aRec User" @if($notification->name_form == 'mRec/aRec User') selected @endif>mRec/aRec User</option>
                                    <option value="Payment Report Admin" @if($notification->name_form == 'Payment Report Admin') selected @endif>Payment Report Admin</option>
                                    <option value="Payment Report User" @if($notification->name_form == 'Payment Report User') selected @endif>Payment Report User</option>
                                    <option value="Register Email" @if($notification->name_form == 'Register Email') selected @endif>Register Email</option>
                                    <option value="Reset Password Mail" @if($notification->name_form == 'Reset Password Mail') selected @endif>Reset Password Mail</option>
                                    <option value="Verify Email" @if($notification->name_form == 'Verify Email') selected @endif>Verify Email</option>
                                    <option value="W9 Email Admin" @if($notification->name_form == 'W9 Email Admin') selected @endif>W9 Email Admin</option>
                                    <option value="W9 Email User" @if($notification->name_form == 'W9 Email User') selected @endif>W9 Email User</option>
                                    <option value="Welcome County Email" @if($notification->name_form == 'Welcome County Email') selected @endif>Welcome County Email</option>
                                </select>
                                @error('name_form')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Input Subject -->
                        <div class="mb-7">
                            <label for="subject" class="form-label">Subject:</label>
                            <textarea class="form-control" name="subject" rows="3" value="{{ $notification->subject }}" required>{{ $notification->subject }}</textarea>
                            @error('subject')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Input Body -->
                        <div class="mb-7">
                            <label for="body" class="form-label">Body:</label>
                            <textarea class="form-control" name="body" rows="3" value="{{ $notification->body }}" required>{{ $notification->body }}</textarea>
                            @error('body')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Input Button Title -->
                        <div class="mb-7">
                            <label for="button_title" class="form-label">Button Title:</label>
                            <input type="text" name="button_title" class="form-control" value="{{ $notification->button_title }}" required>
                            @error('button_title')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
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
