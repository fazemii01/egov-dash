<x-default-layout>
    @section('title') detail link situs @endsection
    @section('breadcrumbs') {{ Breadcrumbs::render('linksite-management.index') }} @endsection

    <div class="card">
        <div class="card-body">
            <div class="mb-6">
                <h3 class="card-title">Detail Link Situs</h3>
            </div>

            <div class="mb-6">
                <h5 class="text-dark mb-3">Nama Situs:</h5>
                <div class="p-4 bg-light rounded">
                    <p class="mb-0 fs-5">{{ $link->name }}</p>
                </div>
            </div>

            <div class="mb-6">
                <h5 class="text-dark mb-3">Link:</h5>
                <div class="p-4 bg-light rounded">
                    <a href="{{ $link->link }}" target="_blank" class="fs-6 text-primary text-decoration-underline">
                        {{ $link->link }}
                    </a>
                    <div class="mt-2">
                        <small class="text-muted">Klik link di atas untuk membuka di tab baru</small>
                    </div>
                </div>
            </div>

            <div class="row mb-6">
                <div class="col-md-6">
                    <strong>Dibuat:</strong> {{ $link->created_at ? $link->created_at->format('d F Y H:i') : '-' }}
                </div>
                <div class="col-md-6">
                    <strong>Diperbarui:</strong> {{ $link->updated_at ? $link->updated_at->format('d F Y H:i') : '-' }}
                </div>
            </div>

            <div class="d-flex gap-3">
                <a href="{{ route('linksite-management.linksite.index') }}" class="btn btn-light">Kembali</a>
                <a href="{{ $link->link }}" target="_blank" class="btn btn-info">
                    <i class="fas fa-external-link-alt"></i> Kunjungi Situs
                </a>
                <a href="{{ route('linksite-management.linksite.edit', $link->id) }}" class="btn btn-warning">Edit</a>
            </div>
        </div>
    </div>
</x-default-layout>