{{-- resources/views/pages/apps/announcements/columns/_actions.blade.php --}}
<div class="d-flex justify-content-end">
    <!--begin::Action menu-->
    <a href="#" class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
        Aksi
        <i class="ki-duotone ki-down fs-5 ms-1"></i>
    </a>
    <!--begin::Menu-->
    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
        <!--begin::Menu item-->
        <div class="menu-item px-3">
            <a href="#" class="menu-link px-3" data-bs-toggle="modal" data-bs-target="#viewAnnouncementsModal"
               data-kt-announcement-modal-action="view"
               data-announcement-id="{{ $announcement->id }}"
               data-announcement-title="{{ $announcement->title }}"
               data-announcement-file="{{ $announcement->file_path ? asset('storage/'.$announcement->file_path) : '' }}"
               data-announcement-published="{{ $announcement->published_at ? \Carbon\Carbon::parse($announcement->published_at)->format('M d, Y') : 'Belum Dipublikasi' }}"
               data-announcement-created="{{ \Carbon\Carbon::parse($announcement->created_at)->format('M d, Y') }}">
                Lihat
            </a>
        </div>
        <!--end::Menu item-->

        <!--begin::Menu item-->
        <div class="menu-item px-3">
            <a href="{{ route('announcements-management.announcements.edit', $announcement->id) }}" class="menu-link px-3">
                Edit
            </a>
        </div>
        <!--end::Menu item-->

        <!--begin::Menu item-->
        <div class="menu-item px-3">
            <form method="POST" action="{{ route('announcements-management.announcements.destroy', $announcement->id) }}" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="button" class="menu-link px-3 btn-delete" style="background: none; border: none; width: 100%; text-align: left;">
                    Hapus
                </button>
            </form>
        </div>
        <!--end::Menu item-->
    </div>
    <!--end::Menu-->
</div>
