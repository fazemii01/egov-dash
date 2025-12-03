<x-default-layout>
    @section('title')
    Gallery
    @endsection

    @section('breadcrumbs')
    {{ Breadcrumbs::render('gallery-management.index') }}
    @endsection

    @include('pages.apps.gallery.modals._view-modal')
    <!-- Toast Container -->
    <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 9999">
        <!-- Toast akan ditambahkan secara dinamis -->
    </div>

    <div class="card">
        <!--begin::Card header-->
        <div class="card-header border-0 pt-6">
            <!--begin::Card title-->
            <div class="card-title">
                <!--begin::Search-->
                <div class="d-flex align-items-center position-relative my-1">
                    {!! getIcon('magnifier', 'fs-3 position-absolute ms-5') !!}
                    <input type="text"
                        data-kt-gallery-table-filter="search"
                        class="form-control form-control-solid w-250px ps-13"
                        placeholder="Cari galeri"
                        id="gallerySearchInput" />
                </div>
                <!--end::Search-->
            </div>
            <!--begin::Card title-->

            <!--begin::Card toolbar-->
            <div class="card-toolbar">
                <!--begin::Toolbar-->
                <div class="d-flex justify-content-end" data-kt-gallery-table-toolbar="base">
                    <!--begin::Add gallery-->
                    <a href="{{ route('gallery-management.gallery.create') }}" class="btn btn-primary">
                        {!! getIcon('plus', 'fs-2', '', 'i') !!}
                        Tambah Gallery
                    </a>
                    <!--end::Add gallery-->
                </div>
                <!--end::Toolbar-->
            </div>
            <!--end::Card toolbar-->
        </div>
        <!--end::Card header-->

        <!--begin::Card body-->
        <div class="card-body py-4">
            <!--begin::Table-->
            <div class="table-responsive">
                {{ $dataTable->table() }}
            </div>
            <!--end::Table-->
        </div>
        <!--end::Card body-->
    </div>

    @push('scripts')
    {{ $dataTable->scripts() }}
    <script>
        // Search functionality
        document.getElementById('gallerySearchInput').addEventListener('keyup', function() {
            window.LaravelDataTables['gallery-table'].search(this.value).draw();
        });

        // Show SweetAlert notification
        function showNotification(type, message) {
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: type,
                title: message,
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer);
                    toast.addEventListener('mouseleave', Swal.resumeTimer);
                }
            });
        }

        // Show success/error messages from session
        @if(session('success'))
        document.addEventListener('DOMContentLoaded', function() {
            showNotification('success', '{{ session('success') }}');
        });
        @endif

        @if(session('error'))
        document.addEventListener('DOMContentLoaded', function() {
            showNotification('error', '{{ session('error') }}');
        });
        @endif

        // Delete function for gallery
        function confirmDelete(event) {
            event.preventDefault();
            event.stopPropagation();

            const button = event.target.closest('.btn-delete-gallery') || event.target;
            if (!button) return;

            const galleryId = button.getAttribute('data-id');
            const galleryName = button.getAttribute('data-name') || 'galeri ini';

            if (!galleryId || galleryId === 'null') {
                console.error('Gallery ID is null or undefined');
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Gallery ID tidak valid!'
                });
                return;
            }

            Swal.fire({
                title: "Hapus Gallery?",
                text: `Apakah Anda yakin ingin menghapus "${galleryName}"? Tindakan ini tidak dapat dibatalkan.`,
                icon: "warning",
                showCancelButton: true,
                buttonsStyling: false,
                confirmButtonText: "Ya, hapus!",
                cancelButtonText: "Tidak, batal",
                customClass: {
                    confirmButton: "btn btn-danger",
                    cancelButton: "btn btn-active-light"
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show loading state on the button
                    const originalText = button.innerHTML;
                    button.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Menghapus...';
                    button.disabled = true;

                    // Create form data
                    const formData = new FormData();
                    formData.append('_method', 'DELETE');
                    formData.append('_token', '{{ csrf_token() }}');

                    // Submit delete request
                    fetch(`/gallery-management/gallery/${galleryId}`, {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json'
                            }
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (data.success) {
                                showNotification('success', data.message);
                                window.LaravelDataTables['gallery-table'].ajax.reload();
                            } else {
                                throw new Error(data.message || 'Hapus gagal');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            showNotification('error', 'Gagal menghapus gallery: ' + error.message);
                        })
                        .finally(() => {
                            // Restore button state
                            button.innerHTML = originalText;
                            button.disabled = false;
                        });
                }
            });
        }

        // Attach delete listeners
        function attachDeleteListeners() {
            const deleteButtons = document.querySelectorAll('.btn-delete-gallery');

            deleteButtons.forEach(button => {
                // Remove existing listeners to prevent duplicates
                button.removeEventListener('click', confirmDelete);

                // Add new listener
                button.addEventListener('click', confirmDelete);
            });
        }

        // Event listeners
        document.addEventListener('DOMContentLoaded', function() {

            // Attach listeners initially
            attachDeleteListeners();

            // Re-attach after DataTable redraw
            if (window.LaravelDataTables && window.LaravelDataTables['gallery-table']) {
                window.LaravelDataTables['gallery-table'].on('draw', function() {
                    setTimeout(attachDeleteListeners, 100);
                    attachViewModalListener();
                });
            }

            // Initialize KTMenu for actions dropdown
            if (typeof KTMenu !== 'undefined') {
                KTMenu.init();
            }

            // Attach view modal listener
            attachViewModalListener();
        });

        // View Modal Handler
        function attachViewModalListener() {
            const viewModal = document.getElementById('viewGalleryModal');
            if (!viewModal) return;

            viewModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                if (!button) return;

                // Get data attributes dengan null checking
                const galleryId = button.getAttribute('data-gallery-id');
                const galleryActivity = button.getAttribute('data-gallery-activity');
                const galleryTime = button.getAttribute('data-gallery-time');
                const galleryPlace = button.getAttribute('data-gallery-place');
                const galleryPhotosCount = button.getAttribute('data-gallery-photos-count') || '0';
                const galleryCreated = button.getAttribute('data-gallery-created');
                const galleryUpdated = button.getAttribute('data-gallery-updated');
                const galleryPhotosJson = button.getAttribute('data-gallery-photos');

                // Update modal content dengan null checking
                const updateElement = (id, value) => {
                    const element = document.getElementById(id);
                    if (element && value !== null) {
                        element.textContent = value;
                    }
                };

                updateElement('modal-gallery-activity', galleryActivity);
                updateElement('modal-gallery-time', galleryTime);
                updateElement('modal-gallery-place', galleryPlace);
                updateElement('modal-gallery-photos-count', galleryPhotosCount + ' foto');
                updateElement('modal-gallery-created', galleryCreated);
                updateElement('modal-gallery-updated', galleryUpdated);

                // Update status
                const statusBadge = document.getElementById('modal-gallery-status');
                if (statusBadge) {
                    if (parseInt(galleryPhotosCount) > 0) {
                        statusBadge.textContent = 'Aktif';
                        statusBadge.className = 'badge badge-light-success';
                    } else {
                        statusBadge.textContent = 'Kosong';
                        statusBadge.className = 'badge badge-light-warning';
                    }
                }

                // Update links dengan null checking
                const updateLink = (id, href) => {
                    const link = document.getElementById(id);
                    if (link && href) {
                        link.href = href;
                    }
                };

                updateLink('modal-gallery-edit-link', `/gallery-management/gallery/${galleryId}/edit`);

                // Handle photos display
                const photosContainer = document.getElementById('modal-gallery-photos');
                if (!photosContainer) return;

                photosContainer.innerHTML = '';

                // Store photos data globally for lightbox
                try {
                    window.currentGalleryPhotos = galleryPhotosJson ? JSON.parse(galleryPhotosJson) : [];
                } catch (e) {
                    console.error('Error parsing photos JSON:', e);
                    window.currentGalleryPhotos = [];
                }

                if (window.currentGalleryPhotos.length > 0) {
                    createModernPhotoGrid(photosContainer, window.currentGalleryPhotos);
                } else {
                    showNoPhotosMessage(photosContainer);
                }
            });

            // Clear modal content when hidden
            viewModal.addEventListener('hidden.bs.modal', function() {
                // Reset all content
                const fields = [
                    'modal-gallery-activity',
                    'modal-gallery-time',
                    'modal-gallery-place',
                    'modal-gallery-photos-count',
                    'modal-gallery-created',
                    'modal-gallery-updated'
                ];

                fields.forEach(field => {
                    const element = document.getElementById(field);
                    if (element) {
                        element.textContent = '';
                    }
                });

                const photosContainer = document.getElementById('modal-gallery-photos');
                if (photosContainer) {
                    photosContainer.innerHTML = '';
                }

                window.currentGalleryPhotos = [];
            });
        }

        // Modern photo grid creator with click to zoom
        function createModernPhotoGrid(container, photos) {
            if (!container) return;

            const maxPhotos = 4; // Show max 4 photos in preview

            // Create main container
            const gridContainer = document.createElement('div');
            gridContainer.className = 'position-relative';
            gridContainer.style.maxWidth = '500px';
            gridContainer.style.margin = '0 auto';

            // Create grid
            const grid = document.createElement('div');
            grid.className = 'row g-4';

            // Calculate grid layout
            const displayPhotos = photos.slice(0, maxPhotos);

            displayPhotos.forEach((photo, index) => {
                const col = document.createElement('div');
                col.className = displayPhotos.length === 1 ? 'col-12' :
                    displayPhotos.length === 2 ? 'col-6' :
                    displayPhotos.length === 3 ? 'col-4' : 'col-6';

                const photoItem = document.createElement('div');
                photoItem.className = 'position-relative overflow-hidden rounded-lg photo-item';
                photoItem.style.height = '140px';
                photoItem.style.cursor = 'pointer';
                photoItem.setAttribute('data-index', index);

                const img = document.createElement('img');
                img.src = photo.photo_path;
                img.alt = photo.title_photo || `Photo ${index + 1}`;
                img.className = 'w-100 h-100 object-fit-cover';
                img.style.transition = 'transform 0.3s ease';

                // Click to open lightbox
                photoItem.addEventListener('click', () => {
                    openLightbox(index);
                });

                // Hover effect
                photoItem.addEventListener('mouseenter', () => {
                    img.style.transform = 'scale(1.1)';
                    photoItem.style.boxShadow = '0 10px 25px rgba(0,0,0,0.2)';
                });

                photoItem.addEventListener('mouseleave', () => {
                    img.style.transform = 'scale(1)';
                    photoItem.style.boxShadow = '';
                });

                photoItem.appendChild(img);

                // Add zoom icon overlay
                const zoomOverlay = document.createElement('div');
                zoomOverlay.className = 'position-absolute top-0 end-0 m-3';
                zoomOverlay.innerHTML = `
            <div class="bg-white rounded-circle p-2 shadow-sm">
                <i class="ki-duotone ki-maximize text-primary fs-4"></i>
            </div>
        `;
                photoItem.appendChild(zoomOverlay);

                // Add overlay for more than 4 photos
                if (index === maxPhotos - 1 && photos.length > maxPhotos) {
                    const overlay = document.createElement('div');
                    overlay.className = 'position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center';
                    overlay.style.backgroundColor = 'rgba(0, 0, 0, 0.7)';
                    overlay.style.backdropFilter = 'blur(2px)';
                    overlay.style.cursor = 'pointer';

                    overlay.addEventListener('click', () => {
                        openLightbox(maxPhotos - 1);
                    });

                    const moreText = document.createElement('span');
                    moreText.className = 'text-white fw-bold fs-3';
                    moreText.textContent = `+${photos.length - maxPhotos + 1}`;

                    overlay.appendChild(moreText);
                    photoItem.appendChild(overlay);
                }

                col.appendChild(photoItem);
                grid.appendChild(col);
            });

            gridContainer.appendChild(grid);
            container.appendChild(gridContainer);
        }

        // Open lightbox with carousel
        function openLightbox(startIndex) {
            if (!window.currentGalleryPhotos || window.currentGalleryPhotos.length === 0) return;

            const lightboxModalEl = document.getElementById('lightboxModal');
            if (!lightboxModalEl) return;

            const lightboxModal = new bootstrap.Modal(lightboxModalEl);
            const carouselInner = document.getElementById('lightbox-carousel-inner');
            const currentIndexSpan = document.getElementById('lightbox-current-index');
            const totalCountSpan = document.getElementById('lightbox-total-count');

            if (!carouselInner || !currentIndexSpan || !totalCountSpan) return;

            // Clear existing carousel items
            carouselInner.innerHTML = '';

            // Populate carousel
            window.currentGalleryPhotos.forEach((photo, index) => {
                const carouselItem = document.createElement('div');
                carouselItem.className = `carousel-item ${index === startIndex ? 'active' : ''}`;

                carouselItem.innerHTML = `
            <div class="d-flex justify-content-center align-items-center" style="min-height: 80vh;">
                <div class="text-center">
                    <img src="${photo.photo_path}"
                         alt="${photo.title_photo || `Photo ${index + 1}`}"
                         class="img-fluid rounded-lg shadow-lg"
                         style="max-height: 70vh; max-width: 100%; object-fit: contain;">
                    ${photo.title_photo ? `
                        <div class="mt-4 text-white">
                            <h4 class="text-white mb-1">${photo.title_photo}</h4>
                            ${photo.caption ? `<p class="text-gray-300 mb-0">${photo.caption}</p>` : ''}
                        </div>
                    ` : ''}
                </div>
            </div>
        `;

                carouselInner.appendChild(carouselItem);
            });

            // Update counters
            totalCountSpan.textContent = window.currentGalleryPhotos.length;
            currentIndexSpan.textContent = startIndex + 1;

            // Update counter when carousel slides
            const carousel = document.getElementById('lightbox-carousel');
            if (carousel) {
                carousel.addEventListener('slid.bs.carousel', function(event) {
                    const activeIndex = Array.from(carouselInner.children).indexOf(event.relatedTarget);
                    if (currentIndexSpan) {
                        currentIndexSpan.textContent = activeIndex + 1;
                    }
                });

                // Initialize carousel
                const bsCarousel = new bootstrap.Carousel(carousel);
                bsCarousel.to(startIndex);
            }

            // Show lightbox
            lightboxModal.show();

            // Close lightbox with ESC key
            function lightboxKeyHandler(e) {
                if (e.key === 'Escape') {
                    lightboxModal.hide();
                    document.removeEventListener('keydown', lightboxKeyHandler);
                }
            }

            document.addEventListener('keydown', lightboxKeyHandler);

            // Remove event listener when modal is hidden
            lightboxModalEl.addEventListener('hidden.bs.modal', function() {
                document.removeEventListener('keydown', lightboxKeyHandler);
            });
        }

        // Show no photos message
        function showNoPhotosMessage(container) {
            if (!container) return;

            container.innerHTML = `
        <div class="text-center py-8">
            <div class="symbol symbol-100px symbol-circle mx-auto mb-6">
                <div class="symbol-label bg-light-warning">
                    <i class="ki-duotone ki-photo text-warning fs-2x"></i>
                </div>
            </div>
            <h4 class="text-gray-600 mb-2">Belum ada foto</h4>
            <p class="text-muted">Gallery ini belum memiliki foto</p>
        </div>
    `;
        }

        // Initialize when page loads
        document.addEventListener('DOMContentLoaded', function() {
            // Attach view modal listener
            attachViewModalListener();

            // Attach delete listeners
            function attachDeleteListeners() {
                const deleteButtons = document.querySelectorAll('.btn-delete-gallery');
                deleteButtons.forEach(button => {
                    button.removeEventListener('click', confirmDelete);
                    button.addEventListener('click', confirmDelete);
                });
            }

            // Attach listeners initially
            attachDeleteListeners();

            // Re-attach after DataTable redraw
            if (window.LaravelDataTables && window.LaravelDataTables['gallery-table']) {
                window.LaravelDataTables['gallery-table'].on('draw', function() {
                    setTimeout(() => {
                        attachDeleteListeners();
                        attachViewModalListener(); // Re-attach view modal listener
                    }, 100);
                });
            }

            // Initialize KTMenu for actions dropdown
            if (typeof KTMenu !== 'undefined') {
                KTMenu.init();
            }
        });

        // Quick delete function for dropdown
        function quickDelete(galleryId, galleryName) {
            if (!galleryId || galleryId === 'null') {
                console.error('Gallery ID is null or undefined');
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Gallery ID tidak valid!'
                });
                return;
            }

            Swal.fire({
                title: "Hapus Gallery?",
                text: `Apakah Anda yakin ingin menghapus "${galleryName}"?`,
                icon: "warning",
                showCancelButton: true,
                buttonsStyling: false,
                confirmButtonText: "Ya, hapus!",
                cancelButtonText: "Tidak, batal",
                customClass: {
                    confirmButton: "btn btn-danger",
                    cancelButton: "btn btn-light"
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const formData = new FormData();
                    formData.append('_method', 'DELETE');
                    formData.append('_token', '{{ csrf_token() }}');

                    fetch(`/gallery-management/gallery/${galleryId}`, {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                showNotification('success', data.message);
                                window.LaravelDataTables['gallery-table'].ajax.reload();
                            } else {
                                showNotification('error', data.message || 'Hapus gagal');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            showNotification('error', 'Gagal menghapus gallery');
                        });
                }
            });
        }

        // Handle dropdown menu actions
        document.addEventListener('click', function(e) {
            // Handle delete from dropdown
            if (e.target.closest('.btn-delete-gallery')) {
                const target = e.target.closest('.btn-delete-gallery');
                const galleryId = target.getAttribute('data-id');
                const galleryName = target.getAttribute('data-name') || 'galeri ini';

                e.preventDefault();
                quickDelete(galleryId, galleryName);
            }
        });
    </script>

    <style>
        /* Custom styles for gallery modal */
        .object-fit-cover {
            object-fit: cover;
        }

        .modal-content.rounded {
            border-radius: 12px !important;
        }

        .modal-header.pb-0 {
            padding-bottom: 0 !important;
        }

        .modal-body {
            scrollbar-width: thin;
            scrollbar-color: var(--kt-border-color) transparent;
        }

        .modal-body::-webkit-scrollbar {
            width: 6px;
        }

        .modal-body::-webkit-scrollbar-track {
            background: transparent;
        }

        .modal-body::-webkit-scrollbar-thumb {
            background-color: var(--kt-border-color);
            border-radius: 3px;
        }

        .symbol.symbol-40px.symbol-circle .symbol-label {
            transition: all 0.3s ease;
        }

        .symbol.symbol-40px.symbol-circle:hover .symbol-label {
            transform: scale(1.1);
        }

        /* Photo grid hover effects */
        .position-relative.overflow-hidden.rounded-lg {
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .position-relative.overflow-hidden.rounded-lg:hover {
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.15);
        }

        /* Modern button styles */
        .btn {
            border-radius: 8px !important;
            padding: 10px 20px !important;
            font-weight: 600 !important;
            transition: all 0.3s ease !important;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        /* Badge styling */
        .badge {
            border-radius: 20px !important;
            padding: 6px 12px !important;
            font-weight: 600 !important;
        }
    </style>
    <style>
        /* Lightbox styles */
        .modal-fullscreen .modal-content {
            background-color: rgba(0, 0, 0, 0.95) !important;
        }

        .carousel-control-prev,
        .carousel-control-next {
            width: 60px;
            height: 60px;
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            top: 50%;
            transform: translateY(-50%);
            margin: 0 20px;
            transition: all 0.3s ease;
        }

        .carousel-control-prev:hover,
        .carousel-control-next:hover {
            background-color: rgba(255, 255, 255, 0.2);
            transform: translateY(-50%) scale(1.1);
        }

        /* Photo item styles */
        .photo-item {
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border: 2px solid transparent;
        }

        .photo-item:hover {
            border-color: var(--kt-primary);
            transform: translateY(-5px);
        }

        .photo-item .bg-white.rounded-circle {
            transition: all 0.3s ease;
            opacity: 0;
        }

        .photo-item:hover .bg-white.rounded-circle {
            opacity: 1;
            transform: scale(1.1);
        }

        /* Modal styling */
        .modal-content.rounded {
            border-radius: 12px !important;
            overflow: hidden;
        }

        .card.card-flush {
            border: 1px solid var(--kt-border-color);
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .card.card-flush:hover {
            border-color: var(--kt-primary-light);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }

        .card-body {
            padding: 1.5rem !important;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .modal-body {
                padding-left: 1rem !important;
                padding-right: 1rem !important;
            }

            .photo-item {
                height: 100px !important;
            }

            .carousel-control-prev,
            .carousel-control-next {
                width: 40px;
                height: 40px;
                margin: 0 10px;
            }
        }

        /* Smooth transitions */
        .modal.fade .modal-dialog {
            transition: transform 0.3s ease-out;
        }

        .carousel-item {
            transition: transform 0.6s ease-in-out;
        }

        /* Custom scrollbar for modal */
        .scroll-y {
            scrollbar-width: thin;
            scrollbar-color: var(--kt-border-color) transparent;
        }

        .scroll-y::-webkit-scrollbar {
            width: 6px;
        }

        .scroll-y::-webkit-scrollbar-track {
            background: transparent;
        }

        .scroll-y::-webkit-scrollbar-thumb {
            background-color: var(--kt-border-color);
            border-radius: 3px;
        }
    </style>
    @endpush

</x-default-layout>
