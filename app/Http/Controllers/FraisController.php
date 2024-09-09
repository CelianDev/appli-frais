<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Frais;
use App\Models\FraisForfait;
use App\Models\FraisHorsForfait;
use App\Models\FicheFrais;
use App\Models\TypeFraisForfait;
use Carbon\Carbon;
use Inertia\Inertia;
use Illuminate\Support\Facades\Log;

class FraisController extends Controller
{
  // Afficher le formulaire de création d'un frais
  public function create($mois, $idVisiteur,  Request $request)
  {
    // Récupérer l'utilisateur authentifié
    $currentUserId = auth()->id();

    // Vérifier si l'utilisateur connecté correspond à l'id du visiteur
    if ($currentUserId !== (int) $idVisiteur) {
      return redirect()->route('dashboard')->with('notification', [
        'titre' => 'Accès interdit',
        'message' => 'Vous n\'êtes pas autorisé à accéder à cette page.',
        'etat' => 'fail', // ou 'error' selon comment tu gères l'affichage
      ]);
    }

    try {
      // Récupérer la fiche de frais et les frais associés
      $ficheFrais = FicheFrais::with(['fraisHorsForfait', 'fraisForfait.typeFraisForfait'])
        ->where('mois', $mois)
        ->where('idVisiteur', $idVisiteur)
        ->firstOrFail();
    } catch (\Exception $e) {
      return redirect()->route('dashboard')->with('notification', [
        'titre' => 'Erreur',
        'message' => 'Impossible de trouver la fiche de frais associée.',
        'etat' => 'fail',
      ]);
    }

    $currentMonth = Carbon::now()->format('Y-m'); // Mois actuel au format 'Y-m'
    $previousMonth = Carbon::now()->subMonth()->format('Y-m'); // Mois précédent au format 'Y-m'
    $currentDay = Carbon::now()->day; // Jour actuel

    // Si le mois n'est ni celui en cours, ni le mois précédent dans les 10 premiers jours du mois actuel
    if (!($mois === $currentMonth || ($mois === $previousMonth && $currentDay <= 10))) {
      return to_route('fiche-frais.show', ['mois' => $mois, 'idVisiteur' => $idVisiteur])
        ->with('notification', [
          'titre' => 'Erreur d\'accès',
          'message' => 'Impossible d\'ajouter des frais à une fiche de frais d\'un mois précédent.',
          'etat' => 'fail',
        ]);
    }


    // Récupérer tous les types de frais forfaitisés
    $typesFrais = TypeFraisForfait::all();

    // Vérifier si une notification a été envoyée depuis la requête
    $notification = $request->input('notification') ?? null;

    // Envoyer les données à la vue avec Inertia
    return Inertia::render('Dashboard/Index', [
      'ficheFrais' => $ficheFrais,
      'fraisHorsForfait' => $ficheFrais->fraisHorsForfait,
      'fraisForfait' => $ficheFrais->fraisForfait,
      'typesFrais' => $typesFrais, // Ajout des types de frais
      'content' => 'formulaireFrais',
      'notification' => $notification, // Transmettre la notification
      'breadcrumb' => [
        [
          'name' => 'Note de frais',
          'href' => route('fiche-frais.index', ['idVisiteur' => $idVisiteur]),
          'current' => false,
        ],
        [
          'name' => 'Détails',
          'href' => route('fiche-frais.show', ['mois' => $mois, 'idVisiteur' => $idVisiteur]),
          'current' => false,
        ],
        [
          'name' => 'Nouveau frais',
          'href' => '#',
          'current' => true,
        ],
      ],
    ]);
  }

