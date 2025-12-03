@php
    $photoCount = $gallery->photos_count ?? 0;
    $photos = $gallery->photos ?? collect();
@endphp

<div class="d-flex align-items-center justify-content-center">
    @if($photoCount > 0)
        <div class="position-relative" style="width: 80px; height: 60px;">
            <!-- Foto pertama (paling belakang) -->
            @if($photos->count() > 0 && $photos[0]->photo)
                <div class="position-absolute" style="top: 0; left: 0; z-index: 1; transform: rotate(-5deg);">
                    <div class="symbol symbol-40px symbol-circle">
                        <img src="{{ asset('storage/' . $photos[0]->photo) }}"
                             alt="Photo 1"
                             class="symbol-img border border-3 border-white"
                             style="object-fit: cover;">
                    </div>
                </div>
            @endif

            <!-- Foto kedua (tengah) -->
            @if($photos->count() > 1 && $photos[1]->photo)
                <div class="position-absolute" style="top: 8px; left: 20px; z-index: 2; transform: rotate(0deg);">
                    <div class="symbol symbol-40px symbol-circle">
                        <img src="{{ asset('storage/' . $photos[1]->photo) }}"
                             alt="Photo 2"
                             class="symbol-img border border-3 border-white"
                             style="object-fit: cover;">
                    </div>
                </div>
            @endif

            <!-- Foto ketiga (paling depan) -->
            @if($photos->count() > 2 && $photos[2]->photo)
                <div class="position-absolute" style="top: 16px; left: 40px; z-index: 3; transform: rotate(5deg);">
                    <div class="symbol symbol-40px symbol-circle">
                        <img src="{{ asset('storage/' . $photos[2]->photo) }}"
                             alt="Photo 3"
                             class="symbol-img border border-3 border-white"
                             style="object-fit: cover;">
                    </div>
                </div>
            @endif

            <!-- Badge jumlah foto -->
            @if($photoCount > 3)
                <div class="position-absolute" style="bottom: -5px; right: -5px; z-index: 4;">
                    <span class="badge badge-primary fw-bold">
                        +{{ $photoCount - 3 }}
                    </span>
                </div>
            @endif

            <!-- Overlay untuk melihat semua foto -->
            <!-- <a href="{{ route('gallery-management.gallery.photos', $gallery->id) }}"
               class="position-absolute w-100 h-100"
               style="z-index: 5; opacity: 0;"
               title="Lihat semua foto">
            </a> -->
        </div>

        <!-- Teks jumlah foto -->
        <div class="ms-3">
            <div class="fw-bold text-gray-800">{{ $photoCount }}</div>
            <div class="text-muted fs-7">foto</div>
        </div>
    @else
        <div class="text-center">
            <div class="symbol symbol-40px symbol-circle mb-2">
                <div class="symbol-label bg-light-danger text-danger">
                    <i class="ki-duotone ki-image fs-2"></i>
                </div>
            </div>
            <div class="text-muted fs-7">Tidak ada foto</div>
        </div>
    @endif
</div>
