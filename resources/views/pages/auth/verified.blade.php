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
                <h1 class="text-dark fw-bolder mb-3">Verifikasi Akun</h1>
                <!--end::Title-->

                <!--begin::Subtitle-->
                <div class="text-gray-500 fw-semibold fs-6">- Sistem Retribusi Permintaan Pemeriksaan Sempel -</div>
                <!--end::Subtitle=-->
            </div>
            <!--begin::Heading-->

            <img src="{{ asset('images/logo-apps2.png') }}" class="img-fluid mx-5" alt="logo">
            
            <!--begin::Separator-->
            <div class="separator separator-dotted separator-content border-success my-10">
                <i class="bi bi-check-square text-success fs-2"></i>
            </div>

            @php
                // dd($model['vilid_token']);
            @endphp

            @if ($model['vilid_token']['status'] == true)
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
                    <h4 class="mb-1 text-dark">Verifikasi Akun Berhasil</h4>
                    <!--end::Title-->
                    <!--begin::Content-->
                    <span>Terimakasih anda sudah melakukan verifikasi akun. Token hanya dapat digunakan satu kali. Untuk masuk kedalam aplikasi silahkan klik tombol dibawah ini.</span>
                    <!--end::Content-->
                </div>
                <!--end::Wrapper-->
            </div>

            <div class="d-grid mb-10">
                <a href="{{url('/dash')}}" class="btn btn-warning mt-5"><i class="bi bi-building-lock fs-4 me-2"></i> Masuk Aplikasi</a>
            </div>
            @endif

            @if ($model['vilid_token']['status'] == false)            
            <div class="alert alert-danger d-flex align-items-center p-2">
                <!--begin::Icon-->
                <span class="svg-icon svg-icon-2hx svg-icon-danger me-3">
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
                    <h4 class="mb-1 text-dark">Verifikasi Akun Gagal.</h4>
                    <!--end::Title-->
                    
                    @if ($model['vilid_token']['reason'] == 'token_invalid')
                        <!--begin::Content-->
                        <span>Token anda invalid, tidak seseuai dengan sistem. Silahkan melakukan pengajuan link verifikasi akun ulang, dengan menekan tombol dibawah ini.</span>
                        <!--end::Content-->
                    @endif

                    @if ($model['vilid_token']['reason'] == 'token_sudah_digunakan')
                        <!--begin::Content-->
                        <span>Token anda sudah digunakan. Silahkan melakukan pengajuan link verifikasi akun ulang, dengan menekan tombol dibawah ini.</span>
                        <!--end::Content-->
                    @endif
                    
                    @if ($model['vilid_token']['reason'] == 'token_expired')
                        <!--begin::Content-->
                        <span>Token anda expired atau tidak bisa digunakan. Silahkan melakukan pengajuan link verifikasi akun ulang, dengan menekan tombol dibawah ini.</span>
                        <!--end::Content-->
                    @endif

                </div>
                <!--end::Wrapper-->
            </div>

            <div class="d-grid mb-10">
                <a href="{{url('/dash')}}" class="btn btn-warning mt-5"><i class="bi bi-building-lock fs-4 me-2"></i> Link Konfirmasi</a>
            </div>
            @endif

            

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
    
@endsection
