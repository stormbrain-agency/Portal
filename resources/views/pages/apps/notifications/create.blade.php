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
                <a href="{{ route('notification-management.dashboard.index') }}" class="d-flex text-center">
                    {!! getIcon('arrow-left', 'fs-2', '', 'i') !!}
                </a>
                <div class="ms-1">Add Notification</div>
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
            <form method="POST" action="{{ route('notification-management.dashboard.store') }}" class="form w-100" style="max-width: 800px;">
                @csrf
                <div class="mt-10">
                    <!-- Input Title -->
                    <div class="mb-7">
                        <label for="title" class="form-label">Notification Title:</label>
                        <input type="text" name="title" class="form-control" required>
                    </div>

                    <!-- Input Message -->
                    <div class="mb-7">
                        <label for="message" class="form-label">Message:</label>
                        <textarea class="form-control" name="message" rows="3" required></textarea>
                    </div>

                    <div class="input-group mb-7 justify-content-between gap-7">
                        <!-- Select Where to show -->
                        <div class="d-flex flex-column flex-grow-1">
                            <label for="where_to_show" class="form-label">Where to show:</label>
                            <select class="form-select" id="location" name="where_to_show">
                                <option value="1">Sitewide</option>
                                <option value="2">User</option>
                            </select>
                        </div>

                        <!-- Select Type of notification -->
                        <div class="d-flex flex-column flex-grow-1">
                            <label for="type" class="form-label">Type of notification:</label>
                            <select class="form-select" id="type" name="type">
                                <option value="1">Information</option>
                                <option value="2">Success</option>
                                <option value="3">Warning</option>
                                <option value="3">Alert</option>
                            </select>
                        </div>
                    </div>

                    <!-- Input Group for Schedule -->
                    <div class="input-group mb-7 justify-content-between gap-7">
                        <div class="d-flex flex-column flex-grow-1">
                            <label for="schedule" class="form-label">Schedule:</label>
                            <select class="form-select" id="schedule" name="schedule_status">
                                <option value="1">Yes</option>
                                <option value="2">No</option>
                            </select>
                        </div>
                        <div class="d-flex flex-column flex-grow-1">
                            <label for="from" class="form-label">From:</label>
                            <input type="datetime-local" id="schedule_start" name="schedule_start" class="form-control">
                        </div>
                        <div class="d-flex flex-column flex-grow-1">
                            <label for="till" class="form-label">Till:</label>
                            <input type="datetime-local" id="schedule_end" name="schedule_end" class="form-control">
                        </div>
                    </div>

                    <!-- Select Status -->
                    <div class="mb-7">
                        <label for="status" class="form-label">Status:</label>
                        <select class="form-select" id="status" name="status">
                            <option value="1">Active</option>
                            <option value="2">Unactive</option>
                        </select>
                    </div>
                </div>
                <hr>
                <!-- Submit Button -->
                <div class="pt-2">
                    <button type="submit" id="submit-button" class="btn btn-primary mt-2 mb-8">
                        <span class="fs-5 fw-bold indicator-label">Add Notification</span>
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
