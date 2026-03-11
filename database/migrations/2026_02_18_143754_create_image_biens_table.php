<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('image_biens', function (Blueprint $table) {
            $table->id();

            $table->foreignId('bien_id')
                  ->constrained('biens')
                  ->onDelete('cascade');

            $table->enum('media_type', ['image','video']);
            $table->string('media_path');
            $table->boolean('is_main')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('image_biens');
    }
};
