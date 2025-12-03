<x-default-layout>
    @section('title') edit faq @endsection
    @section('breadcrumbs') {{ Breadcrumbs::render('faq-management.index') }} @endsection

    <div class="card">
        <div class="card-body">
            <form action="{{ route('faq-management.faq.update', ['faq' => $faq->id]) }}" method="post">
                @csrf @method('PUT')
                @include('pages.apps.faq.modals.form', ['mode' => 'edit'])
            </form>
        </div>
    </div>
</x-default-layout>