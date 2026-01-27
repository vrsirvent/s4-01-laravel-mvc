<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [App\Http\Controllers\JukeboxController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::post('/jukebox/purchase-token', [App\Http\Controllers\JukeboxController::class, 'purchaseToken'])
    ->middleware(['auth', 'verified'])
    ->name('jukebox.purchase');

Route::post('/favorites/toggle', [App\Http\Controllers\FavoriteController::class, 'toggle'])
    ->middleware(['auth', 'verified'])
    ->name('favorites.toggle');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
Route::get('/song', function () {
    return view('song');
})->name('song');

Route::get('/artist', function () {
    return view('artist');
})->name('artist');

Route::get('/category', function () {
    return view('category');
})->name('category');

});

require __DIR__.'/auth.php';
