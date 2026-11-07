<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pasangan extends Model
{
    public $table = "pasangan";
    protected $guarded = [];
    public $casts = ['tanggal_lahir' => 'date', 'tanggal_akta' => 'date'];
}
