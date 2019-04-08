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


    public function conventions()
    {
        return $this->belongsToMany('App\Convention', 'partenaire_convention', 'partenaire_id', 'convention_id')->withPivot('montant')->withTimestamps();
    }


    public function versements()
    {
        return $this->hasMany('App\SuiviVersement', 'partenaire_id', 'id');
    }



}
