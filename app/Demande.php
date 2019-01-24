<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Demande extends Model
{
    // protected $fillable = ['num_ordre', 'objet_fr', 'objet_ar'];
    use SoftDeletes;
    protected $dates = ['deleted_at'];

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

    public function convention()
    {
        return $this->belongsTo('App\Convention', 'demande_id');
    }
}
