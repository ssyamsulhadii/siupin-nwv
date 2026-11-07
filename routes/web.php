<?php

use Illuminate\Support\Facades\Route;


Route::livewire('/', 'pages::beranda')->name('beranda');
Route::livewire('/masuk', 'pages::account.login')->name('login')->middleware('guest');
Route::livewire('/daftar', 'pages::account.register')->name('register')->middleware('guest');


Route::middleware(['auth', 'level:admin'])->group(function () {
    Route::livewire('/rumpun-jabatan', 'pages::rumpun-jabatan')->name('rumpun-jabatan');
    Route::livewire('/jenis-pensiun', 'pages::jenis-pensiun')->name('jenis-pensiun');
    Route::livewire('/manajemen-user', 'pages::manajemen-user')->name('manajemen-user');

    Route::livewire('/data-pemohon', 'pages::data-pemohon')->name('data-pemohon');
    Route::livewire('/data-statistik', 'pages::data-statistik')->name('data-statistik');
    Route::livewire('/dokumen-pendukung', 'pages::dokumen-pendukung')->name('dokumen-pendukung');
});
Route::livewire('/usul-pensiun', 'pages::usul-pensiun.create')->name('usul-pensiun.create');




Route::post('/keluar', function () {
    \Illuminate\Support\Facades\Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/masuk');
})->name('logout');
