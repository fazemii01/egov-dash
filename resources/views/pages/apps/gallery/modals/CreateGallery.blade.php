<x-default-layout>
    @section('title') create gallery @endsection
    @section('breadcrumbs') {{ Breadcrumbs::render('gallery-management.index') }} @endsection

    <div class="card">
        <div class="card-body">
            <form action="{{ route('gallery-management.gallery.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                @include('pages.apps.gallery.modals.form', ['mode' => 'create'])
            </form>
        </div>
    </div>
</x-default-layout>