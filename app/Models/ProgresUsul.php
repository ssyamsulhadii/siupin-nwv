<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgresUsul extends Model
{
    protected $table = "progres_usul";
    protected $fillable = ['warna', 'keterangan', 'kategori_status_usul'];
}
