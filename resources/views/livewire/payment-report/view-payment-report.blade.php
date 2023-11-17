<div class="modal fade" id="kt_modal_view_payment_report" tabindex="-1" aria-hidden="true" wire:ignore.self >
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header" id="kt_modal_view_payment_report_header">
                <!--begin::Modal title-->
                <h2 class="fw-bold">View Payment Report</h2>
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
                <form id="kt_modal_view_payment_report_form" class="form" action="#" wire:submit.prevent="store" enctype="multipart/form-data">
                    <!--begin::Scroll-->
                    <div class="d-flex fs-4 flex-column scroll-y px-1 px-lg-10" id="kt_modal_view_payment_report_scroll" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_view_payment_report_header" data-kt-scroll-wrappers="#kt_modal_view_payment_report_scroll" data-kt-scroll-offset="300px">
                        <!--begin::Input group-->
                       <div class="fv-row mb-7">
                            <label class="fw-semibold mb-2"><b>Month/Year :</b>   <span>{{$monthYear}}</span></label>
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="fv-row mb-7">
                            <label class="fw-semibold mb-2"><b>Time of Submission :</b> <span>{{$created_at}}</span></label>
                        </div>
                        <div class="fv-row mb-7">
                            <label class="fw-semibold mb-2"><b>County Designation :</b> <span>{{$county_full}}</span></label>
                        </div>
                        <div class="fv-row mb-7">
                            <label class="fw-semibold mb-2"><b>User submitted :</b>
                                <span>
                                @if ($user_id)
                                    <a href="{{ route('user-management.users.show', $user_id) }}" class="text-primary-800 text-hover-primary mb-1">
                                        {{ $user_name}}
                                    </a>
                                    {{-- <span>{{ $user_email }}</span> --}}
                                @endif</span></label>
                        </div>
                        <!--end::Input group-->
                        <div class="fv-row mb-7">
                            <label class="fw-semibold mb-2"><b>Comment :</b> <span>{{$comment}}</span></label>
                        </div>

                        <div class="fv-row mb-7">
                            <label class="fw-semibold mb-2"><b>File(s) :</b></label>
                            <div class="bg-light rounded p-2 mb-2 pt-4">
                                @if ($payment_report_files && count($payment_report_files) > 0)
                                    @foreach ($payment_report_files as $file)
                                    <div class="row p-2">
                                        <div class="col-9">
                                            <p>{{$file->file_path}}</p>
                                        </div>
                                        <div class="col-3">
                                            <a href="{{ route('county-provider-payment-report.download', ['filename' => $file->file_path]) }}" class="btn btn-primary bnt-active-light-primary btn-sm">Download</a>
                                        </div>
                                    </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                    <!--end::Scroll-->
                    <!--begin::Actions-->
                    <div class="text-center pt-15">
                        <button type="reset" class="btn btn-light me-3" data-bs-dismiss="modal" aria-label="Close" wire:loading.attr="disabled">Discard</button>
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