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
                <a href="{{ route('notification-management.index') }}" class="text-center">
                    {!! getIcon('black-left', 'fs-2', '', 'i') !!}
                </a>
                <p>Edit Notification</p>
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
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <form method="POST" action="{{ route('notification-management.update', ['id' => $notification->id]) }}" class="form form-edit-notification">
                @csrf
                @method('PUT')
                <div class="container mt-5">
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <!-- Input Title -->
                            <div class="mb-3">
                                <label for="title" class="form-label">Notification Title:</label>
                                <input type="text" id="title" name="title" class="form-control" value="{{ $notification->title }}" required>
                            </div>

                            <!-- Input Message -->
                            <div class="mb-3">
                                <label for="message" class="form-label">Message:</label>
                                <textarea class="form-control" id="message" name="message" value="{{ $notification->message }}" rows="3">{{ $notification->message }}</textarea>
                            </div>

                            <!-- Select Where to show -->
                            <div class="mb-3">
                                <label for="where_to_show" class="form-label">Where to show:</label>
                                <select class="form-select" id="location" name="where_to_show">
                                    <option value="Sitewide" @if($notification->location == 'Sitewide') selected @endif>Sitewide</option>
                                    <option value="User" @if($notification->location == 'User') selected @endif>User</option>
                                </select>
                            </div>

                            <!-- Select Type of notification -->
                            <div class="mb-3">
                                <label for="type" class="form-label">Type of notification:</label>
                                <select class="form-select" id="type" name="type">
                                    <option value="Information" @if($notification->type == 'Information') selected @endif>Information</option>
                                    <option value="Success" @if($notification->type == 'Success') selected @endif>Success</option>
                                    <option value="Warning" @if($notification->type == 'Warning') selected @endif>Warning</option>
                                    <option value="Alert" @if($notification->type == 'Alert') selected @endif>Alert</option>
                                </select>
                            </div>

                            <!-- Input Group for Schedule -->
                            <div class="input-group mb-3">
                                <label for="schedule" class="form-label">Schedule:</label>
                                <select class="form-select" id="schedule" name="schedule_status">
                                    <option value="Yes" @if($notification->schedule_status == 'Yes') selected @endif>Yes</option>
                                    <option value="No" @if($notification->schedule_status == 'No') selected @endif>No</option>
                                </select>

                                <label for="from" class="form-label">From:</label>
                                <input type="datetime-local" name="schedule_start" class="form-control"
                                value="{{ !empty($notification->schedule_start) ? \Carbon\Carbon::parse($notification->schedule_start)->format('Y-m-d\TH:i') : '' }}">

                                <label for="till" class="form-label">Till:</label>
                                <input type="datetime-local" name="schedule_end" class="form-control"
                                value="{{ !empty($notification->schedule_end) ? \Carbon\Carbon::parse($notification->schedule_end)->format('Y-m-d\TH:i') : '' }}">
                            </div>

                            <!-- Select Status -->
                            <div class="mb-3">
                                <label for="status" class="form-label">Status:</label>
                                <select class="form-select" id="status" name="status">
                                    <option value="Active" @if($notification->status == 'Active') selected @endif>Active</option>
                                    <option value="Unactive" @if($notification->status == 'Unactive') selected @endif>Unactive</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <!-- DELETE Button -->
                <button type="submit" id="delete-button" class="btn btn-danger" data-notification-id="{{ $notification->id }}">
                    <span class="indicator-label">Delete Notification</span>
                </button>
                <!-- DISCARD Button -->
                <button type="button" id="discard-button" class="btn btn-secondary">
                    <span class="indicator-label">DISCARD CHANGES</span>
                </button>
                <!-- SAVE CHANGES Button -->
                <button type="submit" id="submit-button" class="btn btn-primary">
                    <span class="indicator-label">SAVE CHANGES</span>
                </button>
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
                        window.location.href = '/notification-management/';
                    }
                });

                $('#delete-button').on('click', function () {
                    var notificationId = $(this).data('notification-id');

                    $.ajax({
                        url: '/notification-management/delete/' + notificationId,
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (data) {
                            console.log(data);
                            window.location.href = '/notification-management/';
                            alert('Notification deleted successfully.');
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
