<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JenisPensiun extends Model
{
    protected $table = "jenis_pensiun";
    protected $fillable = ["nama", "keterangan", "with_tanggal"];


    public function pegawai(): HasMany
    {
        return $this->hasMany(Pegawai::class, 'jenis_pensiun_id');
    }
}
