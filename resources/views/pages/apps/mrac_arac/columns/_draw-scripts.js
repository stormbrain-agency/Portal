// Initialize KTMenu
KTMenu.init();

// Add click event listener to delete buttons
document.querySelectorAll('[data-kt-action="delete_row"]').forEach(function (element) {
    element.addEventListener('click', function () {
        var mrac_arac_id = this.getAttribute("data-kt-mrac-id");
        if (confirm('Are you sure you want to delete mRec/aRec with this id'+ ' ' + mrac_arac_id + ' ' + '?')) {
            $.ajax({
                url: '/county-mrac-arac/delete/' + mrac_arac_id,
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    alert('mRec/aRec deleted successfully.');
                    LaravelDataTables["mrac_arac-table"].ajax.reload();
                },
                error: function(xhr, status, error) {
                    alert('Error deleting mRec/aRec: ' + error);
                }
            });
        }
    });
});

// Add click event listener to update buttons
document.querySelectorAll('[data-kt-action="view_row"]').forEach(function (element) {
    element.addEventListener('click', function () {
        Livewire.emit('view_mrac_arac', this.getAttribute('data-kt-mrac-arac-id'));
    });
});

document.querySelectorAll('[data-kt-action="download_all"]').forEach(function (element) {
    element.addEventListener('click', function () {
        Livewire.emit('triggerDownloadAllFilesBtn', this.getAttribute('data-kt-mrac-arac-id'));
    });
});
// Listen for 'success' event emitted by Livewire
Livewire.on('success', (message) => {
    // Reload the users-table datatable
    LaravelDataTables["mrac_arac-table"].ajax.reload();
});
