<x-default-layout>
    @section('title') Detail Gallery @endsection
    @section('breadcrumbs') {{ Breadcrumbs::render('gallery-management.index') }} @endsection

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ $gallery->activity }}</h3>
        </div>
        <div class="card-body">
            <div class="row mb-10">
                <div class="col-md-4">
                    <strong>Waktu:</strong> {{ $gallery->time }}
                </div>
                <div class="col-md-4">
                    <strong>Tempat:</strong> {{ $gallery->place }}
                </div>
                <div class="col-md-4">
                    <strong>Total Foto:</strong> {{ $gallery->photos->count() }}
                </div>
            </div>

            <div class="row">
                @foreach($gallery->photos as $photo)
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <img src="{{ asset('storage/' . $photo->photo) }}" class="card-img-top" alt="{{ $photo->title_photo }}" style="height: 200px; object-fit: cover;">
                            <div class="card-body">
                                <h5 class="card-title">{{ $photo->title_photo ?? 'No Title' }}</h5>
                                <p class="card-text">{{ $photo->caption ?? 'No Caption' }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-4">
                <a href="{{ route('gallery-management.gallery.index') }}" class="btn btn-light">Kembali</a>
            </div>
        </div>
    </div>
</x-default-layout>