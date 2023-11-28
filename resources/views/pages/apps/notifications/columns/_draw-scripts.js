// Initialize KTMenu
KTMenu.init();

// Add click event listener to delete buttons
// Add click event listener to update buttons
document.querySelectorAll('[data-kt-action="view_row"]').forEach(function (element) {
    element.addEventListener('click', function () {
        Livewire.emit('view_notifications', this.getAttribute('data-kt-notifications-id'));
    });
});
document.querySelectorAll('[data-kt-action="view_edit"]').forEach(function (element) {
    element.addEventListener('click', function () {
        Livewire.emit('edit_notifications', this.getAttribute('data-kt-edit-notification-id'));
    });
});
// Listen for 'success' event emitted by Livewire
Livewire.on('success', (message) => {
    // Reload the users-table datatable
    LaravelDataTables["notifications-table"].ajax.reload();
});
