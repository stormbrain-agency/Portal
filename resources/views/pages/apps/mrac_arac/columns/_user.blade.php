
<!--begin::User details-->
<div class="d-flex flex-column">
    <a href="{{ route('user-management.users.show', $mrac_arac->user->id) }}" class="text-gray-800 text-hover-primary mb-1">
        {{ $mrac_arac->user->first_name}} {{ $mrac_arac->user->last_name}}
    </a>
    {{-- <span>{{ $mrac_arac->user->email }}</span> --}}
</div>
<!--begin::User details-->
