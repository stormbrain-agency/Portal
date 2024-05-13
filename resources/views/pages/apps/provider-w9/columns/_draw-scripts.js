// Initialize KTMenu
KTMenu.init();

// Add click event listener to delete buttons
document.querySelectorAll('[data-kt-action="delete_row"]').forEach(function (element) {
    element.addEventListener('click', function () {
        var w9Id = this.getAttribute("data-kt-w9-id");
        if (confirm('Are you sure you want to delete W9 with this id'+ ' ' + w9Id + ' ' + '?')) {
            $.ajax({
                url: '/county-w9/delete/' + w9Id,
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    alert('W9 deleted successfully.');
                    LaravelDataTables["w9-upload-table"].ajax.reload();
                },
                error: function(xhr, status, error) {
                    alert('Error deleting W9: ' + error);
                }
            });
        }
    });
});

// Add click event listener to update buttons
document.querySelectorAll('[data-kt-action="view_row"]').forEach(function (element) {
    element.addEventListener('click', function () {
        Livewire.emit("view_w9", this.getAttribute("data-kt-w9-id"));
    });
});
// Listen for 'success' event emitted by Livewire
Livewire.on('success', (message) => {
    // Reload the users-table datatable
    LaravelDataTables["w9-upload-table"].ajax.reload();
});
