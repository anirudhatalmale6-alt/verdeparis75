<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\BeforeAfterController;
use App\Http\Controllers\Admin\PhotoController;
use App\Http\Controllers\Admin\VideoController;
use App\Http\Controllers\Admin\PartnerController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\LegalPageController;
use App\Http\Controllers\Admin\SeoController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\HomepageController;
use App\Http\Controllers\Admin\AnalyticsController;
use App\Http\Controllers\Admin\BackupController;
use App\Http\Controllers\Admin\SecurityController;
use App\Http\Controllers\Admin\TestimonialController;
use Illuminate\Support\Facades\Route;

Route::middleware(['web', 'auth'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('services', ServiceController::class);
    Route::resource('projects', ProjectController::class);
    Route::post('projects/{project}/images', [ProjectController::class, 'addImage'])->name('projects.add-image');
    Route::delete('projects/images/{image}', [ProjectController::class, 'removeImage'])->name('projects.remove-image');

    Route::resource('before-after', BeforeAfterController::class);
    Route::resource('photos', PhotoController::class);
    Route::post('photos/bulk', [PhotoController::class, 'storeBulk'])->name('photos.bulk');
    Route::resource('videos', VideoController::class);
    Route::resource('partners', PartnerController::class);
    Route::resource('testimonials', TestimonialController::class);

    Route::get('messages', [ContactController::class, 'index'])->name('messages.index');
    Route::get('messages/{message}', [ContactController::class, 'show'])->name('messages.show');
    Route::delete('messages/{message}', [ContactController::class, 'destroy'])->name('messages.destroy');

    Route::resource('legal-pages', LegalPageController::class);

    Route::get('seo', [SeoController::class, 'index'])->name('seo.index');
    Route::get('seo/{page}', [SeoController::class, 'edit'])->name('seo.edit');
    Route::put('seo/{page}', [SeoController::class, 'update'])->name('seo.update');

    Route::get('settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::put('settings', [SettingsController::class, 'update'])->name('settings.update');

    Route::get('homepage', [HomepageController::class, 'index'])->name('homepage.index');
    Route::get('homepage/{section}', [HomepageController::class, 'edit'])->name('homepage.edit');
    Route::put('homepage/{section}', [HomepageController::class, 'update'])->name('homepage.update');

    Route::get('analytics', [AnalyticsController::class, 'index'])->name('analytics.index');

    Route::get('backups', [BackupController::class, 'index'])->name('backups.index');
    Route::post('backups', [BackupController::class, 'create'])->name('backups.create');
    Route::get('backups/{backup}/download', [BackupController::class, 'download'])->name('backups.download');
    Route::delete('backups/{backup}', [BackupController::class, 'destroy'])->name('backups.destroy');

    Route::get('security', [SecurityController::class, 'index'])->name('security.index');
});
