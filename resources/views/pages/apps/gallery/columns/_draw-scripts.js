// Initialize KTMenu
KTMenu.init();

// Handle delete gallery action from dropdown
document.addEventListener('click', function(e) {
    if (e.target.matches('[data-kt-action="delete_gallery"]') ||
        e.target.closest('[data-kt-action="delete_gallery"]')) {
        e.preventDefault();

        const target = e.target.matches('[data-kt-action="delete_gallery"]')
            ? e.target
            : e.target.closest('[data-kt-action="delete_gallery"]');

        const galleryId = target.getAttribute('data-kt-gallery-id');
        const galleryName = target.getAttribute('data-kt-gallery-name') || 'galeri ini';

        Swal.fire({
            text: `Apakah Anda yakin ingin menghapus "${galleryName}"?`,
            icon: 'warning',
            buttonsStyling: false,
            showCancelButton: true,
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            customClass: {
                confirmButton: 'btn btn-danger',
                cancelButton: 'btn btn-secondary',
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Dispatch Livewire event for delete
                Livewire.dispatch('delete_gallery', { id: galleryId });
            }
        });
    }
});

// Handle edit gallery action from dropdown
document.addEventListener('click', function(e) {
    if (e.target.matches('[data-kt-action="edit_gallery"]') ||
        e.target.closest('[data-kt-action="edit_gallery"]')) {
        e.preventDefault();

        const target = e.target.matches('[data-kt-action="edit_gallery"]')
            ? e.target
            : e.target.closest('[data-kt-action="edit_gallery"]');

        const galleryId = target.getAttribute('data-kt-gallery-id');

        // Dispatch Livewire event for edit
        Livewire.dispatch('edit_gallery', { id: galleryId });
    }
});

// Handle view gallery action from dropdown
document.addEventListener('click', function(e) {
    if (e.target.matches('[data-kt-action="view_gallery"]') ||
        e.target.closest('[data-kt-action="view_gallery"]')) {
        e.preventDefault();

        const target = e.target.matches('[data-kt-action="view_gallery"]')
            ? e.target
            : e.target.closest('[data-kt-action="view_gallery"]');

        const galleryId = target.getAttribute('data-kt-gallery-id');

        // Dispatch Livewire event for view
        Livewire.dispatch('view_gallery', { id: galleryId });
    }
});

// Handle manage photos action from dropdown
document.addEventListener('click', function(e) {
    if (e.target.matches('[data-kt-action="manage_photos"]') ||
        e.target.closest('[data-kt-action="manage_photos"]')) {
        e.preventDefault();

        const target = e.target.matches('[data-kt-action="manage_photos"]')
            ? e.target
            : e.target.closest('[data-kt-action="manage_photos"]');

        const galleryId = target.getAttribute('data-kt-gallery-id');

        // Dispatch Livewire event for manage photos
        Livewire.dispatch('manage_photos', { id: galleryId });

        // Or redirect to manage photos page
        // window.location.href = `/gallery/${galleryId}/photos`;
    }
});

// Listen for Livewire events
Livewire.on('success', (message) => {
    // Show success notification
    Swal.fire({
        text: message || 'Operasi berhasil!',
        icon: 'success',
        buttonsStyling: false,
        confirmButtonText: 'OK',
        customClass: {
            confirmButton: 'btn btn-primary'
        }
    });

    // Reload datatable
    reloadGalleryTable();
});

Livewire.on('error', (message) => {
    Swal.fire({
        text: message || 'Terjadi kesalahan!',
        icon: 'error',
        buttonsStyling: false,
        confirmButtonText: 'OK',
        customClass: {
            confirmButton: 'btn btn-primary'
        }
    });
});

// Function to reload datatable
function reloadGalleryTable() {
    if (typeof LaravelDataTables['gallery-table'] !== 'undefined') {
        LaravelDataTables['gallery-table'].ajax.reload(null, false);
    }
}

// Close dropdown menu after click (optional)
document.addEventListener('click', function(e) {
    if (e.target.matches('.menu-link')) {
        const menu = e.target.closest('[data-kt-menu="true"]');
        if (menu) {
            KTMenu.getInstance(menu).hide();
        }
    }
});

// Initialize tooltips
KTUtil.onDOMContentLoaded(function() {
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
