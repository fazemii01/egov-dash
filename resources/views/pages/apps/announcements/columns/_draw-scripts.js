// resources/views/pages/apps/announcements/columns/_draw-scripts.js

// Initialize KTMenu
if (typeof KTMenu !== 'undefined') {
    KTMenu.init();
}

// Add click event listener to delete buttons
document.addEventListener('DOMContentLoaded', function() {
    // Delete functionality
    document.querySelectorAll('[data-kt-action="delete_row"]').forEach(function (element) {
        element.addEventListener('click', function (e) {
            e.preventDefault();
            const announcementId = this.getAttribute('data-kt-announcement-id');

            Swal.fire({
                text: 'Apakah Anda yakin ingin menghapus pengumuman ini?',
                icon: 'warning',
                buttonsStyling: false,
                showCancelButton: true,
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Tidak, batal',
                customClass: {
                    confirmButton: 'btn btn-danger',
                    cancelButton: 'btn btn-secondary',
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Create and submit delete form
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `/announcements-management/announcements/${announcementId}`;
                    form.style.display = 'none';

                    const csrfToken = document.createElement('input');
                    csrfToken.name = '_token';
                    csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    form.appendChild(csrfToken);

                    const methodField = document.createElement('input');
                    methodField.name = '_method';
                    methodField.value = 'DELETE';
                    form.appendChild(methodField);

                    document.body.appendChild(form);
                    form.submit();
                }
            });
        });
    });

    // Add click event listener to edit buttons (if using Livewire)
    document.querySelectorAll('[data-kt-action="update_row"]').forEach(function (element) {
        element.addEventListener('click', function (e) {
            e.preventDefault();
            const announcementId = this.getAttribute('data-kt-announcement-id');
            // Dispatch Livewire event or redirect to edit page
            if (typeof Livewire !== 'undefined') {
                Livewire.dispatch('update_announcement', [announcementId]);
            } else {
                window.location.href = `/announcements-management/announcements/${announcementId}/edit`;
            }
        });
    });
});

// Listen for 'success' event emitted by Livewire (if using Livewire)
if (typeof Livewire !== 'undefined') {
    Livewire.on('success', (message) => {
        // Reload the announcements-table datatable
        if (typeof LaravelDataTables !== 'undefined' && LaravelDataTables['announcements-table']) {
            LaravelDataTables['announcements-table'].ajax.reload();
        }

        // Show success message
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                text: message || 'Operasi berhasil diselesaikan!',
                icon: 'success',
                buttonsStyling: false,
                confirmButtonText: 'Ok, mengerti!',
                customClass: {
                    confirmButton: 'btn btn-primary',
                }
            });
        }
    });

    // Listen for delete event
    Livewire.on('delete_announcement', (announcementId) => {
        // Handle delete via Livewire if needed
    });

    // Listen for update event
    Livewire.on('update_announcement', (announcementId) => {
        // Handle update via Livewire if needed
    });
}

// DataTable draw callback enhancements
function initializeAnnouncementsDataTable() {
    const table = LaravelDataTables['announcements-table'];

    if (table) {
        // Re-initialize KTMenu after each DataTable draw
        table.on('draw', function () {
            if (typeof KTMenu !== 'undefined') {
                KTMenu.init();
            }

            // Re-attach event listeners after table redraw
            setTimeout(() => {
                document.querySelectorAll('[data-kt-action="delete_row"]').forEach(function (element) {
                    if (!element.hasListener) {
                        element.hasListener = true;
                        element.addEventListener('click', function (e) {
                            e.preventDefault();
                            const announcementId = this.getAttribute('data-kt-announcement-id');

                            Swal.fire({
                                text: 'Apakah Anda yakin ingin menghapus pengumuman ini?',
                                icon: 'warning',
                                buttonsStyling: false,
                                showCancelButton: true,
                                confirmButtonText: 'Ya, hapus!',
                                cancelButtonText: 'Tidak, batal',
                                customClass: {
                                    confirmButton: 'btn btn-danger',
                                    cancelButton: 'btn btn-secondary',
                                }
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    const form = document.createElement('form');
                                    form.method = 'POST';
                                    form.action = `/announcements-management/announcements/${announcementId}`;
                                    form.style.display = 'none';

                                    const csrfToken = document.createElement('input');
                                    csrfToken.name = '_token';
                                    csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                                    form.appendChild(csrfToken);

                                    const methodField = document.createElement('input');
                                    methodField.name = '_method';
                                    methodField.value = 'DELETE';
                                    form.appendChild(methodField);

                                    document.body.appendChild(form);
                                    form.submit();
                                }
                            });
                        });
                    }
                });
            }, 100);
        });
    }
}

// Initialize when document is ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initializeAnnouncementsDataTable);
} else {
    initializeAnnouncementsDataTable();
}

// Export function for delete confirmation (if needed elsewhere)
window.confirmAnnouncementDelete = function(announcementId) {
    Swal.fire({
        text: 'Apakah Anda yakin ingin menghapus pengumuman ini?',
        icon: 'warning',
        buttonsStyling: false,
        showCancelButton: true,
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Tidak, batal',
        customClass: {
            confirmButton: 'btn btn-danger',
            cancelButton: 'btn btn-secondary',
        }
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/announcements-management/announcements/${announcementId}`;
            form.style.display = 'none';

            const csrfToken = document.createElement('input');
            csrfToken.name = '_token';
            csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            form.appendChild(csrfToken);

            const methodField = document.createElement('input');
            methodField.name = '_method';
            methodField.value = 'DELETE';
            form.appendChild(methodField);

            document.body.appendChild(form);
            form.submit();
        }
    });
};
