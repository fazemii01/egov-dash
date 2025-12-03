<x-default-layout>
    @section('title') Detail Video @endsection
    @section('breadcrumbs') {{ Breadcrumbs::render('video-management.index') }} @endsection

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ $video->title }}</h3>
        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-6">
                    <strong>Diupload oleh:</strong> {{ $video->user->name ?? 'Unknown User' }}
                </div>
                <div class="col-md-6">
                    <strong>Tanggal Upload:</strong> {{ $video->created_at ? $video->created_at->format('d F Y H:i') : '-' }}
                </div>
            </div>

            @if($video->file)
                <div class="mb-4">
                    <strong>Video:</strong><br>
                    <div class="mt-3">
                        <video width="100%" height="400" controls style="max-width: 800px;">
                            <source src="{{ asset('storage/' . $video->file) }}" type="video/mp4">
                            Browser Anda tidak mendukung video tag.
                        </video>
                    </div>
                    <div class="mt-2">
                        <a href="{{ asset('storage/' . $video->file) }}" 
                           download 
                           class="btn btn-primary">
                            <i class="fas fa-download"></i> Download Video
                        </a>
                    </div>
                </div>
            @endif

            <div class="mt-4">
                <a href="{{ route('video-management.video.index') }}" class="btn btn-light">Kembali</a>
            </div>
        </div>
    </div>
</x-default-layout>