<?php

use Illuminate\Support\Facades\Route;
use Modules\Member\Http\Controllers\MemberController;

Route::middleware(['web'])->group(function () {
    Route::get('/member', [MemberController::class, 'index'])->name('member.index');
    Route::get('/member/create', [MemberController::class, 'create'])->name('member.create');
    Route::post('/member', [MemberController::class, 'store'])->name('member.store');
    Route::get('/member/{member}/edit', [MemberController::class, 'edit'])->name('member.edit');
    Route::put('/member/{member}', [MemberController::class, 'update'])->name('member.update');
    Route::delete('/member/{member}', [MemberController::class, 'destroy'])->name('member.destroy');
    // dan route edit/update/delete lainnya kalau perlu
});
