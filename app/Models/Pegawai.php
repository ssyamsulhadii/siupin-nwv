<?php

namespace App\Models;

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
}
