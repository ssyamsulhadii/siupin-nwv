<?php

use Illuminate\Support\Facades\Route;

Route::livewire('/', 'pages::beranda')->name('beranda');
Route::livewire('/masuk', 'pages::account.login')->name('login')->middleware('guest');
Route::livewire('/daftar', 'pages::account.register')->name('register')->middleware('guest');


Route::middleware(['auth', 'level:admin'])->group(function () {
    Route::livewire('/data-pemohon', 'pages::data-pemohon.index')->name('data-pemohon.index');
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
    $pegawais = \App\Models\Pegawai::all();
    $createdUserCount = 0;
    $updatedPegawaiCount = 0;

    foreach ($pegawais as $pegawai) {
        // 1. Cek apakah sudah ada user dengan username yang sama dengan NIP pegawai
        $user = \App\Models\User::where('username', $pegawai->nip)->first();

        // 2. Jika belum ada, buat data user baru sesuai permintaan
        if (!$user) {
            $user = \App\Models\User::create([
                'username' => $pegawai->nip,
                'nik'      => $pegawai->nik ?? null,
                'nkk'      => '1234567890123488',
                'nama'     => $pegawai->nama, // Catatan: Jika di tabel users kolomnya bernama 'name', ubah 'nama' menjadi 'name'
                'password' => bcrypt('pensiun'),
            ]);
            $createdUserCount++;
        }

        // 3. Pastikan kolom user_id pada tabel pegawai terhubung dengan id user yang bersangkutan
        if ($pegawai->user_id !== $user->id) {
            $pegawai->update(['user_id' => $user->id]);
            $updatedPegawaiCount++;
        }
    }

    return "Proses Selesai! Berhasil membuat $createdUserCount user baru dan memperbarui $updatedPegawaiCount relasi pegawai.";
});


Route::post('/keluar', function () {
    \Illuminate\Support\Facades\Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/masuk');
})->name('logout');
