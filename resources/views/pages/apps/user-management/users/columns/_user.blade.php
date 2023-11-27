<div class="d-flex flex-column">
    <a href="{{ route('user-management.users.show', $user) }}" class="text-gray-800 text-hover-primary mb-1">
        {{ $user->first_name}} {{ $user->last_name}}
    </a>
</div>
<!--begin::User details-->
