<x-default-layout>
    @section('title') edit link situs @endsection
    @section('breadcrumbs') {{ Breadcrumbs::render('linksite-management.index') }} @endsection

    <div class="card">
        <div class="card-body">
            <form action="{{ route('linksite-management.linksite.update', ['linksite' => $link->id]) }}" method="post">
                @csrf @method('PUT')
                @include('pages.apps.linksite.modals.form', ['mode' => 'edit'])
            </form>
        </div>
    </div>
</x-default-layout>