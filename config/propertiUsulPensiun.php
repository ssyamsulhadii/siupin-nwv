<?php

return [
    'identitas_diri' => [
        'jenis_pensiun_id' => '',
        'tanggal_pensiun' => null,
        'alamat_sekarang' => '',
        'mempunyai_pasangan' => '',
        'rumpun_jabatan_id' => '',
        'jabatan' => '',
        'telepon' => '',
        'alamat_pensiun' => '',
        'status_pasangan' => null,
    ],

    'identitas_pasangan' => [
        'nama' => '',
        'nip' => null,
        'nik' => '',
        'tanggal_lahir' => '',
        'telepon' => '',
        'pekerjaan' => '',
        'nomor_akta' => '',
        'tanggal_akta' => '',
        'file_akta' => '',
        'suket_kematian' => '',
        'suket_janda_duda' => '',
        'mempunyai_anak' => '',
        'pegawai_id' => '',
    ],

    'identitas_anak' => [
        'nama' => '',
        'nik' => '',
        'jenis_kelamin' => '',
        'tanggal_lahir' => '',
        'telepon' => '',
        'nomor_akta' => '',
        'tanggal_akta' => '',
        'file_akta' => '',
        'pasangan_id' => '',
    ],

    // Termasuk 14 kolom dokumen Anda nantinya di sini...
    'upload_dokumen' => [
        'supeng_instansi' => null,
        'super_pemohon' => null,
        'super_disiplin' => null,
        'super_pidana' => null,
        'sk_cpns' => null,
        'sk_pns' => null,
        'sk_pangkat_akhir' => null,
        'sk_pmk' => null,
        'skp_tahunan' => null,
        'foto_ktp' => null,
        'foto_kk' => null,
        'pas_foto' => null,
        'pertek_pensiun' => null,
        'sk_pensiun' => null,
    ],

    'attributes' => [
        // --- Identitas Diri ---
        'form_identitas_diri.jenis_pensiun_id' => 'Jenis Pensiun',
        'form_identitas_diri.tanggal_pensiun' => 'Tanggal Pensiun',
        'form_identitas_diri.alamat_sekarang' => 'Alamat Sekarang',
        'form_identitas_diri.mempunyai_pasangan' => 'Status Mempunyai Pasangan',
        'form_identitas_diri.rumpun_jabatan_id' => 'Rumpun Jabatan',
        'form_identitas_diri.jabatan' => 'Jabatan',
        'form_identitas_diri.telepon' => 'Nomor Telepon',
        'form_identitas_diri.alamat_pensiun' => 'Alamat Setelah Pensiun',
        'form_identitas_diri.status_pasangan' => 'Status Pasangan',

        // --- Identitas Pasangan ---
        'form_identitas_pasangan.nama' => 'Nama Pasangan',
        'form_identitas_pasangan.nip' => 'NIP Pasangan',
        'form_identitas_pasangan.nik' => 'NIK Pasangan',
        'form_identitas_pasangan.tanggal_lahir' => 'Tanggal Lahir Pasangan',
        'form_identitas_pasangan.telepon' => 'Nomor Telepon Pasangan',
        'form_identitas_pasangan.pekerjaan' => 'Pekerjaan Pasangan',
        'form_identitas_pasangan.nomor_akta' => 'Nomor Akta Nikah',
        'form_identitas_pasangan.tanggal_akta' => 'Tanggal Akta Nikah',
        'form_identitas_pasangan.file_akta' => 'File Akta Nikah',
        'form_identitas_pasangan.suket_kematian' => 'Surat Keterangan Kematian',
        'form_identitas_pasangan.suket_janda_duda' => 'Surat Keterangan Janda Duda',
        'form_identitas_pasangan.mempunyai_anak' => 'Status Mempunyai Anak',
        'form_identitas_pasangan.pegawai_id' => 'ID Pegawai',

        // --- Identitas Anak ---
        'form_identitas_anak.nama' => 'Nama Anak',
        'form_identitas_anak.nik' => 'NIK Anak',
        'form_identitas_anak.jenis_kelamin' => 'Jenis Kelamin Anak',
        'form_identitas_anak.tanggal_lahir' => 'Tanggal Lahir Anak',
        'form_identitas_anak.telepon' => 'Nomor Telepon Anak',
        'form_identitas_anak.nomor_akta' => 'Nomor Akta Kelahiran Anak',
        'form_identitas_anak.tanggal_akta' => 'Tanggal Akta Kelahiran Anak',
        'form_identitas_anak.file_akta' => 'File Akta Kelahiran Anak',
        'form_identitas_anak.pasangan_id' => 'ID Pasangan',

        // --- Upload Dokumen ---
        'upload_dokumen.supeng_instansi' => 'Supeng Instansi',
        'upload_dokumen.super_pemohon' => 'Surat Permohonan Pensiun', // atau disesuaikan jika singkatan lain
        'upload_dokumen.super_disiplin' => 'Surat Pernyataan Tidak Sedang Menjalani Hukuman Disiplin',
        'upload_dokumen.super_pidana' => 'Surat Pernyataan Tidak Pernah Dipidana',
        'upload_dokumen.sk_cpns' => 'SK CPNS',
        'upload_dokumen.sk_pns' => 'SK PNS',
        'upload_dokumen.sk_pangkat_akhir' => 'SK Pangkat Akhir',
        'upload_dokumen.sk_pmk' => 'SK PMK (Peninjauan Masa Kerja)',
        'upload_dokumen.skp_tahunan' => 'SKP Tahunan',
        'upload_dokumen.foto_ktp' => 'Foto KTP',
        'upload_dokumen.foto_kk' => 'Foto Kartu Keluarga (KK)',
        'upload_dokumen.pas_foto' => 'Pas Foto',
        'upload_dokumen.pertek_pensiun' => 'Pertek Pensiun (Pertimbangan Teknis BKN)',
        'upload_dokumen.sk_pensiun' => 'SK Pensiun',

    ],
];
