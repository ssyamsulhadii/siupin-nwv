<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DokumenInformasi extends Model
{
    protected $table = "dokumen_informasi";
    protected $fillable = ["label", "nama_file", "format_file", "keterangan"];
}
