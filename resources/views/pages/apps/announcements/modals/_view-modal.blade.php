{{-- resources/views/pages/apps/announcements/modals/_view-modal.blade.php --}}
<div class="modal fade" id="viewAnnouncementsModal" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-900px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header">
                <!--begin::Modal title-->
                <h2 class="fw-bold">Detail Pengumuman</h2>
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
                <!--begin::Announcement header-->
                <div class="text-center mb-10">
                    <!--begin::File Container-->
                    <div class="d-flex justify-content-center mb-7">
                        <div id="modal-announcement-file" style="display: none;"></div>
                    </div>
                    <!--end::File Container-->

                    <!--begin::Title-->
                    <h1 id="modal-announcement-title" class="text-gray-900 fw-bolder mb-3 fs-2hx"></h1>
                    <!--end::Title-->

                    <!--begin::Meta info-->
                    <div class="text-gray-600 fw-semibold fs-6">
                        <span id="modal-announcement-published" class="badge badge-light-success me-2"></span>
                        <span id="modal-announcement-created" class="text-muted"></span>
                    </div>
                    <!--end::Meta info-->
                </div>
                <!--end::Announcement header-->

                <!--begin::Actions-->
                <div class="text-center pt-15">
                    <button type="button" class="btn btn-light me-3" data-bs-dismiss="modal">Tutup</button>
                    <a href="#" id="modal-edit-link" class="btn btn-primary">
                        <i class="ki-duotone ki-pencil fs-2 me-2">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                        Edit Pengumuman
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
