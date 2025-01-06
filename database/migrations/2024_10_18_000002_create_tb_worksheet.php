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
        Schema::create('tb_worksheet', function (Blueprint $table) {
            $table->id('id_ws')->primary();
            $table->dateTime('working_date_ws')->nullable();
            $table->time('arrival_time_ws')->nullable();
            $table->time('finish_time_ws')->nullable();
            $table->string('status_ws')->nullable();
            $table->dateTime('expired_at_ws')->nullable();
            $table->dateTime('closed_at_ws')->nullable();
            $table->string('remark_ws', 9999)->nullable();
            $table->foreignId('id_karyawan')->nullable()->constrained('tb_karyawan', 'id_karyawan');
            $table->string('id_project')->nullable(); // Keep it as a string to match tb_projects
            $table->foreign('id_project')->references('id_project')->on('tb_projects')->onDelete('set null'); // Correct foreign key definition
            // $table->foreignId('id_monitoring')->nullable()->constrained('tb_monitoring', 'id_monitoring');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_worksheet', function (Blueprint $table) {
            $table->dropForeign(['id_karyawan']);
            $table->dropForeign(['id_project']);
            // $table->dropForeign(['id_monitoring']);
        });
        Schema::dropIfExists('tb_worksheet');
    }
};
