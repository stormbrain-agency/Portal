<x-default-layout>

    @section('title')
        Users Pending Profile
    @endsection
    <!--begin::Layout-->
    <div class="d-flex flex-column flex-lg-row">
        <!--begin::Sidebar-->
        <div class="flex-column flex-lg-row-auto w-lg-250px w-xl-350px mb-10">
            <!--begin::Card-->
            <div class="card mb-5 mb-xl-8">
                <!--begin::Card body-->
                <div class="card-body">
                    <!--begin::Summary-->
                    <!--begin::User Info-->
                    <div class="d-flex flex-center flex-column py-5">
                        <!--begin::Avatar-->
                        <div class="symbol symbol-100px symbol-circle mb-7">
                            @if($user->profile_photo_url)
                                <img src="{{ $user->profile_photo_url }}" alt="image"/>
                            @else
                                <div class="symbol-label fs-3 {{ app(\App\Actions\GetThemeType::class)->handle('bg-light-? text-?', $user->first_name) }}">
                                    {{ substr($user->first_name, 0, 1) }}
                                </div>
                            @endif
                        </div>
                        <!--end::Avatar-->
                        <!--begin::Name-->
                        <a href="#" class="fs-3 text-gray-800 text-hover-primary fw-bold mb-3">{{ $user->first_name}} {{$user->last_name}}</a>
                        <!--end::Name-->
                        <!--begin::Position-->
                        <div class="mb-9">
                            @if($user->status == 0)
                                <div class="badge badge-lg badge-light-warning d-inline">Approval Needed</div>
                            @elseif($user->status == 2)
                                <div class="badge badge-lg badge-light-danger d-inline">Declined</div>
                            @endif
                        </div>
                        <!--end::Position-->
                    
                        <!--end::Info-->
                    </div>
                    <!--end::User Info-->
                    <!--end::Summary-->
                    <!--begin::Details toggle-->
                    <div class="d-flex flex-stack fs-4 py-3">
                        <div class="fw-bold rotate collapsible" data-bs-toggle="collapse" href="#kt_user_view_details" role="button" aria-expanded="false" aria-controls="kt_user_view_details">Details
                            <span class="ms-2 rotate-180">
                                <i class="ki-duotone ki-down fs-3"></i>
                            </span>
                        </div>
                    </div>
                    <!--end::Details toggle-->
                    <div class="separator"></div>
                    <!--begin::Details content-->
                    <div id="kt_user_view_details" class="collapse show">
                        <div class="pb-5 fs-6">
                        
                            <!--begin::Details item-->
                            <!--begin::Details item-->
                            @if ($user->email)
                            <div class="fw-bold mt-5">Email</div>
                            <div class="text-gray-600">
                                <a href="#" class="text-gray-600 text-hover-primary">{{$user->email}}</a>
                            </div>
                            @endif
                            <!--begin::Details item-->
                            <!--begin::Details item-->
                            @if ($user->business_phone)
                            <div class="fw-bold mt-5">Business Phone</div>
                            <div class="text-gray-600">
                                {{$user->business_phone}}
                            </div>
                            @endif
                            <!--begin::Details item-->
                            <!--begin::Details item-->
                            @if ($user->mobile_phone)
                            <div class="fw-bold mt-5">Mobile Phone</div>
                            <div class="text-gray-600">{{$user->getFormattedMobilePhoneAttribute()}}</div>
                            @endif
                            <!--begin::Details item-->
                            <!--begin::Details item-->
                            @if ($user->mailing_address)
                            <div class="fw-bold mt-5">Agency Mailing Address</div>
                            <div class="text-gray-600">{{$user->mailing_address}}</div>
                            @endif
                            <!--begin::Details item-->
                            <!--begin::Details item-->
                            @if ($user->vendor_id)
                            <div class="fw-bold mt-5">Vendor ID Number</div>
                            <div class="text-gray-600">{{$user->vendor_id}}</div>
                            @endif
                            <!--begin::Details item-->
                            <!--begin::Details item-->
                            @if ($user->vendor_id)
                            <div class="fw-bold mt-5">County Designation</div>
                            <div class="text-gray-600">{{$user->county->county_full}}</div>
                            @endif
                            <!--begin::Details item-->
                            <!--begin::Details item-->
                            <div class="fw-bold mt-5">Last Login</div>
                            <div class="text-gray-600">{{$user->last_login_at ? $user->last_login_at->diffForHumans() : $user->updated_at->diffForHumans()}}</div>
                            <!--begin::Details item-->
                            <!--begin::Details item-->
                            <div class="fw-bold mt-5">Joined Date</div>
                            <div class="text-gray-600">
                                @if($user->created_at)
                                    {{ $user->created_at->format('d M Y, h:i a') }}
                                @else
                                    No joined date available
                                @endif
                            </div>

                        </div>
                    </div>
                    <!--end::Details content-->
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Card-->
        </div>
        <!--end::Sidebar-->
        <!--begin::Content-->
        <div class="flex-lg-row-fluid ms-lg-15">
            <!--begin:::Tabs-->
            <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-semibold mb-8">
                <!--begin:::Tab item-->
                <li class="nav-item">
                    <a class="nav-link text-active-primary pb-4 active" data-kt-countup-tabs="true" data-bs-toggle="tab" href="#kt_user_view_w9_files">W-9 Files</a>
                </li>
                <!--end:::Tab item-->
                
                <!--begin:::Tab item-->
                <li class="nav-item ms-auto">
                    <!--begin::Action menu-->
                    <a href="#" class="btn btn-primary ps-7" data-kt-menu-trigger="click" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">Actions
                        <i class="ki-duotone ki-down fs-2 me-0"></i></a>
                    <!--begin::Menu-->
                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold py-4 w-200px fs-6" data-kt-menu="true">
                        @if ($user->status == 0)
                        <!--begin::Menu item-->
                        <div class="menu-item px-5">
                            <a href={{ route('user-management.county-users.approve', $user) }} id="approveUser" class="menu-link px-5">Approve User</a>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-5 my-1">
                            <a href={{ route('user-management.county-users.deny', $user) }} id="denyUser" class="menu-link px-5 text-danger">Deny User</a>
                        </div>
                        <!--end::Menu item-->
                        @endif
                        <!--begin::Menu item-->
                        @if ($user->status == 2)
                        <form method="POST" action="{{ route('user-management.users.destroy', $user) }}" class="menu-item px-5" id="deleteUserForm">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-white menu-link text-danger px-5 w-100">Delete User</button>
                        </form>
                        @endif
                        <!--end::Menu item-->
                    </div>
                    <!--end::Menu-->
                    <!--end::Menu-->
                </li>
                <!--end:::Tab item-->
            </ul>
            <!--end:::Tabs-->
            <!--begin:::Tab content-->
            <div class="tab-content" id="myTabContent">
                <!--begin:::Tab pane-->
                <div class="tab-pane fade show active" id="kt_user_view_w9_files" role="tabpanel">
                    <!--begin::Card-->
                    <div class="card card-flush mb-6 mb-xl-9">
                        <!--begin::Card header-->
                        <div class="card-header mt-6">
                            <!--begin::Card title-->
                            <div class="card-title flex-column">
                                <h2 class="mb-1">W-9 file of user</h2>
                                <div class="fs-6 fw-semibold text-muted">Download to view file</div>
                            </div>
                            <!--end::Card title-->
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body p-9 pt-4">
                            <!--begin::Day-->
                                <div class="tab-pane fade show">

                                    @if ($w9Uploads && count($w9Uploads) > 0)
                                        @foreach($w9Uploads as $w9Upload)
                                        <!--begin::Time-->
                                        <div class="d-flex flex-stack position-relative mt-6">
                                            <!--begin::Bar-->
                                            <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>
                                            <!--end::Bar-->
                                            <!--begin::Info-->
                                            <div class="fw-semibold ms-5">
                                                <!--begin::Time-->
                                                <div class="fs-7 mb-1">{{$w9Upload->created_at->format('d M Y, h:i a')}}
                                                    <span class="fs-7 text-muted text-uppercase"></span>
                                                </div>
                                                <!--end::Time-->
                                                <!--begin::Title-->
                                                <p class="fs-5 fw-bold text-dark text-hover-primary mb-2">{{$w9Upload->original_name}}</p>
                                                <!--end::Title-->
                                                <!--begin::User-->
                                                {{-- <div class="fs-7 text-muted">Lead by
                                                    <a href="#">David Stevenson</a>
                                                </div> --}}
                                                <!--end::User-->
                                            </div>
                                            <!--end::Info-->
                                            <!--begin::Action-->
                                            <a href="{{ route('w9_upload.w9_download', ['w9_id' => $w9Upload->id, 'filename' => $w9Upload->original_name]) }}" class="btn btn-primary bnt-active-light-primary btn-sm">Download</a>
                                            {{-- <a href="" class="btn btn-primary">Download</a> --}}
                                            <!--end::Action-->
                                        </div>
                                        <!--end::Time-->
                                        @endforeach
                                    @else
                                    <div class="d-flex flex-stack position-relative mt-6">
                                        <div class="fw-semibold ms-5">
                                            <!--begin::Title-->
                                            <p href="#" class="fs-5 fw-bold text-dark text-hover-primary mb-2">No file found</p>
                                            <!--end::Title-->
                                        </div>
                                    @endif
                                </div>
                                <!--end::Day-->
    
                            
                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Card-->
                </div>
                <!--end:::Tab pane-->
            </div>
            <!--end:::Tab content-->
        </div>
        <!--end::Content-->
    </div>
    <!--end::Layout-->
    <!--begin::Modals-->
    @push('scripts')
        <script>
             document.getElementById('deleteUserForm').addEventListener('submit', function (event) {
                event.preventDefault();

                Swal.fire({
                    text: "This action will delete this user's data!\nAre you sure?",
                    icon: "warning",
                    buttonsStyling: false,
                    showCancelButton: true,
                    confirmButtonText: "Yes",
                    cancelButtonText: "No",
                    customClass: {
                        confirmButton: "btn btn-danger",
                        cancelButton: "btn btn-secondary",
                    },
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('deleteUserForm').submit();
                    }
                });
            });
            
            document.getElementById('approveUser').addEventListener('click', function (event) {
                event.preventDefault(); 
                Swal.fire({
                    text: "Approve this User ?",
                    icon: "info",
                    buttonsStyling: false,
                    showCancelButton: true,
                    confirmButtonText: "Yes",
                    cancelButtonText: "No",
                    customClass: {
                        confirmButton: "btn btn-primary",
                        cancelButton: "btn btn-secondary",
                    },
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = document.getElementById('approveUser').getAttribute('href');
                    }
                });
            });
            document.getElementById('denyUser').addEventListener('click', function (event) {
                event.preventDefault(); 
                Swal.fire({
                    text: "This action will reject this user!\nAre you sure?",
                    icon: "warning",
                    buttonsStyling: false,
                    showCancelButton: true,
                    confirmButtonText: "Yes",
                    cancelButtonText: "No",
                    customClass: {
                        confirmButton: "btn btn-danger",
                        cancelButton: "btn btn-secondary",
                    },
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = document.getElementById('denyUser').getAttribute('href');
                    }
                });
            });
            
           
        </script>
    @endpush
</x-default-layout>
