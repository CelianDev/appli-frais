<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypeFraisForfaitSeeder extends Seeder
{
    public function run()
    {
        DB::table('type_frais_forfait')->insert([
            [
                'libelle' => 'Repas Midi',
                'montant' => 25.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => 'Nuitée Hôtel',
                'montant' => 100.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => 'Relais Étape',
                'montant' => 130.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => 'Kilométrage',
                'montant' => 0.50,  // Exemple de montant par kilomètre
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
