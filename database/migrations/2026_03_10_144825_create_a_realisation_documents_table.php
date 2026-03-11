<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('realisation_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('realisation_id')
                  ->constrained('realisations')
                  ->onDelete('cascade'); // supprime les docs si la réalisation est supprimée
            $table->string('file_path');       // chemin stockage ex: realisations/docs/fichier.pdf
            $table->string('file_name');       // nom original du fichier
            $table->string('file_type')->nullable(); // mime type ex: application/pdf
            $table->unsignedBigInteger('file_size')->nullable(); // taille en octets
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('realisation_documents');
    }
};