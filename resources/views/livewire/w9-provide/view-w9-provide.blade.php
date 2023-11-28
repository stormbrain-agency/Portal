<div class="modal fade" id="kt_modal_view_w9" tabindex="-1" aria-hidden="true" wire:ignore.self >
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header" id="kt_modal_view_w9_header">
                <!--begin::Modal title-->
                <h2 class="fw-bold">View Country Provider W-9</h2>
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
                <form id="kt_modal_view_w9_form" class="form" action="#" enctype="multipart/form-data">
                    <!--begin::Scroll-->
                    <div class="d-flex fs-4 flex-column scroll-y px-1 px-lg-10" id="kt_modal_view_w9_scroll" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_view_w9_header" data-kt-scroll-wrappers="#kt_modal_view_w9_scroll" data-kt-scroll-offset="300px">
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
                                @endif</span></label>
                        </div>
                        <!--end::Input group-->
                        <div class="fv-row mb-7">
                            <label class="fw-semibold mb-2"><b>Comment :</b> <span>{{$comment}}</span></label>
                        </div>

                        <div class="fv-row mb-7">
                            <label class="fw-semibold mb-2 w-100">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <b>File(s) :</b>

                                    </div>
                                    @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('manager')) 
                                        @if (isset($file_name))
                                            <div>
                                                <a href="{{route('w9_upload.w9_download', ['w9_id' => $w9_id, 'filename' => $file_name]) }}" class="btn btn-primary bnt-active-light-primary btn-sm">Download</a>
                                            </div>
                                        @endif
                                    @endif
                                    
                                </div>
                            </label>
                            <div class="bg-light rounded p-2 mb-2 pt-4">
                                @if (isset($file_name))
                                    <div class="row p-2">
                                        <p class="fs-6">{{$file_name}}</p>
                                    </div>
                                @else
                                    <p class="p-2">No file found</p>
                                @endif
                            </div>
                        </div>

                        @if(!auth()->user()->hasRole('county user')) 
                        <div class="fv-row mb-7">
                            <label class="fw-semibold mb-2">
                                <b>Download History:</b>
                            </label>
                            <div class="bg-light rounded p-2 mb-2 pt-4" style="max-height: 300px; overflow: auto;">
                                @if (isset($download_history) && count($download_history) > 0)
                                    <table class="table w-100 align-middle">
                                        <thead>
                                            <tr>
                                                <th scope="col" class="text-center text-nowrap"><b>#</b></th>
                                                <th scope="col" class="text-nowrap"><b>User</b></th>
                                                <th scope="col" class="text-center text-nowrap"><b>Downloaded at </b></th>
                                            </tr>
                                        </thead>
                                        <tbody >
                                            @foreach($download_history as $index => $download)
                                                <tr>
                                                    <th scope="row" class="text-center text-nowrap">{{ $index + 1 }}</th>
                                                    <td class=" text-nowrap">
                                                        @if (isset($download->user->id) && !empty($download->user->id))
                                                        <a href="{{ route('user-management.users.show', $download->user->id) }}"> {{ $download->user->first_name}} {{ $download->user->last_name}} 
                                                            @if (isset($download->user->roles?->first()?->name))
                                                            <span class="fs-6 fw-bold">
                                                                ({{ ucwords($download->user->roles?->first()?->name)}})
                                                            </span> 
                                                            @endif
                                                        </a>
                                                        @endif 
                                                    </td>
                                                    <td class="text-center text-nowrap">{{ $download['created_at']->format('Y-m-d H:i:s') }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @else
                                    <p class="p-2">No one has downloaded it yet</p>
                                @endif
                            </div>
                        </div>
                        @endif
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