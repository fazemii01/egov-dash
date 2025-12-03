<x-default-layout>
    @section('title') Edit Profile @endsection
    @section('breadcrumbs') {{ Breadcrumbs::render('profile-management.index') }} @endsection

    <div class="card">
        <div class="card-body">
            <form action="{{ route('profile-management.profile.update', ['profile' => $profile->id]) }}" method="post" enctype="multipart/form-data">
                @csrf @method('PUT')
                @include('pages.apps.profile.modals.form', ['mode' => 'edit'])
            </form>
        </div>
    </div>
</x-default-layout>