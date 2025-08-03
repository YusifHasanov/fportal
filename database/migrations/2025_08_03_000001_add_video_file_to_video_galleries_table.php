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
        Schema::table('video_galleries', function (Blueprint $table) {
            // Önce video_url'i nullable yap
            $table->string('video_url')->nullable()->change();
            $table->string('video_file')->nullable()->after('video_url');
            $table->string('video_type')->default('url')->after('video_file'); // 'url' or 'file'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('video_galleries', function (Blueprint $table) {
            $table->dropColumn(['video_file', 'video_type']);
        });
    }
};