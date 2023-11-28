<x-auth-layout>

    <!--begin::Form-->
    <form class="form w-100" method="POST" novalidate="novalidate" id="kt_password_reset_form" data-kt-redirect-url="{{ route('login') }}" action="{{ route('password.email') }}">
        @csrf
        <!--begin::Heading-->
        <div class="text-center mb-10">
            <!--begin::Title-->
            <h1 class="text-dark fw-bolder mb-3">
                Forgot Password ?
            </h1>
            <!--end::Title-->

            <!--begin::Link-->
            <div class="text-gray-500 fw-semibold fs-6">
                Enter your email to reset your password.
            </div>
            <!--end::Link-->
        </div>
        <!--begin::Heading-->

        <!--begin::Input group--->
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
        
        <div class="fv-row mb-8">
            <!--begin::Email-->
            <input type="text" placeholder="Email" name="email" autocomplete="off" class="form-control bg-transparent" value="{{ old('email') }}"/>
            <!--end::Email-->
        </div>

        <!--begin::Actions-->
        <div class="d-flex flex-wrap justify-content-center pb-lg-0">
            <button type="submit" id="kt_password_reset_submit" class="btn btn-primary me-4">
                @include('partials/general/_button-indicator', ['label' => 'Submit'])
            </button>

            <a href="{{ route('login') }}" class="btn btn-light">Cancel</a>
        </div>
        <!--end::Actions-->
    </form>
    <!--end::Form-->

</x-auth-layout>