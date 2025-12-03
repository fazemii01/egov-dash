<x-default-layout>
    @section('title') update Service @endsection
    @section('breadcrumbs') {{ Breadcrumbs::render('service-management.index') }} @endsection

    <div class="card">
        <div class="card-body">
            <form action="{{ route('service-management.service.update', ['service' => $service->id]) }}" method="post" enctype="multipart/form-data">
                @csrf @method('PUT')
                @include('pages.apps.service.modals.form', ['mode' => 'edit'])
            </form>
        </div>
    </div>
</x-default-layout>