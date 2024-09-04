<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFicheFraisTable extends Migration
{
    public function up()
    {
        Schema::create('fiche_frais', function (Blueprint $table) {
            $table->id();  // Clé primaire auto-incrémentée
            $table->string('mois');
            $table->foreignId('idVisiteur')->constrained('users')->onDelete('cascade');
            $table->integer('nbJustificatifs')->default(0);
            $table->decimal('montantValide', 8, 2)->default(0.00);
            $table->dateTime('dateModif')->nullable();
            $table->boolean('cloture')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('fiche_frais');
    }
}
