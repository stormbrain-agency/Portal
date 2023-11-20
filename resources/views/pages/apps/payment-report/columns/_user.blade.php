
<!--begin::User details-->
<div class="d-flex flex-column">
    <a href="{{ route('user-management.users.show', $payment_report->user->id) }}" class="text-gray-800 text-hover-primary mb-1">
        {{ $payment_report->user->first_name}} {{ $payment_report->user->last_name}}
    </a>
    {{-- <span>{{ $payment_report->user->email }}</span> --}}
</div>
<!--begin::User details-->
