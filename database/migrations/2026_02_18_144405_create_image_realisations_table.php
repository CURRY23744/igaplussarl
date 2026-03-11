<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('image_realisations', function (Blueprint $table) {
            $table->id();

            $table->foreignId('realisation_id')
                  ->constrained('realisations')
                  ->onDelete('cascade');

            $table->string('image_path');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('image_realisations');
    }
};
