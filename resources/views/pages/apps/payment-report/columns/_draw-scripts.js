// Initialize KTMenu
KTMenu.init();

// Add click event listener to delete buttons
document.querySelectorAll('[data-kt-action="delete_row"]').forEach(function (element) {
    element.addEventListener('click', function () {
        var payment_report_id = this.getAttribute("data-kt-payment-id");
        if (confirm('Are you sure you want to delete Payment Report with this id'+ ' ' + payment_report_id + ' ' + '?')) {
            $.ajax({
                url: '/county-provider-payment-report/delete/' + payment_report_id,
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    alert('Payment Report deleted successfully.');
                    LaravelDataTables["payment_report-table"].ajax.reload();
                },
                error: function(xhr, status, error) {
                    alert('Error deleting Payment Report: ' + error);
                }
            });
        }
    });
});

// Add click event listener to update buttons
document.querySelectorAll('[data-kt-action="view_row"]').forEach(function (element) {
    element.addEventListener('click', function () {
        Livewire.emit('view_payment', this.getAttribute('data-kt-payment-report-id'));
    });
});

document.querySelectorAll('[data-kt-action="download_all"]').forEach(function (element) {
    element.addEventListener('click', function () {
        Livewire.emit('triggerDownloadAllFilesBtn', this.getAttribute('data-kt-payment-report-id'));
    });
});
// Listen for 'success' event emitted by Livewire
Livewire.on('success', (message) => {
    // Reload the users-table datatable
    LaravelDataTables["payment_report-table"].ajax.reload();
});
