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
        Schema::create('fuente_scrapers', function (Blueprint $table) {
            $table->id();
            $table->string('source_name');
            $table->string('source_url');
            $table->string('script');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->timestamp('processed_at')->nullable();
            $table->boolean('is_valid')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fuente_scrapers');
    }
};
