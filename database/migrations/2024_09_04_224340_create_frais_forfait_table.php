<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFraisForfaitTable extends Migration
{
    public function up()
    {
        // Création de la table type_frais_forfait
        Schema::create('type_frais_forfait', function (Blueprint $table) {
            $table->id();  // Clé primaire auto-incrémentée
            $table->string('libelle');  // Type de frais (ex : repas, nuitée, etc.)
            $table->decimal('montant', 8, 2);  // Montant du forfait
            $table->timestamps();
        });

        // Création de la table frais_forfait
        Schema::create('frais_forfait', function (Blueprint $table) {
            $table->id();  // Clé primaire auto-incrémentée
            $table->foreignId('fiche_frais_id')->constrained('fiche_frais')->onDelete('cascade');  // Lien avec la fiche de frais
            $table->foreignId('type_frais_forfait_id')->constrained('type_frais_forfait')->onDelete('cascade');  // Lien avec le type de frais forfaitisé
            $table->integer('quantite');  // Quantité de frais (ex : nombre de repas)
            $table->enum('etat', ['validé', 'refusé', 'en attente'])->default('en attente');
            $table->date('date');
            $table->timestamps();
        });
    }

    public function down()
    {
        // Suppression des tables
        Schema::dropIfExists('frais_forfait');
        Schema::dropIfExists('type_frais_forfait');
    }
}
