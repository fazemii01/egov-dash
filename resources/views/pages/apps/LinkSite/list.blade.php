<x-default-layout>
    @section('title')
        Site Link
    @endsection
    @section('breadcrumbs')
        {{ Breadcrumbs::render('linksite-management.index') }}
    @endsection

    <div class="card">
        <div class="card-header border-0 pt-6">
            <div class="card-title">
                <form method="get" action="{{ route('linksite-management.linksite.index') }}"
                    class="d-flex align-items-center position-relative my-1">
                    {!! getIcon('magnifier', 'fs-3 position-absolute ms-5') !!}
                    <input type="text" name="q" value="{{ $q }}"
                        class="form-control form-control-solid w-250px ps-13" placeholder="Cari nama atau link situs" />
                </form>
            </div>
            <div class="card-toolbar">
                <a href="{{ route('linksite-management.linksite.create') }}" class="btn btn-primary">
                    {!! getIcon('plus', 'fs-2', '', 'i') !!} Tambah Link
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
                            <th width="80">No</th>
                            <th>Nama Situs</th>
                            <th>Link</th>
                            <th>Tanggal Dibuat</th>
                            <th width="150">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($links as $link)
                            <tr id="link-{{ $link->id }}" class="link-row">
                                <td>{{ $loop->iteration }}</td>
                                <td class="text-wrap">
                                    <div class="fw-bold">{{ $link->name }}</div>
                                </td>
                                <td class="text-wrap">
                                    <a href="{{ $link->link }}" target="_blank" class="text-primary text-decoration-underline">
                                        {{ Str::limit($link->link, 50) }}
                                    </a>
                                    <div>
                                        <small class="text-muted">Klik untuk buka link</small>
                                    </div>
                                </td>
                                <td>
                                    {{ $link->created_at ? $link->created_at->format('d M Y') : '-' }}
                                </td>
                                <td>
                                    <a class="btn btn-sm btn-info"
                                        href="{{ route('linksite-management.linksite.show', $link->id) }}">View</a>
                                    <a class="btn btn-sm btn-warning"
                                        href="{{ route('linksite-management.linksite.edit', $link->id) }}">Edit</a>
                                    <form method="post" action="{{ route('linksite-management.linksite.destroy', $link->id) }}"
                                        class="d-inline">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-danger"
                                            onclick="return confirm('Hapus link situs?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">Belum ada data link situs</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">{{ $links->links() }}</div>
        </div>
    </div>

    @if(session('scroll_to'))
        @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Scroll ke data yang baru dibuat
                const linkId = {{ session('scroll_to') }};
                const element = document.getElementById('link-' + linkId);
                
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
            .link-row {
                transition: all 0.3s ease;
            }
        </style>
        @endpush
    @endif
</x-default-layout>