<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    protected $table = "pegawai";
    protected $guarded = [];
    public $casts = ['tanggal_pensiun' => 'date'];
}
