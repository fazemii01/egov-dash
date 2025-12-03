<div class="mb-10">
    <label class="form-label required">Pertanyaan</label>
    <textarea name="statement" class="form-control" rows="3" required placeholder="Masukkan pertanyaan yang sering diajukan">{{ old('statement', $faq->statement) }}</textarea>
    <div class="form-text">Tulis pertanyaan yang jelas dan mudah dipahami.</div>
    @error('statement') <div class="text-danger small">{{ $message }}</div> @enderror
</div>

<div class="mb-10">
    <label class="form-label required">jawaban</label>
    <textarea name="answer" class="form-control" rows="12" required>{{ old('answer', $faq->answer) }}</textarea>
    @error('answer') <div class="text-danger small">{{ $message }}</div> @enderror
</div>

<div class="d-flex gap-3">
    <a href="{{ route('faq-management.faq.index') }}" class="btn btn-light">Batal</a>
    <button class="btn btn-primary" type="submit">
        {{ ($mode ?? 'create') === 'edit' ? 'Simpan Perubahan' : 'Simpan FAQ' }}
    </button>
</div>
