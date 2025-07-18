<?php

use Illuminate\Support\Facades\Route;
use Modules\Member\Http\Controllers\MemberController;
// use Modules\Member\Http\Controllers\MemberLoginController;

// Route::get('/member/login', [MemberLoginController::class, 'showLoginForm'])->name('member.login');
// Route::post('/member/login', [MemberLoginController::class, 'login'])->name('member.login.submit');
// Route::get('/member/dashboard', [MemberLoginController::class, 'dashboard'])->name('member.dashboard');

// =============================
// 👤 PROTECTED ROUTES (butuh login)
// =============================
Route::middleware(['web'])->group(function () {


    // 👨‍💼 DASHBOARD
    Route::get('/dashboard-member', function () {
        return view('member::dashboard');
    })->name('member.dashboard');

    // 📚 DATA BUKU (aktifkan kalau modul Buku sudah siap)
    // Route::get('/data-buku', [BukuController::class, 'listBukuForMember'])->name('member.buku');

    // 📦 LOCAL CRUD
    Route::get('/member', [MemberController::class, 'index'])->name('member.index');
    Route::get('/member/create', [MemberController::class, 'create'])->name('member.create');
    Route::post('/member', [MemberController::class, 'store'])->name('member.store');
    Route::get('/member/{member}/edit', [MemberController::class, 'edit'])->name('member.edit');
    Route::put('/member/{member}', [MemberController::class, 'update'])->name('member.update');
    Route::delete('/member/{member}', [MemberController::class, 'destroy'])->name('member.destroy');

    // 🌐 CONSUME API
    Route::middleware(['web'])->group(function () {
        Route::get('/member/api', [MemberController::class, 'getMembersFromApi'])->name('member.api.index');
        Route::get('/member/api/create', fn() => view('member::create_api'))->name('member.api.create.form');
        Route::post('/member/api/create', [MemberController::class, 'createMemberApi'])->name('member.api.create');
        Route::get('/member/api/edit/{id}', [MemberController::class, 'editMemberApi'])->name('member.api.edit.form');
        Route::post('/member/api/update/{id}', [MemberController::class, 'updateMemberApi'])->name('member.api.update');
        Route::delete('/member/api/delete/{id}', [MemberController::class, 'deleteMemberApi'])->name('member.api.delete');
    });

});
