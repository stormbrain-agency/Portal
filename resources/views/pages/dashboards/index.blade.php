<x-default-layout>
    <div class="card p-15">
        <h1>Welcome to the CDA Supplemental Payment Dashboard</h1>
        <div class="mt-5">
            @if(session('error'))
                <div class="alert bg-light-danger border-danger d-flex align-items-center p-5">
                    <i class="ki-duotone ki-shield-tick fs-2hx text-danger me-4"><span class="path1"></span><span class="path2"></span></i>
                    <div class="d-flex flex-column">
                        <h4 class="mb-1 text-dark">Error</h4>
                        <span>{{ session('error') }}</span>
                    </div>
                    <button type="button" class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto" data-bs-dismiss="alert">
                        <i class="ki-duotone ki-cross fs-1 text-danger"><span class="path1"></span><span class="path2"></span></i>
                    </button>
                </div>
            <br>
            @endif
             @if(session('success'))
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
            <br>
            @endif

            {{-- Display Conty User --}}
            @if (auth()->user()->hasRole('county user'))
                @foreach ($notifications as $notification)
                    @if ($notification->status == 'Active')
                        @if ($notification->location == 'User')
                            @php
                                $now = now();
                                $start = now()->parse($notification->schedule_start);
                                $end = now()->parse($notification->schedule_end);
                                $isWithinSchedule = $now->between($start, $end);
                                $isEqual = $start->equalTo($end);
                            @endphp
                            @if ($isWithinSchedule || $notification->schedule_status == 'No' || $isEqual)
                                @if ($notification->type == 'Information')
                                    <div class="alert bg-light-primary border-primary d-flex align-items-center p-5">
                                        <i class="ki-duotone ki-shield-tick fs-2hx text-primary me-4"><span class="path1"></span><span class="path2"></span></i>
                                        <div class="d-flex flex-column">
                                            <h4 class="mb-1 text-dark">{{ $notification->title }}</h4>
                                            <span>{{ $notification->message }}</span>
                                        </div>
                                        <button type="button" class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto" data-bs-dismiss="alert">
                                            <i class="ki-duotone ki-cross fs-1 text-primary"><span class="path1"></span><span class="path2"></span></i>
                                        </button>
                                    </div>
                                @elseif ($notification->type == 'Success')
                                    <div class="alert bg-light-success border-success d-flex align-items-center p-5">
                                        <i class="ki-duotone ki-shield-tick fs-2hx text-success me-4"><span class="path1"></span><span class="path2"></span></i>
                                        <div class="d-flex flex-column">
                                            <h4 class="mb-1 text-dark">{{ $notification->title }}</h4>
                                            <span>{{ $notification->message }}</span>
                                        </div>
                                        <button type="button" class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto" data-bs-dismiss="alert">
                                            <i class="ki-duotone ki-cross fs-1 text-success"><span class="path1"></span><span class="path2"></span></i>
                                        </button>
                                    </div>
                                @elseif ($notification->type == 'Warning')
                                    <div class="alert bg-light-info border-info d-flex align-items-center p-5">
                                        <i class="ki-duotone ki-shield-tick fs-2hx text-info me-4"><span class="path1"></span><span class="path2"></span></i>
                                        <div class="d-flex flex-column">
                                            <h4 class="mb-1 text-dark">{{ $notification->title }}</h4>
                                            <span>{{ $notification->message }}</span>
                                        </div>
                                        <button type="button" class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto" data-bs-dismiss="alert">
                                            <i class="ki-duotone ki-cross fs-1 text-info"><span class="path1"></span><span class="path2"></span></i>
                                        </button>
                                    </div>
                                @elseif ($notification->type == 'Alert')
                                    <div class="alert bg-light-danger border-danger d-flex align-items-center p-5">
                                        <i class="ki-duotone ki-shield-tick fs-2hx text-danger me-4"><span class="path1"></span><span class="path2"></span></i>
                                        <div class="d-flex flex-column">
                                            <h4 class="mb-1 text-dark">{{ $notification->title }}</h4>
                                            <span>{{ $notification->message }}</span>
                                        </div>
                                        <button type="button" class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto" data-bs-dismiss="alert">
                                            <i class="ki-duotone ki-cross fs-1 text-danger"><span class="path1"></span><span class="path2"></span></i>
                                        </button>
                                    </div>
                                @else
                                    <div class="d-flex flex-column">
                                        <h4 class="mb-1 text-dark">Not Notification</h4>
                                    </div>
                                @endif
                            @endif
                        @endif
                    @endif
                @endforeach
            @endif

            {{-- Display Admin --}}
            @if (auth()->user()->hasRole('admin'))
                @foreach ($notifications as $notification)
                    @if ($notification->status == 'Active')
                        @if ($notification->location == 'Sitewide' || $notification->location == 'User')
                            @php
                                $now = now();
                                $start = now()->parse($notification->schedule_start);
                                $end = now()->parse($notification->schedule_end);
                                $isWithinSchedule = $now->between($start, $end);
                                $isEqual = $start->equalTo($end);
                            @endphp
                            @if ($isWithinSchedule || $notification->schedule_status == 'No' || $isEqual)
                                @if ($notification->type == 'Information')
                                    <div class="alert bg-light-primary border-primary d-flex align-items-center p-5">
                                        <i class="ki-duotone ki-shield-tick fs-2hx text-primary me-4"><span class="path1"></span><span class="path2"></span></i>
                                        <div class="d-flex flex-column">
                                            <h4 class="mb-1 text-dark">{{ $notification->title }}</h4>
                                            <span>{{ $notification->message }}</span>
                                        </div>
                                        <button type="button" class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto" data-bs-dismiss="alert">
                                            <i class="ki-duotone ki-cross fs-1 text-primary"><span class="path1"></span><span class="path2"></span></i>
                                        </button>
                                    </div>
                                @elseif ($notification->type == 'Success')
                                    <div class="alert bg-light-success border-success d-flex align-items-center p-5">
                                        <i class="ki-duotone ki-shield-tick fs-2hx text-success me-4"><span class="path1"></span><span class="path2"></span></i>
                                        <div class="d-flex flex-column">
                                            <h4 class="mb-1 text-dark">{{ $notification->title }}</h4>
                                            <span>{{ $notification->message }}</span>
                                        </div>
                                        <button type="button" class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto" data-bs-dismiss="alert">
                                            <i class="ki-duotone ki-cross fs-1 text-success"><span class="path1"></span><span class="path2"></span></i>
                                        </button>
                                    </div>
                                @elseif ($notification->type == 'Warning')
                                    <div class="alert bg-light-info border-info d-flex align-items-center p-5">
                                        <i class="ki-duotone ki-shield-tick fs-2hx text-info me-4"><span class="path1"></span><span class="path2"></span></i>
                                        <div class="d-flex flex-column">
                                            <h4 class="mb-1 text-dark">{{ $notification->title }}</h4>
                                            <span>{{ $notification->message }}</span>
                                        </div>
                                        <button type="button" class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto" data-bs-dismiss="alert">
                                            <i class="ki-duotone ki-cross fs-1 text-info"><span class="path1"></span><span class="path2"></span></i>
                                        </button>
                                    </div>
                                @elseif ($notification->type == 'Alert')
                                    <div class="alert bg-light-danger border-danger d-flex align-items-center p-5">
                                        <i class="ki-duotone ki-shield-tick fs-2hx text-danger me-4"><span class="path1"></span><span class="path2"></span></i>
                                        <div class="d-flex flex-column">
                                            <h4 class="mb-1 text-dark">{{ $notification->title }}</h4>
                                            <span>{{ $notification->message }}</span>
                                        </div>
                                        <button type="button" class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto" data-bs-dismiss="alert">
                                            <i class="ki-duotone ki-cross fs-1 text-danger"><span class="path1"></span><span class="path2"></span></i>
                                        </button>
                                    </div>
                                @else
<<<<<<< HEAD
                                    <div class="d-flex flex-column">
                                        <h4 class="mb-1 text-dark">Not Notification</h4>
=======
                                    <div>
                                        <p>Not Notification</p>
>>>>>>> e9b6728 (update notifications)
                                    </div>
                                @endif
                            @endif
                        @endif
                    @endif
                @endforeach
            @endif


        </div>
    </div>
</x-default-layout>
