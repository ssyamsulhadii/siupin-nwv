<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class DataPns extends Model
{
    public static function list(): array
    {
        // $nama_file = \App\Models\UploadDokumen::first()->data_pns;
        $nama_file = 'data-pns.csv';
        $path = public_path('assets/dokumen-informasi/' . $nama_file);

        if (!File::exists($path)) {
            return [];
        }
        $handle = fopen($path, 'r');
        // Ambil header
        $headers = array_map(function ($h) {
            return Str::snake(strtolower($h));
        }, fgetcsv($handle));
        $data = [];
        while (($row = fgetcsv($handle)) !== false) {
            // Gabungkan header + value
            $item = array_combine($headers, $row);
            $data[] = (object) $item;
        }
        fclose($handle);
        return $data;
    }

    public static function nipList(): array
    {
        return collect(self::list())
            ->pluck('nip')
            ->toArray();
    }

    public static function findByNip(string $nip): ?object
    {
        $list = self::list();
        foreach ($list as $item) {
            if ($item->nip === $nip) {
                return $item;
            }
        }
        return null;
    }


    /**
     * Mendapatkan daftar pilihan pangkat dan golongan PNS dalam bentuk Collection of Objects.
     */
    public static function getListPangkatGolongan(): Collection
    {
        $pangkatData = [
            ['id' => 'Pembina Utama Madya - IV/d', 'nama' => 'Pembina Utama Madya - IV/d'],
            ['id' => 'Pembina Utama Muda - IV/c', 'nama' => 'Pembina Utama Muda - IV/c'],
            ['id' => 'Pembina Tingkat I - IV/b', 'nama' => 'Pembina Tingkat I - IV/b'],
            ['id' => 'Pembina - IV/a', 'nama' => 'Pembina - IV/a'],
            ['id' => 'Penata Tingkat I - III/d', 'nama' => 'Penata Tingkat I - III/d'],
            ['id' => 'Penata - III/c', 'nama' => 'Penata - III/c'],
            ['id' => 'Penata Muda Tingkat I - III/b', 'nama' => 'Penata Muda Tingkat I - III/b'],
            ['id' => 'Penata Muda - III/a', 'nama' => 'Penata Muda - III/a'],
            ['id' => 'Pengatur Tingkat I - II/d', 'nama' => 'Pengatur Tingkat I - II/d'],
            ['id' => 'Pengatur - II/c', 'nama' => 'Pengatur - II/c'],
            ['id' => 'Pengatur Muda Tingkat I - II/b', 'nama' => 'Pengatur Muda Tingkat I - II/b'],
            ['id' => 'Pengatur Muda - II/a', 'nama' => 'Pengatur Muda - II/a'],
        ];

        // Mengubah array menjadi collection object (id & nama)
        return collect($pangkatData)->map(fn($item) => (object) [
            'id'   => $item['id'],
            'nama' => $item['nama'],
        ]);
    }
}
