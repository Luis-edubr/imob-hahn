<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\PropertyController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AnuncieController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/contato', [ContactController::class, 'show'])->name('contact.show');
Route::post('/contato', [ContactController::class, 'store'])->name('contact.store');

Route::get('/anuncie', [AnuncieController::class, 'show'])->name('anuncie.show');
Route::post('/anuncie', [AnuncieController::class, 'store'])->name('anuncie.store');

Route::get('/busca', [SearchController::class, 'index'])->name('search.index');
Route::get('/media/{mediaAsset}', [MediaController::class, 'show'])->middleware('signed')->name('media.show');
Route::get('/media/{mediaAsset}/download', [MediaController::class, 'download'])->middleware('signed')->name('media.download');

Route::prefix('admin')->group(function () {
    Route::middleware(['auth', 'verified'])->group(function () {
        Route::get('/', function () {
            return view('dashboard');
        })->name('dashboard');

        Route::prefix('imoveis')->name('admin.properties.')->group(function () {
            Route::get('/', [PropertyController::class, 'index'])->name('index');
            Route::get('/novo', [PropertyController::class, 'create'])->name('create');
            Route::post('/', [PropertyController::class, 'store'])->name('store');
            Route::get('/{property}', [PropertyController::class, 'show'])->name('show');
            Route::get('/{property}/editar', [PropertyController::class, 'edit'])->name('edit');
            Route::match(['put', 'patch'], '/{property}', [PropertyController::class, 'update'])->name('update');
            Route::delete('/{property}', [PropertyController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('terrenos')->name('admin.lands.')->group(function () {
            Route::get('/', [PropertyController::class, 'landsIndex'])->name('index');
            Route::get('/novo', [PropertyController::class, 'landsCreate'])->name('create');
            Route::post('/', [PropertyController::class, 'landsStore'])->name('store');
            Route::get('/{property}', [PropertyController::class, 'landsShow'])->name('show');
            Route::get('/{property}/editar', [PropertyController::class, 'landsEdit'])->name('edit');
            Route::match(['put', 'patch'], '/{property}', [PropertyController::class, 'landsUpdate'])->name('update');
            Route::delete('/{property}', [PropertyController::class, 'landsDestroy'])->name('destroy');
        });

        Route::prefix('galeria')->name('admin.gallery.')->group(function () {
            Route::get('/', [GalleryController::class, 'index'])->name('index');
            Route::get('/{property}', [GalleryController::class, 'show'])->name('show');
        });
    });

    Route::redirect('/dashboard', '/admin');

    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

    require __DIR__.'/auth.php';
});
