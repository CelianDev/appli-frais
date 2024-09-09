<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FicheFrais;
use Illuminate\Support\Facades\DB;

class FraisForfaitSeeder extends Seeder
{
    public function run()
    {
        // Récupérer toutes les fiches frais
        $fichesFrais = FicheFrais::all();

        $fraisForfait = [];

        foreach ($fichesFrais as $fiche) {
            $etat = $fiche->mois === '2024-09' ? 'en attente' : (rand(0, 1) ? 'validé' : 'refusé');

            $fraisForfait[] = [
                'fiche_frais_id' => $fiche->id,
                'type_frais_forfait_id' => 1,
                'date' => $fiche->mois . '-05',
                'quantite' => rand(1, 5),  // Exemple : 1 à 5 repas
                'etat' => $etat,
                'created_at' => now(),
                'updated_at' => now(),
            ];
            $fraisForfait[] = [
                'fiche_frais_id' => $fiche->id,
                'type_frais_forfait_id' => 2,
                'date' => $fiche->mois . '-10',
                'quantite' => rand(1, 3),  // Exemple : 1 à 3 nuitées
                'etat' => $etat,
                'created_at' => now(),
                'updated_at' => now(),
            ];
            $fraisForfait[] = [
                'fiche_frais_id' => $fiche->id,
                'type_frais_forfait_id' => 3,
                'date' => $fiche->mois . '-15',
                'quantite' => rand(1, 4),  // Exemple : 1 à 4 relais étape
                'etat' => $etat,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('frais_forfait')->insert($fraisForfait);
    }
}
