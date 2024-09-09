<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FicheFrais extends Model
{
    protected $table = 'fiche_frais';

    protected $fillable = [
        'mois',
        'idVisiteur',
        'nbJustificatifs',
        'montantValide',
        'dateModif',
        'cloture',
    ];

    public function visiteur()
    {
        return $this->belongsTo(User::class, 'idVisiteur');
    }

    public function fraisHorsForfait()
    {
        return $this->hasMany(FraisHorsForfait::class, 'fiche_frais_id');
    }

    public function fraisForfait()
    {
        return $this->hasMany(FraisForfait::class, 'fiche_frais_id');
    }
}
