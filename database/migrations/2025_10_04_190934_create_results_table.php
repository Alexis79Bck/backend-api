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
        Schema::create('results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('draw_id')->constrained('draws')->cascadeOnDelete();
            $table->foreignId('animal_id')->constrained('animals')->cascadeOnDelete();
            $table->date('date');
            $table->boolean('processed')->default(false);
            $table->foreignId('scraping_source_id')->constrained('scraping_sources')->cascadeOnDelete();
            $table->unique(['draw_id', 'date'], 'draw_date_unique');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('results');
    }
};
