<x-default-layout>
    @section('title') Edit Video @endsection
    @section('breadcrumbs') {{ Breadcrumbs::render('video-management.index') }} @endsection

    <div class="card">
        <div class="card-body">
            <form action="{{ route('video-management.video.update', ['video' => $video->id]) }}" method="post" enctype="multipart/form-data">
                @csrf @method('PUT')
                @include('pages.apps.video.modals.form', ['mode' => 'edit'])
            </form>
        </div>
    </div>
</x-default-layout>