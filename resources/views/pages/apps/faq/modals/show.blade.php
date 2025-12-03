<x-default-layout>
    @section('title') detail faq @endsection
    @section('breadcrumbs') {{ Breadcrumbs::render('faq-management.index') }} @endsection

    <div class="card">
        <div class="card-body">
            <div class="mb-6">
                <h3 class="card-title">Detail FAQ</h3>
            </div>

            <div class="mb-6">
                <h5 class="text-dark mb-3">Pertanyaan:</h5>
                <div class="p-4 bg-light rounded">
                    <p class="mb-0 fs-5">{{ $faq->statement }}</p>
                </div>
            </div>

            <div class="mb-6">
                <h5 class="text-dark mb-3">Jawaban:</h5>
                <div class="p-4 bg-light rounded">
                    <div class="fs-6">{!! nl2br(e($faq->answer)) !!}</div>
                </div>
            </div>

            <div class="row mb-6">
                <div class="col-md-6">
                    <strong>Dibuat:</strong> {{ $faq->created_at ? $faq->created_at->format('d F Y H:i') : '-' }}
                </div>
                <div class="col-md-6">
                    <strong>Diperbarui:</strong> {{ $faq->updated_at ? $faq->updated_at->format('d F Y H:i') : '-' }}
                </div>
            </div>

            <div class="d-flex gap-3">
                <a href="{{ route('faq-management.faq.index') }}" class="btn btn-light">Kembali</a>
                <a href="{{ route('faq-management.faq.edit', $faq->id) }}" class="btn btn-warning">Edit</a>
            </div>
        </div>
    </div>
</x-default-layout>