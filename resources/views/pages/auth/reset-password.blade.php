<x-auth-layout>

    <!--begin::Form-->
    <form class="form w-100" method="post" novalidate="novalidate" id="kt_new_password_form" data-kt-redirect-url="{{ route('login') }}" action="{{ route('password.update') }}">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->token }}">
        <input type="hidden" name="email" value="{{ old('email', $request->email) }}">

        <!--begin::Heading-->
        <div class="text-center mb-10">
            <!--begin::Title-->
            <h1 class="text-dark fw-bolder mb-3">
                New Password
            </h1>
            <!--end::Title-->

            <!--begin::Link-->
            <div class="text-gray-500 fw-semibold fs-6">
                Enter your new password.
            </div>
            <!--end::Link-->
        </div>
        <!--begin::Heading-->
        @if (session('status'))
            <div class="fv-row mb-4">
                <span class="text-primary">{{ session('status') }}</span>
            </div>
        @endif

        @if ($errors->has('email'))
        <div class="fv-row mb-4">
            <span class="text-danger">{{ $errors->first('email') }}</span>
        </div>
        @endif

        @if ($errors->has('password'))
        <div class="fv-row mb-4">
            <span class="text-danger">{{ $errors->first('password') }}</span>
        </div>
        @endif
        <!--begin::Input group-->
        <div class="fv-row mb-8" data-kt-password-meter="true">
            <!--begin::Wrapper-->
            <div class="mb-1">
                <!--begin::Input wrapper-->
                <div class="position-relative mb-3">
                    <input class="form-control bg-transparent" type="password" placeholder="Password" name="password" autocomplete="off"/>

                    <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2" data-kt-password-meter-control="visibility">
                        <i class="bi bi-eye-slash fs-2"></i>
                        <i class="bi bi-eye fs-2 d-none"></i>
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
            <div class="text-muted">
                Use 8 or more characters with a mix of letters, numbers & symbols.
            </div>
            <!--end::Hint-->
        </div>
        <!--end::Input group--->

        <!--end::Input group--->
        <div class="fv-row mb-8">
            <!--begin::Repeat Password-->
            <input placeholder="Repeat Password" name="password_confirmation" type="password" autocomplete="off" class="form-control bg-transparent"/>
            <!--end::Repeat Password-->
        </div>
        <!--end::Input group--->

        <!--begin::Actions-->
        <div class="d-flex flex-wrap justify-content-center pb-lg-0">
            <button type="submit" id="kt_new_password_submit" class="btn btn-primary me-4">
                @include('partials/general/_button-indicator', ['label' => 'Submit'])
            </button>

            <a href="{{ route('login') }}" class="btn btn-light">Cancel</a>
        </div>
        <!--end::Actions-->
    </form>
    <!--end::Form-->

</x-auth-layout>
