<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FraisHorsForfait extends Model
{
    protected $table = 'frais_hors_forfait';

    protected $fillable = [
        'fiche_frais_id',
        'date',
        'libelle',
        'montant',
        'etat',
    ];

    public function ficheFrais()
    {
        return $this->belongsTo(FicheFrais::class, 'fiche_frais_id');
    }

    // Méthode pour récupérer les frais pour un visiteur spécifique
    public static function forUser($user)
    {
        return self::whereHas('ficheFrais', function ($query) use ($user) {
            $query->where('idVisiteur', $user->id);
        })->get();
    }
}
