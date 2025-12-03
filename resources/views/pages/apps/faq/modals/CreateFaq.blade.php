<x-default-layout>
    @section('title') buat faq @endsection
    @section('breadcrumbs') {{ Breadcrumbs::render('faq-management.index') }} @endsection

    <div class="card">
        <div class="card-body">
            <form action="{{ route('faq-management.faq.store') }}" method="post">
                @csrf
                @include('pages.apps.faq.modals.form', ['mode' => 'create'])
            </form>
        </div>
    </div>
</x-default-layout>