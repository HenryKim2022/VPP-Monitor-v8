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
        Schema::create('tb_sys_settings', function (Blueprint $table) {
            $table->string('na_sett')->primary();
            $table->string('lbl_sett')->nullable();
            $table->string('tooltip_text_sett')->nullable();
            $table->integer('val_sett')->nullable();
            $table->string('url_sett')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_sys_settings');
    }
};
