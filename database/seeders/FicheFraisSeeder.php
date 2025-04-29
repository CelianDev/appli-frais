<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class FicheFraisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fichesFrais = [];

        // Générer les fiches frais de septembre 2023 à septembre 2024
        for ($i = 0; $i <= 12; $i++) {
            $date = Carbon::now()->startOfMonth()->subMonths(12 - $i);
            $fichesFrais[] = [
                'mois' => $date->format('Y-m'),
                'idVisiteur' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }

        DB::table('fiche_frais')->insert($fichesFrais);
    }
}
