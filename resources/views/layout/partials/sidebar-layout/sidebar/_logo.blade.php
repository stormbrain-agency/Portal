<!--begin::Logo-->
<div class="app-sidebar-logo px-6" id="kt_app_sidebar_logo">
	<!--begin::Sidebar toggle-->
	<!--begin::Minimized sidebar setup:
            if (isset($_COOKIE["sidebar_minimize_state"]) && $_COOKIE["sidebar_minimize_state"] === "on") {
                1. "src/js/layout/sidebar.js" adds "sidebar_minimize_state" cookie value to save the sidebar minimize state.
                2. Set data-kt-app-sidebar-minimize="on" attribute for body tag.
                3. Set data-kt-toggle-state="active" attribute to the toggle element with "kt_app_sidebar_toggle" id.
                4. Add "active" class to to sidebar toggle element with "kt_app_sidebar_toggle" id.
            }
        -->
	<div id="kt_app_sidebar_toggle" class="app-sidebar-toggle h-30px w-30px btn-menu-header" data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body" data-kt-toggle-name="app-sidebar-minimize">
		{!! getIcon('burger-menu-4', 'fs-3 rotate-180') !!}
	</div>
	<!--begin::Logo image-->
	<a  href="{{ route('dashboard') }}">
		{{-- <img alt="Logo" src="{{ asset('assets/images/logo/logo.png') }}" class="h-27px app-sidebar-logo-default" /> --}}
		<img alt="Logo" src="{{ asset('assets/images/logo/logo.png') }}" class="app-sidebar-logo-default" />
		<img alt="Logo" src="{{ asset('assets/images/logo/logo.png') }}" class="app-sidebar-logo-minimize" />
	</a>
	<!--end::Logo image-->
	<script type="text/javascript">
		var sidebar_toggle = document.getElementById("kt_app_sidebar_toggle");  // Get the sidebar toggle button element
		@if (isset($_COOKIE["sidebar_minimize_state"]) && $_COOKIE["sidebar_minimize_state"] === "on") 
			document.body.setAttribute("data-kt-app-sidebar-minimize", "on");  // Set the 'data-kt-app-sidebar-minimize' attribute for the body tag
			sidebar_toggle.setAttribute("data-kt-toggle-state", "active");  // Set the 'data-kt-toggle-state' attribute for the sidebar toggle button
			sidebar_toggle.classList.add("active");  // Add the 'active' class to the sidebar toggle button
		@endif
	</script>
	<!--end::Sidebar toggle-->
</div>
<!--end::Logo-->
