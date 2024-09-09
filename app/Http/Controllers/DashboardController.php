<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\FraisHorsForfait;
use App\Models\FraisForfait;
use App\Models\FicheFrais;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
  public function index(Request $request): Response
  {
    // Récupère l'utilisateur connecté
    $user = Auth::user();
    $idVisiteur = auth()->id();

    // Récupère les frais hors forfait associés à l'utilisateur
    $fraisHorsForfait = FraisHorsForfait::forUser($user);

    // Récupère les frais forfaitisés associés à l'utilisateur
    $fraisForfait = FraisForfait::forUser($user);

    // Calculer la date il y a 12 mois
    $twelveMonthsAgo = Carbon::now()->subMonths(12)->format('Y-m'); // 'Y-m' format (ex. : '2023-09')
    $currentMonth = Carbon::now()->format('Y-m'); // Date actuelle au format 'Y-m'

    try {
      // Récupérer toutes les fiches de frais pour les 12 derniers mois
      $listeFicheFrais = FicheFrais::with(['fraisHorsForfait', 'fraisForfait.typeFraisForfait'])
        ->where('idVisiteur', $idVisiteur)
        ->whereBetween('mois', [$twelveMonthsAgo, $currentMonth]) // Filtrer les mois entre 12 mois en arrière et le mois actuel
        ->get(); // Utiliser get() pour récupérer toutes les fiches
    } catch (\Exception $e) {
      return redirect()->route("dashboard")->with('notification', [
        'titre' => 'Erreur',
        'message' => 'Une erreur est survenue lors de la récupération des fiches de frais.',
        'etat' => 'fail',
      ]);
    }

    // Récupérer la notification depuis la session ou les données de la requête
    $notification = session('notification') ?? $request->input('notification') ?? null;

    // Retourne la vue du tableau de bord avec les données de l'utilisateur, frais hors forfait, et frais forfaitisés
    return Inertia::render('Dashboard/Index', [
      'auth' => [
        'user' => $user
      ],
      'content' => 'dashboard',
      'listeFicheFrais' => $listeFicheFrais, // Liste des fiches de frais
      'fraisHorsForfait' => $fraisHorsForfait,
      'fraisForfait' => $fraisForfait,
      'notification' => $notification,
      'breadcrumb' => [
        [
          'name' => 'Dashboard',
          'href' => route('dashboard'),
          'current' => true,
        ],
      ],
    ]);
  }
}
