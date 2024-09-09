<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FraisHorsForfaitController;
use App\Http\Controllers\FicheFraisController;
use App\Http\Controllers\FraisController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Inertia\Inertia;

// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });

// Dashboard
Route::get('/', [DashboardController::class, 'index'])
  ->name('dashboard')
  ->middleware('auth');

// Afficher les détails d'un frais
// Route::get('/frais/horsforfait/{id}', [FraisHorsForfaitController::class, 'show'])
//   ->name('frais.show')
//   ->middleware('auth');


Route::get('/fiche-frais/{mois}/{idVisiteur}', [FicheFraisController::class, 'show'])
  ->name('fiche-frais.show')
  ->middleware('auth');

Route::get('/fiche-frais/{idVisiteur}', [FicheFraisController::class, 'index'])
  ->name('fiche-frais.index')
  ->middleware('auth');

Route::middleware(['auth'])->group(function () {
  Route::get('/fiche-frais/{mois}/{idVisiteur}/create', [FraisController::class, 'create'])
    ->name('frais.create');

  Route::post('/fiche-frais/{mois}/{idVisiteur}/frais-forfait/store', [FraisController::class, 'store'])
    ->name('frais.store');

  Route::post('/fiche-frais/{mois}/{idVisiteur}/frais-hors-forfait/store', [FraisHorsForfaitController::class, 'store'])
    ->name('frais-hors-forfait.store');

  Route::get('/fiche-frais/{mois}/{idVisiteur}/frais-forfait/{id}/edit', [FraisController::class, 'edit'])
    ->name('frais.edit');

  Route::get('/fiche-frais/{mois}/{idVisiteur}/frais-hors-forfait/{id}/edit', [FraisHorsForfaitController::class, 'edit'])
    ->name('frais-hors-forfait.edit');

  Route::put('/fiche-frais/{mois}/{idVisiteur}/frais-forfait/{id}/update', [FraisController::class, 'update'])
    ->name('frais.update');

  Route::put('/fiche-frais/{mois}/{idVisiteur}/frais-hors-forfait/{id}/update', [FraisHorsForfaitController::class, 'update'])
    ->name('frais-hors-forfait.update');

  Route::delete('/frais-forfait/{mois}/{idVisiteur}/{id}/destroy/', [FraisController::class, 'destroy'])
    ->name('frais.destroy');

  Route::delete('/frais-hors-forfait/{mois}/{idVisiteur}/{id}/destroy/', [FraisHorsForfaitController::class, 'destroy'])
    ->name('frais-hors-forfait.destroy');
});



Route::get('/about', function () {
  return Inertia::render('About');
});

// Route::get('/dashboard', function () {
//     return Inertia::render('Dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
  Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
  Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
  Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
  ->name('logout');

Route::fallback(function () {
  return redirect()->route("dashboard")->with('notification', [
    'titre' => 'Erreur 404',
    'message' => 'La page que vous recherchez est introuvable.',
    'etat' => 'fail', // ou 'error' selon comment tu gères l'affichage
  ]);
});
require __DIR__ . '/auth.php';
