{{-- resources/views/pages/apps/announcements/columns/_file.blade.php --}}
@if($announcement->file_path)
    @php
        $extension = pathinfo($announcement->file_path, PATHINFO_EXTENSION);
        $isImage = in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif']);
        $fileName = basename($announcement->file_path);
        $fileUrl = asset('storage/'.$announcement->file_path);
    @endphp

    @if($isImage)
        <img src="{{ $fileUrl }}"
             alt="Gambar Pengumuman"
             class="img-thumbnail"
             style="max-height: 60px; max-width: 80px;">
    @else
        <div class="d-flex align-items-center">
            @if(strtolower($extension) === 'pdf')
                <i class="bi bi-file-pdf fs-2 text-danger" title="{{ $fileName }}"></i>
            @elseif(in_array(strtolower($extension), ['zip', 'rar']))
                <i class="bi bi-file-zip fs-2 text-warning" title="{{ $fileName }}"></i>
            @else
                <i class="bi bi-file-earmark fs-2 text-primary" title="{{ $fileName }}"></i>
            @endif
        </div>
    @endif
@else
    <span class="text-muted fs-7">Tidak ada file</span>
@endif
