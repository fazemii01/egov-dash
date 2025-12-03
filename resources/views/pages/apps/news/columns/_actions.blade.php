{{-- resources/views/pages/apps/news/columns/_actions.blade.php --}}
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
            <a href="#" class="menu-link px-3" data-bs-toggle="modal" data-bs-target="#viewNewsModal"
               data-kt-news-modal-action="view"
               data-news-id="{{ $news->id }}"
               data-news-headline="{{ $news->headline }}"
               data-news-content="{{ $news->content }}"
               data-news-image="{{ $news->images ? asset('storage/'.$news->images) : '' }}"
               data-news-published="{{ $news->published_at ? $news->published_at->format('M d, Y') : 'Belum Dipublikasi' }}"
               data-news-created="{{ $news->created_at->format('M d, Y') }}">
                Lihat
            </a>
        </div>
        <!--end::Menu item-->

        <!--begin::Menu item-->
        <div class="menu-item px-3">
            <a href="{{ route('news-management.news.edit', $news->id) }}" class="menu-link px-3">
                Edit
            </a>
        </div>
        <!--end::Menu item-->

        <!--begin::Menu item-->
        <div class="menu-item px-3">
            <form method="POST" action="{{ route('news-management.news.destroy', $news->id) }}" class="d-inline">
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
