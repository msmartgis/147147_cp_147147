<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Demande extends Model
{
    // protected $fillable = ['num_ordre', 'objet_fr', 'objet_ar'];

    public function communes()
    {
        return $this->belongsToMany('App\Commune', 'commune_demande')->withTimestamps();
    }

    public function interventions()
    {
        return $this->belongsToMany('App\Intervention', 'intervention_demande')->withTimestamps();
    }

    public function partenaire()
    {
        return $this->belongsToMany('App\Partenaire', 'partenaire_demande')->withTimestamps();
    }

    //through many 
    public function type_partenaires()
    {
        return $this->hasManyThrough('App\PartenaireType', 'App\Partenaire');
    }

    public function point_desservi()
    {
        return $this->belongsToMany('App\PointDesservi', 'pointdesservi_demande')->withTimestamps();
    }

    public function piste()
    {
        return $this->hasOne('App\Piste');
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
