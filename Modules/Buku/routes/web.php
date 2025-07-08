<?php

use Illuminate\Support\Facades\Route;
use Modules\Buku\Http\Controllers\BukuController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('bukus', BukuController::class)->names('buku');
});
