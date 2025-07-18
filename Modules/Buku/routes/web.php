<?php

use Illuminate\Support\Facades\Route;
use Modules\Buku\Http\Controllers\BukuController;


// API route
Route::get('/buku/external', [BukuController::class, 'fetchExternalBooks'])->name('buku.external');
Route::get('/buku/external/create', function() { return view('buku::create_external'); })->name('buku.external.create');
Route::post('/buku/external/create', [BukuController::class, 'createExternal'])->name('buku.external.store');
Route::get('/buku/external/edit/{id}', [BukuController::class, 'editExternal'])->name('buku.external.edit');
Route::put('/buku/external/update/{id}', [BukuController::class, 'updateExternal'])->name('buku.external.update');
Route::delete('/buku/external/delete/{id}', [BukuController::class, 'deleteExternal'])->name('buku.external.delete');

// local crud
Route::get('/buku', [BukuController::class, 'index'])->name('buku.index'); 
Route::get('/buku/create', [BukuController::class, 'create'])->name('buku.create');
Route::post('/buku', [BukuController::class, 'store'])->name('buku.store');
Route::get('/buku/{id}', [BukuController::class, 'show'])
    ->whereNumber('id')     // ⬅️ hanya angka
    ->name('buku.show');
Route::get('/buku/{id}/edit', [BukuController::class, 'edit'])->name('buku.edit');
Route::put('/buku/{id}', [BukuController::class, 'update'])->name('buku.update');
Route::delete('/buku/{id}', [BukuController::class, 'destroy'])->name('buku.destroy');
