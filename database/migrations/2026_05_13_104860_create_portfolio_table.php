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
        Schema::create('portfolio', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('judul');
            $table->longText('deskripsi')->nullable();
            $table->string('kategori')->nullable();
            $table->date('tanggal_project')->nullable();
            $table->string('client_name')->nullable();
            $table->string('lokasi')->nullable();
            $table->decimal('nilai_project', 15, 2)->nullable();
            $table->integer('durasi_hari')->nullable();
            $table->string('foto_cover')->nullable();
            $table->decimal('rating', 2, 1)->default(0);
            $table->enum('status', ['draft', 'published'])->default('published');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('portfolio');
    }
};
