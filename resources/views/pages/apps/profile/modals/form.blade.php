<div class="mb-10">
    <label class="form-label required">Judul Profile</label>
    <input type="text" name="title" class="form-control" value="{{ old('title', $profile->title) }}" required>
    @error('title') <div class="text-danger small">{{ $message }}</div> @enderror
</div>

<div class="mb-10">
    <label class="form-label required">Description</label>
    <textarea name="description" class="form-control" rows="12" required>{{ old('description', $profile->description) }}</textarea>
    @error('description') <div class="text-danger small">{{ $message }}</div> @enderror
</div>

<div class="mb-10">
    <label class="form-label">File</label>
    <input type="file" name="file" class="form-control" accept=".jpg,.jpeg,.png,.pdf,.doc,.docx"
           onchange="previewFile(this)">
    <div class="form-text">Format: jpg, jpeg, png, pdf, doc, docx. Maks 10MB.</div>
    
    @if($mode === 'edit' && $profile->file)
        <div class="mt-3">
            @if(Str::endsWith($profile->file, ['.jpg', '.jpeg', '.png']))
                <img src="{{ asset('storage/' . $profile->file) }}" 
                     id="file-preview"
                     style="max-height: 200px; object-fit: cover;" 
                     class="img-thumbnail">
            @else
                <div id="file-preview" class="alert alert-info">
                    <i class="fas fa-file"></i> File saat ini: 
                    <a href="{{ asset('storage/' . $profile->file) }}" target="_blank">
                        {{ basename($profile->file) }}
                    </a>
                </div>
            @endif
        </div>
    @else
        <div class="mt-3">
            <div id="file-preview" style="display: none;"></div>
        </div>
    @endif
    
    @error('file') <div class="text-danger small">{{ $message }}</div> @enderror
</div>

<div class="d-flex gap-3">
    <a href="{{ route('profile-management.profile.index') }}" class="btn btn-light">Batal</a>
    <button class="btn btn-primary" type="submit">
        {{ ($mode ?? 'create') === 'edit' ? 'Simpan Perubahan' : 'Simpan' }}
    </button>
</div>

@push('scripts')
<script src="https://cdn.tiny.cloud/1/your-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    function previewFile(input) {
        const preview = document.getElementById('file-preview');
        
        if (input.files && input.files[0]) {
            const file = input.files[0];
            const reader = new FileReader();
            
            reader.onload = function(e) {
                if (file.type.startsWith('image/')) {
                    preview.innerHTML = `<img src="${e.target.result}" style="max-height: 200px; object-fit: cover;" class="img-thumbnail">`;
                } else {
                    preview.innerHTML = `
                        <div class="alert alert-info">
                            <i class="fas fa-file"></i> File yang dipilih: ${file.name}
                        </div>
                    `;
                }
                preview.style.display = 'block';
            }
            
            reader.readAsDataURL(file);
        }
    }
</script>
@endpush