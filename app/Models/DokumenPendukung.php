<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DokumenPendukung extends Model
{
    protected $table = "dokumen_pendukung";
    protected $fillable = ["label", "nama_file", "format_file", "keterangan"];
}
