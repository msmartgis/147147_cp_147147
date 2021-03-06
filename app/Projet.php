<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Projet extends Model
{


    public function communes()
    {
        return $this->belongsToMany('App\Commune', 'commune_convention')->withTimestamps();
    }

    public function interventions()
    {
        return $this->belongsToMany('App\Intervention', 'intervention_convention')->withTimestamps();
    }


    public function point_desservis()
    {
        return $this->belongsToMany('App\PointDesservi', 'pointdesservi_convention')->withTimestamps();
    }

    /*public function piste()
    {
        return $this->hasOne('App\Piste');
    }*/


    public function piece()
    {
        return $this->hasMany('App\Piece');
    }

    public function session()
    {
        return $this->belongsTo('App\Session', 'session_id');
    }

    public function moas()
    {
        return $this->belongsToMany('App\Moa', 'moa_convention')->withTimestamps();
    }

    public function partenaires()
    {
        return $this->belongsToMany('App\PartenaireType', 'partenaire_convention', 'convention_id', 'partenaire_id')->withPivot('montant')->withTimestamps();
    }


    public function programmes()
    {
        return $this->belongsToMany('App\Programme', 'programmes_projet')->withTimestamps();
    }

    public function etat()
    {
        return $this->hasMany('App\Etat');
    }

}
