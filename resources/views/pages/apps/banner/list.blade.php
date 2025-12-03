<x-default-layout>
    @section('title')
        Banner
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('banner-management.index') }}
    @endsection

    @include('pages.apps.banner.modals._view-modal')
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
                    <input type="text" data-kt-banners-table-filter="search" class="form-control form-control-solid w-250px ps-13" placeholder="Cari banner" id="bannersSearchInput" />
                </div>
                <!--end::Search-->
            </div>
            <!--begin::Card title-->

            <!--begin::Card toolbar-->
            <div class="card-toolbar">
                <!--begin::Toolbar-->
                <div class="d-flex justify-content-end" data-kt-banners-table-toolbar="base">
                    <!--begin::Add banners-->
                    <a href="{{ route('banner-management.banner.create') }}" class="btn btn-primary">
                        {!! getIcon('plus', 'fs-2', '', 'i') !!}
                        Tambah Banner
                    </a>
                    <!--end::Add banners-->
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
        document.getElementById('bannersSearchInput').addEventListener('keyup', function() {
            window.LaravelDataTables['banners-table'].search(this.value).draw();
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

        // Delete function
        function confirmDelete(event) {
            event.preventDefault();
            event.stopPropagation();

            const button = event.target;
            const form = button.closest('form');
            const action = form.getAttribute('action');

            Swal.fire({
                title: "Hapus Banner?",
                text: "Apakah Anda yakin ingin menghapus banner ini? Tindakan ini tidak dapat dibatalkan.",
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

                    // Submit form
                    fetch(action, {
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
                                window.LaravelDataTables['banners-table'].ajax.reload();
                            } else {
                                throw new Error(data.message || 'Hapus gagal');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            showNotification('error', 'Gagal menghapus banner: ' + error.message);
                        })
                        .finally(() => {
                            // Restore button state
                            button.innerHTML = originalText;
                            button.disabled = false;
                        });
                }
            });
        }

        // Handle form submissions for create and update
        function handleFormSubmission(formId, successMessage) {
            const form = document.getElementById(formId);
            if (form) {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();

                    const submitButton = form.querySelector('button[type="submit"]');
                    const originalText = submitButton.innerHTML;

                    // Show loading
                    submitButton.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Memproses...';
                    submitButton.disabled = true;

                    const formData = new FormData(form);

                    fetch(form.action, {
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
                                showNotification('success', data.message || successMessage);
                                // Close modal if exists
                                const modal = bootstrap.Modal.getInstance(form.closest('.modal'));
                                if (modal) {
                                    modal.hide();
                                }
                                // Reload DataTable
                                window.LaravelDataTables['banners-table'].ajax.reload();
                            } else {
                                throw new Error(data.message || 'Operasi gagal');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            showNotification('error', 'Operasi gagal: ' + error.message);
                        })
                        .finally(() => {
                            // Restore button state
                            submitButton.innerHTML = originalText;
                            submitButton.disabled = false;
                        });
                });
            }
        }

        // Event listeners
        document.addEventListener('DOMContentLoaded', function() {
            // Attach event listeners to delete buttons
            function attachDeleteListeners() {
                const deleteButtons = document.querySelectorAll('.btn-delete');
                deleteButtons.forEach(button => {
                    // Remove existing listeners to prevent duplicates
                    button.removeEventListener('click', confirmDelete);
                    // Add new listener
                    button.addEventListener('click', confirmDelete);
                });
            }

            // Attach listeners initially
            attachDeleteListeners();

            // Handle form submissions for create and edit
            handleFormSubmission('createBannersForm', 'Banner berhasil dibuat!');
            handleFormSubmission('editBannersForm', 'Banner berhasil diperbarui!');

            // Re-attach after DataTable redraw
            if (window.LaravelDataTables && window.LaravelDataTables['banners-table']) {
                window.LaravelDataTables['banners-table'].on('draw', function() {
                    setTimeout(attachDeleteListeners, 100);
                });
            }
        });

        // Livewire events
        document.addEventListener('livewire:init', function() {
            Livewire.on('success', function(message) {
                showNotification('success', message);
                window.LaravelDataTables['banners-table'].ajax.reload();
            });

            Livewire.on('error', function(message) {
                showNotification('error', message);
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const viewBannersModal = document.getElementById('viewBannerModal');

            if (viewBannersModal) {
                viewBannersModal.addEventListener('show.bs.modal', function(event) {
                    const button = event.relatedTarget;

                    // Get data attributes
                    const bannerId = button.getAttribute('data-banner-id');
                    const title = button.getAttribute('data-banner-title');
                    const fileUrl = button.getAttribute('data-banner-file');
                    const link = button.getAttribute('data-banner-link');
                    const order = button.getAttribute('data-banner-order');
                    const active = button.getAttribute('data-banner-active');
                    const createdDate = button.getAttribute('data-banner-created');
                    const updatedDate = button.getAttribute('data-banner-updated');

                    // Update modal content
                    document.getElementById('modal-banner-title').textContent = title;
                    document.getElementById('modal-banner-link').textContent = `Link: ${link || '-'}`;
                    document.getElementById('modal-banner-order').textContent = `Urutan: ${order || '-'}`;
                    document.getElementById('modal-banner-status').textContent = `Status: ${active}`;
                    document.getElementById('modal-banner-created').textContent = `Dibuat: ${createdDate}`;
                    document.getElementById('modal-banner-updated').textContent = `Diupdate: ${updatedDate}`;

                    // Handle file
                    const bannerFile = document.getElementById('modal-banner-file');
                    if (fileUrl && fileUrl !== '') {
                        // Check if file is image
                        const fileExtension = fileUrl.split('.').pop().toLowerCase();
                        const isImage = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'].includes(fileExtension);

                        if (isImage) {
                            bannerFile.innerHTML = `
                                <div class="text-center">
                                    <img src="${fileUrl}" class="img-fluid rounded" style="max-height: 300px; max-width: 100%;" alt="Banner Image">
                                    <div class="mt-2">
                                        <a href="${fileUrl}" target="_blank" class="btn btn-sm btn-primary">Lihat Full Size</a>
                                    </div>
                                </div>
                            `;
                        } else {
                            bannerFile.innerHTML = `
                                <div class="d-flex align-items-center">
                                    <i class="ki-duotone ki-file fs-2x text-primary me-3"></i>
                                    <div>
                                        <div class="fw-bold">File Banner</div>
                                        <div class="text-muted">${fileUrl.split('/').pop()}</div>
                                        <a href="${fileUrl}" target="_blank" class="btn btn-sm btn-primary mt-2">Download File</a>
                                    </div>
                                </div>
                            `;
                        }
                        bannerFile.style.display = 'block';
                    } else {
                        bannerFile.innerHTML = '<div class="text-muted">Tidak ada gambar</div>';
                        bannerFile.style.display = 'block';
                    }

                    // Update edit link
                    document.getElementById('modal-edit-link').href = `/banner-management/banner/${bannerId}/edit`;
                });

                // Clear modal content when hidden
                viewBannersModal.addEventListener('hidden.bs.modal', function() {
                    document.getElementById('modal-banner-title').textContent = '';
                    document.getElementById('modal-banner-file').innerHTML = '';
                    document.getElementById('modal-banner-link').textContent = '';
                    document.getElementById('modal-banner-order').textContent = '';
                    document.getElementById('modal-banner-status').textContent = '';
                    document.getElementById('modal-banner-created').textContent = '';
                    document.getElementById('modal-banner-updated').textContent = '';
                });
            }

            // Initialize KTMenu for actions dropdown
            if (typeof KTMenu !== 'undefined') {
                KTMenu.init();
            }
        });
    </script>
    @endpush

</x-default-layout>
