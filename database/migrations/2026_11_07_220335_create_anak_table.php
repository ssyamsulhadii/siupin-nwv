<?php

use App\Models\Pasangan;
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
        Schema::create('anak', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 128);
            $table->char('nik', 16);
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->date('tanggal_lahir');
            $table->char('telepon', 15);
            $table->string('nomor_akta');
            $table->date('tanggal_akta');
            $table->string('file_akta');
            $table->string('keterangan');
            $table->foreignIdFor(Pasangan::class, 'pasangan_id')->constrained('pasangan', 'id')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anak');
    }
};