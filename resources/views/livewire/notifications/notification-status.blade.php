<div class="d-flex flex-column">
    <span>{{$notification->status}}</span>
    <div class="form-check form-switch">
        <input
            data-kt-action="view_rows"
            class="form-check-input status-toggle"
            type="checkbox"
            data-notification-id="{{ $notification->id }}"
            {{ $notification->status === 'Active' ? 'checked' : '' }}
        >
    </div>
</div>
