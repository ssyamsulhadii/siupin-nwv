<?php

use Illuminate\Support\Facades\Route;


Route::livewire('/', 'pages::beranda')->name('beranda');
Route::post('/keluar', function () {
    \Illuminate\Support\Facades\Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/masuk');
})->name('logout');
