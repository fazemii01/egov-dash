<div class="mb-10">
    <label class="form-label required">Judul Video</label>
    <input type="text" name="title" class="form-control" value="{{ old('title', $video->title) }}" required placeholder="Masukkan judul video">
    @error('title') <div class="text-danger small">{{ $message }}</div> @enderror
</div>

<div class="mb-10">
    <label class="form-label required">Link YouTube</label>
    <input type="url" name="file" class="form-control" value="{{ old('file', $video->file) }}" required placeholder="https://www.youtube.com/watch?v=xxxxxxxxxxx">
    <div class="form-text">
        Masukkan link YouTube video. Contoh: 
        <code>https://www.youtube.com/watch?v=xxxxxxxxxxx</code> atau 
        <code>https://youtu.be/xxxxxxxxxxx</code>
    </div>
    
    @if($mode === 'edit' && $video->file)
        <div class="mt-3">
            <strong>Preview:</strong>
            <div class="mt-2">
                <div class="ratio ratio-16x9" style="max-width: 400px;">
                    <iframe src="{{ $video->getYoutubeEmbedUrl() }}" 
                            frameborder="0" 
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                            allowfullscreen>
                    </iframe>
                </div>
            </div>
        </div>
    @endif
    
    @error('file') <div class="text-danger small">{{ $message }}</div> @enderror
</div>

<div class="mb-10">
    <label class="form-label">Tanggal</label>
    <input type="datetime-local" name="created_at" class="form-control" 
           value="{{ old('created_at', $video->created_at ? $video->created_at->format('Y-m-d\TH:i') : '') }}">
    @error('created_at') <div class="text-danger small">{{ $message }}</div> @enderror
</div>

<div class="d-flex gap-3">
    <a href="{{ route('video-management.video.index') }}" class="btn btn-light">Batal</a>
    <button class="btn btn-primary" type="submit">
        {{ ($mode ?? 'create') === 'edit' ? 'Simpan Perubahan' : 'Simpan Video' }}
    </button>
</div>

@push('scripts')
<script>
    // Live preview untuk YouTube link
    document.addEventListener('DOMContentLoaded', function() {
        const urlInput = document.querySelector('input[name="file"]');
        const previewContainer = document.createElement('div');
        previewContainer.className = 'mt-3';
        previewContainer.innerHTML = '<strong>Live Preview:</strong><div class="mt-2"><div class="ratio ratio-16x9" style="max-width: 400px;" id="youtube-preview"></div></div>';
        
        if (urlInput) {
            urlInput.parentNode.appendChild(previewContainer);
            
            urlInput.addEventListener('input', function() {
                const url = this.value;
                const preview = document.getElementById('youtube-preview');
                
                if (isValidYouTubeUrl(url)) {
                    const videoId = extractYouTubeId(url);
                    if (videoId) {
                        preview.innerHTML = `<iframe src="https://www.youtube.com/embed/${videoId}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>`;
                    }
                } else {
                    preview.innerHTML = '<div class="alert alert-warning p-2">Link YouTube tidak valid</div>';
                }
            });
        }
    });

    function isValidYouTubeUrl(url) {
        return /^(https?:\/\/)?(www\.)?(youtube\.com|youtu\.?be)\/.+$/.test(url);
    }

    function extractYouTubeId(url) {
        const regExp = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#&?]*).*/;
        const match = url.match(regExp);
        return (match && match[7].length === 11) ? match[7] : false;
    }
</script>

<style>
    .ratio-16x9 {
        aspect-ratio: 16 / 9;
    }
</style>
@endpush