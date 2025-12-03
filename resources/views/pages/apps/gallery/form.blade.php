<x-default-layout>
    @section('title')
    {{ $mode === 'edit' ? 'Edit Gallery' : 'Tambah Gallery Baru' }}
    @endsection

    @section('breadcrumbs')
    {{ Breadcrumbs::render('gallery-management.gallery.' . ($mode === 'edit' ? 'edit' : 'create'), $mode === 'edit' ? $gallery->id : null) }}
    @endsection

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ $mode === 'edit' ? 'Edit Gallery' : 'Tambah Gallery Baru' }}</h3>
        </div>
        <div class="card-body">
            <form method="POST"
                action="{{ $mode === 'edit' ? route('gallery-management.gallery.update', $gallery->id) : route('gallery-management.gallery.store') }}"
                enctype="multipart/form-data" id="gallery-form">
                @csrf
                @if($mode === 'edit')
                @method('PUT')
                @endif

                <div class="mb-10">
                    <label class="form-label required">Nama Kegiatan</label>
                    <input type="text" name="activity" class="form-control" value="{{ old('activity', $gallery->activity ?? '') }}" required>
                    @error('activity')
                    <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row mb-10">
                    <div class="col-md-6">
                        <label class="form-label required">Waktu</label>
                        <input type="datetime-local" name="time" class="form-control"
                            value="{{ old('time', $mode === 'edit' && $gallery->time ? \Carbon\Carbon::parse($gallery->time)->format('Y-m-d\TH:i') : '') }}"
                            required>
                        @error('time')
                        <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label required">Tempat</label>
                        <input type="text" name="place" class="form-control"
                            value="{{ old('place', $gallery->place ?? '') }}"
                            placeholder="Contoh: Ballroom Hotel, Gedung Serba Guna" required>
                        @error('place')
                        <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- SECTION UNTUK FOTO-FOTO -->
                <div class="mb-10">
                    <label class="form-label {{ $mode === 'create' ? 'required' : '' }}">Foto Gallery</label>

                    @if ($mode === 'edit' && $gallery->photos->count() > 0)
                    <!-- Tampilkan foto yang sudah ada (edit mode) -->
                    <div class="mb-6">
                        <h6 class="fw-bold mb-4">Foto Saat Ini:</h6>
                        <div class="row g-4">
                            @foreach ($gallery->photos as $photo)
                            <div class="col-md-4 col-lg-3">
                                <div class="card card-flush h-100">
                                    <div class="card-body p-4 text-center">
                                        <!-- Preview Image -->
                                        <div class="position-relative mb-3">
                                            <img src="{{ asset('storage/' . $photo->photo) }}"
                                                class="rounded w-100"
                                                style="height: 120px; object-fit: cover;"
                                                alt="{{ $photo->title_photo ?? 'Foto' }}">

                                            <!-- Delete Button -->
                                            <button type="button"
                                                class="btn btn-icon btn-sm btn-light-danger position-absolute top-0 end-0 m-2"
                                                onclick="deletePhoto({{ $photo->id }})"
                                                data-bs-toggle="tooltip"
                                                title="Hapus Foto">
                                                <i class="ki-duotone ki-trash fs-3">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                    <span class="path3"></span>
                                                    <span class="path4"></span>
                                                    <span class="path5"></span>
                                                </i>
                                            </button>
                                        </div>

                                        <!-- Photo Details -->
                                        @if($photo->title_photo || $photo->caption)
                                        <div class="text-start">
                                            @if($photo->title_photo)
                                            <h6 class="fw-bold text-gray-800 mb-1">{{ $photo->title_photo }}</h6>
                                            @endif
                                            @if($photo->caption)
                                            <p class="text-muted fs-7 mb-0">{{ Str::limit($photo->caption, 50) }}</p>
                                            @endif
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- INPUT UNTUK FOTO BARU -->
                    <div class="{{ $mode === 'edit' ? 'mt-6' : '' }}">
                        <h6 class="fw-bold mb-4">{{ $mode === 'create' ? 'Tambah Foto' : 'Tambah Foto Baru' }}:</h6>

                        <div id="photo-container">
                            <!-- Photo input template -->
                            <div class="photo-item mb-5 p-4 border rounded bg-light">
                                <div class="row g-4">
                                    <div class="col-md-4">
                                        <label class="form-label {{ $mode === 'create' ? 'required' : '' }}">File Foto</label>
                                        <input type="file"
                                            name="{{ $mode === 'create' ? 'photos[]' : 'new_photos[]' }}"
                                            class="form-control"
                                            accept=".jpg,.jpeg,.png"
                                            onchange="previewPhoto(this, {{ $mode === 'create' ? 'true' : 'false' }})"
                                            {{ $mode === 'create' ? 'required' : '' }}>
                                        <div class="form-text mt-1">Format: jpg, jpeg, png. Maks 2MB.</div>

                                        <!-- Image Preview -->
                                        <div class="photo-preview mt-3 d-none">
                                            <img src="" class="img-thumbnail rounded"
                                                style="max-height: 100px; width: auto;">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Judul Foto</label>
                                        <input type="text"
                                            name="{{ $mode === 'create' ? 'title_photo[]' : 'new_title_photo[]' }}"
                                            class="form-control"
                                            placeholder="Judul foto">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Caption</label>
                                        <input type="text"
                                            name="{{ $mode === 'create' ? 'caption[]' : 'new_caption[]' }}"
                                            class="form-control"
                                            placeholder="Caption foto">

                                        <!-- Remove Button -->
                                        <button type="button"
                                            class="btn btn-sm btn-light-danger mt-3 w-100"
                                            onclick="removePhotoField(this)">
                                            <i class="ki-duotone ki-trash fs-3 me-2">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                                <span class="path3"></span>
                                                <span class="path4"></span>
                                                <span class="path5"></span>
                                            </i> Hapus Foto
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Add More Button -->
                        <button type="button" class="btn btn-light-primary w-100" onclick="addPhotoField()">
                            <i class="ki-duotone ki-plus fs-2 me-2"></i> Tambah Foto Lainnya
                        </button>
                    </div>
                </div>

                <div class="d-flex gap-3">
                    <a href="{{ route('gallery-management.gallery.index') }}" class="btn btn-light">
                        Kembali
                    </a>
                    <button class="btn btn-primary" type="submit" id="submit-btn">
                        {{ $mode === 'edit' ? 'Simpan Perubahan' : 'Simpan Gallery' }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        // Preview photo when file is selected
        function previewPhoto(input, isCreateMode) {
            const file = input.files[0];
            const previewDiv = input.parentNode.querySelector('.photo-preview');
            const previewImg = previewDiv.querySelector('img');

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    previewDiv.classList.remove('d-none');
                };
                reader.readAsDataURL(file);
            } else {
                previewDiv.classList.add('d-none');
            }
        }

        // Add new photo field
        function addPhotoField() {
            const container = document.getElementById('photo-container');
            const isCreateMode = {{$mode === 'create' ? 'true' : 'false'}};
            const fieldName = isCreateMode ? 'photos' : 'new_photos';
            const titleName = isCreateMode ? 'title_photo' : 'new_title_photo';
            const captionName = isCreateMode ? 'caption' : 'new_caption';

            const newItem = document.createElement('div');
            newItem.className = 'photo-item mb-5 p-4 border rounded bg-light';
            newItem.innerHTML = `
                <div class="row g-4">
                    <div class="col-md-4">
                        <label class="form-label">File Foto</label>
                        <input type="file"
                               name="${fieldName}[]"
                               class="form-control"
                               accept=".jpg,.jpeg,.png"
                               onchange="previewPhoto(this, ${isCreateMode})">
                        <div class="form-text mt-1">Format: jpg, jpeg, png. Maks 2MB.</div>

                        <!-- Image Preview -->
                        <div class="photo-preview mt-3 d-none">
                            <img src="" class="img-thumbnail rounded"
                                 style="max-height: 100px; width: auto;">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Judul Foto</label>
                        <input type="text"
                               name="${titleName}[]"
                               class="form-control"
                               placeholder="Judul foto">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Caption</label>
                        <input type="text"
                               name="${captionName}[]"
                               class="form-control"
                               placeholder="Caption foto">

                        <!-- Remove Button -->
                        <button type="button"
                                class="btn btn-sm btn-light-danger mt-3 w-100"
                                onclick="removePhotoField(this)">
                            <i class="ki-duotone ki-trash fs-3 me-2">
                                <span class="path1"></span>
                                <span class="path2"></span>
                                <span class="path3"></span>
                                <span class="path4"></span>
                                <span class="path5"></span>
                            </i> Hapus Foto
                        </button>
                    </div>
                </div>
            `;
            container.appendChild(newItem);
        }

        // Remove photo field
        function removePhotoField(button) {
            const photoItem = button.closest('.photo-item');
            if (photoItem) {
                photoItem.remove();
            }
        }

        // Delete existing photo (edit mode)
        function deletePhoto(photoId) {
            Swal.fire({
                title: 'Hapus Foto?',
                text: 'Apakah Anda yakin ingin menghapus foto ini?',
                icon: 'warning',
                showCancelButton: true,
                buttonsStyling: false,
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal',
                customClass: {
                    confirmButton: 'btn btn-danger',
                    cancelButton: 'btn btn-light'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/gallery-management/gallery/photo/${photoId}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil!',
                                    text: data.message,
                                    confirmButtonText: 'OK'
                                }).then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal!',
                                    text: data.message
                                });
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: 'Terjadi kesalahan saat menghapus foto'
                            });
                        });
                }
            });
        }

        // Form submission
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('gallery-form');

            if (form) {
                form.addEventListener('submit', function(e) {
                    const submitBtn = document.getElementById('submit-btn');

                    if (submitBtn) {
                        // Simpan teks asli jika belum disimpan
                        if (!submitBtn.dataset.originalText) {
                            submitBtn.dataset.originalText = submitBtn.innerHTML;
                        }

                        // Set loading state
                        submitBtn.disabled = true;
                        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Menyimpan...';
                    }
                });
            }

            // Initialize tooltips
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            const tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>

    <style>
        .spinner-border-sm {
            width: 1rem;
            height: 1rem;
            margin-right: 0.5rem;
        }

        /* Optional: Animasi untuk feedback yang lebih smooth */
        .btn:disabled {
            opacity: 0.7;
            cursor: not-allowed;
        }

        .photo-item {
            transition: all 0.3s ease;
            border: 1px solid var(--kt-border-color);
        }

        .photo-item:hover {
            border-color: var(--kt-primary);
            box-shadow: 0 0 0 1px var(--kt-primary);
        }

        .btn-light-danger {
            color: var(--kt-danger);
            background-color: var(--kt-danger-light);
            border-color: var(--kt-danger-light);
        }

        .btn-light-danger:hover {
            color: var(--kt-white);
            background-color: var(--kt-danger);
            border-color: var(--kt-danger);
        }

        .btn-light-primary {
            color: var(--kt-primary);
            background-color: var(--kt-primary-light);
            border-color: var(--kt-primary-light);
        }

        .btn-light-primary:hover {
            color: var(--kt-white);
            background-color: var(--kt-primary);
            border-color: var(--kt-primary);
        }
    </style>
    @endpush
</x-default-layout>
