
<!--begin::User details-->
<div class="d-flex flex-column">
    @if (auth()->user()->hasRole('admin'))
    <a href="{{ route('user-management.county-users.show', $mrac_arac->user->id) }}" class="text-gray-800 text-hover-primary mb-1">
        {{ $mrac_arac->user->first_name}} {{ $mrac_arac->user->last_name}}
    </a>
    @elseif(auth()->user()->hasRole('county user'))
     <a href="{{ route('profile') }}" class="text-gray-800 text-hover-primary mb-1">
        {{ $mrac_arac->user->first_name}} {{ $mrac_arac->user->last_name}}
    </a>
    @else
    <p class="text-gray-800 mb-1">
        {{ $mrac_arac->user->first_name}} {{ $mrac_arac->user->last_name}}
    </p> 
    @endif
</div>
<!--begin::User details-->
