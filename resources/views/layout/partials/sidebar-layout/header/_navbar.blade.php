<!--begin::Navbar-->
<div class="app-navbar flex-shrink-0">
    <!--end::My apps links-->
    <!--begin::User menu-->
	<div class="app-navbar-item ms-1 ms-md-4" id="kt_header_user_menu_toggle">
		<div class="cursor-pointer symbol symbol-35px d-flex align-item-center" >
            <div class="app-navbar-item ">
                @if(auth()->user()->hasRole('admin'))
                    <div class="status admin me-2">Admin</div>
                @elseif (auth()->user()->hasRole('manager'))
                    <div class="status manager me-2">Manager / Support</div>
                @elseif (auth()->user()->hasRole('view only'))
                    <div class="status view-only me-2">View Only</div>
                @elseif (auth()->user()->hasRole('county user'))
                    <div class="status county-user me-2">County User</div>
                @endif
            </div>
            <div class="app-navbar-item ">
                <a class="menu-link" href="{{ url('/dashboard') }}">
                    <span class="menu-icon">{!! getIcon('notification-on', 'fs-2') !!}</span>
                </a>
            </div>
            <div class="app-navbar-item">
                <a class="menu-link profile" href="{{ url('/profile') }}">
                    <span class="menu-icon">{!! getIcon('user', 'fs-2') !!}</span>
                </a>
            </div>
            <div class="app-navbar-item">
                <a class="button-ajax menu-link" href="#" data-action="{{ route('logout') }}" data-method="post" data-csrf="{{ csrf_token() }}" data-reload="true">
                    {!! getIcon('exit-right', 'fs-1') !!}
                </a>
            </div>
        </div>
    </div>
</div>
<!--end::Navbar-->
