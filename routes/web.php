<?php

use Illuminate\Support\Facades\Route;

Route::livewire('/', 'pages::beranda')->name('beranda');
Route::livewire('/masuk', 'pages::account.login')->name('login')->middleware('guest');
Route::livewire('/daftar', 'pages::account.register')->name('register')->middleware('guest');


Route::middleware(['auth', 'level:admin'])->group(function () {
    Route::livewire('/data-pemohon', 'pages::data-pemohon')->name('data-pemohon');
    Route::livewire('/jenis-pensiun', 'pages::jenis-pensiun')->name('jenis-pensiun');
    Route::livewire('/rumpun-jabatan', 'pages::rumpun-jabatan')->name('rumpun-jabatan');
    Route::livewire('/manajemen-user', 'pages::manajemen-user')->name('manajemen-user');
    Route::livewire('/progres-usul', 'pages::progres-usul')->name('progres-usul');
    Route::livewire('/dokumen-pendukung', 'pages::dokumen-pendukung')->name('dokumen-pendukung');
});

Route::middleware(['auth', 'level:member'])->group(function () {
    Route::livewire('/usul-pensiun/create', 'pages::usul-pensiun.create')->name('usul-pensiun.create');
    Route::livewire('/usul-pensiun/{pegawai}/detail-usulan', 'pages::usul-pensiun.detail-usulan')->name('usul-pensiun.detail_usulan');
});

Route::get('test', function () {
    //  1. Ambil semua data user (hanya kolom id dan username/nip untuk efisiensi)
    $users = \App\Models\User::select('id', 'username')->get();
    $updatedCount = 0;
    // 2. Lakukan perulangan untuk setiap user
    foreach ($users as $user) {
        // 3. Cari data pegawai yang kolom nip-nya sama dengan username user, lalu update user_id-nya
        $affected = \App\Models\Pegawai::where('nip', $user->username)
            ->update(['user_id' => $user->id]);

        if ($affected > 0) {
            $updatedCount += $affected;
        }
    }
    return "Berhasil memperbarui $updatedCount data pegawai!";
});


Route::post('/keluar', function () {
    \Illuminate\Support\Facades\Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/masuk');
})->name('logout');