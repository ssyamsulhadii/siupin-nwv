<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Anak extends Model
{
    protected $table = "anak";
    protected $guarded = [];
    protected $casts = ['tanggal_lahir' => 'date', 'tanggal_akta' => 'date'];
}
