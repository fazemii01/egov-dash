<x-default-layout>
    @section('title') upload video @endsection
    @section('breadcrumbs') {{ Breadcrumbs::render('video-management.index') }} @endsection

    <div class="card">
        <div class="card-body">
            <form action="{{ route('video-management.video.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                @include('pages.apps.video.modals.form', ['mode' => 'create'])
            </form>
        </div>
    </div>
</x-default-layout>