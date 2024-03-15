<x-auth-layout>

    <!--begin::Form-->
    <form class="form w-100" method="POST" novalidate="novalidate" id="kt_sign_in_form1" data-kt-redirect-url="{{ route('dashboard') }}" action="{{ route('login') }}">
        @csrf
        <!--begin::Heading-->
        <div class="text-center mb-11">
            <!--begin::Title-->
            <h1 class="text-dark fw-bolder mb-3">
                County user only. <br> Sign in to your account.
            </h1>
            <!--end::Title-->
        </div>
        <!--end::Separator-->
        @if (session('status'))
            <div class="fv-row mb-4">
                <span class="text-primary">{{ session('status') }}</span>
            </div>
        @endif
        @if (session('success'))
            <div class="fv-row mb-4">
                <span class="text-primary">{{ session('success') }}</span>
            </div>
        @elseif (session('error'))
            <div class="fv-row mb-4">
                <span class="text-danger">{{ session('error') }}</span>
            </div>
        @endif
        @if ($errors->has('notfounduser'))
        <div class="fv-row mb-4">
            <span class="text-danger">{{ $errors->first('notfounduser') }}</span>
        </div>
        @endif

        @if ($errors->has('email'))
        <div class="fv-row mb-4">
            <span class="text-danger">{{ $errors->first('email') }}</span>
        </div>
        @endif
        <!--begin::Input group--->
        <div class="fv-row mb-8">
            <!--begin::Email-->
            <input type="text" placeholder="Email" name="email" autocomplete="off" class="form-control bg-transparent" value=""/>
            <!--end::Email-->
        </div>

        <!--end::Input group--->
        <div class="fv-row mb-3">
            <!--begin::Password-->
            <input type="password" placeholder="Password" name="password" autocomplete="off" class="form-control bg-transparent" value=""/>
            <!--end::Password-->
        </div>
        <!--end::Input group--->

        <!--begin::Wrapper-->
        <div class="d-flex flex-center flex-wrap gap-3 fs-base fw-semibold mb-8">
            <div></div>

            <!--begin::Link-->
            <a href="{{ route('password.request') }}" class="link-primary">
                Forgot Password ?
            </a>
            <!--end::Link-->
        </div>
        <!--end::Wrapper-->

        <!--begin::Submit button-->
        <div class="d-grid mb-10">
            <button type="submit" id="kt_sign_in_submit" class="btn btn-login btn-primary">
                @include('partials/general/_button-indicator', ['label' => 'Sign In'])
            </button>
        </div>
        <!--end::Submit button-->

        <!--begin::Sign up-->
        <div class="text-gray-500 text-center fw-semibold fs-6">
            Don’t have an account?

            <a href="{{ route('register') }}" class="link-primary">
                Sign up
            </a>
        </div>
        <!--end::Sign up-->
    </form>
    <!--end::Form-->

</x-auth-layout>
