// resources/views/pages/apps/news/columns/_draw-scripts.js

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
            const newsId = this.getAttribute('data-kt-news-id');

            Swal.fire({
                text: 'Are you sure you want to delete this news?',
                icon: 'warning',
                buttonsStyling: false,
                showCancelButton: true,
                confirmButtonText: 'Yes, delete!',
                cancelButtonText: 'No, cancel',
                customClass: {
                    confirmButton: 'btn btn-danger',
                    cancelButton: 'btn btn-secondary',
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Create and submit delete form
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `/news-management/news/${newsId}`;
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
            const newsId = this.getAttribute('data-kt-news-id');
            // Dispatch Livewire event or redirect to edit page
            if (typeof Livewire !== 'undefined') {
                Livewire.dispatch('update_news', [newsId]);
            } else {
                window.location.href = `/news-management/news/${newsId}/edit`;
            }
        });
    });
});

// Listen for 'success' event emitted by Livewire (if using Livewire)
if (typeof Livewire !== 'undefined') {
    Livewire.on('success', (message) => {
        // Reload the news-table datatable
        if (typeof LaravelDataTables !== 'undefined' && LaravelDataTables['news-table']) {
            LaravelDataTables['news-table'].ajax.reload();
        }

        // Show success message
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                text: message || 'Operation completed successfully!',
                icon: 'success',
                buttonsStyling: false,
                confirmButtonText: 'Ok, got it!',
                customClass: {
                    confirmButton: 'btn btn-primary',
                }
            });
        }
    });

    // Listen for delete event
    Livewire.on('delete_news', (newsId) => {
        // Handle delete via Livewire if needed
    });

    // Listen for update event
    Livewire.on('update_news', (newsId) => {
        // Handle update via Livewire if needed
    });
}

// DataTable draw callback enhancements
function initializeNewsDataTable() {
    const table = LaravelDataTables['news-table'];

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
                            const newsId = this.getAttribute('data-kt-news-id');

                            Swal.fire({
                                text: 'Are you sure you want to delete this news?',
                                icon: 'warning',
                                buttonsStyling: false,
                                showCancelButton: true,
                                confirmButtonText: 'Yes, delete!',
                                cancelButtonText: 'No, cancel',
                                customClass: {
                                    confirmButton: 'btn btn-danger',
                                    cancelButton: 'btn btn-secondary',
                                }
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    const form = document.createElement('form');
                                    form.method = 'POST';
                                    form.action = `/news-management/news/${newsId}`;
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
    document.addEventListener('DOMContentLoaded', initializeNewsDataTable);
} else {
    initializeNewsDataTable();
}

// Export function for delete confirmation (if needed elsewhere)
window.confirmNewsDelete = function(newsId) {
    Swal.fire({
        text: 'Are you sure you want to delete this news?',
        icon: 'warning',
        buttonsStyling: false,
        showCancelButton: true,
        confirmButtonText: 'Yes, delete!',
        cancelButtonText: 'No, cancel',
        customClass: {
            confirmButton: 'btn btn-danger',
            cancelButton: 'btn btn-secondary',
        }
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/news-management/news/${newsId}`;
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
