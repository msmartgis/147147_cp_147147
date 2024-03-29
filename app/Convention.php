<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Uuids;
use Webpatser\Uuid\Uuid;
class Convention extends Model
{
    protected $fillable = ['id','num_ordre', 'objet_fr', 'objet_ar', 'montant_global', 'observation', 'etat'];
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    public $incrementing = false;

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->id = (string) Uuid::generate();
        });
    }

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
        return $this->belongsTo('App\Moa', 'moa_id');
    }



    public function partenaires()
    {
        return $this->belongsToMany('App\PartenaireType', 'partenaire_convention', 'convention_id', 'partenaire_id')->withPivot('montant')->withTimestamps();
    }


    public function programme()
    {
        return $this->belongsTo('App\Programme', 'programme_id');
    }


    public function piste()
    {
        return $this->hasOne('App\Piste','convention_id');
    }


    public function versements()
    {
        return $this->hasMany('App\SuiviVersement', 'convention_id', 'id');
    }

    public function porteur()
    {
        return $this->belongsTo('App\Porteur', 'porteur_projet_id');
    }

    public function appelOffres()
    {
        return $this->belongsTo('App\AppelOffre', 'appel_offre_id');
    }


    public function etats()
    {
        return $this->hasMany('App\Etat');
    }

    public function galleries()
    {
        return $this->hasMany('App\Gallery');
    }

    public function sourceFinancement()
    {
        return $this->belongsToMany('App\SourceFinancement', 'sourcefinancement_demande','id_convention', 'sourceFinancement_id')->withPivot('montant')->withTimestamps();
    }
}
