<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Convention extends Model
{
    public function communes()
    {
        return $this->belongsToMany('App\Commune', 'commune_demande')->withTimestamps();
    }

    public function moas()
    {
        return $this->belongsToMany('App\Moa', 'moa_convention')->withTimestamps();
    }

    public function interventions()
    {
        return $this->belongsToMany('App\Intervention', 'intervention_demande')->withTimestamps();
    }

    public function partenaire()
    {
        return $this->belongsToMany('App\Partenaire', 'partenaire_demande')->withTimestamps();
    }


    public function point_desservi()
    {
        return $this->belongsToMany('App\PointDesservi', 'pointdesservi_demande')->withTimestamps();
    }

    public function piste()
    {
        return $this->hasOne('App\Piste');
    }

    public function demande()
    {
        return $this->hasOne('App\Demande');
    }

    public function porteur()
    {
        return $this->hasOne('App\Porteur');
    }

    public function piece()
    {
        return $this->hasOne('App\Piece');
    }

    public function session()
    {
        return $this->belongsTo('App\Session', 'session_id');
    }
}
