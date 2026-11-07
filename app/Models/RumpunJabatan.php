<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RumpunJabatan extends Model
{
    protected $table = 'rumpun_jabatan';
    protected $fillable = ['nama', 'bup'];
}
