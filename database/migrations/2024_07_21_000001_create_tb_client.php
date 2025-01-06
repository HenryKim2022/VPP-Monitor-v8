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
        Schema::create('tb_client', function (Blueprint $table) {
            $table->id('id_client', 11);
            $table->string('na_client', 80);
            $table->string('alamat_client')->nullable();
            $table->string('notelp_client', 20)->nullable();
            $table->string('foto_client')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_client');
    }
};
