<?php

use App\Models\JenisPensiun;
use App\Models\ProgresUsul;
use App\Models\RumpunJabatan;
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
        Schema::create('pegawai', function (Blueprint $table) {
            $table->id();
            // By Mapping Datat
            $table->string('nama', 128);
            $table->char('nip', 18);
            $table->char('nkk', 16);
            $table->char('nik', 16);
            $table->string('tanggal_lahir');
            $table->string('unit_organisasi', 128);
            $table->string('pangkat_golongan', 56);
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->foreignId('user_id')->constrained()->onDelete('cascade')->nullable();

            // By Input Data
            $table->foreignIdFor(JenisPensiun::class, 'jenis_pensiun_id')->constrained('jenis_pensiun', 'id')->onDelete('cascade');
            $table->date('tanggal_pensiun')->nullable();
            $table->text('alamat_sekarang');
            $table->foreignIdFor(RumpunJabatan::class, 'rumpun_jabatan_id')->constrained('rumpun_jabatan', 'id')->onDelete('cascade');
            $table->string('nama_jabatan', 128);
            $table->char('telepon', 15);
            $table->text('alamat_pensiun');
            $table->boolean('mempunyai_pasangan');
            $table->string('status_pasangan')->nullable();

            // By Controll Data
            $table->tinyInteger('status_usul')->default(0); // 0=Draft 1=Terkirirm 2=Perbaikan 3=Diterima
            $table->date('tanggal_usul')->nullable();
            $table->foreignIdFor(ProgresUsul::class, 'progres_usul_id')->nullable()->constrained('progres_usul', 'id')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pegawai');
    }
};
