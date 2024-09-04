<?php

use App\Http\Controllers\FicheFraisController;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

// Planification de la commande 'frais:update-cloture' chaque jour
// Schedule::call(function () {
//     // Créer une instance de FicheFraisController
//     $controller = new FicheFraisController();
//     // Appeler la méthode non statique sur l'instance
//     $controller->UpdateClotureStatus();
// })->everyFiveSeconds();

Schedule::command('frais:update-cloture')->daily();
