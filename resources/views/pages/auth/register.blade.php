<x-auth-layout>

    <!--begin::Form-->
    <form class="form w-100" novalidate="novalidate" id="kt_sign_up_form" data-kt-redirect-url="{{ route('login') }}" action="{{ route('register') }}">
        @csrf
        <!--begin::Heading-->
        <div class="text-center mb-11">
            <!--begin::Title-->
            <h1 class="text-dark fw-bolder mb-3">
                Sign Up
            </h1>
            <!--end::Title-->

        </div>
        <!--begin::Heading-->

        <!--begin::Input group--->
        <div class="fv-row mb-8">
            <div class="row">
                <div class="col-6">
                    <!--begin::Name-->
                    <input type="text" placeholder="First Name *" name="first_name" autocomplete="off" class="form-control bg-transparent"/> 
                <!--end::Name-->
                </div>
                <div class="col-6">
                    <!--begin::Name-->
                    <input type="text" placeholder="Last Name *" name="last_name" autocomplete="off" class="form-control bg-transparent"/> 
                <!--end::Name-->
                </div>
            </div>

        </div>

        <!--begin::Input group--->
        <div class="fv-row mb-8">
            <!--begin::Email-->
            <input type="text" placeholder="Email *" name="email" autocomplete="off" class="form-control bg-transparent"/>
            <!--end::Email-->
        </div>

        <!--begin::Input group-->
        <div class="fv-row mb-8" data-kt-password-meter="true">
            <!--begin::Wrapper-->
            <div class="mb-1">
                <!--begin::Input wrapper-->
                <div class="position-relative mb-3">
                    <input class="form-control bg-transparent" type="password" placeholder="Password *" name="password" autocomplete="off"/>

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
            <input placeholder="Repeat Password *" name="password_confirmation" type="password" autocomplete="off" class="form-control bg-transparent"/>
            <!--end::Repeat Password-->
        </div>
        <!--end::Input group--->

        <!--begin::Input group--->
        <div class="fv-row mb-8">
            <!--begin::Email-->
            <input type="text" id="business_phone" placeholder="Business Phone Number + Ext. *" name="business_phone" autocomplete="off" class="form-control bg-transparent"/>
            <!--end::Email-->
        </div>
        <!--end::Input group--->

        <!--begin::Input group--->
        <div class="fv-row mb-8">
            <!--begin::Email-->
            <input type="text" id="mobile_phone" placeholder="Mobile Phone Number *" name="mobile_phone" autocomplete="off" class="form-control bg-transparent"/>
            <!--end::Email-->
        </div>
        <!--end::Input group--->

        <!--begin::Input group--->
        <div class="fv-row mb-8">
            <!--begin::Email-->
            <input type="text" placeholder="Agency Mailing Address *" name="mailing_address" autocomplete="off" class="form-control bg-transparent"/>
            <!--end::Email-->
        </div>
        <!--end::Input group--->

        <!--begin::Input group--->
        <div class="fv-row mb-8">
            <!--begin::Email-->
            <input type="text" placeholder="Vendor ID Number *" name="vendor_id" autocomplete="off" class="form-control bg-transparent"/>
            <!--end::Email-->
        </div>
        <!--end::Input group--->

        <div class="fv-row mb-6">
            <div class="row">
                <div class="col-6">
                    <input type="text" readonly placeholder="California" class="form-control bg-transparent"/>
                </div>
                <div class="col-6">
                    <select id="county_option" name="county_designation" class="form-control bg-transparent">
                        <option value="">Select County *</option>
                        @if ($counties && count($counties) > 0)
                        @foreach($counties as $county)
                            <option value="{{ $county->county_fips }}">{{ $county->county }}</option>
                        @endforeach
                        @endif
                    </select>
                </div>
            </div>
            <!--end::County Designation-->
        </div>

        <!--end::Input group--->

        <!--begin::Input group--->
        <div class="text-muted mb-2 required">
           Upload Provider W9
        </div>
        <div class="fv-row mb-8">
            <!--begin::Email-->
            <input type="file" placeholder="Upload Provider W9" name="w9_file_path" autocomplete="off" class="form-control bg-transparent" accept=".zip" title="Upload Provider W9"/>
            <!--end::Email-->
        </div>
        <!--end::Input group--->

        <!--begin::Input group--->
        <div class="fv-row mb-10">
            <div class="form-check form-check-custom form-check-solid form-check-inline">
                <input class="form-check-input" type="checkbox" name="toc" value="1"/>

                <label class="form-check-label fw-semibold text-gray-700 fs-6">
                    I Agree &

                    <a href="#" class="ms-1 link-primary">Terms and conditions</a>.
                </label>
            </div>
        </div>
        <!--end::Input group--->

        <!--begin::Submit button-->
        <div class="d-grid mb-10">
            <button type="submit" id="kt_sign_up_submit" class="btn btn-primary btn-login">
                @include('partials/general/_button-indicator', ['label' => 'Sign Up'])
            </button>
        </div>
        <!--end::Submit button-->

        <!--begin::Sign up-->
        <div class="text-gray-500 text-center fw-semibold fs-6">
            Already have an Account?

            <a href="/login" class="link-primary fw-semibold">
                Sign in
            </a>
        </div>
        <!--end::Sign up-->
    </form>
    <!--end::Form-->
</x-auth-layout>
