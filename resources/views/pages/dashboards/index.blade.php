<x-default-layout>

    @section('title')
        Dashboard
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('dashboard') }}
    @endsection

    <!--begin::Row-->
    <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
        <!--begin::Col-->
        <div class="col-md-6 col-lg-6 col-xl-6 col-xxl-3 mb-md-5 mb-xl-10">
            @include('pages/dashboards/cards/NewsCoun')
        </div>
        <!--end::Col-->
         <!--begin::Col-->
        <div class="col-md-6 col-lg-6 col-xl-6 col-xxl-3 mb-md-5 mb-xl-10">
           @include('pages/dashboards/cards/WebsiteVisitors')
        </div>
        <!--end::Col-->
        <!--begin::Col-->
        <div class="col-md-6 col-lg-6 col-xl-6 col-xxl-3 mb-md-5 mb-xl-10">
            @include('pages/dashboards/cards/TotalAnnouncements')
        </div>
        <!--end::Col-->
    </div>
    <!--end::Row-->
    <!--end::Container-->
    <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
        <!--begin::Row-->
        <div class="col-md-6 col-lg-6 col-xl-6 col-xxl-9">
            @include('pages/dashboards/cards/PopularNews')
        </div>
        <!--end::Row-->
    </div>
    <!--end::Row-->
</x-default-layout>
