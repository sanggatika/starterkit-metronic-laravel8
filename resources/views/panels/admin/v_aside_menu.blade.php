@php
    $routeLive = Route::currentRouteName();
    $pageAktif = null;
    if(isset($model['pageAktif']))
    {
        $pageAktif = $model['pageAktif'];
    }
    $ms_menu = $menuData[0]['ms_menu'];
    $menu_active = $menuData[0]['active_menu'];
@endphp

<div class="aside-menu flex-column-fluid">
    <!--begin::Aside Menu-->
    <div class="hover-scroll-overlay-y px-2 my-5 my-lg-5" id="kt_aside_menu_wrapper" data-kt-scroll="true"
        data-kt-scroll-height="auto"
        data-kt-scroll-dependencies="{default: '#kt_aside_toolbar, #kt_aside_footer', lg: '#kt_header, #kt_aside_toolbar, #kt_aside_footer'}"
        data-kt-scroll-wrappers="#kt_aside_menu" data-kt-scroll-offset="5px">
        <!--begin::Menu-->
        <div class="menu menu-column menu-title-gray-800 menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500"
            id="#kt_aside_menu" data-kt-menu="true">
            
            <!--begin:Menu item-->
            <div class="menu-item">
                <!--begin:Menu link-->
                <a class="menu-link {{ $routeLive == 'dash' ? 'active' : '' }}" href="{{url('/dash')}}">
                    <span class="menu-icon">
                        <!--begin::Svg Icon | path: icons/duotune/general/gen019.svg-->
                        <span class="svg-icon svg-icon-2">
                            <i class="bi bi-columns-gap text-white me-2"></i>
                        </span>
                        <!--end::Svg Icon-->
                    </span>
                    <span class="menu-title">Dashboard</span>
                </a>
                <!--end:Menu link-->
            </div>
            <!--end:Menu item-->          
            
            @php
                // dd($menuData[0]['ms_menu']);
            @endphp

            @if ($ms_menu != null)
                @foreach ($ms_menu->groupBy('menu_grup') as $grup_menu)
                <!--begin:Menu item-->
                <div class="menu-item pt-2">
                    <!--begin:Menu content-->
                    <div class="menu-content">
                        <span class="menu-heading fw-bold text-uppercase text-warning fs-7">{{$grup_menu[0]->menu_grup}}</span>
                    </div>
                    <!--end:Menu content-->
                </div>
                <!--end:Menu item-->

                    @foreach ($ms_menu->where('menu_parent', 0)->where('menu_grup',$grup_menu[0]->menu_grup)->sortBy('menu_sort') as $menu)
                        @if ($menu->menu_parent_status == 0)
                            <!--begin:Menu item-->
                            <div class="menu-item">
                                <!--begin:Menu link-->
                                <a class="menu-link {{ $routeLive == $menu->menu_routename || $pageAktif == 'aktif' ? 'active' : '' }}" href="{{$menu->menu_url}}">
                                    <span class="menu-icon">
                                        <!--begin::Svg Icon | path: icons/duotune/general/gen019.svg-->
                                        <span class="svg-icon svg-icon-2">
                                            {!!$menu->menu_icon!!}
                                        </span>
                                        <!--end::Svg Icon-->
                                    </span>
                                    <span class="menu-title">{{$menu->menu_title}}</span>
                                </a>
                                <!--end:Menu link-->
                            </div>
                            <!--end:Menu item-->
                        @else
                            @php
                                $urlSubMenu = null;
                                $pageAktif = null;                    
                            @endphp
                            @foreach ($ms_menu as $submenu)
                                @if($submenu->menu_parent == $menu->id_menu)
                                    @if (request()->is(substr($submenu->menu_url,1)))
                                        @php
                                            $urlSubMenu = 'active';
                                            break;
                                        @endphp
                                    @endif
                                @endif
                            @endforeach

                            <!--begin:Menu item-->
                            <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ $urlSubMenu == 'active' || $pageAktif == 'aktif' ? 'show' : '' }}">
                                
                                <!--begin:Menu link-->
                                <span class="menu-link">
                                    <span class="menu-icon">
                                        <!--begin::Svg Icon | path: icons/duotune/communication/com005.svg-->
                                        {!!$menu->menu_icon!!}
                                        <!--end::Svg Icon-->
                                    </span>
                                    <span class="menu-title">{{$menu->menu_title}}</span>
                                    <span class="menu-arrow"></span>
                                </span>
                                <!--end:Menu link-->
                                
                                <!--begin:Menu sub-->
                                <div class="menu-sub menu-sub-accordion">
                                    @foreach ($ms_menu->where('menu_parent', $menu->id_menu)->sortBy('menu_sort') as $submenu)
                                        <!--begin:Menu item-->
                                        <div class="menu-item">
                                            <!--begin:Menu link-->
                                            <a class="menu-link {{ Route::currentRouteName() == $submenu->menu_routename || $pageAktif == 'aktif' ? 'active' : '' }}" href="{{$submenu->menu_url}}">
                                                <span class="menu-bullet">
                                                    <span class="bullet bullet-dot"></span>
                                                </span>
                                                <span class="menu-title">{{$submenu->menu_title}}</span>
                                            </a>
                                            <!--end:Menu link-->
                                        </div>
                                        <!--end:Menu item-->
                                    @endforeach
                                </div>
                                <!--end:Menu sub-->

                            </div>
                            <!--end:Menu item-->
                        @endif
                    @endforeach

                @endforeach
            @endif

            <!--begin:Menu item-->
            <div class="menu-item pt-2">
                <!--begin:Menu content-->
                <div class="menu-content">
                    <span class="menu-heading fw-bold text-uppercase text-warning fs-7">LAINNYA</span>
                </div>
                <!--end:Menu content-->
            </div>
            <!--end:Menu item-->

            <!--begin:Menu item-->
            <div class="menu-item">
                <!--begin:Menu link-->
                <a class="menu-link" href="{{route('management.account')}}">
                    <span class="menu-icon">
                        <!--begin::Svg Icon | path: icons/duotune/general/gen019.svg-->
                        <span class="svg-icon svg-icon-2">
                            <i class="bi bi-person-circle text-white me-2"></i>
                        </span>
                        <!--end::Svg Icon-->
                    </span>
                    <span class="menu-title">Pengaturan Akun</span>
                </a>
                <!--end:Menu link-->
            </div>
            <!--end:Menu item-->

            <!--begin:Menu item-->
            <div class="menu-item">
                <!--begin:Menu link-->
                <a class="menu-link" href="{{url('/auth/logout')}}">
                    <span class="menu-icon">
                        <!--begin::Svg Icon | path: icons/duotune/general/gen019.svg-->
                        <span class="svg-icon svg-icon-2">
                            <i class="bi bi-box-arrow-left text-white me-2"></i>
                        </span>
                        <!--end::Svg Icon-->
                    </span>
                    <span class="menu-title">Sign-Out</span>
                </a>
                <!--end:Menu link-->
            </div>
            <!--end:Menu item-->
            
        </div>
        <!--end::Menu-->
    </div>
    <!--end::Aside Menu-->
</div>
