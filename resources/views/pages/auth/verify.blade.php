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
                <h1 class="text-dark fw-bolder mb-3">Verifikasi Akun Sistem</h1>
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
            <!--end::Separator-->

            <p class="fs-6">Link verifikasi telah dikirim ke alamat email :<br><br>
                <b class="text-black">{{ auth()->user()->email }}</b><br><br>
                Silahkan cek folder inbox atau spam pada email anda. <br>
                Jika anda tidak menemukan/belum menerima email verifikasi,<br>
                Silahkan Klik <button type="button" class="btn btn-info btn-sm" onclick="actsubmitResendVerifikasi()"><i class="bi bi-envelope-check"></i> Kirim Ulang</button>  untuk mengirim ulang email verifikasi.<br>
                
                {{-- Atau jika terdapat kesalahan penulisan email,<br>
                <a id="change_button" href="#">klik disini</a> untuk memperbarui email. --}}
            </p>

            <div class="d-grid">
                <a href="{{url('/auth/logout')}}" class="btn btn-secondary mt-5"><i class="bi bi-back fs-4 me-2"></i> Kembali Halaman Login</a>
            </div>            

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
    <script src="{{ URL::asset('js/pages/auth/verify.js?version=') }}{{uniqid()}}"></script>

    <script type="text/javascript">
        
    </script>
@endsection
