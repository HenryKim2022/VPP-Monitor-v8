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
        Schema::create('tb_projects', function (Blueprint $table) {
            $table->string('id_project')->primary();
            $table->string('na_project');
            $table->dateTime('start_project');
            $table->dateTime('deadline_project');
            $table->string('status_project')->nullable();
            $table->dateTime('closed_at_project')->nullable();
            $table->integer('show_to_client')->nullable();
            $table->foreignId('id_client')->nullable()->constrained('tb_client', 'id_client');
            $table->integer('order')->nullable();
            // $table->foreignId('id_karyawan')->nullable()->constrained('tb_karyawan', 'id_karyawan');
            // $table->foreignId('id_team')->nullable()->constrained('tb_team', 'id_team');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_projects', function (Blueprint $table) {
            $table->dropForeign(['id_client']);
            // $table->dropForeign(['id_karyawan']);
            // $table->dropForeign(['id_team']);
        });
        Schema::dropIfExists('tb_projects');
    }
};
