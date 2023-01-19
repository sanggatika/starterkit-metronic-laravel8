@extends('layouts/authLayoutMaster')

@section('title', 'Forgot Password')

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
                <h1 class="text-dark fw-bolder mb-3">Lupa Password</h1>
                <!--end::Title-->

                <!--begin::Subtitle-->
                <div class="text-gray-500 fw-semibold fs-6">- Sistem Retribusi Permintaan Pemeriksaan Sempel -</div>
                <!--end::Subtitle=-->
            </div>
            <!--begin::Heading-->
            
            <div class="alert alert-info d-flex align-items-center p-2">
                <!--begin::Icon-->
                <span class="svg-icon svg-icon-2hx svg-icon-info me-3">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10" fill="currentColor"/>
                        <rect x="11" y="14" width="7" height="2" rx="1" transform="rotate(-90 11 14)" fill="currentColor"/>
                        <rect x="11" y="17" width="2" height="2" rx="1" transform="rotate(-90 11 17)" fill="currentColor"/>
                    </svg>
                </span>
                <!--end::Icon-->

                <!--begin::Wrapper-->
                <div class="d-flex flex-column">
                    <!--begin::Title-->
                    <h4 class="mb-1 text-dark">Informasi</h4>
                    <!--end::Title-->
                    <!--begin::Content-->
                    <span>Silahkan isi formulir berikut untuk melakukan reset password akun anda.</span>
                    <!--end::Content-->
                </div>
                <!--end::Wrapper-->
            </div>

            <!--begin::Separator-->
            <div class="separator separator-dotted separator-content border-success my-10">
                <i class="bi bi-check-square text-success fs-2"></i>
            </div>
            <!--end::Separator-->

            <!--begin::Alert-->
            <div id="card_alert_informasi" style="display:none">
                <div class="alert alert-danger d-flex align-items-center p-2">
                    <!--begin::Icon-->
                    <span class="svg-icon svg-icon-2hx svg-icon-danger me-3">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path opacity="0.3" d="M20.5543 4.37824L12.1798 2.02473C12.0626 1.99176 11.9376 1.99176 11.8203 2.02473L3.44572 4.37824C3.18118 4.45258 3 4.6807 3 4.93945V13.569C3 14.6914 3.48509 15.8404 4.4417 16.984C5.17231 17.8575 6.18314 18.7345 7.446 19.5909C9.56752 21.0295 11.6566 21.912 11.7445 21.9488C11.8258 21.9829 11.9129 22 12.0001 22C12.0872 22 12.1744 21.983 12.2557 21.9488C12.3435 21.912 14.4326 21.0295 16.5541 19.5909C17.8169 18.7345 18.8277 17.8575 19.5584 16.984C20.515 15.8404 21 14.6914 21 13.569V4.93945C21 4.6807 20.8189 4.45258 20.5543 4.37824Z" fill="currentColor"/>
                            <rect x="9" y="13.0283" width="7.3536" height="1.2256" rx="0.6128" transform="rotate(-45 9 13.0283)" fill="currentColor"/>
                            <rect x="9.86664" y="7.93359" width="7.3536" height="1.2256" rx="0.6128" transform="rotate(45 9.86664 7.93359)" fill="currentColor"/>
                        </svg>
                    </span>
                    <!--end::Icon-->
    
                    <!--begin::Wrapper-->
                    <div class="d-flex flex-column">
                        <!--begin::Title-->
                        <h4 class="mb-1 text-dark">This is an alert</h4>
                        <!--end::Title-->
                        <!--begin::Content-->
                        <span id="alert_informasi">The alert component can be used to highlight</span>
                        <!--end::Content-->
                    </div>
                    <!--end::Wrapper-->
                </div>
            </div>            
            <!--end::Alert-->
            
            <!--begin::Input group=-->
            <div class="fv-row mb-8">
                <!--begin::Email-->
                <input type="text" placeholder="Email or Username" name="form_email" id="form_email" autocomplete="off"
                    class="form-control bg-transparent" />
                <!--end::Email-->
            </div>
            <!--end::Input group=-->

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
                    <span class="indicator-label">Kirim Email</span>
                    <!--end::Indicator label-->
                    <!--begin::Indicator progress-->
                    <span class="indicator-progress">Please wait...
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    <!--end::Indicator progress-->
                </button>
                <a href="{{url('/auth/login')}}" class="btn btn-secondary mt-5"><i class="bi bi-back fs-4 me-2"></i> Kembali Halaman Login</a>
            </div>
            <!--end::Submit button-->
            <!--begin::Sign up-->
            {{-- <div class="text-gray-500 text-center fw-semibold fs-6">Not a Member yet?
                <a href="../../demo8/dist/authentication/layouts/overlay/sign-up.html" class="link-primary">Sign up</a>
            </div> --}}
            <!--end::Sign up-->
        </form>
        <!--end::Form-->
    </div>
    <!--end::Content-->
@endsection

@section('page-script')
    <!-- Current Page JS Costum -->
    <script src="{{ URL::asset('js/pages/auth/forgot.js?version=') }}{{uniqid()}}"></script>
@endsection
