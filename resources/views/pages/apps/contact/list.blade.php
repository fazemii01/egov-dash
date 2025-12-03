<x-default-layout>
    @section('title')
        Contact Settings
    @endsection
    @section('breadcrumbs')
        {{ Breadcrumbs::render('contact-management.index') }}
    @endsection

    <div class="row">
        <!-- CARD ATAS - DISPLAY CURRENT DATA -->
        <div class="col-12">
            <div class="card mb-5">
                <div class="card-header">
                    <h3 class="card-title">Current Contact Settings</h3>
                </div>
                <div class="card-body">
                    @if($contact)
                        <!-- ADA DATA - TAMPILKAN -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <strong>Nama:</strong>
                                    <div class="mt-1">{{ $contact->name }}</div>
                                </div>
                                <div class="mb-4">
                                    <strong>Telepon:</strong>
                                    <div class="mt-1">{{ $contact->telephon }}</div>
                                </div>
                                <div class="mb-4">
                                    <strong>Email:</strong>
                                    <div class="mt-1">{{ $contact->email }}</div>
                                </div>
                                <div class="mb-4">
                                    <strong>Alamat:</strong>
                                    <div class="mt-1">{{ $contact->address ?: '-' }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <strong>Facebook:</strong>
                                    <div class="mt-1">
                                        @if($contact->facebook)
                                            <a href="{{ $contact->facebook }}" target="_blank">{{ $contact->facebook }}</a>
                                        @else
                                            -
                                        @endif
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <strong>Instagram:</strong>
                                    <div class="mt-1">
                                        @if($contact->instagram)
                                            <a href="{{ $contact->instagram }}" target="_blank">{{ $contact->instagram }}</a>
                                        @else
                                            -
                                        @endif
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <strong>Twitter:</strong>
                                    <div class="mt-1">
                                        @if($contact->twitter)
                                            <a href="{{ $contact->twitter }}" target="_blank">{{ $contact->twitter }}</a>
                                        @else
                                            -
                                        @endif
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <strong>Lokasi:</strong>
                                    <div class="mt-1">{{ $contact->location ?: '-' }}</div>
                                </div>
                                <div class="mb-4">
                                    <strong>Versi Aplikasi:</strong>
                                    <div class="mt-1">{{ $contact->aplication_version ?: '-' }}</div>
                                </div>
                                <div class="mb-4">
                                    <strong>Copyright:</strong>
                                    <div class="mt-1">{{ $contact->copyright ?: '-' }}</div>
                                </div>
                            </div>
                        </div>
                    @else
                        <!-- BELUM ADA DATA -->
                        <div class="text-center py-4">
                            <div class="text-muted">
                                <i class="fas fa-info-circle fa-2x mb-3"></i>
                                <p class="mb-0">Belum ada data contact settings.</p>
                                <p>Silakan isi form di bawah untuk membuat data pertama.</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- CARD BAWAH - FORM INPUT/EDIT -->
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        {{ $contact ? 'Update Contact Settings' : 'Create Contact Settings' }}
                    </h3>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <form action="{{ route('contact-management.contact.store') }}" method="post">
                        @csrf
                        
                        <div class="row">
                            <!-- Kolom Kiri -->
                            <div class="col-md-6">
                                <div class="mb-10">
                                    <label class="form-label required">Nama</label>
                                    <input type="text" name="name" class="form-control" 
                                           value="{{ old('name', $contact->name ?? '') }}" required>
                                    @error('name') <div class="text-danger small">{{ $message }}</div> @enderror
                                </div>

                                <div class="mb-10">
                                    <label class="form-label required">Telepon</label>
                                    <input type="text" name="telephon" class="form-control" 
                                           value="{{ old('telephon', $contact->telephon ?? '') }}" required>
                                    @error('telephon') <div class="text-danger small">{{ $message }}</div> @enderror
                                </div>

                                <div class="mb-10">
                                    <label class="form-label required">Email</label>
                                    <input type="email" name="email" class="form-control" 
                                           value="{{ old('email', $contact->email ?? '') }}" required>
                                    @error('email') <div class="text-danger small">{{ $message }}</div> @enderror
                                </div>

                                <div class="mb-10">
                                    <label class="form-label">Alamat</label>
                                    <textarea name="address" class="form-control" rows="3">{{ old('address', $contact->address ?? '') }}</textarea>
                                    @error('address') <div class="text-danger small">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <!-- Kolom Kanan -->
                            <div class="col-md-6">
                                <div class="mb-10">
                                    <label class="form-label">Facebook</label>
                                    <input type="url" name="facebook" class="form-control" 
                                           value="{{ old('facebook', $contact->facebook ?? '') }}" 
                                           placeholder="https://facebook.com/username">
                                    @error('facebook') <div class="text-danger small">{{ $message }}</div> @enderror
                                </div>

                                <div class="mb-10">
                                    <label class="form-label">Instagram</label>
                                    <input type="url" name="instagram" class="form-control" 
                                           value="{{ old('instagram', $contact->instagram ?? '') }}" 
                                           placeholder="https://instagram.com/username">
                                    @error('instagram') <div class="text-danger small">{{ $message }}</div> @enderror
                                </div>

                                <div class="mb-10">
                                    <label class="form-label">Twitter</label>
                                    <input type="url" name="twitter" class="form-control" 
                                           value="{{ old('twitter', $contact->twitter ?? '') }}" 
                                           placeholder="https://twitter.com/username">
                                    @error('twitter') <div class="text-danger small">{{ $message }}</div> @enderror
                                </div>

                                <div class="mb-10">
                                    <label class="form-label">Lokasi</label>
                                    <input type="text" name="location" class="form-control" 
                                           value="{{ old('location', $contact->location ?? '') }}">
                                    @error('location') <div class="text-danger small">{{ $message }}</div> @enderror
                                </div>

                                <div class="mb-10">
                                    <label class="form-label">Versi Aplikasi</label>
                                    <input type="text" name="aplication_version" class="form-control" 
                                           value="{{ old('aplication_version', $contact->aplication_version ?? '') }}" 
                                           placeholder="Contoh: v1.0.0">
                                    @error('aplication_version') <div class="text-danger small">{{ $message }}</div> @enderror
                                </div>

                                <div class="mb-10">
                                    <label class="form-label">Copyright</label>
                                    <input type="text" name="copyright" class="form-control" 
                                           value="{{ old('copyright', $contact->copyright ?? '') }}" 
                                           placeholder="Contoh: © 2024 Nama Perusahaan">
                                    @error('copyright') <div class="text-danger small">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="d-flex gap-3 mt-10">
                            <button class="btn btn-primary" type="submit">
                                {{ $contact ? 'Update Settings' : 'Create Settings' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-default-layout>