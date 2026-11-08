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
        Schema::create('dokumen_pensiun', function (Blueprint $table) {
            $table->id();
            $table->string('supeng_instansi')->nullable();
            $table->string('super_pemohon')->nullable();
            $table->string('super_disiplin')->nullable();
            $table->string('super_pidana')->nullable();
            $table->string('sk_cpns')->nullable();
            $table->string('sk_pns')->nullable();
            $table->string('sk_pangkat_akhir')->nullable();
            $table->string('sk_pmk')->nullable();
            $table->string('skp_tahunan')->nullable();
            $table->string('foto_ktp')->nullable();
            $table->string('foto_kk')->nullable();
            $table->string('pas_foto')->nullable();
            $table->string('pertek_pensiun')->nullable();
            $table->string('sk_pensiun')->nullable();
            $table->foreignIdFor(Pegawai::class, 'pegawai_id')->constrained('pegawai', 'id')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokumen_pensiun');
    }
};
