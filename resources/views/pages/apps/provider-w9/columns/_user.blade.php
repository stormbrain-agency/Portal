
<!--begin::User details-->
<div class="d-flex flex-column">
    @if (auth()->user()->hasRole('admin'))
        <a href="{{ route('user-management.users.show', $upload->user->id) }}" class="text-gray-800 text-hover-primary mb-1">
            {{ $upload->user->first_name}} {{ $upload->user->last_name}}
        </a>
    @elseif(auth()->user()->hasRole('county user'))
        <a href="{{ route('profile')}}" class="text-gray-800 text-hover-primary mb-1">
            {{ $upload->user->first_name}} {{ $upload->user->last_name}}
        </a>
    @else
        <p class="text-gray-800 mb-1">
            {{ $upload->user->first_name}} {{ $upload->user->last_name}}
        </p>
    @endif
</div>
<!--begin::User details-->
