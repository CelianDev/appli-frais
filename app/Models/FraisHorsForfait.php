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
        'justificatifs',
    ];

    // Cette propriété permet d'indiquer que la colonne "justificatifs" doit être traitée comme un tableau JSON
    protected $casts = [
        'justificatifs' => 'array',
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
