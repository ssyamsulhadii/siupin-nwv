<?php

namespace App\Models;

use App\Models\Anak;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pasangan extends Model
{
    public $table = "pasangan";
    protected $guarded = [];
    public $casts = ['tanggal_lahir' => 'date', 'tanggal_akta' => 'date'];

    public function anak(): HasMany
    {
        return $this->hasMany(Anak::class, 'pasangan_id');
    }
}
