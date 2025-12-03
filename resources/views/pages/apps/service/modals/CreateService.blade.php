<x-default-layout>
    @section('title') create service @endsection
    @section('breadcrumbs') {{ Breadcrumbs::render('service-management.index') }} @endsection

    <div class="card">
        <div class="card-body">
            <form action="{{ route('service-management.service.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                @include('pages.apps.service.modals.form', ['mode' => 'create'])
            </form>
        </div>
    </div>
</x-default-layout>