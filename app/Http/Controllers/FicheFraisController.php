<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Carbon\Carbon;
use App\Models\FicheFrais;
use App\Models\User;

class FicheFraisController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fichesFrais = FicheFrais::all();
        return view('fiche_frais.index', compact('fichesFrais'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $visiteurs = User::all();
        return view('fiche_frais.create', compact('visiteurs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'mois' => 'required|string',
            'idVisiteur' => 'required|exists:visiteurs,id',
            'nbJustificatifs' => 'required|integer',
            'montantValide' => 'required|numeric',
            'dateModif' => 'required|date',
        ]);

        FicheFrais::create($request->all());

        return redirect()->route('fiche_frais.index')->with('success', 'Fiche frais créée avec succès.');
    }

    public function show($mois, $idVisiteur)
    {
        // Récupérer la fiche de frais avec les frais hors forfait associés
        $ficheFrais = FicheFrais::with('fraisHorsForfait')
            ->where('mois', $mois)
            ->where('idVisiteur', $idVisiteur)
            ->firstOrFail();

        // Debugging
        // dd($ficheFrais->fraisHorsForfait);

        // Envoyer les données à la vue avec Inertia
        return Inertia::render('Dashboard/Index', [
            'ficheFrais' => $ficheFrais,
            'fraisHorsForfait' => $ficheFrais->fraisHorsForfait,
            'content' => 'ficheFrais',
            'breadcrumb' => [
                [
                    'name' => 'Note de frais',
                    // 'href' => route('fiche-frais.index'), // Lien vers l'index ou accueil
                    'current' => false,
                ],
                [
                    'name' => 'Détails',
                    'href' => '#', // Pas de lien car c'est la page actuelle
                    'current' => true,
                ],
            ],
        ]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  string $mois
     * @param  int $idVisiteur
     * @return \Illuminate\Http\Response
     */
    public function edit($mois, $idVisiteur)
    {
        $ficheFrais = FicheFrais::where('mois', $mois)->where('idVisiteur', $idVisiteur)->firstOrFail();
        $visiteurs = User::all();
        return view('fiche_frais.edit', compact('ficheFrais', 'visiteurs'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string $mois
     * @param  int $idVisiteur
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $mois, $idVisiteur)
    {
        $request->validate([
            'nbJustificatifs' => 'required|integer',
            'montantValide' => 'required|numeric',
            'dateModif' => 'required|date',
        ]);

        $ficheFrais = FicheFrais::where('mois', $mois)->where('idVisiteur', $idVisiteur)->firstOrFail();
        $ficheFrais->update($request->all());

        return redirect()->route('fiche_frais.index')->with('success', 'Fiche frais mise à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string $mois
     * @param  int $idVisiteur
     * @return \Illuminate\Http\Response
     */
    public function destroy($mois, $idVisiteur)
    {
        $ficheFrais = FicheFrais::where('mois', $mois)->where('idVisiteur', $idVisiteur)->firstOrFail();
        $ficheFrais->delete();

        return redirect()->route('fiche_frais.index')->with('success', 'Fiche frais supprimée avec succès.');
    }

    public function updateClotureStatus()
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
            }
        }
    }
}