  // Enregistrer un frais forfaitaire
  public function store(Request $request, $mois, $idVisiteur)
  {
    // Récupérer l'utilisateur authentifié
    $currentUserId = auth()->id();

    // Vérifier si l'utilisateur connecté correspond à l'id du visiteur
    if ($currentUserId !== (int) $idVisiteur) {
      return redirect()->route("dashboard")->with('notification', [
        'titre' => 'Accès interdit',
        'message' => 'Vous n\'êtes pas autorisé à accéder à cette page.',
        'etat' => 'fail', // ou 'error' selon comment tu gères l'affichage
      ]);
    }

    // Valider les données
    $validated = $request->validate([
      'type_frais_forfait_id' => 'required|exists:type_frais_forfait,id',
      'quantite' => 'required|integer|min:1|max:99',
    ]);

    try {
      // Récupérer la fiche de frais associée
      $ficheFrais = FicheFrais::where('mois', $mois)
        ->where('idVisiteur', $idVisiteur)
        ->firstOrFail();
    } catch (\Exception $e) {
      return redirect()->route('dashboard')->with('notification', [
        'titre' => 'Erreur',
        'message' => 'Impossible de trouver la fiche de frais associée.',
        'etat' => 'fail',
      ]);
    }

    $currentMonth = Carbon::now()->format('Y-m'); // Mois actuel au format 'Y-m'
    $previousMonth = Carbon::now()->subMonth()->format('Y-m'); // Mois précédent au format 'Y-m'
    $currentDay = Carbon::now()->day; // Jour actuel

    // Si le mois n'est ni celui en cours ni celui précédent (avec la condition des 10 premiers jours)
    if (!($mois === $currentMonth || ($mois === $previousMonth && $currentDay <= 10))) {
      return to_route('fiche-frais.show', ['mois' => $mois, 'idVisiteur' => $idVisiteur])
        ->with('notification', [
          'titre' => 'Erreur d\'accès',
          'message' => 'Impossible d\'ajouter des frais à une fiche de frais d\'un mois précédent.',
          'etat' => 'fail',
        ]);
    }

    // Créer un nouveau frais forfaitaire
    $fraisForfait = new FraisForfait();
    $fraisForfait->fiche_frais_id = $ficheFrais->id;
    $fraisForfait->type_frais_forfait_id = $validated['type_frais_forfait_id'];
    $fraisForfait->quantite = $validated['quantite'];
    $fraisForfait->etat = "en attente";
    $fraisForfait->date = now()->format('Y-m-d');
    $fraisForfait->save();

    return redirect()->route('fiche-frais.show', ['mois' => $mois, 'idVisiteur' => $idVisiteur])
      ->with('message', 'Frais forfaitaire ajouté avec succès')
      ->with('notification', 'success');
  }

  public function edit($mois, $idVisiteur, $id, Request $request)
  {
    // Récupérer l'utilisateur authentifié
    $currentUserId = auth()->id();

    // Vérifier si l'utilisateur connecté correspond à l'id du visiteur
    if ($currentUserId !== (int) $idVisiteur) {
      return redirect()->route("dashboard")->with('notification', [
        'titre' => 'Accès interdit',
        'message' => 'Vous n\'êtes pas autorisé à accéder à cette page.',
        'etat' => 'fail', // ou 'error' selon comment tu gères l'affichage
      ]);
    }

    $currentMonth = Carbon::now()->format('Y-m'); // Mois actuel au format 'Y-m'
    $previousMonth = Carbon::now()->subMonth()->format('Y-m'); // Mois précédent au format 'Y-m'
    $currentDay = Carbon::now()->day; // Jour actuel

    // Si le mois n'est ni celui en cours, ni le mois précédent dans les 10 premiers jours du mois actuel
    if (!($mois === $currentMonth || ($mois === $previousMonth && $currentDay <= 10))) {
      return to_route('fiche-frais.show', ['mois' => $mois, 'idVisiteur' => $idVisiteur])
        ->with('notification', [
          'titre' => 'Erreur d\'accès',
          'message' => 'Impossible d\'ajouter des frais à une fiche de frais d\'un mois précédent.',
          'etat' => 'fail',
        ]);
    }

    try {
      $frais = FraisForfait::findOrFail($id);
    } catch (\Exception $e) {
      return redirect()->route('dashboard')->with('notification', [
        'titre' => 'Erreur',
        'message' => 'Impossible de trouver le frais forfaitaire associé.',
        'etat' => 'fail',
      ]);
    }

    try {
      // Récupérer la fiche de frais et les frais associés
      $ficheFrais = FicheFrais::with(['fraisHorsForfait', 'fraisForfait.typeFraisForfait'])
        ->where('mois', $mois)
        ->where('idVisiteur', $idVisiteur)
        ->firstOrFail();
    } catch (\Exception $e) {
      return redirect()->route('dashboard')->with('notification', [
        'titre' => 'Erreur',
        'message' => 'Impossible de trouver la fiche de frais associée.',
        'etat' => 'fail',
      ]);
    }

    // Vérifier que l'ID de la fiche de frais associé au frais forfaitaire correspond bien
    if ($frais->fiche_frais_id !== $ficheFrais->id) {
      return redirect()->route('dashboard')->with('notification', [
        'titre' => 'Erreur',
        'message' => 'Le frais forfaitaire ne correspond pas à la fiche de frais associée.',
        'etat' => 'fail',
      ]);
    }

    // Récupérer tous les types de frais forfaitisés
    $typesFrais = TypeFraisForfait::all();

    // Vérifier si une notification a été envoyée depuis la requête
    $notification = $request->input('notification') ?? null;

    // Envoyer les données à la vue avec Inertia
    return Inertia::render('Dashboard/Index', [
      'frais' => $frais,
      'ficheFrais' => $ficheFrais,
      'fraisHorsForfait' => $ficheFrais->fraisHorsForfait,
      'fraisForfait' => $ficheFrais->fraisForfait,
      'typesFrais' => $typesFrais, // Ajout des types de frais
      'content' => 'fraisDetails',
      'notification' => $notification, // Transmettre la notification
      'breadcrumb' => [
        [
          'name' => 'Note de frais',
          'href' => route('fiche-frais.index', ['idVisiteur' => $idVisiteur]),
          'current' => false,
        ],
        [
          'name' => 'Détails',
          'href' => route('fiche-frais.show', ['mois' => $mois, 'idVisiteur' => $idVisiteur]),
          'current' => false,
        ],
        [
          'name' => 'Frais',
          'href' => '#',
          'current' => true,
        ],
      ],
    ]);
  }

