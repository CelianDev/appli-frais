<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class FraisHorsForfaitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('frais_hors_forfait')->insert([
            [
                'idVisiteur' => 1,
                'date' => '2024-08-15',
                'libelle' => 'Déjeuner avec un client',
                'montant' => 45.50,
                'etat' => 'validé',
            ],
            [
                'idVisiteur' => 1,
                'date' => '2024-08-20',
                'libelle' => 'Achat de fournitures',
                'montant' => 30.00,
                'etat' => 'en attente',
            ],
            [
                'idVisiteur' => 1,
                'date' => '2024-09-05',
                'libelle' => 'Réservation de salle pour conférence',
                'montant' => 200.00,
                'etat' => 'refusé',
            ],
            [
                'idVisiteur' => 1,
                'date' => '2024-09-10',
                'libelle' => 'Repas avec spécialiste',
                'montant' => 75.00,
                'etat' => 'validé',
            ],
            [
                'idVisiteur' => 1,
                'date' => '2024-09-12',
                'libelle' => 'Frais de déplacement',
                'montant' => 150.75,
                'etat' => 'en attente',
            ],
            [
                'idVisiteur' => 1,
                'date' => '2024-08-15',
                'libelle' => 'Déjeuner avec un client',
                'montant' => 45.50,
                'etat' => 'validé',
            ],
            [
                'idVisiteur' => 1,
                'date' => '2024-08-20',
                'libelle' => 'Achat de fournitures',
                'montant' => 30.00,
                'etat' => 'en attente',
            ],
            [
                'idVisiteur' => 1,
                'date' => '2024-09-05',
                'libelle' => 'Réservation de salle pour conférence',
                'montant' => 200.00,
                'etat' => 'refusé',
            ],
            [
                'idVisiteur' => 1,
                'date' => '2024-09-10',
                'libelle' => 'Repas avec spécialiste',
                'montant' => 75.00,
                'etat' => 'validé',
            ],
            [
                'idVisiteur' => 1,
                'date' => '2024-09-12',
                'libelle' => 'Frais de déplacement',
                'montant' => 150.75,
                'etat' => 'en attente',
            ],
            [
                'idVisiteur' => 1,
                'date' => '2024-08-15',
                'libelle' => 'Déjeuner avec un client',
                'montant' => 45.50,
                'etat' => 'validé',
            ],
            [
                'idVisiteur' => 1,
                'date' => '2024-08-20',
                'libelle' => 'Achat de fournitures',
                'montant' => 30.00,
                'etat' => 'en attente',
            ],
            [
                'idVisiteur' => 1,
                'date' => '2024-09-05',
                'libelle' => 'Réservation de salle pour conférence',
                'montant' => 200.00,
                'etat' => 'refusé',
            ],
            [
                'idVisiteur' => 1,
                'date' => '2024-09-10',
                'libelle' => 'Repas avec spécialiste',
                'montant' => 75.00,
                'etat' => 'validé',
            ],
            [
                'idVisiteur' => 2,
                'date' => '2024-09-12',
                'libelle' => 'Frais de déplacement',
                'montant' => 150.75,
                'etat' => 'en attente',
            ],
        ]);
    }
}
