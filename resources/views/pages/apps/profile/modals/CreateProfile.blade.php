<x-default-layout>
    @section('title') create profile @endsection
    @section('breadcrumbs') {{ Breadcrumbs::render('profile-management.index') }} @endsection

    <div class="card">
        <div class="card-body">
            <form action="{{ route('profile-management.profile.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                @include('pages.apps.profile.modals.form', ['mode' => 'create'])
            </form>
        </div>
    </div>
</x-default-layout>