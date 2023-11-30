// Initialize KTMenu
KTMenu.init();

// Add click event listener to delete buttons
document.querySelectorAll('[data-kt-action="delete_row"]').forEach(function (element) {
    element.addEventListener('click', function () {
        Swal.fire({
            text: 'Are you sure you want to remove?',
            icon: 'warning',
            buttonsStyling: false,
            showCancelButton: true,
            confirmButtonText: 'Yes',
            cancelButtonText: 'No',
            customClass: {
                confirmButton: 'btn btn-danger',
                cancelButton: 'btn btn-secondary',
            }
        }).then((result) => {
            if (result.isConfirmed) {
                Livewire.emit('delete_user', this.getAttribute('data-kt-user-id'));
            }
        });
    });
});

// Add click event listener to update buttons
document.querySelectorAll('[data-kt-action="update_row"]').forEach(function (element) {
    element.addEventListener('click', function () {
        Livewire.emit('update_user', this.getAttribute('data-kt-user-id'));
    });
});

document.querySelectorAll('[data-kt-action="create_view"]').forEach(function (element) {
    element.addEventListener('click', function () {
        Livewire.emit("create_view");
    });
});

document.querySelectorAll('[data-kt-action="approve_row"]').forEach(function (element) {
    element.addEventListener('click', function () {
        Swal.fire({
            text: "Approve this user?",
            icon: "info",
            buttonsStyling: false,
            showCancelButton: true,
            confirmButtonText: "Yes",
            cancelButtonText: "No",
            customClass: {
                confirmButton: "btn btn-primary",
                cancelButton: "btn btn-secondary",
            },
        }).then((result) => {
            if (result.isConfirmed) {
                Livewire.emit("approve_user", this.getAttribute("data-kt-user-id"));
            }
        });
    });
});

document.querySelectorAll('[data-kt-action="deny_row"]').forEach(function (element) {
    element.addEventListener('click', function () {
        Swal.fire({
            text: "This action will reject this user!\nAre you sure?",
            icon: "warning",
            buttonsStyling: false,
            showCancelButton: true,
            confirmButtonText: "Yes",
            cancelButtonText: "No",
            customClass: {
                confirmButton: "btn btn-danger",
                cancelButton: "btn btn-secondary",
            },
        }).then((result) => {
            if (result.isConfirmed) {
                Livewire.emit(
                    "deny_user",
                    this.getAttribute("data-kt-user-id")
                );
            }
        });
    });
});

// Listen for 'success' event emitted by Livewire
Livewire.on('success', (message) => {
    // Reload the users-table datatable
    LaravelDataTables["users-pending-table"].ajax.reload();
});
