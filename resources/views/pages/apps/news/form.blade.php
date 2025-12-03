<x-default-layout>
    @section('title')
        {{ $mode === 'edit' ? 'Edit Berita' : 'Buat Berita Baru' }}
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('news-management.' . ($mode === 'edit' ? 'edit' : 'create'), $mode === 'edit' ? $news->id : null) }}
    @endsection

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ $mode === 'edit' ? 'Edit Berita' : 'Buat Berita Baru' }}</h3>
        </div>
        <div class="card-body">
            <form method="POST"
                  action="{{ $mode === 'edit' ? route('news-management.news.update', $news->id) : route('news-management.news.store') }}"
                  enctype="multipart/form-data" id="news-form">
                @csrf
                @if($mode === 'edit')
                    @method('PUT')
                @endif

                <div class="mb-10">
                    <label class="form-label required">Judul Berita</label>
                    <input type="text" name="headline" class="form-control" value="{{ old('headline', $news->headline) }}" required>
                    @error('headline') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>

                <div class="row mb-10">
                    <div class="col-md-6">
                        <label class="form-label">Gambar Utama</label>
                        <input type="file" name="images" class="form-control" accept=".jpg,.jpeg,.png" onchange="previewImage(event)">
                        <div class="form-text">Format: jpg, jpeg, png. Maksimal 2MB.</div>
                        <div class="mt-3">
                            <img id="img-preview" src="{{ $news->images ? asset('storage/'.$news->images) : '' }}"
                                style="max-height:140px; display: {{ $news->images ? 'block' : 'none' }};"
                                class="img-thumbnail">
                        </div>
                        @error('images') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Tanggal Publikasi</label>
                        <input type="date" name="published_at" class="form-control" value="{{ old('published_at', $news->published_at ? $news->published_at->format('Y-m-d') : now()->format('Y-m-d')) }}">
                        @error('published_at') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="mb-10">
                    <label class="form-label required">Konten Berita</label>
                    <textarea name="content" id="content" class="form-control" style="display: none;">{{ old('content', $news->content) }}</textarea>
                    <div id="content-editor"></div>
                    @error('content') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>

                <div class="d-flex gap-3">
                    <a href="{{ route('news-management.news.index') }}" class="btn btn-light">Batal</a>
                    <button class="btn btn-primary" type="submit" id="submit-btn">
                        {{ $mode === 'edit' ? 'Perbarui Berita' : 'Simpan Berita' }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('styles')
    <link href="https://cdn.jsdelivr.net/npm/tinymce@6.8.3/skins/ui/oxide/content.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tinymce@6.8.3/skins/content/default/content.min.css" rel="stylesheet">
    @endpush

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/tinymce@6.8.3/tinymce.min.js"></script>
    <script>
        function previewImage(e) {
            const [file] = e.target.files;
            const preview = document.getElementById('img-preview');
            if (file) {
                preview.src = URL.createObjectURL(file);
                preview.style.display = 'block';
            }
        }

        // Initialize existing image preview
        document.addEventListener('DOMContentLoaded', function() {
            const preview = document.getElementById('img-preview');
            if (preview.src && !preview.src.includes('{{ url("") }}')) {
                preview.style.display = 'block';
            }
        });

        // Initialize TinyMCE
        tinymce.init({
            selector: '#content-editor',
            promotion: false,
            branding: false,
            height: 400,
            menubar: 'edit view insert format tools',
            plugins: [
                'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
                'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
                'insertdatetime', 'media', 'table', 'code', 'help', 'wordcount'
            ],
            toolbar: 'undo redo | blocks | bold italic underline strikethrough | ' +
                'alignleft aligncenter alignright alignjustify | ' +
                'bullist numlist outdent indent | forecolor backcolor | ' +
                'link image media | table | code | fullscreen | ' +
                'removeformat | help',
            content_style: `
                body {
                    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
                    font-size: 14px;
                    line-height: 1.6;
                }
                img { max-width: 100%; height: auto; }
            `,
            automatic_uploads: true,
            file_picker_types: 'image',
            paste_data_images: true,
            setup: function(editor) {
                editor.on('init', function() {
                    const content = document.getElementById('content').value;
                    editor.setContent(content || '');
                });

                editor.on('change keyup', function() {
                    document.getElementById('content').value = editor.getContent();
                });
            }
        });
    </script>
    @endpush
</x-default-layout>
