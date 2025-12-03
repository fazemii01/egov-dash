<x-default-layout>
    @section('title')
        Service
    @endsection
    @section('breadcrumbs')
        {{ Breadcrumbs::render('service-management.index') }}
    @endsection

    <div class="card">
        <div class="card-header border-0 pt-6">
            <div class="card-title">
                <form method="get" action="{{ route('service-management.service.index') }}"
                    class="d-flex align-items-center position-relative my-1">
                    {!! getIcon('magnifier', 'fs-3 position-absolute ms-5') !!}
                    <input type="text" name="q" value="{{ $q }}"
                        class="form-control form-control-solid w-250px ps-13" placeholder="Cari judul service" />
                </form>
            </div>
            <div class="card-toolbar">
                <a href="{{ route('service-management.service.create') }}" class="btn btn-primary">
                    {!! getIcon('plus', 'fs-2', '', 'i') !!} Create Service
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
                            <th>Judul</th>
                            <th>SOP</th>
                            <th>File Download</th>
                            <th>Isi</th>
                            <th width="190">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($service as $s)
                            <tr>
                                <td>{{ $s->id }}</td>
                                <td class="text-wrap">{{ $s->title }}</td>
                                <td>
                                    @if ($s->sop)
                                        <div class="text-primary">
                                            @if (Str::endsWith($s->sop, '.pdf'))
                                                <i class="fas fa-file-pdf me-1"></i>
                                            @elseif(Str::endsWith($s->sop, ['.doc', '.docx']))
                                                <i class="fas fa-file-word me-1"></i>
                                            @else
                                                <i class="fas fa-file me-1"></i>
                                            @endif
                                            {{ basename($s->sop) }}
                                        </div>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($s->file_download)
                                        <div class="text-success">
                                            @if (Str::endsWith($s->file_download, ['.jpg', '.jpeg', '.png']))
                                                <i class="fas fa-file-image me-1"></i>
                                            @elseif(Str::endsWith($s->file_download, '.pdf'))
                                                <i class="fas fa-file-pdf me-1"></i>
                                            @elseif(Str::endsWith($s->file_download, '.zip'))
                                                <i class="fas fa-file-archive me-1"></i>
                                            @else
                                                <i class="fas fa-file me-1"></i>
                                            @endif
                                            {{ basename($s->file_download) }}
                                        </div>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>{{ Str::limit(strip_tags($s->content), 50) }}</td>
                                <td>
                                    <a class="btn btn-sm btn-warning"
                                        href="{{ route('service-management.service.edit', $s->id) }}">Edit</a>
                                    <form method="post"
                                        action="{{ route('service-management.service.destroy', $s->id) }}"
                                        class="d-inline">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-danger"
                                            onclick="return confirm('Delete service??')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">Belum ada data</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">{{ $service->links() }}</div>
        </div>
    </div>
</x-default-layout>
