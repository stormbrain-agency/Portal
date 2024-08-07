<!--begin::sidebar menu-->
<div class="app-sidebar-menu overflow-hidden flex-column-fluid">
	<!--begin::Menu wrapper-->
	<div id="kt_app_sidebar_menu_wrapper" class="app-sidebar-wrapper hover-scroll-overlay-y my-5" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_app_sidebar_logo, #kt_app_sidebar_footer" data-kt-scroll-wrappers="#kt_app_sidebar_menu" data-kt-scroll-offset="5px" data-kt-scroll-save-state="true">
		<!--begin::Menu-->
		<div class="menu menu-column menu-rounded menu-sub-indention px-3 fw-semibold fs-6" id="#kt_app_sidebar_menu" data-kt-menu="true" data-kt-menu-expand="false">
			<div class="menu-item">
				<!--begin:Menu link-->
				<a class="menu-link  {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
					<span class="menu-icon">
						{!! getIcon('element-11', 'fs-2') !!}
					</span>
					<span class="menu-title">Dashboard</span>
				</a>
				<!--end:Menu link-->
			</div>
			@if(!auth()->user()->hasRole('county user') && !auth()->user()->hasRole('CDSS'))
				{{-- Provider W-9 --}}
				<div class="menu-item">
					<!--begin:Menu link-->
					<a class="menu-link {{ request()->routeIs('w9_upload.*') ? 'active' : '' }}" href="{{ route('w9_upload.index') }}">
						<span class="menu-icon">{!! getIcon('file', 'fs-1') !!}</span>
						<span class="menu-title">County W-9 Forms</span>
					</a>
					<!--end:Menu link-->
				</div>
				<!-- mRec/aRec -->
				<div class="menu-item">
					<a class="menu-link {{ request()->routeIs('county-mrac-arac.*') ? 'active' : '' }}" href="{{ route('county-mrac-arac.index') }}">
						<span class="menu-icon">{!! getIcon('graph-up', 'fs-1') !!}</span>
						<span class="menu-title">County mRec/aRec</span>
					</a>
				</div>
				{{-- Payment Report --}}
				<div class="menu-item">
					<a class="menu-link {{ request()->routeIs('county-provider-payment-report.*') ? 'active' : '' }}" href="{{ route('county-provider-payment-report.index') }}">
						<span class="menu-icon">{!! getIcon('dollar', 'fs-1') !!}</span>
						<span class="menu-title">CDSS Payment Report</span>
					</a>
				</div>
				<!-- Notifications -->
				@if(auth()->user()->hasRole('admin') && count(auth()->user()->roles) != 0)
				<div class="menu-item menu-accordion {{ request()->routeIs('notification-management.*') ? 'hover show' : '' }}">
                    <span class="menu-link">
                        <span class="menu-icon">{!! getIcon('notification', 'fs-2') !!}</span>
                        <a href="{{ route('notification-management.dashboard.index') }}" class="menu-title">Notifications Management</a>
                        <span class="menu-arrow"></span>
                    </span>
                    <div class="menu-sub menu-sub-accordion">
                        <div class="menu-item">
                            <a class="menu-link {{ request()->routeIs('notification-management.dashboard.*') ? 'active' : '' }}" href="{{ route('notification-management.dashboard.index') }}">
                                <span class="menu-title">Notifications Dashboard</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link {{ request()->routeIs('notification-management.email.*') ? 'active' : '' }}" href="{{ route('notification-management.email.index') }}" style="padding-right: 0px">
                                <span class="menu-title">Notification Mail</span>
                            </a>
                        </div>
                    </div>
                </div>


				@endif
				{{-- User Management --}}
				@if(auth()->user()->hasRole('admin'))
					<div class="menu-item menu-accordion {{ request()->routeIs('user-management.*') ? 'hover show' : '' }}">
						<span class="menu-link">
							<span class="menu-icon">{!! getIcon('user', 'fs-2') !!}</span>
							<a href="{{ route('user-management.users.index') }}" class="menu-title">User Management</a>
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
								<a class="menu-link {{ request()->routeIs('user-management.county-users.*') ? 'active' : '' }}" href="{{ route('user-management.county-users.index') }}">
									<span class="menu-title">County Users</span>
								</a>
							</div>
							@endif
						</div>
					</div>
				@endif
				@if(auth()->user()->hasRole('admin') && count(auth()->user()->roles) != 0)
				{{-- Activity Management --}}
				<div class="menu-item">
					<a class="menu-link {{ request()->routeIs('activity-management.*') ? 'active' : '' }}" href="{{ route('activity-management.index') }}">
						<span class="menu-icon">{!! getIcon('time', 'fs-2') !!}</span>
						<span class="menu-title">Activity </span>
					</a>
				</div>
				@endif
				{{-- Help/FAQ --}}
				<div class="menu-item">
					<!--begin:Menu link-->
					<a class="menu-link {{ request()->routeIs('help-faq') ? 'active' : '' }}" href="{{ url('/help-faq') }}">
						<span class="menu-icon">{!! getIcon('chart', 'fs-1') !!}</span>
						<span class="menu-title">FAQs</span>
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
			@else
				{{-- Provider W-9 --}}
				<div class="menu-item menu-accordion {{ request()->routeIs('w9_upload.*') ? 'hover show' : '' }}">
					<!--begin:Menu link-->
					<span class="menu-link ">
						<span class="menu-icon">{!! getIcon('file', 'fs-1') !!}</span>
						<a href="{{ route('w9_upload.create') }}" class="menu-title">County W-9 Forms</a>
						<span class="menu-arrow"></span>
					</span>
					{{-- <a href="{{ route('w9_upload.create') }}"></a> --}}
					<!--end:Menu link-->
					<!--begin:Menu sub-->
					<div class="menu-sub menu-sub-accordion">
						<!--begin:Menu item-->
						<div class="menu-item">
							<!--begin:Menu link-->
							<a class="menu-link {{ request()->routeIs('w9_upload.create') ? 'active' : '' }}" href="{{ route('w9_upload.create') }}">
								<span class="menu-title">Submit W-9 Forms</span>
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
				{{-- mRec/aRec --}}
				<div class="menu-item menu-accordion {{ request()->routeIs('county-mrac-arac.*') ? 'hover show' : '' }}">
					<span class="menu-link">
						<span class="menu-icon">{!! getIcon('graph-up', 'fs-1') !!}</span>
						<a href="{{ route('county-mrac-arac.create') }}" class="menu-title">County mRec/aRec</a>
						<span class="menu-arrow"></span>
					</span>
					<div class="menu-sub menu-sub-accordion">
						<div class="menu-item">
							<a class="menu-link {{ request()->routeIs('county-mrac-arac.create') ? 'active' : '' }}" href="{{ route('county-mrac-arac.create') }}">
								<span class="menu-title">Submit mRec/aRec</span>
							</a>
						</div>
						<div class="menu-item">
							<a class="menu-link {{ request()->routeIs('county-mrac-arac.index') ? 'active' : '' }}" href="{{ route('county-mrac-arac.index') }}">
								<span class="menu-title">Submission History</span>
							</a>
						</div>
					</div>
				</div>
				{{-- Payment Report --}}
				<div class="menu-item menu-accordion {{ request()->routeIs('county-provider-payment-report.*') ? 'hover show' : '' }}">
					<span class="menu-link">
						<span class="menu-icon">{!! getIcon('dollar', 'fs-1') !!}</span>
						<a href="{{ route('county-provider-payment-report.create') }}" class="menu-title ">CDSS Payment Report</a>
						<span class="menu-arrow"></span>
					</span>
					<div class="menu-sub menu-sub-accordion">
						<div class="menu-item">
							<a class="menu-link {{ request()->routeIs('county-provider-payment-report.create') ? 'active' : '' }}" href="{{ route('county-provider-payment-report.create') }}">
								<span class="menu-title">Submit Payment Report</span>
							</a>
						</div>
						<div class="menu-item">
							<a class="menu-link {{ request()->routeIs('county-provider-payment-report.index') ? 'active' : '' }}" href="{{ route('county-provider-payment-report.index') }}">
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
						<span class="menu-title">FAQs</span>
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

<script>
	// Menu
	const menuItems = document.querySelectorAll('.menu-accordion');
	for (const menuItem of menuItems) {
		const btnDropDown = menuItem.querySelector('.menu-link .menu-arrow');
		btnDropDown.addEventListener('click', function () {
			menuItem.classList.toggle('show');
			console.log('click');
		});
	}
</script>
