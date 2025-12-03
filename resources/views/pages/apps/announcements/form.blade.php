<x-default-layout>
    @section('title')
        {{ $mode === 'edit' ? 'Edit Pengumuman' : 'Buat Pengumuman Baru' }}
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('announcements-management.' . ($mode === 'edit' ? 'edit' : 'create'), $mode === 'edit' ? $announcements->id : null) }}
    @endsection

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ $mode === 'edit' ? 'Edit Pengumuman' : 'Buat Pengumuman Baru' }}</h3>
        </div>
        <div class="card-body">
            <form method="POST"
                  action="{{ $mode === 'edit' ? route('announcements-management.announcements.update', $announcements->id) : route('announcements-management.announcements.store') }}"
                  enctype="multipart/form-data" id="announcements-form">
                @csrf
                @if($mode === 'edit')
                    @method('PUT')
                @endif

                <div class="mb-10">
                    <label class="form-label required">Judul Pengumuman</label>
                    <input type="text" name="title" class="form-control" value="{{ old('title', $announcements->title ?? '') }}" required>
                    @error('title') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>

                <div class="row mb-10">
                    <div class="col-md-6">
                        <label class="form-label {{ $mode === 'create' ? 'required' : '' }}">File</label>
                        <input type="file" name="file_path" class="form-control" accept=".jpg,.jpeg,.png,.pdf,.zip" onchange="previewFile(event)" {{ $mode === 'create' ? 'required' : '' }}>
                        <div class="form-text">Format: pdf, zip, jpg, jpeg, png. Maksimal 2MB.</div>

                        <div class="mt-3">
                            <!-- Preview untuk file baru -->
                            <div id="file-preview" class="d-none">
                                <strong>File terupload: </strong><span id="file-name"></span>
                            </div>
                            <div id="img-preview" class="d-none">
                                <img src="" id="img-thumbnail" style="max-height:140px" alt="Preview">
                            </div>

                            <!-- Tampilkan file existing jika edit mode -->
                            @if($mode === 'edit' && $announcements->file_path)
                                <div class="mt-2">
                                    <strong>File saat ini: </strong>
                                    @php
                                        $extension = pathinfo($announcements->file_path, PATHINFO_EXTENSION);
                                        $isImage = in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif']);
                                    @endphp
                                    @if($isImage)
                                        <img src="{{ asset('storage/'.$announcements->file_path) }}"
                                             style="max-height:140px"
                                             class="img-thumbnail"
                                             alt="Current Image">
                                    @else
                                        <div class="d-flex align-items-center mt-2">
                                            <i class="ki-duotone ki-file fs-2 text-primary me-2"></i>
                                            <span>{{ basename($announcements->file_path) }}</span>
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>
                        @error('file_path') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Tanggal Publikasi</label>
                        <input type="date" name="published_at" class="form-control" value="{{ old('published_at', $announcements->published_at ? \Carbon\Carbon::parse($announcements->published_at)->format('Y-m-d') : now()->format('Y-m-d')) }}">
                        @error('published_at') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="d-flex gap-3">
                    <a href="{{ route('announcements-management.announcements.index') }}" class="btn btn-light">Batal</a>
                    <button class="btn btn-primary" type="submit" id="submit-btn">
                        {{ $mode === 'edit' ? 'Perbarui Pengumuman' : 'Simpan Pengumuman' }}
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
                // Jika file adalah gambar
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        imgThumbnail.src = e.target.result;
                        imgPreview.classList.remove('d-none');
                    };
                    reader.readAsDataURL(file);
                } else {
                    // Jika file bukan gambar
                    fileName.textContent = file.name;
                    filePreview.classList.remove('d-none');
                }
            }
        }

        // Initialize existing file preview
        document.addEventListener('DOMContentLoaded', function() {
            // Jika ada file existing di edit mode, sembunyikan preview baru
            const existingFile = {{ $mode === 'edit' && $announcements->file_path ? 'true' : 'false' }};
            if (existingFile) {
                document.getElementById('file-preview').classList.add('d-none');
                document.getElementById('img-preview').classList.add('d-none');
            }

            // Tambahkan spinner loading pada form submit
            const form = document.getElementById('announcements-form');
            form.addEventListener('submit', function(e) {
                const submitBtn = document.getElementById('submit-btn');
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Menyimpan...';
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
    </style>
    @endpush
</x-default-layout>
