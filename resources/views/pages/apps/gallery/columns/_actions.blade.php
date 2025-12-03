{{-- resources/views/pages/apps/gallery/columns/_actions.blade.php --}}
<div class="d-flex justify-content-end">
    <!--begin::Action menu-->
    <a href="#" class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm"
       data-kt-menu-trigger="click"
       data-kt-menu-placement="bottom-end">
        Aksi
        <i class="ki-duotone ki-down fs-5 ms-1"></i>
    </a>

    <!--begin::Menu-->
    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4"
         data-kt-menu="true">

        <!--begin::Menu item - View-->
        <div class="menu-item px-3">
            <a href="#" class="menu-link px-3"
               data-bs-toggle="modal"
               data-bs-target="#viewGalleryModal"
               data-gallery-id="{{ $gallery->id }}"
               data-gallery-activity="{{ $gallery->activity }}"
               data-gallery-time="{{ \Carbon\Carbon::parse($gallery->time)->format('d M Y, h:i A') }}"
               data-gallery-place="{{ $gallery->place }}"
               data-gallery-photos-count="{{ $gallery->photos_count ?? 0 }}"
               data-gallery-created="{{ \Carbon\Carbon::parse($gallery->created_at)->format('d M Y, h:i A') }}"
               data-gallery-updated="{{ \Carbon\Carbon::parse($gallery->updated_at)->format('d M Y, h:i A') }}"
               @if($gallery->relationLoaded('photos') && $gallery->photos->count() > 0)
               data-gallery-photos="{{ $gallery->photos->take(6)->map(function($photo) {
                   return [
                       'photo_path' => asset('storage/' . $photo->photo),
                       'title_photo' => $photo->title_photo
                   ];
               })->toJson() }}"
               @endif>
                Lihat
            </a>
        </div>
        <!--end::Menu item-->

        <!--begin::Menu item - Edit-->
        <div class="menu-item px-3">
            <a href="{{ route('gallery-management.gallery.edit', $gallery->id) }}" class="menu-link px-3">
                Edit
            </a>
        </div>
        <!--end::Menu item-->

        <!--begin::Menu item - Delete-->
        <div class="menu-item px-3">
            <button type="button"
                    class="menu-link px-3 text-danger btn-delete-gallery"
                    style="background: none; border: none; width: 100%; text-align: left;"
                    data-id="{{ $gallery->id }}"
                    data-name="{{ $gallery->activity }}">
                Hapus
            </button>
        </div>
        <!--end::Menu item-->
    </div>
    <!--end::Menu-->
</div>
