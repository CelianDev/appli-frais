<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FicheFrais;
use App\Models\FraisHorsForfait;

class FraisHorsForfaitSeeder extends Seeder
{
    public function run()
    {
        // Récupérer toutes les fiches frais
        $fichesFrais = FicheFrais::all();

        $libelles = [
            'Repas avec client',
            'Achat de fournitures',
            'Réservation de salle',
            'Participation à un salon',
            'Frais de déplacement'
        ];

        $fraisHorsForfait = [];

        foreach ($fichesFrais as $fiche) {
            $etat = $fiche->mois === '2024-09' ? 'en attente' : (rand(0, 1) ? 'validé' : 'refusé');

            for ($i = 0; $i < 2; $i++) {
                $fraisHorsForfait[] = [
                    'fiche_frais_id' => $fiche->id,
                    'date' => $fiche->mois . '-20',
                    'libelle' => $libelles[array_rand($libelles)],
                    'montant' => rand(20, 300),  // Montant aléatoire entre 20 et 300 €
                    'etat' => $etat,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        FraisHorsForfait::insert($fraisHorsForfait);
    }
}
