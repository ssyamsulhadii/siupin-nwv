<?php

use App\Models\Pegawai;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pasangan', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 128);
            $table->char('nip', 18)->nullable();
            $table->char('nik', 16);
            $table->date('tanggal_lahir');
            $table->string('pekerjaan');
            $table->string('nomor_akta');
            $table->date('tanggal_akta');
            $table->string('file_akta');
            $table->foreignIdFor(Pegawai::class, 'pegawai_id')->constrained('pegawai', 'id')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pasangan');
    }
};
