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
        Schema::create('certificates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('nama_sertifikat');
            $table->string('penerbit');
            $table->date('tanggal_terbit');
            $table->date('tanggal_kadaluarsa')->nullable();
            $table->string('nomor_sertifikat')->nullable();
            $table->string('file_path')->nullable();
            $table->enum('kategori', ['teknis', 'keselamatan', 'manajemen', 'lainnya'])->default('teknis');
            $table->enum('status_verifikasi', ['pending', 'verified', 'rejected'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificates');
    }
};
