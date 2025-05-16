<?php

use App\Http\Controllers\ImageGenController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WalletController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/wallet', [WalletController::class, 'index'])->name('wallet.index');
    Route::post('/wallet/add', [WalletController::class, 'stripePost'])->name('wallet.add');

    Route::get('/image/generate', [ImageGenController::class, 'index'])->name('image.generate.index');
    Route::post('/image/generate/add', [ImageGenController::class, 'generateImage'])->name('image.generate.new');
});

require __DIR__.'/auth.php';
