<?php

namespace App\Http\Controllers;

use App\Models\FraisHorsForfait;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class FraisHorsForfaitController extends Controller
{
    public function show($id)
    {
        // Récupérer l'utilisateur connecté
        $user = Auth::user();

        // Rechercher le frais en s'assurant qu'il appartient à l'utilisateur via la relation avec fiche_frais
        $frais = FraisHorsForfait::where('id', $id)
            ->whereHas('ficheFrais', function ($query) use ($user) {
                $query->where('idVisiteur', $user->id);
            })
            ->firstOrFail();

        // Renvoyer la vue principale avec les détails du frais
        return Inertia::render('Dashboard/Index', [
            'fraisDetails' => $frais,
            'content' => 'fraisDetails',
            // Ajoutez d'autres props si nécessaire, comme la liste des frais
        ]);
    }
}
