<?php

use Illuminate\Support\Facades\Route;


Route::livewire('/', 'pages::beranda')->name('beranda');
Route::livewire('/masuk', 'pages::account.login')->name('login')->middleware('guest');
Route::livewire('/daftar', 'pages::account.register')->name('register')->middleware('guest');

Route::livewire('/jenis-pensiun', 'pages::jenis-pensiun')->name('jenis-pensiun')->middleware('auth');
Route::livewire('/jabatan-nominatif', 'pages::jabatan-nominatif')->name('jabatan-nominatif')->middleware('auth');
Route::livewire('/manajemen-user', 'pages::manajemen-user')->name('manajemen-user')->middleware('auth');

Route::livewire('/data-pemohon', 'pages::data-pemohon')->name('data-pemohon')->middleware('auth');
Route::livewire('/data-statistik', 'pages::data-statistik')->name('data-statistik')->middleware('auth');
Route::livewire('/dokumen-informasi', 'pages::dokumen-informasi')->name('dokumen-informasi')->middleware('auth');




Route::post('/keluar', function () {
    \Illuminate\Support\Facades\Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/masuk');
})->name('logout');
