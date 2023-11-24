<!--begin::Navbar-->
<div class="app-navbar flex-shrink-0">
    <!--begin::Search-->
    {{-- <div class="app-navbar-item align-items-stretch ms-1 ms-md-3">
        @include(config('settings.KT_THEME_LAYOUT_DIR').'/partials/sidebar-layout/search/_dropdown')
    </div>
    <!--end::Search-->
    <!--begin::Activities-->
	<div class="app-navbar-item ms-1 ms-md-4">
        <!--begin::Drawer toggle-->
		<div class="btn btn-icon btn-custom btn-icon-muted btn-active-light btn-active-color-primary w-35px h-35px" id="kt_activities_toggle">{!! getIcon('messages', 'fs-2') !!}</div>
        <!--end::Drawer toggle-->
    </div>
    <!--end::Activities-->
    <!--begin::Notifications-->
	<div class="app-navbar-item ms-1 ms-md-4">
        <!--begin::Menu- wrapper-->
		<div class="btn btn-icon btn-custom btn-icon-muted btn-active-light btn-active-color-primary w-35px h-35px" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end" id="kt_menu_item_wow">{!! getIcon('notification-status', 'fs-2') !!}</div>
        @include('partials/menus/_notifications-menu')
        <!--end::Menu wrapper-->
    </div>
    <!--end::Notifications-->
    <!--begin::Chat-->
	<div class="app-navbar-item ms-1 ms-md-4">
        <!--begin::Menu wrapper-->
		<div class="btn btn-icon btn-custom btn-icon-muted btn-active-light btn-active-color-primary w-35px h-35px position-relative" id="kt_drawer_chat_toggle">{!! getIcon('message-text-2', 'fs-2') !!} 
		<span class="bullet bullet-dot bg-success h-6px w-6px position-absolute translate-middle top-0 start-50 animation-blink"></span></div>
        <!--end::Menu wrapper-->
    </div>
    <!--end::Chat-->
    <!--begin::My apps links-->
	<div class="app-navbar-item ms-1 ms-md-4">
        <!--begin::Menu wrapper-->
		<div class="btn btn-icon btn-custom btn-icon-muted btn-active-light btn-active-color-primary w-35px h-35px" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">{!! getIcon('element-11', 'fs-2') !!}</div>
        @include('partials/menus/_my-apps-menu')
        <!--end::Menu wrapper-->
    </div> --}}
    <!--end::My apps links-->
    <!--begin::User menu-->
	<div class="app-navbar-item ms-1 ms-md-4" id="kt_header_user_menu_toggle">
		<div class="cursor-pointer symbol symbol-35px d-flex align-item-center" >
            <div class="app-navbar-item">
                <a class="menu-link px-5" href="{{ url('/profile') }}">
                    <span class="menu-icon">{!! getIcon('notification-on', 'fs-2') !!}</span>
                </a>
            </div>
            <div class="app-navbar-item">
                <a class="menu-link profile" href="{{ url('/profile') }}">
                    <span class="menu-icon">{!! getIcon('user', 'fs-2') !!}</span>
                </a>
            </div>
            <div class="app-navbar-item">
                <a class="button-ajax menu-link px-5" href="#" data-action="{{ route('logout') }}" data-method="post" data-csrf="{{ csrf_token() }}" data-reload="true">
                    {!! getIcon('exit-right', 'fs-1') !!}
                </a>
            </div>
        </div>
    </div>
    <!--end::User menu-->
    <!--begin::Header menu toggle-->
	<div class="app-navbar-item d-lg-none ms-2 me-n2" title="Show header menu">
		<div class="btn btn-flex btn-icon btn-active-color-primary w-30px h-30px" id="kt_app_header_menu_toggle">{!! getIcon('element-4', 'fs-1') !!}</div>
    </div>
    <!--end::Header menu toggle-->
	<!--begin::Aside toggle-->
	<!--end::Header menu toggle-->
</div>
<!--end::Navbar-->
