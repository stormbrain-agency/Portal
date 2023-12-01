
<!--begin::User details-->
<div class="d-flex flex-column">
    @if (auth()->user()->hasRole('admin'))
        <a href="{{ route('user-management.county-users.show', $payment_report->user->id) }}" class="text-gray-800 text-hover-primary mb-1">
            {{ $payment_report->user->first_name}} {{ $payment_report->user->last_name}}
        </a>
    @elseif(auth()->user()->hasRole('county user'))
        <a href="{{ route('profile') }}" class="text-gray-800 text-hover-primary mb-1">
            {{ $payment_report->user->first_name}} {{ $payment_report->user->last_name}}
        </a>
    @else
        <p class="text-gray-800 mb-1">
            {{ $payment_report->user->first_name}} {{ $payment_report->user->last_name}}
        </p>
    @endif
</div>
<!--begin::User details-->
