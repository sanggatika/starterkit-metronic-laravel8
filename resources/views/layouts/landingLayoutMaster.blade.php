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

    <title>Starterkit Metronic 8 @yield('title')</title>

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

<body id="kt_body" data-bs-spy="scroll" data-bs-target="#kt_landing_menu" class="bg-white position-relative">
    
    <!--begin::Theme mode setup on page load-->
    <script nonce="{{ csp_nonce() }}">
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
        
        <!--begin::Header Section-->
        @include('panels/publik/v_header')
        <!--end::Header Section-->

        <!--begin::Content Section-->
        
        {{-- Include Startkit Content --}}
        @yield('content')
        <!--end::Content Section-->
        
        <!--begin::Footer Section-->
        @include('panels/publik/v_footer')
        <!--end::Footer Section-->

        <!--begin::Scrolltop-->
        <div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
            <!--begin::Svg Icon | path: icons/duotune/arrows/arr066.svg-->
            <span class="svg-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <rect opacity="0.5" x="13" y="6" width="13" height="2"
                        rx="1" transform="rotate(90 13 6)" fill="currentColor" />
                    <path
                        d="M12.5657 8.56569L16.75 12.75C17.1642 13.1642 17.8358 13.1642 18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25L12.7071 5.70711C12.3166 5.31658 11.6834 5.31658 11.2929 5.70711L5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75C6.16421 13.1642 6.83579 13.1642 7.25 12.75L11.4343 8.56569C11.7467 8.25327 12.2533 8.25327 12.5657 8.56569Z"
                        fill="currentColor" />
                </svg>
            </span>
            <!--end::Svg Icon-->
        </div>
        <!--end::Scrolltop-->

    </div>
    <!--end::Root-->
    <!--end::Main-->

    <!--begin::Engage drawers-->
    <!--begin::Demos drawer-->
    @include('panels/publik/v_demos')
    <!--end::Demos drawer-->

    <!--begin::Help drawer-->
    @include('panels/publik/v_help')
    <!--end::Help drawer-->
    <!--end::Engage drawers-->

    <!--begin::Engage modals-->
    <!--end::Engage modals-->

    <!--begin::Engage toolbar-->
    <div
        class="engage-toolbar d-flex position-fixed px-5 fw-bold zindex-2 top-50 end-0 transform-90 mt-5 mt-lg-20 gap-2">
        <!--begin::Demos drawer toggle-->
        <button id="kt_engage_demos_toggle"
            class="engage-demos-toggle engage-btn btn shadow-sm fs-6 px-4 rounded-top-0"
            title="Check out 30 more demos" data-bs-toggle="tooltip" data-bs-placement="left"
            data-bs-dismiss="click" data-bs-trigger="hover">
            <span id="kt_engage_demos_label">Demos</span>
        </button>
        <!--end::Demos drawer toggle-->
        <!--begin::Help drawer toggle-->
        <button id="kt_help_toggle" class="engage-help-toggle btn engage-btn shadow-sm px-5 rounded-top-0"
            title="Learn & Get Inspired" data-bs-toggle="tooltip" data-bs-placement="left"
            data-bs-dismiss="click" data-bs-trigger="hover">Help</button>
        <!--end::Help drawer toggle-->
    </div>
    <!--end::Engage toolbar-->

    <!--begin::Scrolltop-->
    <div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
        <!--begin::Svg Icon | path: icons/duotune/arrows/arr066.svg-->
        <span class="svg-icon">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <rect opacity="0.5" x="13" y="6" width="13" height="2"
                    rx="1" transform="rotate(90 13 6)" fill="currentColor" />
                <path
                    d="M12.5657 8.56569L16.75 12.75C17.1642 13.1642 17.8358 13.1642 18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25L12.7071 5.70711C12.3166 5.31658 11.6834 5.31658 11.2929 5.70711L5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75C6.16421 13.1642 6.83579 13.1642 7.25 12.75L11.4343 8.56569C11.7467 8.25327 12.2533 8.25327 12.5657 8.56569Z"
                    fill="currentColor" />
            </svg>
        </span>
        <!--end::Svg Icon-->
    </div>
    <!--end::Scrolltop-->

    <!--begin::Javascript-->
    <script nonce="{{ csp_nonce() }}">
        var hostUrl = "";
    </script>
    <!--begin::Global Javascript Bundle(mandatory for all pages)-->
    <script nonce="{{ csp_nonce() }}" src="{{ asset('plugins/global/plugins.bundle.js') }}"></script>
    <script nonce="{{ csp_nonce() }}" src="{{ asset('js/scripts.bundle.js') }}"></script>
    <!--end::Global Javascript Bundle-->
    <!--begin::Vendors Javascript(used for this page only)-->
    <script nonce="{{ csp_nonce() }}" src="{{ asset('plugins/custom/fslightbox/fslightbox.bundle.js') }}"></script>
    <script nonce="{{ csp_nonce() }}" src="{{ asset('plugins/custom/typedjs/typedjs.bundle.js') }}"></script>
    <!--end::Vendors Javascript-->
    <!--begin::Custom Javascript(used for this page only)-->
    <script nonce="{{ csp_nonce() }}" src="{{ asset('js/custom/landing.js') }}"></script>
    <script nonce="{{ csp_nonce() }}" src="{{ asset('js/custom/pages/pricing/general.js') }}"></script>
    <!--end::Custom Javascript-->
    <!--end::Javascript-->

    {{-- page script --}}
    @yield('page-script')
    {{-- page script --}}

</body>
<!--end::Body-->

</html>
