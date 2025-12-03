<x-default-layout>
    @section('title')
    Berita
    @endsection

    @section('breadcrumbs')
    {{ Breadcrumbs::render('news-management.index') }}
    @endsection

    @include('pages.apps.news.modals._view-modal')
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
                    <input type="text" data-kt-news-table-filter="search" class="form-control form-control-solid w-250px ps-13" placeholder="Cari berita" id="newsSearchInput" />
                </div>
                <!--end::Search-->
            </div>
            <!--begin::Card title-->

            <!--begin::Card toolbar-->
            <div class="card-toolbar">
                <!--begin::Toolbar-->
                <div class="d-flex justify-content-end" data-kt-news-table-toolbar="base">
                    <!--begin::Add news-->
                    <a href="{{ route('news-management.news.create') }}" class="btn btn-primary">
                        {!! getIcon('plus', 'fs-2', '', 'i') !!}
                        Buat Berita
                    </a>
                    <!--end::Add news-->
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
        document.getElementById('newsSearchInput').addEventListener('keyup', function() {
            window.LaravelDataTables['news-table'].search(this.value).draw();
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
                title: "Delete News?",
                text: "Are you sure you want to delete this news? This action cannot be undone.",
                icon: "warning",
                showCancelButton: true,
                buttonsStyling: false,
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "No, cancel",
                customClass: {
                    confirmButton: "btn btn-danger",
                    cancelButton: "btn btn-active-light"
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show loading state on the button
                    const originalText = button.innerHTML;
                    button.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Deleting...';
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
                                window.LaravelDataTables['news-table'].ajax.reload();
                            } else {
                                throw new Error(data.message || 'Delete failed');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            showNotification('error', 'Failed to delete news: ' + error.message);
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
                    submitButton.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Processing...';
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
                                window.LaravelDataTables['news-table'].ajax.reload();
                            } else {
                                throw new Error(data.message || 'Operation failed');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            showNotification('error', 'Operation failed: ' + error.message);
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
            handleFormSubmission('createNewsForm', 'News created successfully!');
            handleFormSubmission('editNewsForm', 'News updated successfully!');

            // Re-attach after DataTable redraw
            if (window.LaravelDataTables && window.LaravelDataTables['news-table']) {
                window.LaravelDataTables['news-table'].on('draw', function() {
                    setTimeout(attachDeleteListeners, 100);
                });
            }
        });

        // Livewire events
        document.addEventListener('livewire:init', function() {
            Livewire.on('success', function(message) {
                showNotification('success', message);
                window.LaravelDataTables['news-table'].ajax.reload();
            });

            Livewire.on('error', function(message) {
                showNotification('error', message);
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const viewNewsModal = document.getElementById('viewNewsModal');

            if (viewNewsModal) {
                viewNewsModal.addEventListener('show.bs.modal', function(event) {
                    const button = event.relatedTarget;

                    // Get data attributes
                    const newsId = button.getAttribute('data-news-id');
                    const headline = button.getAttribute('data-news-headline');
                    const content = button.getAttribute('data-news-content');
                    const imageUrl = button.getAttribute('data-news-image');
                    const publishedDate = button.getAttribute('data-news-published');
                    const createdDate = button.getAttribute('data-news-created');

                    // Update modal content
                    document.getElementById('modal-news-headline').textContent = headline;
                    document.getElementById('modal-news-content').innerHTML = content;
                    document.getElementById('modal-news-published').textContent = `Published: ${publishedDate}`;
                    document.getElementById('modal-news-created').textContent = `Created: ${createdDate}`;

                    // Handle image
                    const newsImage = document.getElementById('modal-news-image');
                    if (imageUrl && imageUrl !== '') {
                        newsImage.src = imageUrl;
                        newsImage.style.display = 'block';
                    } else {
                        newsImage.style.display = 'none';
                    }

                    // Update edit link
                    document.getElementById('modal-edit-link').href = `/news-management/news/${newsId}/edit`;
                });

                // Clear modal content when hidden
                viewNewsModal.addEventListener('hidden.bs.modal', function() {
                    document.getElementById('modal-news-headline').textContent = '';
                    document.getElementById('modal-news-content').innerHTML = '';
                    document.getElementById('modal-news-published').textContent = '';
                    document.getElementById('modal-news-created').textContent = '';
                    document.getElementById('modal-news-image').style.display = 'none';
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
