@extends('layouts/authLayoutMaster')

@section('title', 'Beranda')

@section('page-style')
    <!-- Current Page CSS Costum -->

@endsection

@section('content')
    <!--begin::Content-->
    <div class="w-md-400px">
        <!--begin::Form-->
        <form class="form w-100" novalidate="novalidate" id="kt_sign_in_form" data-kt-redirect-url="../../demo8/dist/index.html"
            action="#">
            <!--begin::Heading-->
            <div class="text-center mb-5">
                <!--begin::Title-->
                <h1 class="text-dark fw-bolder mb-3">Login Ke Sistem</h1>
                <!--end::Title-->

                <!--begin::Subtitle-->
                <div class="text-gray-500 fw-semibold fs-6">- Sistem Retribusi Permintaan Pemeriksaan Sempel -</div>
                <!--end::Subtitle=-->
            </div>
            <!--begin::Heading-->
            
            <!--begin::Separator-->
            <div class="separator separator-dotted separator-content border-success my-10">
                <i class="bi bi-check-square text-success fs-2"></i>
            </div>
            <!--end::Separator-->
            
            <!--begin::Input group=-->
            <div class="fv-row mb-8">
                <!--begin::Email-->
                <input type="text" placeholder="Email" name="email" autocomplete="off"
                    class="form-control bg-transparent" />
                <!--end::Email-->
            </div>
            <!--end::Input group=-->
            <div class="fv-row mb-3">
                <!--begin::Password-->
                <input type="password" placeholder="Password" name="password" autocomplete="off"
                    class="form-control bg-transparent" />
                <!--end::Password-->
            </div>
            <!--end::Input group=-->
            
            <!--begin::Wrapper-->
            <div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-5">
                <div></div>
                <!--begin::Link-->
                <a href="../../demo8/dist/authentication/layouts/overlay/reset-password.html" class="link-primary">Forgot
                    Password ?</a>
                <!--end::Link-->
            </div>
            <!--end::Wrapper-->

            <!--end::Input group=-->
            <div class="fv-row mb-3">
                <label class="text-gray-500" for="exampleInputPassword1">Captcha</label>
                {!! NoCaptcha::renderJs('id') !!}
                {!! NoCaptcha::display() !!}
            </div>
            <!--end::Input group=-->

            <!--begin::Submit button-->
            <div class="d-grid mb-10">
                <button type="submit" id="kt_sign_in_submit" class="btn btn-primary">
                    <!--begin::Indicator label-->
                    <span class="indicator-label">Sign In</span>
                    <!--end::Indicator label-->
                    <!--begin::Indicator progress-->
                    <span class="indicator-progress">Please wait...
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    <!--end::Indicator progress-->
                </button>
            </div>
            <!--end::Submit button-->
            <!--begin::Sign up-->
            <div class="text-gray-500 text-center fw-semibold fs-6">Not a Member yet?
                <a href="../../demo8/dist/authentication/layouts/overlay/sign-up.html" class="link-primary">Sign up</a>
            </div>
            <!--end::Sign up-->
        </form>
        <!--end::Form-->
    </div>
    <!--end::Content-->
@endsection

@section('page-script')
    <!-- Current Page JS Costum -->

@endsection
