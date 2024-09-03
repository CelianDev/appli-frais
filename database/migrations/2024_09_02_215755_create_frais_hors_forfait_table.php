<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFraisHorsForfaitTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('frais_hors_forfait', function (Blueprint $table) {
            $table->id();
            $table->foreignId('idVisiteur')->constrained('users')->onDelete('cascade');
            $table->date('date'); // Date complète du frais hors forfait
            $table->string('libelle');
            $table->decimal('montant', 8, 2);
            $table->enum('etat', ['validé', 'refusé', 'en attente'])->default('en attente');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('frais_hors_forfait');
    }
}
