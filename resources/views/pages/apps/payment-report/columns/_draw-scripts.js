// Initialize KTMenu
KTMenu.init();

// Add click event listener to delete buttons
// Add click event listener to update buttons
document.querySelectorAll('[data-kt-action="view_row"]').forEach(function (element) {
    element.addEventListener('click', function () {
        Livewire.emit('view_payment', this.getAttribute('data-kt-payment-report-id'));
    });
});

document.getElementById("downloadBtn").addEventListener("click", function () {
    Livewire.emit("triggerDownloadAllFiles");
    console.log("Downloading");
});
// Listen for 'success' event emitted by Livewire
Livewire.on('success', (message) => {
    // Reload the users-table datatable
    LaravelDataTables["payment_report-table"].ajax.reload();
});
