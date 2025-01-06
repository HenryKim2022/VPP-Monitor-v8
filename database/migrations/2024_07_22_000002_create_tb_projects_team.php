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
        Schema::create('tb_projects_teams', function (Blueprint $table) {
            $table->id('id_prj_team');
            $table->foreignId('id_team')->nullable()->constrained('tb_team', 'id_team');
            $table->string('id_project')->nullable(); // Change to string to match tb_projects
            $table->foreign('id_project')->references('id_project')->on('tb_projects')->onDelete('cascade'); // Add foreign key constraint
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_projects_teams', function (Blueprint $table) {
            $table->dropForeign(['id_team']);
            $table->dropForeign(['id_project']);
        });
        Schema::dropIfExists('tb_projects_teams');
    }
};
