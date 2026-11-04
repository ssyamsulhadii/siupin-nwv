<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisPensiun extends Model
{
    protected $table = "jenis_pensiun";
    protected $fillable = ["nama", "keterangan", "with_tanggal"];
}
