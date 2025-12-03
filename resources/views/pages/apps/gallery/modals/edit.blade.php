<x-default-layout>
    @section('title') update Gallery @endsection
    @section('breadcrumbs') {{ Breadcrumbs::render('gallery-management.index') }} @endsection

    <div class="card">
        <div class="card-body">
            <form action="{{ route('gallery-management.gallery.update', ['gallery' => $gallery->id]) }}" method="post" enctype="multipart/form-data">
                @csrf @method('PUT')
                @include('pages.apps.gallery.modals.form', ['mode' => 'edit'])
            </form>
        </div>
    </div>
</x-default-layout>