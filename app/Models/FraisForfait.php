<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FraisForfait extends Model
{
    protected $table = 'frais_forfait';

    protected $fillable = [
        'fiche_frais_id',
        'type_frais_forfait_id',
        'quantite',
        'etat',
        'date',
    ];

    public function ficheFrais()
    {
        return $this->belongsTo(FicheFrais::class, 'fiche_frais_id');
    }

    public function typeFraisForfait()
    {
        return $this->belongsTo(TypeFraisForfait::class, 'type_frais_forfait_id');
    }

    public static function forUser($user)
    {
        return self::with('typeFraisForfait') // Charge la relation type_frais_forfait
            ->whereHas('ficheFrais', function ($query) use ($user) {
                $query->where('idVisiteur', $user->id);
            })->get();
    }
}
