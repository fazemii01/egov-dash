<x-default-layout>
    @section('title')
        FAQ
    @endsection
    @section('breadcrumbs')
        {{ Breadcrumbs::render('faq-management.index') }}
    @endsection

    <div class="card">
        <div class="card-header border-0 pt-6">
            <div class="card-title">
                <form method="get" action="{{ route('faq-management.faq.index') }}"
                    class="d-flex align-items-center position-relative my-1">
                    {!! getIcon('magnifier', 'fs-3 position-absolute ms-5') !!}
                    <input type="text" name="q" value="{{ $q }}"
                        class="form-control form-control-solid w-250px ps-13" placeholder="Cari pertanyaan atau jawaban" />
                </form>
            </div>
            <div class="card-toolbar">
                <a href="{{ route('faq-management.faq.create') }}" class="btn btn-primary">
                    {!! getIcon('plus', 'fs-2', '', 'i') !!} Buat FAQ
                </a>
            </div>
        </div>

        <div class="card-body py-4">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="table-responsive">
                <table class="table align-middle table-row-dashed">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Pertanyaan</th>
                            <th>Jawaban</th>
                            <th>Tanggal Dibuat</th>
                            <th width="150">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($faqs as $faq)
                            <tr>
                                <td>{{ $faq->id }}</td>
                                <td class="text-wrap">
                                    <div class="fw-bold">{{ Str::limit($faq->statement, 80) }}</div>
                                </td>
                                <td class="text-wrap">
                                    {{ Str::limit(strip_tags($faq->answer), 100) }}
                                </td>
                                <td>
                                    {{ $faq->created_at ? $faq->created_at->format('d M Y') : '-' }}
                                </td>
                                <td>
                                    <a class="btn btn-sm btn-info"
                                        href="{{ route('faq-management.faq.show', $faq->id) }}">View</a>
                                    <a class="btn btn-sm btn-warning"
                                        href="{{ route('faq-management.faq.edit', $faq->id) }}">Edit</a>
                                    <form method="post" action="{{ route('faq-management.faq.destroy', $faq->id) }}"
                                        class="d-inline">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-danger"
                                            onclick="return confirm('Hapus FAQ?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">Belum ada data FAQ</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">{{ $faqs->links() }}</div>
        </div>
    </div>

     @if(session('scroll_to'))
        @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Scroll ke data yang baru dibuat
                const faqId = {{ session('scroll_to') }};
                const element = document.getElementById('faq-' + faqId);
                
                if (element) {
                    // Tambah highlight
                    element.classList.add('table-success');
                    
                    // Smooth scroll ke element
                    element.scrollIntoView({ 
                        behavior: 'smooth', 
                        block: 'center' 
                    });
                    
                    // Hapus highlight setelah 3 detik
                    setTimeout(() => {
                        element.classList.remove('table-success');
                    }, 3000);
                }
            });
        </script>
        <style>
            .faq-row {
                transition: all 0.3s ease;
            }
        </style>
        @endpush
    @endif
    
</x-default-layout>