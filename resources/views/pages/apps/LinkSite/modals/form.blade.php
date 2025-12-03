<div class="mb-10">
    <label class="form-label required">Nama Situs</label>
    <input type="text" name="name" class="form-control" value="{{ old('name', $link->name) }}" required placeholder="Masukkan nama situs">
    <div class="form-text">Contoh: Google, Facebook, Instagram, dll.</div>
    @error('name') <div class="text-danger small">{{ $message }}</div> @enderror
</div>

<div class="mb-10">
    <label class="form-label required">Link URL</label>
    <input type="url" name="link" class="form-control" value="{{ old('link', $link->link) }}" required placeholder="https://example.com">
    <div class="form-text">
        Pastikan link diawali dengan https:// atau http://
    </div>
    
    @if($mode === 'edit' && $link->link)
        <div class="mt-3">
            <strong>Preview Link:</strong>
            <div class="mt-2">
                <a href="{{ $link->link }}" target="_blank" class="btn btn-outline-primary btn-sm">
                    <i class="fas fa-external-link-alt me-2"></i>
                    Test Buka Link: {{ parse_url($link->link, PHP_URL_HOST) }}
                </a>
            </div>
        </div>
    @endif
    
    @error('link') <div class="text-danger small">{{ $message }}</div> @enderror
</div>

<div class="d-flex gap-3">
    <a href="{{ route('linksite-management.linksite.index') }}" class="btn btn-light">Batal</a>
    <button class="btn btn-primary" type="submit">
        {{ ($mode ?? 'create') === 'edit' ? 'Simpan Perubahan' : 'Simpan Link' }}
    </button>
</div>

@push('scripts')
<script>
    // Live validation untuk URL
    document.addEventListener('DOMContentLoaded', function() {
        const linkInput = document.querySelector('input[name="link"]');
        const previewContainer = document.createElement('div');
        previewContainer.className = 'mt-3';
        previewContainer.innerHTML = '<strong>Live Preview:</strong><div class="mt-2" id="link-preview"></div>';
        
        if (linkInput) {
            linkInput.parentNode.appendChild(previewContainer);
            
            linkInput.addEventListener('input', function() {
                const url = this.value;
                const preview = document.getElementById('link-preview');
                
                if (isValidUrl(url)) {
                    const domain = extractDomain(url);
                    preview.innerHTML = `
                        <div class="alert alert-success p-2 mb-2">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            Format URL valid
                        </div>
                        <a href="${url}" target="_blank" class="btn btn-outline-success btn-sm">
                            <i class="fas fa-external-link-alt me-2"></i>
                            Test: ${domain}
                        </a>
                    `;
                } else if (url.length > 0) {
                    preview.innerHTML = `
                        <div class="alert alert-warning p-2">
                            <i class="fas fa-exclamation-triangle text-warning me-2"></i>
                            Format URL tidak valid. Pastikan diawali dengan http:// atau https://
                        </div>
                    `;
                } else {
                    preview.innerHTML = '';
                }
            });
        }
    });

    function isValidUrl(string) {
        try {
            new URL(string);
            return true;
        } catch (_) {
            return false;
        }
    }

    function extractDomain(url) {
        try {
            const domain = new URL(url).hostname;
            return domain.replace('www.', '');
        } catch (_) {
            return 'Invalid URL';
        }
    }

    // Auto format URL jika user lupa protocol
    document.addEventListener('DOMContentLoaded', function() {
        const linkInput = document.querySelector('input[name="link"]');
        
        if (linkInput) {
            linkInput.addEventListener('blur', function() {
                let url = this.value.trim();
                
                if (url && !url.startsWith('http://') && !url.startsWith('https://')) {
                    // Tambahkan https:// secara otomatis
                    this.value = 'https://' + url;
                }
            });
        }
    });
</script>

<style>
    .btn-outline-primary:hover, .btn-outline-success:hover {
        transform: translateY(-1px);
        transition: all 0.2s ease;
    }
</style>
@endpush