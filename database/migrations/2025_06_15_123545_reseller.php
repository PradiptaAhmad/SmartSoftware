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
        Schema::create('reseller', function (Blueprint $table) {
            $table->string('kode', 100)->primary();
            $table->string('nama', 255)->nullable();
            $table->bigInteger('saldo')->nullable();
            $table->string('alamat', 255)->nullable();
            $table->string('pin', 50)->nullable();
            $table->tinyInteger('aktif')->nullable();
            $table->string('kode_upline', 50)->nullable();
            $table->string('kode_level', 50)->nullable();
            $table->string('keterangan', 500)->nullable();
            $table->timestamp('tgl_daftar')->nullable();
            $table->bigInteger('saldo_minimal')->nullable();
            $table->timestamp('tgl_aktivitas')->nullable();
            $table->integer('pengingat_saldo')->nullable();
            $table->integer('f_pengingat_saldo')->nullable();
            $table->string('nama_pemilik', 50)->nullable();
            $table->string('kode_area', 100)->nullable();
            $table->timestamp('tgl_pengingat_saldo')->nullable();
            $table->integer('markup')->nullable();
            $table->integer('markup_ril')->nullable();
            $table->string('pengirim', 2000)->nullable();
            $table->bigInteger('komisi')->nullable();
            $table->bigInteger('kode_mutasi')->nullable();
            $table->foreignId('kode_customer')->constrained('users', 'id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reseller');
    }
};
