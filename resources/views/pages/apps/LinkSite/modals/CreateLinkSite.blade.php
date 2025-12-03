<x-default-layout>
    @section('title') tambah link situs @endsection
    @section('breadcrumbs') {{ Breadcrumbs::render('linksite-management.index') }} @endsection

    <div class="card">
        <div class="card-body">
            <form action="{{ route('linksite-management.linksite.store') }}" method="post">
                @csrf
                @include('pages.apps.linksite.modals.form', ['mode' => 'create'])
            </form>
        </div>
    </div>
</x-default-layout>