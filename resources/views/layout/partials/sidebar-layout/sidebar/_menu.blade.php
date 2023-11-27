<!--begin::sidebar menu-->
<div class="app-sidebar-menu overflow-hidden flex-column-fluid">
	<!--begin::Menu wrapper-->
	<div id="kt_app_sidebar_menu_wrapper" class="app-sidebar-wrapper hover-scroll-overlay-y my-5" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_app_sidebar_logo, #kt_app_sidebar_footer" data-kt-scroll-wrappers="#kt_app_sidebar_menu" data-kt-scroll-offset="5px" data-kt-scroll-save-state="true">
		<!--begin::Menu-->
		<div class="menu menu-column menu-rounded menu-sub-indention px-3 fw-semibold fs-6" id="#kt_app_sidebar_menu" data-kt-menu="true" data-kt-menu-expand="false">
			<!--begin:Menu item-->
			{{-- <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ request()->routeIs('dashboard') ? 'hover show' : '' }}">
				<!--begin:Menu link-->
				<span class="menu-link">
					<span class="menu-icon">{!! getIcon('element-11', 'fs-2') !!}</span>
					<span class="menu-title">Dashboards</span>
					<span class="menu-arrow"></span>
				</span>
				<!--end:Menu link-->
				<!--begin:Menu sub-->
				<div class="menu-sub menu-sub-accordion">
					<!--begin:Menu item-->
					<div class="menu-item">
						<!--begin:Menu link-->
						<a class="menu-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
							<span class="menu-bullet">
								<span class="bullet bullet-dot"></span>
							</span>
							<span class="menu-title">Default</span>
						</a>
						<!--end:Menu link-->
					</div>
					<!--end:Menu item-->
				</div>
				<!--end:Menu sub-->
			</div> --}}
			<!--end:Menu item-->
			{{-- <!--begin:Menu item-->
			<div class="menu-item pt-5">
				<!--begin:Menu content-->
				<div class="menu-content">
					<span class="menu-heading fw-bold text-uppercase fs-7">Manager</span>
				</div>
				<!--end:Menu content-->
			</div>
			<!--end:Menu item--> --}}

			@if(auth()->user()->hasRole('admin'))
				{{-- Provider W-9 --}}
				<div class="menu-item">
					<!--begin:Menu link-->
					<a class="menu-link {{ request()->routeIs('w9_upload.index') ? 'active' : '' }}" href="{{ route('w9_upload.index') }}">
						<span class="menu-icon">{!! getIcon('file', 'fs-1') !!}</span>
						<span class="menu-title">County Provider W-9</span>
					</a>
					<!--end:Menu link-->
				</div>
				{{-- Payment Report --}}
				<div class="menu-item">
					<a class="menu-link {{ request()->routeIs('county-provider-payment-report.index') ? 'active' : '' }}" href="{{ route('county-provider-payment-report.index') }}">
						<span class="menu-icon">{!! getIcon('dollar', 'fs-1') !!}</span>
						<span class="menu-title">County Provider Payment Report</span>
					</a>
				</div>
				<!-- MRAC/ARAC -->
				<div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ request()->routeIs('county-mrac-arac.*') ? 'hover show' : '' }}">
					<span class="menu-link">
						<span class="menu-icon">{!! getIcon('graph-up', 'fs-1') !!}</span>
						<span class="menu-title">County MRAC/ARAC</span>
						<span class="menu-arrow"></span>
					</span>
					<div class="menu-sub menu-sub-accordion">
						<div class="menu-item {{ request()->routeIs('county-mrac-arac.template') ? 'active' : '' }}">
							<a class="menu-link {{ request()->routeIs('county-mrac-arac.template') ? 'active' : '' }}" href="{{ route('county-mrac-arac.template') }}">
								<span class="menu-title">Submit MRAC/ARAC</span>
							</a>
						</div>
						<div class="menu-item">
							<a class="menu-link {{ request()->routeIs('county-mrac-arac.index') ? 'active' : '' }}" href="{{ route('county-mrac-arac.index') }}">
								<span class="menu-title">Submission History</span>
							</a>
						</div>
					</div>
				</div>
				<!-- Notifications -->
				<div class="menu-item">
					<a class="menu-link {{ request()->routeIs('notification-management.*') ? 'active' : '' }}" href="{{ route('notification-management.index') }}">
						<span class="menu-icon">{!! getIcon('notification', 'fs-2') !!}</span>
						<span class="menu-title">Notifications</span>
					</a>
				</div>
				{{-- User Management --}}
				<div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ request()->routeIs('user-management.*') ? 'hover show' : '' }}">
					<span class="menu-link">
						<span class="menu-icon">{!! getIcon('user', 'fs-2') !!}</span>
						<span class="menu-title">User Management</span>
						<span class="menu-arrow"></span>
					</span>
					<div class="menu-sub menu-sub-accordion">
						<div class="menu-item">
							<a class="menu-link {{ request()->routeIs('user-management.users.*') ? 'active' : '' }}" href="{{ route('user-management.users.index') }}">
								<span class="menu-title">Users</span>
							</a>
						</div>
						@if(auth()->user()->hasRole('admin') && count(auth()->user()->roles) != 0)
						<div class="menu-item">
							<a class="menu-link {{ request()->routeIs('user-management.users-pending.*') ? 'active' : '' }}" href="{{ route('user-management.users-pending.index') }}">
								<span class="menu-title">Pending Users</span>
							</a>
						</div>
						@endif
					</div>
				</div>
				{{-- Activity Management --}}
				<div class="menu-item">
					<a class="menu-link {{ request()->routeIs('activity-management.*') ? 'active' : '' }}" href="{{ route('activity-management.index') }}">
						<span class="menu-icon">{!! getIcon('time', 'fs-2') !!}</span>
						<span class="menu-title">Activity </span>
					</a>
				</div>
				{{-- Profile --}}
				<div class="menu-item">
					<a class="menu-link {{ request()->routeIs('profile') ? 'active' : '' }}" href="{{ url('/profile') }}">
						<span class="menu-icon">{!! getIcon('setting-2', 'fs-2') !!}</span>
						<span class="menu-title">Profile</span>
					</a>
				</div>
			@else
				{{-- Provider W-9 --}}
				<div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ request()->routeIs('w9_upload.*') ? 'hover show' : '' }}">
					<!--begin:Menu link-->
					<span class="menu-link ">
						<span class="menu-icon">{!! getIcon('file', 'fs-1') !!}</span>
						<span class="menu-title">Submit Provider W-9</span>
						<span class="menu-arrow"></span>
					</span>
					<!--end:Menu link-->
					<!--begin:Menu sub-->
					<div class="menu-sub menu-sub-accordion">
						<!--begin:Menu item-->
						<div class="menu-item">
							<!--begin:Menu link-->
							<a class="menu-link {{ request()->routeIs('w9_upload.create') ? 'active' : '' }}" href="{{ route('w9_upload.create') }}">
								<span class="menu-title">Submit Provider W-9</span>
							</a>
							<!--end:Menu link-->
						</div>
						<div class="menu-item">
							<!--begin:Menu link-->
							<a class="menu-link {{ request()->routeIs('w9_upload.index') ? 'active' : '' }}" href="{{ route('w9_upload.index') }}">
								<span class="menu-title">Submission History</span>
							</a>
							<!--end:Menu link-->
						</div>
						
						<!--end:Menu item-->
					</div>
					<!--end:Menu sub-->
				</div>
				{{-- Payment Report --}}
				<div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ request()->routeIs('county-provider-payment-report.*') ? 'hover show' : '' }}">
					<span class="menu-link }">
						<span class="menu-icon">{!! getIcon('dollar', 'fs-1') !!}</span>
						<span class="menu-title ">Submit Provider Payment Report</span>
						<span class="menu-arrow"></span>
					</span>
					<div class="menu-sub menu-sub-accordion">
						<div class="menu-item">
							<a class="menu-link {{ request()->routeIs('county-provider-payment-report.create') ? 'active' : '' }}" href="{{ route('county-provider-payment-report.create') }}">
								<span class="menu-title">Submit Report</span>
							</a>
						</div>
						<div class="menu-item">
							<a class="menu-link {{ request()->routeIs('county-provider-payment-report.index') ? 'active' : '' }}" href="{{ route('county-provider-payment-report.index') }}">
								<span class="menu-title">Submission History</span>
							</a>
						</div>
					</div>
				</div>
				{{-- MRAC/ARAC --}}
				<div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ request()->routeIs('county-mrac-arac.*') ? 'hover show' : '' }}">
					<span class="menu-link">
						<span class="menu-icon">{!! getIcon('graph-up', 'fs-1') !!}</span>
						<span class="menu-title">MRAC/ARAC</span>
						<span class="menu-arrow"></span>
					</span>
					<div class="menu-sub menu-sub-accordion">
						<div class="menu-item">
							<a class="menu-link {{ request()->routeIs('county-mrac-arac.template') ? 'active' : '' }}" href="{{ route('county-mrac-arac.template') }}">
								<span class="menu-title">Submit MRAC/ARAC</span>
							</a>
						</div>
						<div class="menu-item">
							<a class="menu-link {{ request()->routeIs('county-mrac-arac.index') ? 'active' : '' }}" href="{{ route('county-mrac-arac.index') }}">
								<span class="menu-title">Submission History</span>
							</a>
						</div>
					</div>
				</div>
				{{-- Help/FAQ --}}
				<div class="menu-item">
					<!--begin:Menu link-->
					<a class="menu-link {{ request()->routeIs('help-faq') ? 'active' : '' }}" href="{{ url('/help-faq') }}">
						<span class="menu-icon">{!! getIcon('chart', 'fs-1') !!}</span>
						<span class="menu-title">Help/FAQ</span>
					</a>
					<!--end:Menu link-->
				</div>
				{{-- Profile --}}
				<div class="menu-item">
					<a class="menu-link {{ request()->routeIs('profile') ? 'active' : '' }}" href="{{ url('/profile') }}">
						<span class="menu-icon">{!! getIcon('setting-2', 'fs-2') !!}</span>
						<span class="menu-title">Profile</span>
					</a>
				</div>
			@endif

		</div>
		<!--end::Menu-->
	</div>
	<!--end::Menu wrapper-->
</div>
<!--end::sidebar menu-->