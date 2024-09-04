<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFraisHorsForfaitTable extends Migration
{
    public function up()
    {
        Schema::create('frais_hors_forfait', function (Blueprint $table) {
            $table->id();  // Clé primaire auto-incrémentée
            $table->foreignId('fiche_frais_id')->constrained('fiche_frais')->onDelete('cascade');
            $table->date('date');
            $table->string('libelle');
            $table->decimal('montant', 8, 2);
            $table->enum('etat', ['validé', 'refusé', 'en attente'])->default('en attente');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('frais_hors_forfait');
    }
}
