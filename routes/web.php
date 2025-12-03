<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\LinkSiteController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AnnouncementsController;
use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\Apps\RoleManagementController;
use App\Http\Controllers\Apps\UserManagementController;
use App\Http\Controllers\Apps\PermissionManagementController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/index', function () {
    return view('/pages.landing.index');
});
Route::get('/layanan', function () {
    return view('/pages.landing.layanan');
});
Route::get('/layanan', function () {
    return view('pages.landing.layanan'); 
})->name('landing.layanan');
Route::get('/index', function () {
    return view('pages.landing.index'); 
})->name('landing.index');
Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/', [DashboardController::class, 'index']);

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::name('user-management.')->group(function () {
        Route::resource('/user-management/users', UserManagementController::class);
        Route::resource('/user-management/roles', RoleManagementController::class);
        Route::resource('/user-management/permissions', PermissionManagementController::class);
    });

    Route::name('news-management.')->group(function () {
        Route::resource('/news-management/news', NewsController::class);
    });

    Route::name('announcements-management.')->group(function () {
        Route::resource('/announcements-management/announcements', AnnouncementsController::class);
    });

    Route::name('gallery-management.')->group(function () {
        Route::resource('/gallery-management/gallery', GalleryController::class);
    });

    Route::name('service-management.')->group(function () {
        Route::resource('/service-management/service', ServiceController::class);
    });

    Route::name('gallery-management.')->group(function () {
        Route::resource('/gallery-management/gallery', GalleryController::class);
        Route::delete('/gallery-management/gallery/photo/{id}', [GalleryController::class, 'deletePhoto'])->name('gallery.photo.destroy');
        // Route tambahan untuk photos
        Route::get('gallery/{gallery}/photos', [GalleryController::class, 'photos'])
            ->name('gallery.photos');

        Route::post('gallery/{gallery}/photos', [GalleryController::class, 'storePhotos'])
            ->name('gallery.photos.store');

        Route::delete('gallery/photo/{photo}', [GalleryController::class, 'deletePhoto'])
            ->name('gallery.photo.destroy');
    });

    Route::name('profile-management.')->group(function () {
        Route::resource('/profile-management/profile', ProfileController::class);
    });

    Route::name('video-management.')->group(function () {
        Route::resource('/video-management/video', VideoController::class);
    });

    Route::name('banner-management.')->group(function () {
        Route::resource('/banner-management/banner', BannerController::class);
    });

    Route::name('faq-management.')->group(function () {
        Route::resource('/faq-management/faq', FaqController::class);
    });

    Route::name('linksite-management.')->group(function () {
        Route::resource('/linksite-management/linksite', LinkSiteController::class);
    });

    Route::name('contact-management.')->group(function () {
        Route::get('/contact-management/contact', [ContactController::class, 'index'])->name('contact.index');
        Route::post('/contact-management/contact', [ContactController::class, 'store'])->name('contact.store');
    });
});

Route::get('/error', function () {
    abort(500);
});

Route::get('/auth/redirect/{provider}', [SocialiteController::class, 'redirect']);

require __DIR__ . '/auth.php';
