
<div class="modal fade" id="kt_modal_update_mobile_phone" tabindex="-1" aria-hidden="true" wire:ignore.self>
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header">
                <!--begin::Modal title-->
                <h2 class="fw-bold">Update Mobile Phone</h2>
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
                <form id="kt_modal_update_mobile_phone_form" class="form text-left" action="#" wire:submit.prevent="submit">
                    <!--begin::Input group=-->
                    <div class="fv-row mb-10 text-left">
                        <label class="form-label fs-6 mb-2">Current Mobile Phone</label>
                        <input class="form-control form-control-lg form-control-solid" value="{{$currentMobilePhone}}" readonly wire:model.defer="currentMobilePhone" type="text" placeholder="" name="currentMobilePhone" autocomplete="off" />
                        @error('currentPassword')
                            <span class="text-danger">{{ $message }}</span> 
                        @enderror
                    </div>
                    <!--end::Input group=-->
                    <!--begin::Input group=-->
                    <div class="fv-row mb-10 text-left">
                        <label class="required form-label fw-semibold fs-6 mb-2" >New Mobile Phone</label>
                        <input class="form-control form-control-lg form-control-solid" wire:model.defer="newMobilePhone" type="text" placeholder="" name="newMobilePhone" autocomplete="off" />
                    </div>
                    @error('newMobilePhone')
                        <span class="text-danger">{{ $message }}</span> @enderror
                    <!--end::Input group=-->
                    <!--begin::Actions-->
                    <div class="text-center pt-15">
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