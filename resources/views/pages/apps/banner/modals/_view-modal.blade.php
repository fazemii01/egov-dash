{{-- resources/views/pages/apps/banner/modals/_view-modal.blade.php --}}
<div class="modal fade" id="viewBannerModal" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-900px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header">
                <!--begin::Modal title-->
                <h2 class="fw-bold">Detail Banner</h2>
                <!--end::Modal title-->
                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ki-duotone ki-cross fs-1">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                </div>
                <!--end::Close-->
            </div>
            <!--end::Modal header-->
            <!--begin::Modal body-->
            <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                <!--begin::Banner header-->
                <div class="text-center mb-10">
                    <!--begin::Image Container-->
                    <div class="d-flex justify-content-center mb-7">
                        <div id="modal-banner-file" class="text-center">
                            <!-- Image will be inserted here dynamically -->
                        </div>
                    </div>
                    <!--end::Image Container-->

                    <!--begin::Title-->
                    <h1 id="modal-banner-title" class="text-gray-900 fw-bolder mb-3 fs-2hx"></h1>
                    <!--end::Title-->

                    <!--begin::Meta info-->
                    <div class="d-flex flex-wrap justify-content-center gap-4 mb-6">
                        <div class="d-flex align-items-center">
                            <i class="ki-duotone ki-link fs-2 text-primary me-2"></i>
                            <span id="modal-banner-link" class="text-gray-600 fw-semibold"></span>
                        </div>
                        <div class="d-flex align-items-center">
                            <i class="ki-duotone ki-sort-numeric-asc fs-2 text-warning me-2"></i>
                            <span id="modal-banner-order" class="text-gray-600 fw-semibold"></span>
                        </div>
                        <div class="d-flex align-items-center">
                            <i class="ki-duotone ki-status-on fs-2 text-success me-2"></i>
                            <span id="modal-banner-status" class="text-gray-600 fw-semibold"></span>
                        </div>
                    </div>
                    <!--end::Meta info-->

                    <!--begin::Timeline info-->
                    <div class="d-flex flex-wrap justify-content-center gap-5 text-gray-600 fw-semibold fs-6">
                        <div class="d-flex align-items-center">
                            <i class="ki-duotone ki-calendar-8 fs-2 text-muted me-2"></i>
                            <span id="modal-banner-created" class="text-muted"></span>
                        </div>
                        <div class="d-flex align-items-center">
                            <i class="ki-duotone ki-refresh fs-2 text-muted me-2"></i>
                            <span id="modal-banner-updated" class="text-muted"></span>
                        </div>
                    </div>
                    <!--end::Timeline info-->
                </div>
                <!--end::Banner header-->


                <!--begin::Actions-->
                <div class="text-center pt-10">
                    <button type="button" class="btn btn-light me-3" data-bs-dismiss="modal">Tutup</button>
                    <a href="#" id="modal-edit-link" class="btn btn-primary">
                        <i class="ki-duotone ki-pencil fs-2 me-2">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                        Edit Banner
                    </a>
                </div>
                <!--end::Actions-->
            </div>
            <!--end::Modal body-->
        </div>
        <!--end::Modal content-->
    </div>
    <!--end::Modal dialog-->
</div>

@push('styles')
<style>
    #modal-banner-file img {
        max-height: 300px;
        max-width: 100%;
        border-radius: 8px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }

    .modal-body .d-flex.align-items-center {
        padding: 8px 12px;
        background-color: #f8f9fa;
        border-radius: 6px;
    }

</style>
@endpush


