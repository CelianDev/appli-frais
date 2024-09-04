<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\FicheFrais;
use Carbon\Carbon;

class UpdateClotureStatus extends Command
{
    // Le nom et la description de la commande
    protected $signature = 'frais:update-cloture';
    protected $description = 'Met à jour le statut cloture des fiches de frais';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Récupérer toutes les fiches frais non clôturées
        $fichesFrais = FicheFrais::where('cloture', false)->get();

        foreach ($fichesFrais as $fiche) {
            // Convertir le mois de la fiche frais au format "YYYY-MM"
            $moisFiche = Carbon::createFromFormat('Y-m', $fiche->mois);

            // Date limite : 10 du mois suivant
            $dateLimite = $moisFiche->addMonth()->day(10);

            // Si la date actuelle est après le 10 du mois suivant, on clôture la fiche
            if (Carbon::now()->gt($dateLimite)) {
                $fiche->cloture = true;
                $fiche->save();

                // Affiche un message pour indiquer que la fiche a été clôturée
                $this->info("Fiche de frais pour le mois {$fiche->mois} et visiteur {$fiche->idVisiteur} clôturée.");
            }
        }

        $this->info('Mise à jour des fiches de frais terminée.');
    }
}
