@php
    $photoCount = $gallery->photos_count ?? $gallery->detailsGallery->count();
@endphp

<div class="d-flex align-items-center">
    <div class="symbol symbol-45px me-3">
        <div class="symbol-label bg-light-primary text-primary fw-bold">
            {{ $photoCount }}
        </div>
    </div>
    <div class="d-flex flex-column">
        <span class="fw-bold text-gray-800">Foto</span>
        <span class="text-muted">{{ $photoCount }} foto</span>
    </div>
</div>
