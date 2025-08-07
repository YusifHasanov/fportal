<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\NewsController;
use App\Http\Controllers\Frontend\CategoryController;
use App\Http\Controllers\Frontend\VideoGalleryController;

// Frontend Routes
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::prefix('news')->name('news.')->group(function () {
    Route::get('/', [NewsController::class, 'index'])->name('index');
    Route::get('/{news:slug}', [NewsController::class, 'show'])->name('show');
});

Route::prefix('categories')->name('categories.')->group(function () {
    Route::get('/{category:slug}', [CategoryController::class, 'show'])->name('show');
});

Route::prefix('video-gallery')->name('frontend.video-gallery.')->group(function () {
    Route::get('/', [VideoGalleryController::class, 'index'])->name('index');
    Route::get('/{videoGallery}', [VideoGalleryController::class, 'show'])->name('show');
});



// SEO Routes
Route::get('/sitemap.xml', [App\Http\Controllers\SitemapController::class, 'index'])->name('sitemap');
Route::get('/robots.txt', [App\Http\Controllers\SitemapController::class, 'robots'])->name('robots');

// Storage route with CORS headers
Route::get('/storage/{path}', function ($path) {
    $file = storage_path('app/public/' . $path);
    
    if (!file_exists($file)) {
        abort(404);
    }
    
    $response = response()->file($file);
    $response->headers->set('Access-Control-Allow-Origin', '*');
    $response->headers->set('Access-Control-Allow-Methods', 'GET, OPTIONS');
    $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With');
    
    return $response;
})->where('path', '.*');
