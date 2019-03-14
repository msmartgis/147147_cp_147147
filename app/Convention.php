<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Convention extends Model
{
    protected $fillable = ['num_ordre', 'objet_fr', 'objet_ar', 'montant_global', 'observation', 'etat'];
    use SoftDeletes;
    protected $dates = ['deleted_at'];

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




    public function piece()
    {
        return $this->hasMany('App\Piece');
    }

    public function session()
    {
        return $this->belongsTo('App\Session', 'session_id');
    }

    public function avancement()
    {
        return $this->belongsTo('App\Avancement', 'avancement_id');
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
        return $this->belongsToMany('App\Programme', 'programmes_convention')->withTimestamps();
    }


    public function piste()
    {
        return $this->belongsTo('App\Piste', 'convention_id');
    }


    /*public function porteur()
    {
        return $this->belongsTo('App\Porteur', 'porteur_projet_id');
    }*/



}
