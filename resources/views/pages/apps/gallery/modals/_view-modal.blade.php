{{-- resources/views/pages/apps/gallery/modals/_view-modal.blade.php --}}
<div class="modal fade" id="viewGalleryModal" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-800px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header">
                <!--begin::Modal title-->
                <h2 class="fw-bold">Detail Gallery</h2>
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
                <!--begin::Gallery header-->
                <div class="text-center mb-10">
                    <!--begin::Photos Container-->
                    <div class="d-flex justify-content-center mb-7">
                        <div id="modal-gallery-photos" class="text-center">
                            <!-- Photos will be inserted here dynamically -->
                        </div>
                    </div>
                    <!--end::Photos Container-->

                    <!--begin::Title-->
                    <h1 id="modal-gallery-activity" class="text-gray-900 fw-bolder mb-3 fs-2hx"></h1>
                    <!--end::Title-->

                    <!--begin::Meta info-->
                    <div class="d-flex flex-wrap justify-content-center gap-4 mb-6">
                        <div class="d-flex align-items-center">
                            <i class="ki-duotone ki-calendar-8 fs-2 text-primary me-2"></i>
                            <span id="modal-gallery-time" class="text-gray-600 fw-semibold"></span>
                        </div>
                        <div class="d-flex align-items-center">
                            <i class="ki-duotone ki-geolocation fs-2 text-warning me-2"></i>
                            <span id="modal-gallery-place" class="text-gray-600 fw-semibold"></span>
                        </div>
                        <div class="d-flex align-items-center">
                            <i class="ki-duotone ki-image fs-2 text-success me-2"></i>
                            <span id="modal-gallery-photos-count" class="text-gray-600 fw-semibold"></span>
                        </div>
                    </div>
                    <!--end::Meta info-->

                    <!--begin::Timeline info-->
                    <div class="d-flex flex-wrap justify-content-center gap-5 text-gray-600 fw-semibold fs-6">
                        <div class="d-flex align-items-center">
                            <i class="ki-duotone ki-calendar-add fs-2 text-muted me-2"></i>
                            <span id="modal-gallery-created" class="text-muted"></span>
                        </div>
                        <div class="d-flex align-items-center">
                            <i class="ki-duotone ki-calendar-edit fs-2 text-muted me-2"></i>
                            <span id="modal-gallery-updated" class="text-muted"></span>
                        </div>
                    </div>
                    <!--end::Timeline info-->
                </div>
                <!--end::Gallery header-->

                <!--begin::Actions-->
                <div class="text-center pt-10">
                    <button type="button" class="btn btn-light me-3" data-bs-dismiss="modal">Tutup</button>
                    <a href="#" id="modal-gallery-edit-link" class="btn btn-primary">
                        <i class="ki-duotone ki-pencil fs-2 me-2">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                        Edit Gallery
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

<!-- Lightbox Modal -->
<div class="modal fade" id="lightboxModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-fullscreen">
        <div class="modal-content bg-dark">
            <div class="modal-header border-0">
                <button type="button" class="btn btn-icon btn-sm btn-active-icon-white" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ki-duotone ki-cross fs-1 text-white">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                </button>
            </div>
            <div class="modal-body d-flex align-items-center justify-content-center">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-10">
                            <div id="lightbox-carousel" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-inner" id="lightbox-carousel-inner">
                                    <!-- Carousel items will be inserted here -->
                                </div>
                                <button class="carousel-control-prev" type="button" data-bs-target="#lightbox-carousel" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#lightbox-carousel" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0 justify-content-center">
                <div class="text-white text-center">
                    <span id="lightbox-current-index">1</span> / <span id="lightbox-total-count">0</span>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    /* Gallery photos grid */
    .gallery-photos-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
        gap: 12px;
        max-width: 500px;
        margin: 0 auto;
    }

    .gallery-photo-item {
        position: relative;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }

    .gallery-photo-item:hover {
        transform: translateY(-4px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
    }

    .gallery-photo-item img {
        width: 100%;
        height: 100px;
        object-fit: cover;
        display: block;
    }

    .gallery-photo-count {
        position: absolute;
        top: 8px;
        right: 8px;
        background: rgba(0, 0, 0, 0.7);
        color: white;
        padding: 2px 8px;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: bold;
    }

    .gallery-photo-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(to top, rgba(0,0,0,0.7), transparent);
        color: white;
        padding: 8px;
        font-size: 0.7rem;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .gallery-photo-item:hover .gallery-photo-overlay {
        opacity: 1;
    }

    /* For single photo preview */
    #modal-gallery-photos img {
        max-height: 250px;
        max-width: 100%;
        border-radius: 8px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }

    /* Meta info styling - SAMA DENGAN BANNER */
    .modal-body .d-flex.align-items-center {
        padding: 8px 12px;
        background-color: #f8f9fa;
        border-radius: 6px;
    }

    /* Lightbox styles */
    .modal-fullscreen .modal-content {
        background-color: rgba(0, 0, 0, 0.95) !important;
    }

    .carousel-control-prev,
    .carousel-control-next {
        width: 60px;
        height: 60px;
        background-color: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        top: 50%;
        transform: translateY(-50%);
        margin: 0 20px;
        transition: all 0.3s ease;
    }

    .carousel-control-prev:hover,
    .carousel-control-next:hover {
        background-color: rgba(255, 255, 255, 0.2);
        transform: translateY(-50%) scale(1.1);
    }
</style>
@endpush