  public function update($mois, $idVisiteur, $id, Request $request)
  {
    // Récupérer l'utilisateur authentifié
    $currentUserId = auth()->id();

    // Vérifier si l'utilisateur connecté correspond à l'id du visiteur
    if ($currentUserId !== (int) $idVisiteur) {
      return redirect()->route("dashboard")->with('notification', [
        'titre' => 'Accès interdit',
        'message' => 'Vous n\'êtes pas autorisé à accéder à cette page.',
        'etat' => 'fail',
      ]);
    }

    // Valider les données soumises selon le type de frais soumis
    if ($request->has('type_frais_forfait_id')) {
      // Validation pour frais forfaitaire
      $validatedData = $request->validate([
        'type_frais_forfait_id' => 'required|exists:type_frais_forfait,id',
        'quantite' => 'required|integer|min:1|max:99',
      ]);
    } else {
      // Validation pour frais hors forfait
      $validatedData = $request->validate([
        'libelle' => 'required|string|max:64',
        'montant' => 'required|numeric|max:9999.99',
        'justificatifs.*' => 'file|mimes:jpeg,png,gif,pdf|max:10240', // Maximum 10 MB par fichier
      ]);
    }

    // Vérifier que le mois est correct
    $currentMonth = Carbon::now()->format('Y-m');
    $previousMonth = Carbon::now()->subMonth()->format('Y-m');
    $currentDay = Carbon::now()->day;

    if (!($mois === $currentMonth || ($mois === $previousMonth && $currentDay <= 10))) {
      return to_route('fiche-frais.show', ['mois' => $mois, 'idVisiteur' => $idVisiteur])
        ->with('notification', [
          'titre' => 'Erreur d\'accès',
          'message' => 'Impossible de modifier un frais d\'un mois précédent.',
          'etat' => 'fail',
        ]);
    }

    // Vérification du type de frais (frais forfait ou hors forfait)
    $fraisHorsForfait = FraisHorsForfait::where('id', $id)
      ->whereHas('ficheFrais', function ($query) use ($idVisiteur) {
        $query->where('idVisiteur', $idVisiteur);
      })
      ->first();

    $fraisForfait = FraisForfait::where('id', $id)
      ->whereHas('ficheFrais', function ($query) use ($idVisiteur) {
        $query->where('idVisiteur', $idVisiteur);
      })
      ->first();

    // Si on passe d'un frais hors forfait à un frais forfaitaire
    if ($fraisHorsForfait && $request->has('type_frais_forfait_id')) {
      // Supprimer l'ancien frais hors forfait
      $fraisHorsForfait->delete();

      // Créer un nouveau frais forfaitaire
      try {
        $nouveauFraisForfait = new FraisForfait();
        $nouveauFraisForfait->fiche_frais_id = $fraisHorsForfait->fiche_frais_id;
        $nouveauFraisForfait->type_frais_forfait_id = $validatedData['type_frais_forfait_id'];
        $nouveauFraisForfait->quantite = $validatedData['quantite'];
        $nouveauFraisForfait->etat = "en attente";
        $nouveauFraisForfait->date = now()->format('Y-m-d'); // Ajout de la date
        $nouveauFraisForfait->save(); // Sauvegarder le nouveau frais forfaitaire

        \Log::info("Nouveau frais forfait créé. ID: {$nouveauFraisForfait->id}");
      } catch (\Exception $e) {
        return redirect()->route('dashboard')->with('notification', [
          'titre' => 'Erreur',
          'message' => "Erreur lors de la création du nouveau frais forfaitaire. {$e->getMessage()}",
          'etat' => 'fail',
        ]);
      }

      // Si on passe d'un frais forfait à un frais hors forfait
    } elseif ($fraisForfait && !$request->has('type_frais_forfait_id')) {
      // Supprimer l'ancien frais forfaitaire
      $fraisForfait->delete();

      // Créer un nouveau frais hors forfait
      try {
        $nouveauFraisHorsForfait = new FraisHorsForfait();
        $nouveauFraisHorsForfait->fiche_frais_id = $fraisForfait->fiche_frais_id;
        $nouveauFraisHorsForfait->libelle = $validatedData['libelle'];
        $nouveauFraisHorsForfait->montant = $validatedData['montant'];
        $nouveauFraisHorsForfait->etat = "en attente";
        $nouveauFraisHorsForfait->date = now()->format('Y-m-d'); // Ajout de la date

        // Gestion des fichiers justificatifs
        $justificatifs = [];
        if ($request->hasFile('justificatifs')) {
          foreach ($request->file('justificatifs') as $file) {
            $path = $file->store('justificatifs', 'public');
            $justificatifs[] = $path;
          }
          $nouveauFraisHorsForfait->justificatifs = json_encode($justificatifs);
        }

        $nouveauFraisHorsForfait->save(); // Sauvegarder le nouveau frais hors forfait

        \Log::info("Nouveau frais hors forfait créé. ID: {$nouveauFraisHorsForfait->id}");
      } catch (\Exception $e) {
        return redirect()->route('dashboard')->with('notification', [
          'titre' => 'Erreur',
          'message' => "Erreur lors de la création du nouveau frais hors forfait. {$e->getMessage()}",
          'etat' => 'fail',
        ]);
      }

      // Si le frais reste du même type
    } else {
      // Si c'est toujours un frais hors forfait
      if ($fraisHorsForfait) {
        $fraisHorsForfait->libelle = $validatedData['libelle'];
        $fraisHorsForfait->montant = $validatedData['montant'];

        // Mise à jour des fichiers justificatifs si présents
        if ($request->hasFile('justificatifs')) {
          $justificatifs = [];
          foreach ($request->file('justificatifs') as $file) {
            $path = $file->store('justificatifs', 'public');
            $justificatifs[] = $path;
          }
          $fraisHorsForfait->justificatifs = json_encode($justificatifs);
        }

        $fraisHorsForfait->save();

        // Si c'est toujours un frais forfaitaire
      } elseif ($fraisForfait) {
        $fraisForfait->type_frais_forfait_id = $validatedData['type_frais_forfait_id'];
        $fraisForfait->quantite = $validatedData['quantite'];
        $fraisForfait->save();
      }
    }

    // Rediriger avec un message de succès
    return redirect()->route('fiche-frais.show', ['mois' => $mois, 'idVisiteur' => $idVisiteur])
      ->with('message', 'Frais mis à jour avec succès');
  }



