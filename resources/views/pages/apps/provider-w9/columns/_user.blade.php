
<!--begin::User details-->
<div class="d-flex flex-column">
    @if($upload->user->id !== auth()->id())
    <a href="{{ route('user-management.users.show', $upload->user->id) }}" class="text-gray-800 text-hover-primary mb-1">
        {{ $upload->user->first_name}} {{ $upload->user->last_name}}
    </a>
    @else
    <a href="{{ route('profile')}}" class="text-gray-800 text-hover-primary mb-1">
        {{ $upload->user->first_name}} {{ $upload->user->last_name}}
    </a>
    @endif
    {{-- <span>{{ $upload->user->email }}</span> --}}
</div>
<!--begin::User details-->
