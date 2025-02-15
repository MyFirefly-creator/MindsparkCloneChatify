<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nis')->nullable()->unique();
            $table->string('nama');
            $table->string('email')->unique();
            $table->string('alamat');
            $table->string('password');
            $table->string('role');
            $table->text('avatar');
            $table->unsignedInteger('jumlah_pelanggaran')->default(0);
            $table->timestamps();
            $table->string('foto_ktp')->nullable();
            $table->string('foto_diri')->nullable();
            $table->enum('status_verifikasi', ['pending', 'diterima', 'ditolak'])->default('pending'); 
        });
    }

    public function down(): void {
        Schema::dropIfExists('users');
    }
};

