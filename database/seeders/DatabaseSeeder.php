<?php

namespace Database\Seeders;

use App\Models\JenisPensiun;
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
        // User::factory(10)->create();

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
    }
}
