<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TypeFraisForfait extends Model
{
    protected $table = 'type_frais_forfait';

    protected $fillable = [
        'libelle',
        'montant',
    ];

    public function fraisForfait()
    {
        return $this->hasMany(FraisForfait::class, 'type_frais_forfait_id');
    }
}
