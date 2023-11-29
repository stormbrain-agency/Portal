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
{{-- <script>
    $(document).ready(function () {
        $('.status-toggle').on('click', function () {
            var statusCheckbox = $(this);
            var status = statusCheckbox.prop('checked') ? 'Active' : 'Unactive';
            var notificationId = statusCheckbox.data('notification-id');

            console.log('Notification ID:', notificationId);
            console.log('Status:', status);

            $.ajax({
                url: '{{ route("notification-management.update-status") }}',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    id: notificationId,
                    status: status
                },
                success: function (response) {
                    console.log(response);
                    alert('Changes');
                },
                error: function (error) {
                    console.log(error);
                    alert('No Changes');
                }
            });
        });
    });
</script> --}}
