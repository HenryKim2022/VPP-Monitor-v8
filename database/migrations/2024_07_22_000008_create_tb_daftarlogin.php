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
        Schema::create('tb_daftar_login', function (Blueprint $table) {
            $table->id('user_id');
            $table->string('username', 45)->unique();
            $table->string('email', 80)->unique()->nullable();
            $table->string('password', 60);
            $table->string('type')->default(false);
            $table->foreignId('id_karyawan')->nullable()->constrained('tb_karyawan', 'id_karyawan');
            $table->foreignId('id_client')->nullable()->constrained('tb_client', 'id_client');
            $table->rememberToken();
            $table->timestamp('remember_token_expires_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_daftar_login', function (Blueprint $table) {
            $table->dropRememberToken();
            $table->dropForeign(['id_karyawan']);
            $table->dropForeign(['id_client']);
        });
        Schema::dropIfExists('tb_daftar_login');
    }
};
