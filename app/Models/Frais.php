<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Frais extends Model
{
    protected $fillable = ['fiche_frais_id', 'date', 'libelle', 'montant', 'quantite'];

    public function ficheFrais()
    {
        return $this->belongsTo(FicheFrais::class, 'fiche_frais_id');
    }
}
