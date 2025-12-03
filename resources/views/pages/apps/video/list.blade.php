<x-default-layout>
    @section('title')
        Video
    @endsection
    @section('breadcrumbs')
        {{ Breadcrumbs::render('video-management.index') }}
    @endsection

    <div class="card">
        <div class="card-header border-0 pt-6">
            <div class="card-title">
                <form method="get" action="{{ route('video-management.video.index') }}"
                    class="d-flex align-items-center position-relative my-1">
                    {!! getIcon('magnifier', 'fs-3 position-absolute ms-5') !!}
                    <input type="text" name="q" value="{{ $q }}"
                        class="form-control form-control-solid w-250px ps-13" placeholder="Cari judul video" />
                </form>
            </div>
            <div class="card-toolbar">
                <a href="{{ route('video-management.video.create') }}" class="btn btn-primary">
                    {!! getIcon('plus', 'fs-2', '', 'i') !!} Upload Video
                </a>
            </div>
        </div>

        <div class="card-body py-4">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="table-responsive">
                <table class="table align-middle table-row-dashed">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Judul</th>
                            <th>Video</th>
                            <th>User</th>
                            <th>Tanggal Upload</th>
                            <th width="150">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($videos as $video)
                            <tr>
                                <td>{{ $video->id }}</td>
                                <td class="text-wrap">{{ $video->title }}</td>
                                <td>
                                    @if ($video->file)
                                        <div class="video-thumbnail">
                                            <div class="ratio ratio-16x9" style="width: 120px;">
                                                <iframe src="{{ $video->getYoutubeEmbedUrl() }}" frameborder="0"
                                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                                    allowfullscreen>
                                                </iframe>
                                            </div>
                                            <div class="mt-1">
                                                <small class="text-muted">YouTube Video</small>
                                            </div>
                                        </div>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    {{ $video->user->name ?? 'Unknown User' }}
                                </td>
                                <td>
                                    {{ $video->created_at ? $video->created_at->format('d M Y') : '-' }}
                                </td>
                                <td>
                                    <a class="btn btn-sm btn-info"
                                        href="{{ route('video-management.video.show', $video->id) }}">View</a>
                                    <a class="btn btn-sm btn-warning"
                                        href="{{ route('video-management.video.edit', $video->id) }}">Edit</a>
                                    <form method="post"
                                        action="{{ route('video-management.video.destroy', $video->id) }}"
                                        class="d-inline">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-danger"
                                            onclick="return confirm('Hapus video?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">Belum ada data video</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">{{ $videos->links() }}</div>
        </div>
    </div>

    <style>
        .video-thumbnail video {
            border-radius: 8px;
            background: #000;
        }
    </style>
</x-default-layout>
