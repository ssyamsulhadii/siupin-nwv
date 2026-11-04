<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JabatanNominatif extends Model
{
    protected $table = 'jabatan_nominatif';
    protected $fillable = ['nama', 'bup'];
}