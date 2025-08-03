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
        Schema::create('hero_settings', function (Blueprint $table) {
            $table->id();
            $table->boolean('enabled')->default(true);
            $table->string('video_file')->nullable();
            $table->string('title')->default('Futbolun En Heyecanlı Anları');
            $table->text('subtitle')->default('En son haberler, analizler ve özel içerikler için bizi takip edin');
            $table->string('button_text')->default('Keşfet');
            $table->string('button_url')->default('/haberler');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hero_settings');
    }
};
