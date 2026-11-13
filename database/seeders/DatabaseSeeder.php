<?php

namespace Database\Seeders;

use App\Models\RumpunJabatan;
use App\Models\JenisPensiun;
use App\Models\ProgresUsul;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        User::create([
            'username' => 'admin_siupin',
            'nik' => '1123557799110011',
            'nama' => "I'm Not Robot",
            'level' => 'admin',
            'password' => bcrypt('admin@siupin135'), // Ganti dengan password yang diinginkan
        ]);

        $jenisPensiun = [
            [
                'nama' => 'Pensiun BUP (Batas Usia Pensiun)',
                'keterangan' => 'Pensiun yang diberikan kepada pegawai yang telah mencapai usia pensiun normal.',
            ],
            [
                'nama' => 'Pensiun Atas Permintaan Sendiri (APS)',
                'keterangan' => 'Pensiun yang diajukan atas permintaan sendiri oleh pegawai yang memenuhi syarat masa kerja dan usia tertentu sebelum mencapai BUP.',
                'with_tanggal' => true,
            ],
            [
                'nama' => 'Pensiun Janda Duda',
                'keterangan' => 'Pensiun yang diberikan kepada janda atau duda dari pegawai negeri yang meninggal dunia.',
                'with_tanggal' => true,
            ],
            [
                'nama' => 'Pensiun Yatim Piatu',
                'keterangan' => 'Pensiun yang diberikan kepada anak yatim piatu dari pegawai negeri yang meninggal dunia dan tidak mempunyai suami/istri.',
                'with_tanggal' => true,
            ],
            [
                'nama' => 'Pensiun Dini',
                'keterangan' => 'Pensiun yang diajukan atas permintaan sendiri oleh pegawai yang tidak memenuhi syarat masa kerja dan usia tertentu sebelum mencapai BUP.',
                'with_tanggal' => true,
            ]
        ];
        foreach ($jenisPensiun as $item) {
            JenisPensiun::create($item);
        }

        $rumpun_jabatan = [
            [
                'nama' => 'Struktural Jabatan Pimpinan Tinggi',
                'bup' => 60,
            ],
            [
                'nama' => 'Struktural Jabatan Administrasi',
                'bup' => 58,
            ],
            [
                'nama' => 'Jabatan Pelaksana',
                'bup' => 58,
            ],
            [
                'nama' => 'Jabatan Fungsional Madya',
                'bup' => 60,
            ],
            [
                'nama' => 'Jabatan Fungsional Muda',
                'bup' => 58,
            ],
            [
                'nama' => 'Jabatan Fungsional Pertama',
                'bup' => 58,
            ],
            [
                'nama' => 'Jabatan Fungsional Terampil',
                'bup' => 58,
            ],
            [
                'nama' => 'Jabatan Fungsional Guru',
                'bup' => 60,
            ],
        ];

        foreach ($rumpun_jabatan as $item) {
            RumpunJabatan::create($item);
        }

        $list_progres_usul = [
            [
                'warna' => 'warning',
                'keterangan' => 'Dokumen Masuk',
                'kategori_status_usul' => 'Dikirim',
            ],
            [
                'warna' => 'secondary',
                'keterangan' => 'Dokumen Tarik',
                'kategori_status_usul' => 'Diterima',
            ],
            [
                'warna' => 'primary',
                'keterangan' => 'Menunggu TTE',
                'kategori_status_usul' => 'Diterima',
            ],
            [
                'warna' => 'success',
                'keterangan' => 'Pertek Pensiun Terbit',
                'kategori_status_usul' => 'Diterima',
            ],
            [
                'warna' => 'success',
                'keterangan' => 'SK Pensiun Terbit',
                'kategori_status_usul' => 'Diterima',
            ],
        ];
        foreach ($list_progres_usul as $item) {
            \App\Models\ProgresUsul::create([
                'warna' => $item['warna'],
                'keterangan' => $item['keterangan'],
                'kategori_status_usul' => $item['kategori_status_usul'],
            ]);
        }
    }
}
