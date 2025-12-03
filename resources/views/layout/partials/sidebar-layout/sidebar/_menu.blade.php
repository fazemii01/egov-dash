<!--begin::sidebar menu-->
<div class="app-sidebar-menu overflow-hidden flex-column-fluid">
    <!--begin::Menu wrapper-->
    <div id="kt_app_sidebar_menu_wrapper" class="app-sidebar-wrapper hover-scroll-overlay-y my-5" data-kt-scroll="true"
        data-kt-scroll-activate="true" data-kt-scroll-height="auto"
        data-kt-scroll-dependencies="#kt_app_sidebar_logo, #kt_app_sidebar_footer"
        data-kt-scroll-wrappers="#kt_app_sidebar_menu" data-kt-scroll-offset="5px" data-kt-scroll-save-state="true">
        <!--begin::Menu-->
        <div class="menu menu-column menu-rounded menu-sub-indention px-3 fw-semibold fs-6" id="#kt_app_sidebar_menu"
            data-kt-menu="true" data-kt-menu-expand="false">
            <!--begin:Menu item-->
            <div class="menu-item">
                <!--begin:Menu link-->
                <a class="menu-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                    <span class="menu-icon">
                        {!! getIcon('element-11', 'fs-2') !!}
                    </span>
                    <span class="menu-title">Dashboard</span>
                </a>
                <!--end:Menu link-->
            </div>
            <!--end:Menu item-->
            <!--begin:Menu item-->
            <div class="menu-item pt-5">
                <!--begin:Menu content-->
                <div class="menu-content">
                    <span class="menu-heading fw-bold text-uppercase fs-7">Aplikasi</span>
                </div>
                <!--end:Menu content-->
            </div>
            <!--end:Menu item-->

            {{-- begin:Menu Berita --}}
            <div class="menu-item">
                <a class="menu-link {{ request()->routeIs('news*') ? 'active' : '' }}" href="{{ route('news-management.news.index') }}">
                    <span class="menu-icon">
                        {!! getIcon('document', 'fs-2') !!}
                    </span>
                    <span class="menu-title">Berita</span>
                </a>
            </div>
            {{-- end:Menu Berita --}}

            {{-- begin:Menu Pengumuman --}}
            <div class="menu-item">
                <a class="menu-link {{ request()->routeIs('announcements*') ? 'active' : '' }}" href="{{ route('announcements-management.announcements.index') }}">
                    <span class="menu-icon">
                        {!! getIcon('notification', 'fs-2') !!}
                    </span>
                    <span class="menu-title">Pengumuman</span>
                </a>
            </div>
            {{-- end:Menu Pengumuman --}}

            {{-- begin:Menu Banner --}}
            <div class="menu-item">
                <a class="menu-link {{ request()->routeIs('banner*') ? 'active' : '' }}" href="{{ route('banner-management.banner.index') }}">
                    <span class="menu-icon">
                        {!! getIcon('picture', 'fs-2') !!}
                    </span>
                    <span class="menu-title">Banner</span>
                </a>
            </div>
            {{-- end:Menu Banner --}}

            {{-- begin:Menu Galeri --}}
            <div class="menu-item">
                <a class="menu-link {{ request()->routeIs('gallery*') ? 'active' : '' }}" href="{{ route('gallery-management.gallery.index') }}">
                    <span class="menu-icon">
                        {!! getIcon('grid-2', 'fs-2') !!}
                    </span>
                    <span class="menu-title">Galeri</span>
                </a>
            </div>
            {{-- end:Menu Galeri --}}

            {{-- begin:Menu Profil --}}
            <div class="menu-item">
                <a class="menu-link {{ request()->routeIs('profile*') ? 'active' : '' }}" href="{{ route('profile-management.profile.index') }}">
                    <span class="menu-icon">
                        {!! getIcon('badge', 'fs-2') !!}
                    </span>
                    <span class="menu-title">Profil</span>
                </a>
            </div>
            {{-- end:Menu Profil --}}

            {{-- begin:Menu Video --}}
            <div class="menu-item">
                <a class="menu-link {{ request()->routeIs('video*') ? 'active' : '' }}" href="{{ route('video-management.video.index') }}">
                    <span class="menu-icon">
                        {!! getIcon('monitor-mobile', 'fs-2') !!}
                    </span>
                    <span class="menu-title">Video</span>
                </a>
            </div>
            {{-- end:Menu Video --}}

            {{-- begin:Menu Layanan --}}
            <div class="menu-item">
                <a class="menu-link {{ request()->routeIs('service*') ? 'active' : '' }}" href="{{ route('service-management.service.index') }}">
                    <span class="menu-icon">
                        {!! getIcon('support-24', 'fs-2') !!}
                    </span>
                    <span class="menu-title">Layanan Publik</span>
                </a>
            </div>
            {{-- end:Menu Layanan --}}

            {{-- begin:Menu FAQ --}}
            <div class="menu-item">
                <a class="menu-link {{ request()->routeIs('faq*') ? 'active' : '' }}" href="{{ route('faq-management.faq.index') }}">
                    <span class="menu-icon">
                        {!! getIcon('question', 'fs-2') !!}
                    </span>
                    <span class="menu-title">FAQ</span>
                </a>
            </div>
            {{-- end:Menu FAQ --}}

            {{-- begin:Menu Tautan Situs --}}
            <div class="menu-item">
                <a class="menu-link {{ request()->routeIs('linksite*') ? 'active' : '' }}" href="{{ route('linksite-management.linksite.index') }}">
                    <span class="menu-icon">
                        {!! getIcon('share', 'fs-2') !!}
                    </span>
                    <span class="menu-title">Tautan Situs</span>
                </a>
            </div>
            {{-- end:Menu Tautan Situs --}}

            {{-- begin:Menu Kontak --}}
            <div class="menu-item">
                <a class="menu-link {{ request()->routeIs('contact*') ? 'active' : '' }}" href="{{ route('contact-management.contact.index') }}">
                    <span class="menu-icon">
                        {!! getIcon('message-text', 'fs-2') !!}
                    </span>
                    <span class="menu-title">Kontak</span>
                </a>
            </div>
            {{-- end:Menu Kontak --}}

            <!--begin:Menu item-->
            <div data-kt-menu-trigger="click"
                class="menu-item menu-accordion {{ request()->routeIs('user-management.*') ? 'here show' : '' }}">
                <!--begin:Menu link-->
                <span class="menu-link">
                    <span class="menu-icon">{!! getIcon('abstract-28', 'fs-2') !!}</span>
                    <span class="menu-title">Pengguna</span>
                    <span class="menu-arrow"></span>
                </span>
                <!--end:Menu link-->
                <!--begin:Menu sub-->
                <div class="menu-sub menu-sub-accordion">
                    <!--begin:Menu item-->
                    <div class="menu-item">
                        <!--begin:Menu link-->
                        <a class="menu-link {{ request()->routeIs('user-management.users.*') ? 'active' : '' }}"
                            href="{{ route('user-management.users.index') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Daftar Pengguna</span>
                        </a>
                        <!--end:Menu link-->
                    </div>
                    <!--end:Menu item-->
                    <!--begin:Menu item-->
                    <div class="menu-item">
                        <!--begin:Menu link-->
                        <a class="menu-link {{ request()->routeIs('user-management.roles.*') ? 'active' : '' }}"
                            href="{{ route('user-management.roles.index') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Peran</span>
                        </a>
                        <!--end:Menu link-->
                    </div>
                    <!--end:Menu item-->
                    <!--begin:Menu item-->
                    <div class="menu-item">
                        <!--begin:Menu link-->
                        <a class="menu-link {{ request()->routeIs('user-management.permissions.*') ? 'active' : '' }}"
                            href="{{ route('user-management.permissions.index') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Izin</span>
                        </a>
                        <!--end:Menu link-->
                    </div>
                    <!--end:Menu item-->
                </div>
                <!--end:Menu sub-->
            </div>
            <!--end:Menu item-->
            <!--begin:Menu item-->
            <div class="menu-item pt-5">
                <!--begin:Menu content-->
                <div class="menu-content">
                    <span class="menu-heading fw-bold text-uppercase fs-7">Bantuan</span>
                </div>
                <!--end:Menu content-->
            </div>
            <!--end:Menu item-->
            <!--begin:Menu item-->
            <div class="menu-item">
                <!--begin:Menu link-->
                <a class="menu-link" href="https://preview.keenthemes.com/html/metronic/docs/base/utilities"
                    target="_blank">
                    <span class="menu-icon">{!! getIcon('rocket', 'fs-2') !!}</span>
                    <span class="menu-title">Komponen</span>
                </a>
                <!--end:Menu link-->
            </div>
            <!--end:Menu item-->
            <!--begin:Menu item-->
            <div class="menu-item">
                <!--begin:Menu link-->
                <a class="menu-link" href="https://preview.keenthemes.com/laravel/metronic/docs" target="_blank">
                    <span class="menu-icon">{!! getIcon('abstract-26', 'fs-2') !!}</span>
                    <span class="menu-title">Dokumentasi</span>
                </a>
                <!--end:Menu link-->
            </div>
            <!--end:Menu item-->
            <!--begin:Menu item-->
            <div class="menu-item">
                <!--begin:Menu link-->
                <a class="menu-link" href="https://preview.keenthemes.com/laravel/metronic/docs/changelog"
                    target="_blank">
                    <span class="menu-icon">{!! getIcon('code', 'fs-2') !!}</span>
                    <span class="menu-title">Catatan Perubahan v8.2.0</span>
                </a>
                <!--end:Menu link-->
            </div>
            <!--end:Menu item-->
        </div>
        <!--end::Menu-->
    </div>
    <!--end::Menu wrapper-->
</div>
<!--end::sidebar menu-->
