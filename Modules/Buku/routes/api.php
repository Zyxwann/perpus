<?php

use Illuminate\Support\Facades\Route;
use Modules\Buku\Http\Controllers\Api\BukuApiController;

Route::prefix('v1')->group(function () {
  Route::get('/bukus', [BukuApiController::class, 'index']);
  Route::get('/bukus/{id}', [BukuApiController::class, 'show']);
    Route::post('/bukus', [BukuApiController::class, 'store']);
    Route::put('/bukus/{id}', [BukuApiController::class, 'update']);
    Route::delete('/bukus/{id}', [BukuApiController::class, 'destroy']);
});
