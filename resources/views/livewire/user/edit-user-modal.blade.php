<div class="modal fade" id="kt_modal_edit_user" tabindex="-1" aria-hidden="true" wire:ignore.self >
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header" id="kt_modal_edit_user_header">
                <!--begin::Modal title-->
                
                <h2 class="fw-bold">Edit 
                    @if ($idUser == auth()->id())
                    Profile
                    @else
                    User
                    @endif
                </h2>
                <!--end::Modal title-->
                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal" aria-label="Close">
                    {!! getIcon('cross','fs-1') !!}
                </div>
                <!--end::Close-->
            </div>
            <!--end::Modal header-->
            <!--begin::Modal body-->
            <div class="modal-body px-5 my-7">
                <!--begin::Form-->
                <form id="kt_modal_edit_user_form" class="form" action="#" wire:submit.prevent="submit" enctype="multipart/form-data">
                    <!--begin::Scroll-->
                    <div class="d-flex flex-column scroll-y px-5 px-lg-10" id="kt_modal_edit_user_scroll" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_edit_user_header" data-kt-scroll-wrappers="#kt_modal_edit_user_scroll" data-kt-scroll-offset="300px">
                        <!--begin::Input group-->
                        <div class="fv-row mb-7">
                            <div class="row">
                                <div class="col-6">
                                    <!--begin::Label-->
                                    <label class="required fw-semibold fs-6 mb-2">First Name</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="hidden" wire:model.defer="idUser" name="idUser"/>
                                    <input type="text" wire:model.defer="first_name" name="first_name" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="First name"/>
                                    <!--end::Input-->
                                    @error('first_name')
                                    <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-6">
                                    <!--begin::Label-->
                                    <label class="required fw-semibold fs-6 mb-2">Last Name</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" wire:model.defer="last_name" name="last_name" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Last name"/>
                                    <!--end::Input-->
                                    @error('last_name')
                                    <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="required fw-semibold fs-6 mb-2">Email</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="email" wire:model.defer="email" name="email" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="example@domain.com"/>
                            <!--end::Input-->
                            @error('email')
                            <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="required fw-semibold fs-6 mb-2">Business Phone Number + Ext.</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" wire:model.defer="business_phone" id="business_phone" name="business_phone" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Business Phone Number"/>
                            <!--end::Input-->
                            @error('business_phone')
                            <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="required fw-semibold fs-6 mb-2">Mobile Phone Number.</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" wire:model.defer="mobile_phone" id="mobile_phone" name="mobile_phone" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Mobile Phone Number"/>
                            <!--end::Input-->
                            @error('mobile_phone')
                            <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="required fw-semibold fs-6 mb-2">Agency Mailing Address</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" wire:model.defer="mailing_address" name="mailing_address" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Agency Mailing Address"/>
                            <!--end::Input-->
                            @error('mailing_address')
                            <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="required fw-semibold fs-6 mb-2">Vendor ID Number</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" wire:model.defer="vendor_id" name="vendor_id" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Vendor ID Number"/>
                            <!--end::Input-->
                            @error('vendor_id')
                            <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                       <div class="fv-row mb-7">
                        <!--begin::Label-->
                        <label class="required fw-semibold fs-6 mb-2">County Designation</label>
                        <!--end::Label-->
                        <!--begin::Select-->
                        <div class="row">
                            <div class="col-6">
                                <select wire:model="stateChose" wire:change="updateCountyDropdown" id="stateDropdown" name="stateChose" class="form-select form-select-solid mb-3 mb-lg-0">
                                    <option value="">Select State</option>
                                    @if ($states && count($states) > 0)
                                        @foreach($states as $state)
                                            <option @if ($county_designation == $state->state_id) selected @endif value="{{ $state->state_id }}">{{ $state->state_name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="col-6">
                                <select wire:model.defer="county_designation" name="county_designation" class="form-select form-select-solid mb-3 mb-lg-0">
                                    <option value="">Select County</option>
                                    @if ($countyDropdown && count($countyDropdown) > 0)  
                                        @foreach($countyDropdown as $countyItem)
                                            {{ $countyItem->county_full }} - {{ $countyItem->county_fips }}<br>
                                            <option @if ($county_designation == $countyItem->county_fips) selected @endif value="{{ $countyItem->county_fips }}">{{ $countyItem->county_full }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <!--end::Select-->
                        @error('county_designation')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                        <!--end::Input group-->

                        <!--begin::Input group-->
                        {{-- <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="required fw-semibold fs-6 mb-2">W-9 File Upload</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="file" wire:model.defer="w9_file_path" name="w9_file_path" class="form-control form-control-solid mb-3 mb-lg-0" accept=".zip"/>
                            <!--end::Input-->
                            @error('w9_file_path')
                            <span class="text-danger">{{ $message }}</span> @enderror
                        </div> --}}
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        @if (auth()->check() && auth()->user()->id != $idUser)
                        <div class="mb-7">
                            <!--begin::Label-->
                            <label class="required fw-semibold fs-6 mb-5">Role</label>
                            <!--end::Label-->
                            @error('role')
                            <span class="text-danger">{{ $message }}</span> @enderror
                            <!--begin::Roles-->
                            @foreach($roles as $role)
                                <!--begin::Input row-->
                                <div class="d-flex fv-row">
                                    <!--begin::Radio-->
                                    <div class="form-check form-check-custom form-check-solid">
                                        <!--begin::Input-->
                                        <input class="form-check-input me-3" id="kt_modal_update_role_option_{{ $role->id }}" wire:model.defer="role" name="role" type="radio" value="{{ $role->name }}" checked="checked"/>
                                        <!--end::Input-->
                                        <!--begin::Label-->
                                        <label class="form-check-label" for="kt_modal_update_role_option_{{ $role->id }}">
                                            <div class="fw-bold text-gray-800">
                                                {{ ucwords($role->name) }}
                                            </div>
                                            <div class="text-gray-600">
                                                {{ $role->description }}
                                            </div>
                                        </label>
                                        <!--end::Label-->
                                    </div>
                                    <!--end::Radio-->
                                </div>
                                <!--end::Input row-->
                                @if(!$loop->last)
                                    <div class='separator separator-dashed my-5'></div>
                                @endif
                            @endforeach
                            <!--end::Roles-->
                        </div>
                        @endif
                        <!--end::Input group-->
                    </div>
                    <!--end::Scroll-->
                    <!--begin::Actions-->
                    <div class="text-center pt-5">
                        <button type="reset" class="btn btn-light me-3" data-bs-dismiss="modal" aria-label="Close" wire:loading.attr="disabled">Discard</button>
                        <button type="submit" class="btn btn-primary" data-kt-users-modal-action="submit">
                            <span class="indicator-label" wire:loading.remove>Update</span>
                            <span class="indicator-progress" wire:loading wire:target="submit">
                                Please wait...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>
                        </button>
                    </div>
                    <!--end::Actions-->
                </form>
                <!--end::Form-->
            </div>
            <!--end::Modal body-->
        </div>
        <!--end::Modal content-->
    </div>
    <!--end::Modal dialog-->
</div>

@push('scripts')
    <script>
        Inputmask({
            "mask" : "(999) 999-9999",
        }).mask("#mobile_phone");
        Inputmask({
            mask: "(999) 999-9999 ext. 9999",
        }).mask("#business_phone");
    </script>
@endpush