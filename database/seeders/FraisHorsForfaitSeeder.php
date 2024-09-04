<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FraisHorsForfait;
use App\Models\FicheFrais;

class FraisHorsForfaitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Supposons que vous voulez ajouter des frais hors forfait pour une fiche de frais particulière
        $ficheFrais1 = FicheFrais::where('mois', '2024-08')->where('idVisiteur', 1)->first();
        $ficheFrais2 = FicheFrais::where('mois', '2024-09')->where('idVisiteur', 1)->first();
        $ficheFrais3 = FicheFrais::where('mois', '2024-09')->where('idVisiteur', 2)->first();
        $ficheFrais4 = FicheFrais::where('mois', '2024-07')->where('idVisiteur', 1)->first();

        $fraisHorsForfait = [
            [
                'fiche_frais_id' => $ficheFrais4->id,
                'date' => '2024-07-15',
                'libelle' => 'Déjeuner avec un client',
                'montant' => 45.50,
                'etat' => 'validé',
            ],
            [
                'fiche_frais_id' => $ficheFrais4->id,
                'date' => '2024-07-20',
                'libelle' => 'Achat de fournitures',
                'montant' => 30.00,
                'etat' => 'en attente',
            ],
            [
                'fiche_frais_id' => $ficheFrais4->id,
                'date' => '2024-07-15',
                'libelle' => 'Déjeuner avec un client',
                'montant' => 140.00,
                'etat' => 'validé',
            ],
            [
                'fiche_frais_id' => $ficheFrais4->id,
                'date' => '2024-07-05',
                'libelle' => 'Réservation de salle pour conférence',
                'montant' => 200.00,
                'etat' => 'refusé',
            ],
            [
                'fiche_frais_id' => $ficheFrais2->id,
                'date' => '2022-09-15',
                'libelle' => 'Déjeuner avec un client',
                'montant' => 25.50,
                'etat' => 'validé',
            ],
            [
                'fiche_frais_id' => $ficheFrais2->id,
                'date' => '2022-09-20',
                'libelle' => 'Achat de fournitures',
                'montant' => 30.00,
                'etat' => 'en attente',
            ],
            [
                'fiche_frais_id' => $ficheFrais2->id,
                'date' => '2022-09-15',
                'libelle' => 'Déjeuner avec un client',
                'montant' => 140.00,
                'etat' => 'validé',
            ],
            [
                'fiche_frais_id' => $ficheFrais2->id,
                'date' => '2024-09-05',
                'libelle' => 'Réservation de salle pour conférence',
                'montant' => 200.00,
                'etat' => 'refusé',
            ],
            [
                'fiche_frais_id' => $ficheFrais2->id,
                'date' => '2024-09-12',
                'libelle' => 'Achat de fournitures',
                'montant' => 30.00,
                'etat' => 'en attente',
            ],
            [
                'fiche_frais_id' => $ficheFrais3->id,
                'date' => '2024-09-10',
                'libelle' => 'Repas avec spécialiste',
                'montant' => 75.00,
                'etat' => 'validé',
            ],
            [
                'fiche_frais_id' => $ficheFrais3->id,
                'date' => '2024-09-12',
                'libelle' => 'Frais de déplacement',
                'montant' => 150.75,
                'etat' => 'en attente',
            ],
        ];

        foreach ($fraisHorsForfait as $frais) {
            FraisHorsForfait::create($frais);
        }
    }
}
