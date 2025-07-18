<?php

use Illuminate\Support\Facades\Route;
use Modules\Member\Http\Controllers\Api\MemberApiController;

Route::prefix('members')->group(function () {
    Route::get('/', [MemberApiController::class, 'index']);
    Route::get('/{id}', [MemberApiController::class, 'show']);
    Route::post('/', [MemberApiController::class, 'store']);
    Route::put('/{id}', [MemberApiController::class, 'update']);
    Route::delete('/{id}', [MemberApiController::class, 'destroy']);
    Route::get('/search/query', [MemberApiController::class, 'search']);
    Route::post('/{id}/restore', [MemberApiController::class, 'restore']);
});