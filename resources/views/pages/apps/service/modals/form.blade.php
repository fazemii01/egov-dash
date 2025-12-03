<div class="mb-10">
    <label class="form-label required">Judul Service</label>
    <input type="text" name="title" class="form-control" value="{{ old('title', $service->title) }}" required>
    @error('title') <div class="text-danger small">{{ $message }}</div> @enderror
</div>

<div class="row mb-10">
    <div class="col-md-6">
        <label class="form-label">File SOP</label>
        <input type="file" name="sop" class="form-control" accept=".pdf,.doc,.docx">
        <div class="form-text">Format: pdf, doc, docx. Maks 10MB.</div>
        @if($service->sop)
            <div class="mt-2">
                <small class="text-muted">SOP saat ini: </small>
                <a href="{{ asset('storage/'.$service->sop) }}" target="_blank" class="btn btn-sm btn-info">Download SOP</a>
            </div>
        @endif
        @error('sop') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-6">
        <label class="form-label">File Download</label>
        <input type="file" name="file_download" class="form-control" accept=".jpg,.jpeg,.png,.pdf,.zip,.doc,.docx">
        <div class="form-text">Format: jpg, jpeg, png, pdf, zip, doc, docx. Maks 10MB.</div>
        @if($service->file_download)
            <div class="mt-2">
                <small class="text-muted">File saat ini: </small>
                <a href="{{ asset('storage/'.$service->file_download) }}" target="_blank" class="btn btn-sm btn-success">Download File</a>
            </div>
        @endif
        @error('file_download') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>
</div>

<div class="row mb-10">
    <div class="col-md-6">
        <label class="form-label">Tanggal Dibuat</label>
        <input type="date" name="created_at" class="form-control" value="{{ old('created_at', $service->created_at ? $service->created_at->format('Y-m-d') : '') }}">
        @error('created_at') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>
</div>

<div class="mb-10">
    <label class="form-label required">Isi Service</label>
    <textarea name="content" class="form-control" rows="12" required>{{ old('content', $service->content) }}</textarea>
    @error('content') <div class="text-danger small">{{ $message }}</div> @enderror
</div>

<div class="d-flex gap-3">
    <a href="{{ route('service-management.service.index') }}" class="btn btn-light">Batal</a>
    <button class="btn btn-primary" type="submit">{{ ($mode ?? 'create') === 'edit' ? 'Simpan Perubahan' : 'Simpan' }}</button>
</div>