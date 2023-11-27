// Initialize KTMenu
KTMenu.init();

// Add click event listener to delete buttons
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
