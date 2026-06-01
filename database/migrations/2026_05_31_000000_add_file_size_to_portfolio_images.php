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
        Schema::table('portfolio_images', function (Blueprint $table) {
            $table->string('original_filename')->nullable()->after('caption');
            $table->unsignedBigInteger('file_size')->nullable()->after('original_filename')->comment('file size in bytes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('portfolio_images', function (Blueprint $table) {
            $table->dropColumn(['original_filename', 'file_size']);
        });
    }
};
