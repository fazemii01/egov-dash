{{-- resources/views/pages/apps/news/columns/_images.blade.php --}}
@if ($news->images)
    <div class="d-flex justify-content-center align-items-center">
        <img src="{{ asset('storage/' . $news->images) }}"
             alt="{{ $news->headline }}"
             class="rounded object-fit-cover"
             style="width: 100px; height: 75px; object-fit: cover;">
    </div>
@else
    <div class="d-flex justify-content-center align-items-center" style="width: 100px; height: 75px;">
        <span class="badge badge-light fw-bold text-muted">No Image</span>
    </div>
@endif
