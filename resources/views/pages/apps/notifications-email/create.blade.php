<x-default-layout>

    <div class="card">
        <!--begin::Card header-->
        <div class="card-header border-0 pt-6">
            <!--begin::Card title-->
            <div class="card-title">
                <a href="{{ route('notification-management.email.index') }}" class="d-flex text-center">
                    {!! getIcon('arrow-left', 'fs-2', '', 'i') !!}
                </a>
                <div class="ms-1">Add Notification Email</div>
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
            <form method="POST" action="{{ route('notification-management.email.store') }}" class="form w-100" style="max-width: 800px;">
                @csrf
                <div class="mt-10">
                    <!-- Input Name Form -->
                    <div class="mb-7">
                        <label for="name_form" class="form-label">Name of notifications:</label>
                        <select class="form-select" id="name_form" name="name_form">
                            <option value="MRAC/ARAC Admin">MRAC/ARAC Admin</option>
                            <option value="MRAC/ARAC User">MRAC/ARAC User</option>
                            <option value="Payment Report Admin">Payment Report Admin</option>
                            <option value="Payment Report User">Payment Report User</option>
                            <option value="Register Email">Register Email</option>
                            <option value="Reset Password Mail">Reset Password Mail</option>
                            <option value="Verify Email">Verify Email</option>
                            <option value="W9 Email Admin">W9 Email Admin</option>
                            <option value="W9 Email User">W9 Email User</option>
                            <option value="Welcome County Email">Welcome County Email</option>
                        </select>
                        @error('name_form')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Input Subject -->
                    <div class="mb-7">
                        <label for="subject" class="form-label">Subject:</label>
                        <textarea class="form-control" name="subject" rows="3" required></textarea>
                        @error('subject')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Input Body -->
                    <div class="mb-7">
                        <label for="body" class="form-label">Body:</label>
                        <textarea class="form-control" name="body" rows="3" required></textarea>
                        @error('body')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Input Button Title -->
                    <div class="mb-7">
                        <label for="button_title" class="form-label">Button Title:</label>
                        <input type="text" name="button_title" class="form-control" required>
                        @error('button_title')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <hr>
                <!-- Submit Button -->
                <div class="pt-2">
                    <button type="submit" id="submit-button" class="btn btn-primary mt-2 mb-8">
                        <span class="fs-5 fw-bold indicator-label">Add Notification Email</span>
                    </button>
                </div>
            </form>

        </div>
        <!--end::Card body-->
    </div>
</x-default-layout>
