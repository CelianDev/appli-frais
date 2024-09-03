<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FraisHorsForfait extends Model
{
    use HasFactory;

    protected $table = 'frais_hors_forfait';

    // Méthode pour récupérer les frais pour un visiteur spécifique
    public static function forUser($user)
    {
        return self::where('idVisiteur', $user->id)->get();
    }
}
