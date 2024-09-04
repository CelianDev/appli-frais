<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
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
        // Example data for seeding the fiche_frais table
        $fichesFrais = [
            [
                'mois' => '2024-07',
                'idVisiteur' => 1,  // Replace with a valid user ID from your users table
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'mois' => '2024-08',
                'idVisiteur' => 1,  // Replace with a valid user ID from your users table
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'mois' => '2024-09',
                'idVisiteur' => 1,  // Replace with a valid user ID from your users table
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'mois' => '2024-09',
                'idVisiteur' => 2,  // Replace with a valid user ID from your users table
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        // Insert the data into the fiche_frais table
        DB::table('fiche_frais')->insert($fichesFrais);
    }
}
