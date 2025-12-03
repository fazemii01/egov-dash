<?php

use App\Models\User;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;
use Spatie\Permission\Models\Role;

// Dashboard (sebagai root)
Breadcrumbs::for('dashboard', function (BreadcrumbTrail $trail) {
    $trail->push('Dashboard', route('dashboard'));
});

// Dashboard > Galeri
Breadcrumbs::for('gallery-management.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Manajemen Galeri', route('gallery-management.gallery.index'));
});

// Dashboard > Galeri (Index)
Breadcrumbs::for('gallery-management.gallery.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Galeri', route('gallery-management.gallery.index'));
});

// Dashboard > Galeri > Tambah Gallery
Breadcrumbs::for('gallery-management.gallery.create', function (BreadcrumbTrail $trail) {
    $trail->parent('gallery-management.gallery.index');
    $trail->push('Tambah Gallery', route('gallery-management.gallery.create'));
});

// Dashboard > Galeri > Detail Gallery
Breadcrumbs::for('gallery-management.gallery.show', function (BreadcrumbTrail $trail, $gallery) {
    $trail->parent('gallery-management.gallery.index');
    $trail->push('Detail Gallery', route('gallery-management.gallery.show', $gallery));
});

// Dashboard > Galeri > Edit Gallery
Breadcrumbs::for('gallery-management.gallery.edit', function (BreadcrumbTrail $trail, $gallery) {
    $trail->parent('gallery-management.gallery.index');
    $trail->push('Edit Gallery', route('gallery-management.gallery.edit', $gallery));
});


// Dashboard > Layanan
Breadcrumbs::for('service-management.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Manajemen Layanan', route('service-management.service.index'));
});

// Dashboard > Banner
Breadcrumbs::for('banner-management.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Manajemen Banner', route('banner-management.banner.index'));
});

// Dashboard > Banner > Tambah Banner
Breadcrumbs::for('banner-management.banner.create', function (BreadcrumbTrail $trail) {
    $trail->parent('banner-management.index');
    $trail->push('Tambah Banner', route('banner-management.banner.create'));
});

// Dashboard > Banner > Edit Banner
Breadcrumbs::for('banner-management.banner.edit', function (BreadcrumbTrail $trail, $banner) {
    $trail->parent('banner-management.index');
    $trail->push('Edit Banner', route('banner-management.banner.edit', $banner));
});
// Dashboard > Berita
Breadcrumbs::for('news-management.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Manajemen Berita', route('news-management.news.index'));
});

// Dashboard > Manajemen Berita > Buat Berita
Breadcrumbs::for('news-management.create', function (BreadcrumbTrail $trail) {
    $trail->parent('news-management.index');
    $trail->push('Buat Berita', route('news-management.news.create'));
});

// Dashboard > Manajemen Berita > Edit Berita
Breadcrumbs::for('news-management.edit', function (BreadcrumbTrail $trail, $id) {
    $trail->parent('news-management.index');
    $trail->push('Edit Berita', route('news-management.news.edit', $id));
});

// Dashboard > Profil
Breadcrumbs::for('profile-management.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Manajemen Profil', route('profile-management.profile.index'));
});

// Dashboard > Video
Breadcrumbs::for('video-management.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Manajemen Video', route('video-management.video.index'));
});

// Dashboard > Pengumuman
Breadcrumbs::for('announcements-management.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Manajemen Pengumuman', route('announcements-management.announcements.index'));
});

// Dashboard > Manajemen Pengumuman > Buat Pengumuman
Breadcrumbs::for('announcements-management.create', function (BreadcrumbTrail $trail) {
    $trail->parent('announcements-management.index');
    $trail->push('Buat Pengumuman', route('announcements-management.announcements.create'));
});

// Dashboard > Manajemen Pengumuman > Edit Pengumuman
Breadcrumbs::for('announcements-management.edit', function (BreadcrumbTrail $trail, $id) {
    $trail->parent('announcements-management.index');
    $trail->push('Edit Pengumuman', route('announcements-management.announcements.edit', $id));
});

// Dashboard > FAQ
Breadcrumbs::for('faq-management.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Manajemen FAQ', route('faq-management.faq.index'));
});

// Dashboard > Manajemen Pengguna
Breadcrumbs::for('user-management.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Manajemen Pengguna', route('user-management.users.index'));
});

// Dashboard > Manajemen Tautan Situs
Breadcrumbs::for('linksite-management.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Manajemen Tautan Situs', route('linksite-management.linksite.index'));
});

// Dashboard > Manajemen Kontak
Breadcrumbs::for('contact-management.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Manajemen Kontak', route('contact-management.contact.index'));
});

// Dashboard > Manajemen Pengguna > Pengguna
Breadcrumbs::for('user-management.users.index', function (BreadcrumbTrail $trail) {
    $trail->parent('user-management.index');
    $trail->push('Daftar Pengguna', route('user-management.users.index'));
});

// Dashboard > Manajemen Pengguna > Pengguna > [User]
Breadcrumbs::for('user-management.users.show', function (BreadcrumbTrail $trail, User $user) {
    $trail->parent('user-management.users.index');
    $trail->push(ucwords($user->name), route('user-management.users.show', $user));
});

// Dashboard > Manajemen Pengguna > Peran
Breadcrumbs::for('user-management.roles.index', function (BreadcrumbTrail $trail) {
    $trail->parent('user-management.index');
    $trail->push('Daftar Peran', route('user-management.roles.index'));
});

// Dashboard > Manajemen Pengguna > Peran > [Role]
Breadcrumbs::for('user-management.roles.show', function (BreadcrumbTrail $trail, Role $role) {
    $trail->parent('user-management.roles.index');
    $trail->push(ucwords($role->name), route('user-management.roles.show', $role));
});

// Dashboard > Manajemen Pengguna > Izin
Breadcrumbs::for('user-management.permissions.index', function (BreadcrumbTrail $trail) {
    $trail->parent('user-management.index');
    $trail->push('Daftar Izin', route('user-management.permissions.index'));
});
