<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PartenaireType extends Model
{
    protected $table = 'partenaires_types';

    public function demandes()
    {
        return $this->belongsToMany('App\Demande', 'partenaire_demande', 'partenaire_id', 'demande_id')->withPivot('montant')->withTimestamps();
    }


}
