<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('biens', function (Blueprint $table) {
            $table->id();

            $table->string('titre');
            $table->enum('type', ['Terrain','Maison','Appartement','Villa']);
            $table->enum('statut', ['À vendre','À louer']);
            $table->integer('prix'); 

            $table->string('ville');
            $table->string('quartier');
            $table->text('description');
            $table->boolean('disponibilite')->default(true);

            $table->string('contact_whatsapp');
            $table->string('contact_nom')->nullable();
            $table->string('contact_email')->nullable();

            $table->float('superficie')->nullable();
            $table->integer('nombre_chambres')->nullable();
            $table->integer('nombre_salles_bain')->nullable();
            $table->integer('nombre_cuisine')->nullable();
            $table->integer('nombre_salon')->nullable();
            $table->integer('etage')->nullable();

            $table->boolean('parking')->default(false);
            $table->boolean('piscine')->default(false);
            $table->boolean('jardin')->default(false);
            $table->boolean('meuble')->default(false);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('biens');
    }
};
