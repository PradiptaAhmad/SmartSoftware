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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->boolean('aktif')->default(true);
            $table->string('nama', 255)->nullable();
            $table->string('user_reg', 50);
            $table->string('softid', 255);
            $table->string('kontak', 255)->nullable();
            $table->timestamp('tgl_backup')->useCurrent();
            $table->string('versi', 12)->nullable();
            $table->boolean('online')->default(true)->nullable();;
            $table->integer('saldo')->default(0);
            $table->integer('upline')->nullable();
            $table->integer('lvl_akses')->default(0);
            $table->ipAddress('allow_ip')->nullable();
            $table->ipAddress('last_ip')->nullable();
            $table->timestamp('expired');
            $table->rememberToken();

            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
