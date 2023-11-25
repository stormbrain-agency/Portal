<x-auth-layout>
    <h2>
      Your account is being moderated, please check your email for notifications
    </h2>
    <div class="menu-item py-5">
        {{-- <a class="button-ajax menu-link px-5" data-action="{{ route('logout') }}" data-method="post" data-csrf="{{ csrf_token() }}" data-reload="true">
          Logout
        </a> --}}
        <a href="{{route('logout_to_login')}}" class="btn btn-light w-100 mt-10">
           Log out
        </a>
    </div>
</x-auth-layout>
