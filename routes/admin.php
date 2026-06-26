<?php

use App\Http\Controllers\Admin\BlogCategoryController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\ContactSubmissionController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\NewsletterSubscriberController;
use App\Http\Controllers\Admin\SeoController;
use App\Http\Controllers\Admin\SiteSettingController;
use App\Http\Controllers\Admin\TeamMemberController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('login', [DashboardController::class, 'showLogin'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store'])->name('login.store');
});

Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
    Route::get('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout.get');
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('users', UserController::class)->except(['show']);
    Route::resource('blog-categories', BlogCategoryController::class)->except(['show']);
    Route::resource('blogs', BlogController::class)->except(['show']);
    Route::resource('team', TeamMemberController::class)->except(['show'])->parameters(['team' => 'team']);
    Route::resource('faqs', FaqController::class)->except(['show']);
    Route::resource('contacts', ContactSubmissionController::class)->only(['index', 'show', 'update', 'destroy']);
    Route::get('newsletter-subscribers', [NewsletterSubscriberController::class, 'index'])->name('newsletter-subscribers.index');

    Route::get('settings', [SiteSettingController::class, 'edit'])->name('settings.edit');
    Route::put('settings', [SiteSettingController::class, 'update'])->name('settings.update');

    Route::get('seo', [SeoController::class, 'index'])->name('seo.index');
    Route::get('seo/create', [SeoController::class, 'create'])->name('seo.create');
    Route::post('seo', [SeoController::class, 'store'])->name('seo.store');
    Route::get('seo/{seoMeta}/edit', [SeoController::class, 'edit'])->name('seo.edit');
    Route::put('seo/{seoMeta}', [SeoController::class, 'update'])->name('seo.update');
    Route::post('seo/{seoMeta}/generate-schema', [SeoController::class, 'generateSchema'])->name('seo.generate-schema');
});
