<?php

use App\Http\Controllers\Website\BlogController;
use App\Http\Controllers\Website\ContactController;
use App\Http\Controllers\Website\HomeController;
use App\Http\Controllers\Website\NewsletterController;
use App\Http\Controllers\Website\PageController;
use App\Http\Controllers\Website\ServiceController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/new-website');

Route::get('/admin', function () {
    return auth()->check()
        ? redirect()->route('admin.dashboard')
        : redirect()->route('admin.login');
});

require __DIR__.'/admin.php';

Route::prefix('new-website')->name('website.')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
    Route::get('/services/{slug}', [ServiceController::class, 'show'])->name('services.show');
    Route::get('/about', [PageController::class, 'about'])->name('about');
    Route::get('/team', [PageController::class, 'team'])->name('team');
    Route::get('/contact', [PageController::class, 'contact'])->name('contact');
    Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
    Route::post('/newsletter', [NewsletterController::class, 'store'])->name('newsletter.store');
    Route::get('/pricing', [PageController::class, 'pricing'])->name('pricing');
    Route::get('/faq', [PageController::class, 'faq'])->name('faq');
    Route::get('/portfolio', [PageController::class, 'portfolio'])->name('portfolio');
    Route::get('/blog', [BlogController::class, 'index'])->name('blog');
    Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');
});
