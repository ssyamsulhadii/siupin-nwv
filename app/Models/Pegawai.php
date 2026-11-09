<?php

namespace App\Models;

use App\Models\DokumenPensiun;
use App\Models\Pasangan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Pegawai extends Model
{
    protected $table = "pegawai";
    protected $guarded = [];
    public $casts = ['tanggal_pensiun' => 'date'];


    public function pasangan(): HasOne
    {
        return $this->hasOne(Pasangan::class, 'pegawai_id');
    }
    public function dokumenPensiun(): HasOne
    {
        return $this->hasOne(DokumenPensiun::class, 'pegawai_id');
    }
}