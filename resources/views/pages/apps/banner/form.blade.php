<x-default-layout>
    @section('title')
        {{ $mode === 'edit' ? 'Edit Banner' : 'Tambah Banner Baru' }}
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('banner-management.banner.' . ($mode === 'edit' ? 'edit' : 'create'), $mode === 'edit' ? $banner->id : null) }}
    @endsection

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ $mode === 'edit' ? 'Edit Banner' : 'Tambah Banner Baru' }}</h3>
        </div>
        <div class="card-body">
            <form method="POST"
                  action="{{ $mode === 'edit' ? route('banner-management.banner.update', $banner->id) : route('banner-management.banner.store') }}"
                  enctype="multipart/form-data" id="banners-form">
                @csrf
                @if($mode === 'edit')
                    @method('PUT')
                @endif

                <div class="mb-10">
                    <label class="form-label required">Judul Banner</label>
                    <input type="text" name="title" class="form-control" value="{{ old('title', $banner->title ?? '') }}" required>
                    @error('title') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>

                <div class="row mb-10">
                    <div class="col-md-6">
                        <label class="form-label {{ $mode === 'create' ? 'required' : '' }}">Gambar Banner</label>
                        <input type="file" name="file" class="form-control" accept=".jpg,.jpeg,.png,.gif,.webp" onchange="previewFile(event)" {{ $mode === 'create' ? 'required' : '' }}>
                        <div class="form-text">Format: jpg, jpeg, png, gif, webp. Maksimal 2MB.</div>

                        <div class="mt-3">
                            <!-- Preview untuk file baru -->
                            <div id="file-preview" class="d-none">
                                <strong>File terupload: </strong><span id="file-name"></span>
                            </div>
                            <div id="img-preview" class="d-none">
                                <img src="" id="img-thumbnail" style="max-height:140px" alt="Preview">
                            </div>

                            <!-- Tampilkan file existing jika edit mode -->
                            @if($mode === 'edit' && $banner->file)
                                <div class="mt-2">
                                    <strong>Gambar saat ini: </strong>
                                    <img src="{{ asset('storage/'.$banner->file) }}"
                                         style="max-height:140px"
                                         class="img-thumbnail"
                                         alt="Current Banner">
                                    <div class="mt-1">
                                        <small class="text-muted">{{ basename($banner->file) }}</small>
                                    </div>
                                </div>
                            @endif
                        </div>
                        @error('file') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Link Tujuan</label>
                        <input type="url" name="link" class="form-control" placeholder="https://example.com" value="{{ old('link', $banner->link ?? '') }}">
                        @error('link') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="row mb-10">
                    <div class="col-md-6">
                        <label class="form-label">Urutan Tampil</label>
                        <input type="number" name="order" class="form-control" min="0" value="{{ old('order', $banner->order ?? 0) }}">
                        <div class="form-text">Angka lebih kecil akan ditampilkan lebih dulu</div>
                        @error('order') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label required">Status</label>
                        <div class="d-flex align-items-center">
                            <div class="btn-group w-100" role="group">
                                <input type="radio" class="btn-check" name="active" value="y"
                                       id="activeOn" {{ old('active', $banner->active ?? 'y') == 'y' ? 'checked' : '' }}>
                                <label class="btn btn-outline-success w-50" for="activeOn">
                                    <i class="ki-duotone ki-check-circle fs-2 me-2"></i>
                                    Aktif
                                </label>

                                <input type="radio" class="btn-check" name="active" value="t"
                                       id="activeOff" {{ old('active', $banner->active ?? '') == 't' ? 'checked' : '' }}>
                                <label class="btn btn-outline-danger w-50" for="activeOff">
                                    <i class="ki-duotone ki-cross-circle fs-2 me-2"></i>
                                    Nonaktif
                                </label>
                            </div>
                        </div>
                        @error('active') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="d-flex gap-3">
                    <a href="{{ route('banner-management.banner.index') }}" class="btn btn-light">Batal</a>
                    <button class="btn btn-primary" type="submit" id="submit-btn">
                        {{ $mode === 'edit' ? 'Perbarui Banner' : 'Simpan Banner' }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        function previewFile(event) {
            const file = event.target.files[0];
            const filePreview = document.getElementById('file-preview');
            const imgPreview = document.getElementById('img-preview');
            const fileName = document.getElementById('file-name');
            const imgThumbnail = document.getElementById('img-thumbnail');

            // Reset previews
            filePreview.classList.add('d-none');
            imgPreview.classList.add('d-none');

            if (file) {
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        imgThumbnail.src = e.target.result;
                        imgPreview.classList.remove('d-none');
                    };
                    reader.readAsDataURL(file);
                } else {
                    fileName.textContent = file.name;
                    filePreview.classList.remove('d-none');
                }
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const existingFile = {{ $mode === 'edit' && $banner->file ? 'true' : 'false' }};
            if (existingFile) {
                document.getElementById('file-preview').classList.add('d-none');
                document.getElementById('img-preview').classList.add('d-none');
            }

            const form = document.getElementById('banners-form');
            form.addEventListener('submit', function(e) {
                const submitBtn = document.getElementById('submit-btn');
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Menyimpan...';
            });

            // Animasi untuk toggle buttons
            const toggleButtons = document.querySelectorAll('.btn-check');
            toggleButtons.forEach(button => {
                button.addEventListener('change', function() {
                    // Optional: Add animation effects
                    const label = document.querySelector(`label[for="${this.id}"]`);
                    label.classList.add('pulse-animation');
                    setTimeout(() => {
                        label.classList.remove('pulse-animation');
                    }, 300);
                });
            });
        });
    </script>

    <style>
        .pulse-animation {
            animation: pulse 0.3s ease-in-out;
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(0.95); }
            100% { transform: scale(1); }
        }

        .btn-check:checked + .btn-outline-success {
            background-color: var(--bs-success);
            color: white;
            border-color: var(--bs-success);
        }

        .btn-check:checked + .btn-outline-danger {
            background-color: var(--bs-danger);
            color: white;
            border-color: var(--bs-danger);
        }
    </style>
    @endpush
</x-default-layout>
