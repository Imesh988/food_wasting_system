<?php

use App\Http\Controllers\BarcodeController;
use App\Http\Controllers\ExpirySmsController;
use App\Http\Controllers\ProfileController;
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
});

Route::get('/sms', [ExpirySmsController::class, 'index'])->name('sms.form');
Route::post('/sms/send', [ExpirySmsController::class, 'send'])->name('sms.send');

Route::view('/scan', 'scan');
Route::post('/scan-barcode', [BarcodeController::class,'scan'])->name('scan.barcode');

require __DIR__.'/auth.php';
