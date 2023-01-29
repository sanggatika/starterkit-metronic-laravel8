@extends('layouts/adminLayoutMaster')

@section('title', 'Management Account')

@section('page-style')
    <!-- Current Page CSS Costum -->

@endsection

@section('content')
    <!--begin::Post-->
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <div class="container-fluid">
            <!--begin::Card-->
            <div class="card card-flush pb-0 bgi-position-y-center bgi-no-repeat mb-10" style="background-size: auto calc(100% + 10rem); background-position-x: 100%; background-image: url('{{ URL::asset('media/illustrations/sketchy-1/4.png') }}')">
                <!--begin::Card header-->
                <div class="card-header pt-10">
                    <div class="d-flex align-items-center">
                        <!--begin::Icon-->
                        <div class="symbol symbol-circle me-5">
                            <div class="symbol-label bg-transparent text-primary border border-secondary border-dashed">
                                <!--begin::Svg Icon | path: icons/duotune/abstract/abs020.svg-->
                                <span class="svg-icon svg-icon-2x svg-icon-primary">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M17.302 11.35L12.002 20.55H21.202C21.802 20.55 22.202 19.85 21.902 19.35L17.302 11.35Z" fill="currentColor" />
                                        <path opacity="0.3" d="M12.002 20.55H2.802C2.202 20.55 1.80202 19.85 2.10202 19.35L6.70203 11.45L12.002 20.55ZM11.302 3.45L6.70203 11.35H17.302L12.702 3.45C12.402 2.85 11.602 2.85 11.302 3.45Z" fill="currentColor" />
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->
                            </div>
                        </div>
                        <!--end::Icon-->
                        <!--begin::Title-->
                        <div class="d-flex flex-column">
                            <h2 class="mb-1">Pengaturan Akun Program CSR</h2>
                            <div class="text-muted fw-bolder">
                                <a href="#">BAPPEDA</a>
                                <span class="mx-3">|</span>
                                <a href="#">KABUPATEN KARAWANG</a>
                            </div>
                        </div>
                        <!--end::Title-->
                    </div>
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body pb-0">
                    <!--begin::Navs-->
                    <div class="d-flex overflow-auto h-55px">
                        <ul class="nav nav-stretch nav-tabs nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold flex-nowrap">
                            <!--begin::Nav item-->
                            <li class="nav-item">
                                <a class="nav-link text-active-primary me-6 active" data-bs-toggle="tab" href="#kt_tab_pane_1">Pengaturan Profil</a>
                            </li>
                            <!--end::Nav item-->
                            <!--begin::Nav item-->
                            <li class="nav-item">
                                <a class="nav-link text-active-primary me-6" data-bs-toggle="tab" href="#kt_tab_pane_2">Pengaturan Password</a>
                            </li>
                            <!--end::Nav item-->
                        </ul>
                    </div>
                    <!--begin::Navs-->
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Card-->

            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="kt_tab_pane_1" role="tabpanel">
                    <!--begin::Card-->
                    <div class="card card-flush pt-3 mb-5 mb-xl-10">
                        <!--begin::Card header-->
                        <div class="card-header">
                            <!--begin::Card title-->
                            <div class="card-title">
                                <h2 class="fw-bolder">Pengaturan Profil</h2>
                            </div>
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body pt-3">
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
                            
                            <!-- begin::form_profile -->
                            <form id="form_management_account" class="form" action="#" method="POST" enctype="multipart/form-data" autocomplete="off">
                                @csrf
                                <!--begin::Input group-->
                                <div class="row mb-5">
                                    <div class="col-md-6 fv-row">
                                        <label class="required fs-5 fw-bold mb-2">Username</label>
                                        <input type="text" class="form-control" name="form_account_username" id="form_account_username" placeholder="Username" value="{{ (auth()->user()->username) }}" autocomplete="off" disabled />
                                        <input type="hidden" class="form-control" name="form_account_uuid" id="form_account_uuid" placeholder="data uuid" value="{{ (auth()->user()->uuid) }}" autocomplete="off" readonly />
                                    </div>

                                    <div class="col-md-6 fv-row">
                                        <label class="required fs-5 fw-bold mb-2">Nama Lengkap</label>
                                        <input type="text" class="form-control" name="form_account_name" id="form_account_name" placeholder="Nama Lengkap" value="{{ (auth()->user()->nama) }}" autocomplete="off" autofocus="on" />
                                    </div>
                                </div>
                                <!--end::Input group-->
    
                                {{-- @if (Auth::user()->hasRole('mitra')) --}}
                                <!--begin::Input group-->
                                <div class="row mb-5">
                                    <div class="col-md-6 fv-row">
                                        <label class="required fs-5 fw-bold mb-2">Nomor Handphone</label>
                                        <input type="text" class="form-control" name="form_account_handphone" id="form_account_handphone" placeholder="Nomor Handphone" value="{{ (auth()->user()->telepon) }}" autocomplete="off" autofocus="on" />
                                    </div>
                                    <div class="col-md-6 fv-row">
                                        <label class="required fs-5 fw-bold mb-2">Jabatan</label>
                                        <input type="text" class="form-control" name="form_account_jabatan" id="form_account_jabatan" value="{{ (auth()->user()->jabatan) }}" autocomplete="off" autofocus="on" />
                                    </div>
                                </div>
                                <!--end::Input group-->
                                {{-- @endif --}}
    
                                <div class="fv-row flex-center mb-0">
                                    <div class="form-group @error('g-recaptcha-response') is-invalid @enderror" style="display: inline-block;">
                                        {!! NoCaptcha::renderJs('id') !!}
                                        {!! NoCaptcha::display() !!}
                                        @error('g-recaptcha-response')
                                        <span class="invalid-feedback help-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="separator mb-8"></div>
                                <button type="submit" class="btn btn-primary" id="btnSubmitUpdateDataAccount">
                                    <span class="indicator-label">Simpan</span>
                                    <span class="indicator-progress">Please wait...
                                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                </button>
                            </form>
                            <!-- end::form_profile -->
                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Card-->
                </div>
    
                <div class="tab-pane fade" id="kt_tab_pane_2" role="tabpanel">
                    <!--begin::Card-->
                    <div class="card card-flush pt-3 mb-5 mb-xl-10">
                        <!--begin::Card header-->
                        <div class="card-header">
                            <!--begin::Card title-->
                            <div class="card-title">
                                <h2 class="fw-bolder">Pengaturan Password</h2>
                            </div>
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body pt-3">                           
                            <!--begin::Alert-->
                            <div id="card_alert_informasi_pass" style="display:none">
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
                                        <span id="alert_informasi_pass">The alert component can be used to highlight</span>
                                        <!--end::Content-->
                                    </div>
                                    <!--end::Wrapper-->
                                </div>
                            </div>            
                            <!--end::Alert-->

                            <!-- begin::form_password -->
                            <form id="form_management_account_pass" class="form" action="#" method="POST" enctype="multipart/form-data" autocomplete="off">
                                @csrf
                                <div class="fv-row mb-5">
                                    <label class="required fs-5 fw-bold mb-2">Password Saat Ini</label>
                                    <input type="password" class="form-control" name="form_account_pass_curent" id="form_account_pass_curent" placeholder="Password Saat Ini" autocomplete="off" required />
                                </div>
                                <div class="mb-0 fv-row" data-kt-password-meter="true">
                                    <div class="mb-1">
                                        <label class="required form-label fw-bolder text-dark fs-6 mb-0">Password</label>
                                        <div class="position-relative mb-3">
                                            <input class="form-control form-control-lg" type="password" name="form_account_pass" id="form_account_pass" placeholder="Password" autocomplete="off" required />
                                            <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2" data-kt-password-meter-control="visibility">
                                                <i class="bi bi-eye-slash fs-2"></i>
                                                <i class="bi bi-eye fs-2 d-none"></i>
                                            </span>
                                        </div>

                                        <div class="d-flex align-items-center mb-3" data-kt-password-meter-control="highlight">
                                            <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                                            <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                                            <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                                            <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px"></div>
                                        </div>

                                        <div id="popover-password">
                                            <p class="font-weight-bolder">Password Strength : <span id="result"> </span></p>
                                            <div id="password-indikator" class="progress mt-5" style="height: 30px;">
                                                <div id="password-strength" class="progress-bar progress-bar-striped progress-bar-animated bg-warning" role="progressbar" style="width: 0%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                                <div class="w-100 mb-10 card-body">
                                    <h4 class="text-gray-700 w-bolder mb-4">Kriteria password yang harus dipenuhi :</h4>
                                    <div class="d-flex flex-stack mb-2">
                                        <span class="fw-bold fs-6 text-gray-800 text-start pe-3">Memiliki <b>huruf kecil</b></span>
                                        <span id="lowercase" class="svg-icon svg-icon-1 svg-icon-danger">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10" fill="black"></rect>
                                                <rect x="7" y="15.3137" width="12" height="2" rx="1" transform="rotate(-45 7 15.3137)" fill="black"></rect>
                                                <rect x="8.41422" y="7" width="12" height="2" rx="1" transform="rotate(45 8.41422 7)" fill="black"></rect>
                                            </svg>
                                        </span>
                                    </div>
                                    <div class="d-flex flex-stack mb-2">
                                        <span class="fw-bold fs-6 text-gray-800 text-start pe-3">Memiliki <b>huruf besar</b></span>
                                        <span id="uppercase" class="svg-icon svg-icon-1 svg-icon-danger">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10" fill="black"></rect>
                                                <rect x="7" y="15.3137" width="12" height="2" rx="1" transform="rotate(-45 7 15.3137)" fill="black"></rect>
                                                <rect x="8.41422" y="7" width="12" height="2" rx="1" transform="rotate(45 8.41422 7)" fill="black"></rect>
                                            </svg>
                                        </span>
                                    </div>
                                    <div class="d-flex flex-stack mb-2">
                                        <span class="fw-bold fs-6 text-gray-800 text-start pe-3">Memiliki <b>angka</b></span>
                                        <span id="number" class="svg-icon svg-icon-1 svg-icon-danger">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10" fill="black"></rect>
                                                <rect x="7" y="15.3137" width="12" height="2" rx="1" transform="rotate(-45 7 15.3137)" fill="black"></rect>
                                                <rect x="8.41422" y="7" width="12" height="2" rx="1" transform="rotate(45 8.41422 7)" fill="black"></rect>
                                            </svg>
                                        </span>
                                    </div>
                                    <div class="d-flex flex-stack mb-2">
                                        <span class="fw-bold fs-6 text-gray-800 text-start pe-3">Minimal <b>8 karakter</b></span>
                                        <span id="minimum" class="svg-icon svg-icon-1 svg-icon-danger">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10" fill="black"></rect>
                                                <rect x="7" y="15.3137" width="12" height="2" rx="1" transform="rotate(-45 7 15.3137)" fill="black"></rect>
                                                <rect x="8.41422" y="7" width="12" height="2" rx="1" transform="rotate(45 8.41422 7)" fill="black"></rect>
                                            </svg>
                                        </span>
                                    </div>
                                </div>
                                <div class="fv-row mb-5">
                                    <div class="col-md-12">
                                        <label class="required fs-5 fw-bold mb-2">Konfirmasi Password</label>
                                        <input type="password" class="form-control" name="form_account_pass_konfirm" id="form_account_pass_konfirm" placeholder="Konfirmasi Password" autocomplete="off" required />
                                        <div id="popover-password">
                                            <p class="text-bold" id="re-password-verif"></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="separator mb-8"></div>
                                <button type="submit" class="btn btn-primary" id="btnSubmitUpdateDataAccountPass">
                                    <span class="indicator-label">Update Password</span>
                                    <span class="indicator-progress">Please wait...
                                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                </button>
                            </form>
                            <!-- end::form_password -->
                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Card-->
                </div>    
            </div>
            
        </div>
    </div>
@endsection

@section('page-script')
    <!-- Current Page JS Costum -->
    @if (session()->has('errors'))
    <script>
        Swal.fire({
            title: 'Error Data !',
            text: '{{ $errors->first() }}',
            icon: "warning",
            buttonsStyling: false,
            confirmButtonText: "Ok, got it!",
            customClass: {
                confirmButton: "btn btn-primary"
            }
        });
    </script>
    @endif
    <script src="{{ URL::asset('js/pages/management_account.js?version=') }}{{uniqid()}}"></script>
@endsection