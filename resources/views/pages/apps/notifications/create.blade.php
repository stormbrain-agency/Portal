<x-default-layout>
    {{-- @section('title')
    Monthly Payment notifications_ Submission
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
                <a href="{{ route('notification-management.index') }}" class="text-center">
                    {!! getIcon('black-left', 'fs-2', '', 'i') !!}
                </a>
                <p>Add Notification</p>
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
            <form method="POST" action="{{ route('notification-management.store') }}" class="form">
                @csrf
                <div class="container mt-5">
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <!-- Input Title -->
                            <div class="mb-3">
                                <label for="title" class="form-label">Notification Title:</label>
                                <input type="text" name="title" class="form-control" required>
                            </div>

                            <!-- Input Message -->
                            <div class="mb-3">
                                <label for="message" class="form-label">Message:</label>
                                <textarea class="form-control" name="message" rows="3" required></textarea>
                            </div>

                            <!-- Select Where to show -->
                            <div class="mb-3">
                                <label for="where_to_show" class="form-label">Where to show:</label>
                                <select class="form-select" id="location" name="where_to_show">
                                    <option value="1">Sitewide</option>
                                    <option value="2">User</option>
                                </select>
                            </div>

                            <!-- Select Type of notification -->
                            <div class="mb-3">
                                <label for="type" class="form-label">Type of notification:</label>
                                <select class="form-select" id="type" name="type">
                                    <option value="1">Information</option>
                                    <option value="2">Success</option>
                                    <option value="3">Warning</option>
                                    <option value="3">Alert</option>
                                </select>
                            </div>

                            <!-- Input Group for Schedule -->
                            <div class="input-group mb-3">
                                <label for="schedule" class="form-label">Schedule:</label>
                                <select class="form-select" id="schedule" name="schedule_status">
                                    <option value="1">Yes</option>
                                    <option value="2">No</option>
                                </select>

                                <label for="from" class="form-label">From:</label>
                                <input type="datetime-local" id="schedule_start" name="schedule_start" class="form-control">

                                <label for="till" class="form-label">Till:</label>
                                <input type="datetime-local" id="schedule_end" name="schedule_end" class="form-control">
                            </div>

                            <!-- Select Status -->
                            <div class="mb-3">
                                <label for="status" class="form-label">Status:</label>
                                <select class="form-select" id="status" name="status">
                                    <option value="1">Active</option>
                                    <option value="2">Unactive</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <!-- Submit Button -->
                <div class="pt-2">
                    <button type="submit" id="submit-button" class="btn btn-primary">
                        <span class="indicator-label">Add Notification</span>
                    </button>
                </div>
            </form>

        </div>
        <!--end::Card body-->
    </div>
    @push('scripts')
        <script>
            $(document).ready(function () {
                $('#schedule').on('change', function () {
                    var scheduleValue = $(this).val();
                    if (scheduleValue === '2') {
                        $('#schedule_start').prop('disabled', true);
                        $('#schedule_end').prop('disabled', true);
                    } else {
                        $('#schedule_start').prop('disabled', false);
                        $('#schedule_end').prop('disabled', false);
                    }
                });
            });
        </script>
    @endpush
</x-default-layout>
