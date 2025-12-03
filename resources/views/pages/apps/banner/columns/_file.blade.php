{{-- resources/views/pages/apps/banners/columns/_file.blade.php --}}
@if($banner->file)
    @php
        $fileExtension = pathinfo($banner->file, PATHINFO_EXTENSION);
        $isImage = in_array(strtolower($fileExtension), ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg']);
    @endphp

    @if($isImage)
        <div class="symbol symbol-50px">
            <img src="{{ asset('storage/' . $banner->file) }}" alt="{{ $banner->title }}" class="rounded" style="object-fit: cover; width: 50px; height: 50px;">
        </div>
    @else
        <div class="d-flex align-items-center">
            <i class="ki-duotone ki-file fs-2x text-primary me-2"></i>
            <span class="text-muted">File</span>
        </div>
    @endif
@else
    <span class="text-muted fw-semibold">-</span>
@endif
