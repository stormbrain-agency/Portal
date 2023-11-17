<div class="modal fade" id="kt_modal_add_payment_report" tabindex="-1" aria-hidden="true" wire:ignore.self >
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header" id="kt_modal_add_payment_report_header">
                <!--begin::Modal title-->
                <h2 class="fw-bold">Submit Payment Report</h2>
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
                <form id="kt_modal_add_payment_report_form" class="form" action="#" wire:submit.prevent="store" enctype="multipart/form-data">
                    <!--begin::Scroll-->
                    <div class="d-flex flex-column scroll-y px-5 px-lg-10" id="kt_modal_add_payment_report_scroll" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_add_payment_report_header" data-kt-scroll-wrappers="#kt_modal_add_payment_report_scroll" data-kt-scroll-offset="300px">
                        <!--begin::Input group-->
                       <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="required fw-semibold fs-6 mb-2">Month / Year</label>
                            <!--end::Label-->
                            <!--begin::Select-->
                            <div class="row">
                                <div class="col-6">
                                    <select wire:model="month" name="month" class="form-select form-select-solid mb-3 mb-lg-0">
                                        <option value="">Select Month</option>
                                        <option value="01">01</option>
                                        <option value="02">02</option>
                                        <option value="03">03</option>
                                        <option value="05">05</option>
                                        <option value="06">06</option>
                                        <option value="07">07</option>
                                        <option value="08">08</option>
                                        <option value="09">09</option>
                                        <option value="10">10</option>
                                        <option value="11">11</option>
                                        <option value="12">12</option>
                                    </select>
                                    @error('month')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-6">
                                    <select wire:model.defer="year" name="year" class="form-select form-select-solid mb-3 mb-lg-0">
                                        <option value="">Select Year</option>
                                        <option value="2024">2024</option>
                                        <option value="2025">2025</option>
                                    </select>
                                    @error('year')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <!--end::Select-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="required fw-semibold fs-6 mb-2">Payment Report File Upload</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="file" wire:model="payment_report_file" name="payment_report_file" class="form-control form-control-solid mb-3 mb-lg-0" multiple/>
                            <!--end::Input-->
                            {{-- @error('payment_report_file')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror --}}
                            @if($errors->has('payment_report_file'))
                                <span class="text-danger">{{ $errors->first('payment_report_file') }}</span>
                            @endif

                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="fw-semibold fs-6 mb-2">Comment</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <textarea wire:model.defer="comment" class="form-control form-control-solid mb-3 mb-lg-0" name="comment" id="" cols="30" rows="5s"></textarea>
                                <!--end::Input-->
                                @error('comment')
                                <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <!--end::Input group-->
                    </div>
                    <!--end::Scroll-->
                    <!--begin::Actions-->
                    <div class="text-center pt-15">
                        <button type="reset" class="btn btn-light me-3" data-bs-dismiss="modal" aria-label="Close" wire:loading.attr="disabled">Discard</button>
                        <button type="submit" class="btn btn-primary" data-kt-users-modal-action="submit">
                            <span class="indicator-label" wire:loading.remove>Submit</span>
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