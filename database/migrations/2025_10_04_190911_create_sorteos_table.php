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
        Schema::create('sorteos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('loteria_id')->constrained('loterias')->cascadeOnDelete();
            $table->foreignId('horario_id')->constrained('horarios')->cascadeOnDelete();
            $table->unique(['loteria_id', 'horario_id'], 'loteria_horario_unique');
            $table->string('description');
            $table->string('slug')->unique();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sorteos');
    }
};
