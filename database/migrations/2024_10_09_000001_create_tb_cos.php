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
        Schema::create('tb_cos', function (Blueprint $table) {
            $table->id('id_co');
            $table->string('id_project')->nullable(); // Change to string to match tb_projects
            $table->foreign('id_project')->references('id_project')->on('tb_projects')->onDelete('cascade'); // Add foreign key constraint
            $table->foreignId('id_karyawan')->nullable()->constrained('tb_karyawan', 'id_karyawan');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_cos', function (Blueprint $table) {
            $table->dropForeign(['id_project']);
            $table->dropForeign(['id_karyawan']);
        });
        Schema::dropIfExists('tb_cos');
    }
};
