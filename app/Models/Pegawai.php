<?php

namespace App\Models;

use App\Models\DokumenPensiun;
use App\Models\Pasangan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Pegawai extends Model
{
    protected $table = "pegawai";
    protected $guarded = [];
    public $casts = ['tanggal_pensiun' => 'date'];


    public function pasangan(): HasOne
    {
        return $this->hasOne(Pasangan::class, 'pegawai_id');
    }
    public function dokumenPensiun(): HasOne
    {
        return $this->hasOne(DokumenPensiun::class, 'pegawai_id');
    }

    protected function statusUsulText(): Attribute
    {
        return Attribute::make(
            get: fn () => match ($this->status_usul) {
                0 => 'Draft',
                1 => 'Terkirim',
                2 => 'Perbaikan',
                3 => 'Diterima',
                default => 'Tidak Diketahui',
            }
        );
    }

    protected function statusUsulBadge(): Attribute
    {
        return Attribute::make(
            get: fn () => match ($this->status_usul) {
                0 => 'secondary', // Abu-abu
                1 => 'info text-dark',      // Biru muda / info
                2 => 'warning text-dark',   // Kuning
                3 => 'success',     // Hijau
                default => 'dark',
            }
        );
    }

    protected function statusUsulIcon(): Attribute
    {
        return Attribute::make(
            get: fn () => match ($this->status_usul) {
                0 => 'bi-file-earmark',        // Draft
                1 => 'bi-send-check',                // Terkirim
                2 => 'bi-exclamation-triangle', // Perbaikan
                3 => 'bi-shield-check',        // Diterima
                default => 'bi-question-circle',
            }
        );
    }
}