
<div class="modal fade" id="kt_modal_update_password" tabindex="-1" aria-hidden="true" wire:ignore.self>
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header">
                <!--begin::Modal title-->
                <h2 class="fw-bold">Update Password</h2>
                <!--end::Modal title-->
                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-kt-users-modal-action="close">
                    <i class="ki-duotone ki-cross fs-1">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                </div>
                <!--end::Close-->
            </div>
            <!--end::Modal header-->
            <!--begin::Modal body-->
            <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                <!--begin::Form-->
                <form id="kt_modal_update_password_form" class="form text-left" action="#" wire:submit.prevent="submit">
                    <!--begin::Input group=-->
                    <div class="fv-row mb-10 text-left">
                        <label class="required form-label fs-6 mb-2">Current Password</label>
                        <input class="form-control form-control-lg form-control-solid" wire:model.defer="currentPassword" type="password" placeholder="" name="currentPassword" autocomplete="off" />
                        @error('currentPassword')
                            <span class="text-danger">{{ $message }}</span> 
                        @enderror
                    </div>
                    <!--end::Input group=-->
                    <!--begin::Input group-->
                    <div class="mb-10 fv-row" data-kt-password-meter="true">
                        <!--begin::Wrapper-->
                        <div class="mb-1">
                            <!--begin::Label-->
                            <label class="form-label fw-semibold fs-6 mb-2">New Password</label>
                            <!--end::Label-->
                            <!--begin::Input wrapper-->
                            <div class="position-relative mb-3">
                                <input class="form-control form-control-lg form-control-solid" wire:model.defer="newPassword" type="password" placeholder="" name="newPassword" autocomplete="off" />
                                @error('newPassword')
                                    <span class="text-danger">{{ $message }}</span> 
                                @enderror
                                <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2" data-kt-password-meter-control="visibility">
                                    <i class="ki-duotone ki-eye-slash fs-1">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                        <span class="path4"></span>
                                    </i>
                                    <i class="ki-duotone ki-eye d-none fs-1">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                    </i>
                                </span>
                            </div>
                            <!--end::Input wrapper-->
                            <!--begin::Meter-->
                            <div class="d-flex align-items-center mb-3" data-kt-password-meter-control="highlight">
                                <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                                <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                                <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                                <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px"></div>
                            </div>
                            <!--end::Meter-->
                        </div>
                        <!--end::Wrapper-->
                        <!--begin::Hint-->
                        <div class="text-muted">Use 8 or more characters with a mix of letters, numbers & symbols.</div>
                        <!--end::Hint-->
                    </div>
                    <!--end::Input group=-->
                    <!--begin::Input group=-->
                    <div class="fv-row mb-10 text-left">
                        <label class="form-label fw-semibold fs-6 mb-2" >Confirm New Password</label>
                        <input class="form-control form-control-lg form-control-solid" wire:model.defer="confirmPassword" type="password" placeholder="" name="confirmPassword" autocomplete="off" />
                    </div>
                    @error('confirmPassword')
                        <span class="text-danger">{{ $message }}</span> @enderror
                    <!--end::Input group=-->
                    <div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-8">
                        <div></div>

                        <!--begin::Link-->
                        <a href="{{ route('password.request') }}" target="_blank" class="link-primary">
                            Forgot Password ?
                        </a>
                        <!--end::Link-->
                    </div>
                    <!--begin::Actions-->
                    <div class="text-center pt-5">
                        <button type="reset" class="btn btn-light me-3" data-kt-users-modal-action="cancel" wire:loading.attr="disabled">Discard</button>
                        <button type="submit" class="btn btn-primary" data-kt-users-modal-action="submit">
                            <span class="indicator-label" wire:loading.remove>Submit</span>
                            <span class="indicator-progress" wire:loading wire:target>Please wait...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
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