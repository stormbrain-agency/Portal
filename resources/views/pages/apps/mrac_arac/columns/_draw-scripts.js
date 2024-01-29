// Initialize KTMenu
KTMenu.init();

// Add click event listener to delete buttons
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
