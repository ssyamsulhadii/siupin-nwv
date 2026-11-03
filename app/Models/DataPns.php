<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\Model;

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
}
