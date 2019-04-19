<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AppelOffre extends Model
{
    protected $table = "appel_offres";

    public function conventions()
    {
        return $this->hasMany('App\Convention');
    }

    public function dossierAdjiducataire()
    {
        return $this->hasMany('App\DossierAdjiducataire');
    }

    public function moas()
    {
        return $this->belongsTo('App\Moa', 'moa_id');
    }


    public function adjiducataires()
    {
        return $this->belongsTo('App\Adjiducataire', 'adjiducataire_id');
    }

    public function dce()
    {
        return $this->hasMany('App\DCE');
    }

}
