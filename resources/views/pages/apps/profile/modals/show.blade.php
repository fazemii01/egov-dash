<x-default-layout>
    @section('title') Detail Profile @endsection
    @section('breadcrumbs') {{ Breadcrumbs::render('profile-management.index') }} @endsection

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ $profile->title }}</h3>
        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-6">
                    <strong>Dibuat oleh:</strong> {{ $profile->user->name ?? 'Unknown User' }}
                </div>
                <div class="col-md-6">
                    <strong>Tanggal Dibuat:</strong> {{ $profile->created_at ? $profile->created_at->format('d F Y H:i') : '-' }}
                </div>
            </div>

            @if($profile->file)
                <div class="mb-4">
                    <strong>File:</strong><br>
                    @if(Str::endsWith($profile->file, ['.jpg', '.jpeg', '.png']))
                        <img src="{{ asset('storage/' . $profile->file) }}" 
                             alt="{{ $profile->title }}" 
                             style="max-height: 300px; object-fit: cover;"
                             class="img-thumbnail">
                    @else
                        <a href="{{ asset('storage/' . $profile->file) }}" 
                           target="_blank" 
                           class="btn btn-primary">
                            <i class="fas fa-download"></i> Download File
                        </a>
                    @endif
                </div>
            @endif

            <div class="mb-4">
                <strong>Deskripsi:</strong>
                <div class="mt-2 p-3 border rounded">
                    {!! nl2br(e($profile->description)) !!}
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('profile-management.profile.index') }}" class="btn btn-light">Kembali</a>
            </div>
        </div>
    </div>
</x-default-layout>