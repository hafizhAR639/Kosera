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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('nama_layanan');
            $table->string('kategori')->nullable();
            $table->longText('deskripsi')->nullable();
            $table->decimal('harga_mulai', 15, 2)->nullable();
            $table->decimal('harga_max', 15, 2)->nullable();
            $table->string('satuan')->default('per project');
            $table->integer('durasi_estimasi')->nullable()->comment('dalam menit');
            $table->string('area_layanan')->nullable();
            $table->string('foto')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->integer('views')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
