<x-default-layout>
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
                            @foreach($user->roles as $role)
                                <!--begin::Badge-->
                                <div class="badge badge-lg badge-light-primary d-inline">{{ ucwords($role->name) }}</div>
                                <!--begin::Badge-->
                            @endforeach
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

                        @if((auth()->id() == $user->id && !$user->hasRole('county user')) || auth()->user()->hasRole('admin') )
                        <span data-bs-toggle="tooltip" data-bs-trigger="hover" title="Edit customer details">
                            <a href="#" class="btn btn-sm btn-light-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_edit_user" data-kt-action="update_row" data-kt-user-id="{{$user->id}}">Edit</a>
                        </span>
                        <livewire:user.edit-user-modal></livewire:user.edit-user-modal>
                        @endif

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
                            @if ($user->county?->county_full)
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
                            <div class="text-gray-600">{{$user->created_at->format('d M Y, h:i a')}}</div>
                            <!--begin::Details item-->
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
                @if (auth()->check() && auth()->user()->id == $user->id)
                    <!--begin:::Tab item-->
                    <li class="nav-item">
                        <a class="nav-link text-active-primary pb-4 active" data-kt-countup-tabs="true" data-bs-toggle="tab" href="#kt_user_view_overview_security">Security</a>
                    </li>
                @endif
                <!--end:::Tab item-->
                <!--begin:::Tab item-->
                @if (auth()->user()->hasRole('admin') && auth()->user()->id != $user->id)
                <li class="nav-item ms-auto">
                    <!--begin::Action menu-->
                    <a href="#" class="btn btn-primary ps-7" data-kt-menu-trigger="click" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">Actions
                        <i class="ki-duotone ki-down fs-2 me-0"></i></a>
                    <!--begin::Menu-->
                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold py-4 w-250px fs-6" data-kt-menu="true">
                        <!--begin::Menu item-->
                        @if ($user->status == 1)
                        <form method="POST" action="{{ route('user-management.county-users.destroy', $user) }}" class="menu-item px-5" id="deleteUserForm">
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
                @endif
            </ul>
            <!--end:::Tabs-->
            <!--begin:::Tab content-->
            <div class="tab-content" id="myTabContent">
                <!--begin:::Tab pane-->
                <div class="tab-pane fade show active" id="kt_user_view_overview_security" role="tabpanel">
                    <!--begin::Card-->
                    <div class="card pt-4 mb-6 mb-xl-9">
                        <!--begin::Card header-->
                        <div class="card-header border-0">
                            <!--begin::Card title-->
                            <div class="card-title">
                                <h2>Security/2FA</h2>
                            </div>
                            <!--end::Card title-->
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body pt-0 pb-5">
                            <!--begin::Table wrapper-->
                            <div class="table-responsive">
                                <!--begin::Table-->
                                    <table class="table align-middle table-row-dashed gy-5" id="kt_table_users_login_session">
                                        <tbody class="fs-6 fw-semibold text-gray-600">
                                            <tr>
                                                <td>Password</td>
                                                <td>******</td>
                                                <td class="text-end">
                                                    <button type="button" class="btn btn-icon btn-active-light-primary w-30px h-30px ms-auto" data-bs-toggle="modal" data-bs-target="#kt_modal_update_password">
                                                        <i class="ki-duotone ki-pencil fs-3">
                                                            <span class="path1"></span>
                                                            <span class="path2"></span>
                                                        </i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Mobile Phone</td>
                                                <td>{{$user->getFormattedMobilePhoneAttribute()}}</td>
                                                <td class="text-end">
                                                    <button type="button" class="btn btn-icon btn-active-light-primary w-30px h-30px ms-auto" data-bs-toggle="modal" data-bs-target="#kt_modal_update_mobile_phone">
                                                        <i class="ki-duotone ki-pencil fs-3">
                                                            <span class="path1"></span>
                                                            <span class="path2"></span>
                                                        </i>
                                                    </button>
                                                </td>
                                            </tr>
                                           
                                        </tbody>
                                    </table>
                                <!--end::Table-->
                            </div>
                            <!--end::Table wrapper-->
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
    <!--begin::Modal - Update user details-->
    @include('pages.apps/user-management/users/modals/_update-details')
    <!--end::Modal - Update user details-->
    <!--begin::Modal - Add schedule-->
    @include('pages.apps/user-management/users/modals/_add-schedule')
    <!--end::Modal - Add schedule-->
    <!--begin::Modal - Add one time password-->
    @include('pages.apps/user-management/users/modals/_add-one-time-password')
    <!--end::Modal - Add one time password-->
    <!--begin::Modal - Update email-->
    @include('pages.apps/user-management/users/modals/_update-email')
    <!--end::Modal - Update email-->
    <!--begin::Modal - Update password-->
    {{-- @include('pages.apps/user-management/users/modals/_update-password') --}}
   @if (auth()->check() && auth()->user()->id == $user->id)
        <livewire:user.user-update-password></livewire:user.user-update-password>
        <livewire:user.user-update-mobile-phone></livewire:user.user-update-mobile-phone>
    @endif


    <!--end::Modal - Update password-->
    <!--begin::Modal - Update role-->
    @include('pages.apps/user-management/users/modals/_update-role')
    <!--end::Modal - Update role-->
    <!--begin::Modal - Add auth app-->
    @include('pages.apps/user-management/users/modals/_add-auth-app')
    <!--end::Modal - Add auth app-->
    <!--begin::Modal - Add task-->
    @include('pages.apps/user-management/users/modals/_add-task')
    <!--end::Modal - Add task-->
    <!--end::Modals-->
    @push('scripts')
        <script>
          
            document.querySelectorAll('[data-kt-action="update_row"]').forEach(function (element) {
                element.addEventListener('click', function () {
                    Livewire.emit('update_user', this.getAttribute('data-kt-user-id'));
                });
            });
            document.addEventListener('livewire:load', function () {
                Livewire.on('success', function () {
                    $('#kt_modal_edit_user').modal('hide'); 
                    
                    setTimeout(() => {
                        
                        window.location.reload();
                    }, 1000);
                });
            });
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


        </script>
    @endpush
</x-default-layout>
