<x-default-layout>
    @section('title')
        Profile
    @endsection
    @section('breadcrumbs')
        {{ Breadcrumbs::render('profile-management.index') }}
    @endsection

    <div class="card">
        <div class="card-header border-0 pt-6">
            <div class="card-title">
                <form method="get" action="{{ route('profile-management.profile.index') }}"
                    class="d-flex align-items-center position-relative my-1">
                    {!! getIcon('magnifier', 'fs-3 position-absolute ms-5') !!}
                    <input type="text" name="q" value="{{ $q }}"
                        class="form-control form-control-solid w-250px ps-13" placeholder="Cari judul profile" />
                </form>
            </div>
            <div class="card-toolbar">
                <a href="{{ route('profile-management.profile.create') }}" class="btn btn-primary">
                    {!! getIcon('plus', 'fs-2', '', 'i') !!} Create Profile
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
                            <th>File</th>
                            <th>User</th>
                            <th>Tanggal Dibuat</th>
                            <th width="150">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($profiles as $profile)
                            <tr>
                                <td>{{ $profile->id }}</td>
                                <td class="text-wrap">{{ $profile->title }}</td>
                                <td>
                                    @if ($profile->file)
                                        @if(Str::endsWith($profile->file, ['.jpg', '.jpeg', '.png']))
                                            <img src="{{ asset('storage/' . $profile->file) }}" 
                                                 alt="{{ $profile->title }}" 
                                                 style="max-height: 50px; object-fit: cover;"
                                                 class="img-thumbnail">
                                        @else
                                            <a href="{{ asset('storage/' . $profile->file) }}" 
                                               target="_blank" 
                                               class="btn btn-sm btn-info">
                                                Download File
                                            </a>
                                        @endif
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    {{ $profile->user->name ?? 'Unknown User' }}
                                </td>
                                <td>
                                    {{ $profile->created_at ? $profile->created_at->format('d M Y') : '-' }}
                                </td>
                                <td>
                                    <a class="btn btn-sm btn-info"
                                        href="{{ route('profile-management.profile.show', $profile->id) }}">View</a>
                                    <a class="btn btn-sm btn-warning"
                                        href="{{ route('profile-management.profile.edit', $profile->id) }}">Edit</a>
                                    <form method="post" action="{{ route('profile-management.profile.destroy', $profile->id) }}"
                                        class="d-inline">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-danger"
                                            onclick="return confirm('Delete profile??')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">Belum ada data profile</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">{{ $profiles->links() }}</div>
        </div>
    </div>
</x-default-layout>