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

	    // id_monitoring (PK),  achieve_date,   qty,    id_ws (PK),  id_task (PK),    id_karyawan (PK),    id_project (PK)
        Schema::create('tb_monitoring', function (Blueprint $table) {
            $table->id('id_monitoring')->primary();
            $table->string('category')->nullable(); // Keep it as a string to match tb_projects
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->date('achieve_date')->nullable();
            $table->float('qty')->nullable();
            // $table->foreignId('id_ws')->nullable()->constrained('tb_worksheet', 'id_ws');
            // // $table->foreignId('id_task')->nullable()->constrained('tb_task', 'id_task');
            $table->foreignId('id_karyawan')->nullable()->constrained('tb_karyawan', 'id_karyawan');
            $table->string('id_project')->nullable(); // Keep it as a string to match tb_projects
            $table->foreign('id_project')->references('id_project')->on('tb_projects')->onDelete('set null'); // Correct foreign key definition
            $table->integer('order')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
        // $table->foreign('id_monitoring_parent')->references('id_monitoring')->on('tb_monitoring')->onDelete('cascade');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_monitoring', function (Blueprint $table) {
            // $table->dropForeign(['id_ws']);
            // $table->dropForeign(['id_task']);
            $table->dropForeign(['id_karyawan']);
            $table->dropForeign(['id_project']);
        });
        Schema::dropIfExists('tb_monitoring');
    }
};
