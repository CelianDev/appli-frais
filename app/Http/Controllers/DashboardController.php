<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\FraisHorsForfait;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
  public function index(): Response
  {
    // Récupère l'utilisateur connecté
    $user = Auth::user();

    // Récupère les frais hors forfait associés à l'utilisateur
    $fraisHorsForfait = FraisHorsForfait::forUser($user);

    // Retourne la vue du tableau de bord avec les données de l'utilisateur et des frais
    return Inertia::render('Dashboard/Index', [
      'auth' => [
        'user' => $user
      ],
      'content' => 'dashboard',
      'fraisHorsForfait' => $fraisHorsForfait,
      'breadcrumb' => [
        [
          'name' => 'Dashboard',
          'href' => route('dashboard'), // Lien vers l'index ou accueil
          'current' => true,
        ],
      ],
    ]);
  }
}
