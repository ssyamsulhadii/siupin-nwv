<?php

use Illuminate\Support\Facades\Route;


Route::livewire('/masuk', 'pages::account.login')->name('login')->middleware('guest');
Route::livewire('/daftar', 'pages::account.register')->name('register')->middleware('guest');
Route::livewire('/', 'pages::beranda')->name('beranda');
Route::livewire('/jenis-pensiun', 'pages::jenis-pensiun')->name('jenis-pensiun')->middleware('auth');




Route::post('/keluar', function () {
    \Illuminate\Support\Facades\Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/masuk');
})->name('logout');
