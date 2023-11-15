
<!--begin::User details-->
<div class="d-flex flex-column">
    <a href="{{ route('user-management.users.show', $upload) }}" class="text-gray-800 text-hover-primary mb-1">
        {{ $upload->user->first_name}} {{ $upload->user->last_name}}
    </a>
    <span>{{ $upload->user->email }}</span>
</div>
<!--begin::User details-->