  // Supprimer un frais
  public function destroy($mois, $idVisiteur, $id)
  {
    // Récupérer l'utilisateur authentifié
    $currentUserId = auth()->id();

    // Vérifier si l'utilisateur connecté correspond à l'id du visiteur
    if ($currentUserId !== (int) $idVisiteur) {
      return redirect()->route("dashboard")->with('notification', [
        'titre' => 'Accès interdit',
        'message' => 'Vous n\'êtes pas autorisé à accéder à cette page.',
        'etat' => 'fail', // ou 'error' selon comment tu gères l'affichage
      ]);
    }

    try {
      $frais = FraisForfait::findOrFail($id);
    } catch (\Exception $e) {
      return redirect()->route('dashboard')->with('notification', [
        'titre' => 'Erreur',
        'message' => 'Impossible de trouver le frais forfaitaire associé.',
        'etat' => 'fail',
      ]);
    }

    $frais->delete();

    return redirect()->back()->with('message', 'Frais supprimé avec succès.');
  }

  // Afficher le formulaire d'édition d'un frais
  // public function edit($id)
  // {
  //     $frais = Frais::findOrFail($id);

  //     return Inertia::render('Frais/Edit', [
  //         'frais' => $frais,
  //     ]);
  // }

  // // Supprimer un frais
  // public function destroy($id)
  // {
  //     $frais = Frais::findOrFail($id);
  //     $frais->delete();

  //     return redirect()->back()->with('message', 'Frais supprimé avec succès.');
  // }
}
