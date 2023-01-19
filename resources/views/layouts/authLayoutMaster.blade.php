<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->

<head>
    <!-- Basic -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1.0, shrink-to-fit=no">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Auth Starterkit Metronic 8 @yield('title')</title>

    <!-- Meta Tag -->
    <meta name="keywords" content="Starterkit, Admin, Metronic, Laravel 8, Starterkit Admin Metronic Laravel 8" />
    <meta name="description" content="Starterkit Admin Metronic Laravel 8">
    <meta name="author" content="Diskominfo Kab.Karawang">
    <meta property="og:site_name" content="Starterkit Admin Metronic 8" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ url('') }}" />
    <meta property="og:title" content="Starterkit Admin Metronic 8" />
    <meta property="og:description" content="Starterkit Admin Metronic Laravel 8" />

    <meta property="og:image" content="@yield('imageURL', asset('/images/karawang.png'))">

    <!-- Favicon -->
    <link rel="shortcut icon" href="@yield('imageURL', asset('/images/karawang.png'))" type="image/x-icon" />
    <link rel="apple-touch-icon" href="@yield('imageURL', asset('/images/karawang.png'))">

    <!--begin::Fonts(mandatory for all pages)-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <!--end::Fonts-->

    <!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
    <link href="{{ asset('plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
    <!--end::Global Stylesheets Bundle-->

    <!-- Base URL Java Script -->
    <script>
        let BaseURL = "{{ url('/') }}";
    </script>

    {{-- Page Styles --}}
    @yield('page-style')
</head>
<!--end::Head-->

<!--begin::Body-->

<body id="kt_body" class="app-blank bgi-size-cover bgi-position-center bgi-no-repeat">
    <!--begin::Theme mode setup on page load-->
    <script>
        var defaultThemeMode = "light";
        var themeMode;
        if (document.documentElement) {
            if (document.documentElement.hasAttribute("data-theme-mode")) {
                themeMode = document.documentElement.getAttribute("data-theme-mode");
            } else {
                if (localStorage.getItem("data-theme") !== null) {
                    themeMode = localStorage.getItem("data-theme");
                } else {
                    themeMode = defaultThemeMode;
                }
            }
            if (themeMode === "system") {
                themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
            }
            document.documentElement.setAttribute("data-theme", themeMode);
        }
    </script>
    <!--end::Theme mode setup on page load-->

    <!--begin::Main-->
    <!--begin::Root-->
    <div class="d-flex flex-column flex-root">
        <!--begin::Page bg image-->
        <style>
            body {
                background-image: url('{{ URL::asset('media/auth/bg10.jpeg') }}');
            }

            [data-theme="dark"] body {
                background-image: url('{{ URL::asset('media/auth/bg10-dark.jpeg') }}');
            }
        </style>
        <!--end::Page bg image-->

        <!--begin::Authentication - Sign-in -->
        <div class="d-flex flex-column flex-lg-row flex-column-fluid">
            <!--begin::Aside-->
            <div class="d-flex flex-lg-row-fluid">
                <!--begin::Content-->
                <div class="d-flex flex-column flex-center pb-0 pb-lg-10 p-10 w-100">
                    <!--begin::Title-->
                    <h1 class="text-gray-800 fs-2qx fw-bold text-center">UPTD Labkesda Kabupaten Karawang</h1>
                    <!--end::Title-->
                    <!--begin::Title-->
                    <h1 class="text-dark text-center fw-bolder mb-5">Sistem Retribusi Permintaan Pemeriksaan Sempel</h1>
                    <!--end::Title-->
                    
                    <!--begin::Image-->
                    <img class="theme-light-show mx-auto mw-200 w-250px w-lg-600px mb-5 mb-lg-5"
                        src="{{ URL::asset('images/A03.png') }}" alt="" />
                    <img class="theme-dark-show mx-auto mw-200 w-250px w-lg-600px mb-5 mb-lg-5"
                        src="{{ URL::asset('images/A03.png') }}" alt="" />
                    <!--end::Image-->

                    <!--begin::Title-->
                    <h1 class="text-dark text-center fw-bolder mb-3">Fast, Efficient and Productive</h1>
                    <!--end::Title-->
                    
                    <!--begin::Text-->
                    <div class="text-gray-600 fs-base text-center fw-semibold">Jl. Dr. Taruno, Kelurahan. Adiarsa Barat <br> Kecematan Karawang Barat Kabupaten Karawang, Jawa Barat 41311
                    </div>
                    <!--end::Text-->
                    
                </div>
                <!--end::Content-->
            </div>
            <!--begin::Aside-->

            <!--begin::Body-->
            <div class="d-flex flex-column-fluid flex-lg-row-auto justify-content-center justify-content-lg-end p-12">
                <!--begin::Wrapper-->
                <div class="bg-body d-flex flex-center rounded-4 w-md-600px p-10">
                    <!--begin::Content-->
                    
                    {{-- Include Auth Content --}}
                    @yield('content')

                    <!--end::Content-->
                </div>
                <!--end::Wrapper-->
            </div>
            <!--end::Body-->
        </div>
        <!--end::Authentication - Sign-in-->
    </div>
    <!--end::Root-->
    <!--end::Main-->
    
    <!--begin::Javascript-->
    <script>
        var hostUrl = "assets/";
    </script>
    
    <!--begin::Global Javascript Bundle(mandatory for all pages)-->
    <script src="{{ asset('plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('js/scripts.bundle.js') }}"></script>

    <script src="{{ asset('js/pages/main_page.js') }}"></script>
    <!--end::Global Javascript Bundle-->
    
    <!--begin::Custom Javascript(used for this page only)-->
    {{-- <script src="{{ asset('js/custom/authentication/sign-in/general.js') }}"></script> --}}
    <!--end::Custom Javascript-->

    <!--end::Javascript-->

    {{-- page script --}}
    @yield('page-script')
    {{-- page script --}}
</body>
<!--end::Body-->

</html>
