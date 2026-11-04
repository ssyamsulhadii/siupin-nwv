<?php

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
        Schema::create('dokumen_informasi', function (Blueprint $table) {
            $table->id();
            $table->string('label'); //yang ditampilkan sebagai view informasi data-pns.csv
            $table->string('nama_file'); //hasname KeKdPgOn5qKQ.csv
            $table->enum('format_file', ['pdf', 'csv', 'docx']); //pdf, csv, docx
            $table->text('keterangan'); //digunakan validasi perbandingan data input dengan data database master SIASN ....
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokumen_informasi');
    }
};
