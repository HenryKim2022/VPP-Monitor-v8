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
        Schema::create('tb_karyawan', function (Blueprint $table) {
            $table->id('id_karyawan', 11);
            $table->string('na_karyawan', 80);
            $table->string('tlah_karyawan')->nullable();
            $table->date('tglah_karyawan')->nullable();
            $table->string('agama_karyawan')->nullable();
            $table->string('alamat_karyawan')->nullable();
            $table->string('notelp_karyawan', 20)->nullable();
            $table->string('foto_karyawan')->nullable();
            $table->foreignId('id_team')->nullable()->constrained('tb_team', 'id_team');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_karyawan', function (Blueprint $table) {
            $table->dropForeign(['id_team']);
        });
        Schema::dropIfExists('tb_karyawan');
    }
};
