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
        Schema::create('tb_task', function (Blueprint $table) {
            $table->id('id_task')->primary();
            $table->time('start_time_task')->nullable();
            $table->string('descb_task', 9999)->nullable();
            // $table->float('progress_actual_task')->nullable();
            $table->float('progress_current_task')->nullable();
            $table->foreignId('id_ws')->nullable()->constrained('tb_worksheet', 'id_ws');
            $table->string('id_project')->nullable(); // Keep it as a string to match tb_projects
            $table->foreign('id_project')->references('id_project')->on('tb_projects')->onDelete('set null'); // Correct foreign key definition
            $table->foreignId('id_monitoring')->nullable()->constrained('tb_monitoring', 'id_monitoring');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_task', function (Blueprint $table) {
            $table->dropForeign(['id_ws']);
            $table->dropForeign(['id_project']);
        });
        Schema::dropIfExists('tb_task');
    }
};
