// Initialize KTMenu
KTMenu.init();

// Listen for 'success' event emitted by Livewire
Livewire.on('success', (message) => {
    // Reload the users-table datatable
    LaravelDataTables["activity-table"].ajax.reload();
});
