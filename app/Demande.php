<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Uuids;
use Webpatser\Uuid\Uuid;
class Demande extends Model
{
    protected $fillable = ['id','num_ordre', 'date_reception', 'objet_fr', 'objet_ar', 'montant_global', 'observation', 'decision', 'etat', 'is_affecter', 'porteur_projet_id'];
    use SoftDeletes;

    protected $dates = ['deleted_at','date_reception'];
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
        return $this->belongsToMany('App\Commune', 'commune_demande')->withTimestamps();
    }

    public function interventions()
    {
        return $this->belongsToMany('App\Intervention', 'intervention_demande','demande_id', 'intervention_id')->withTimestamps();
    }

    public function partenaires()
    {
        return $this->belongsToMany('App\PartenaireType', 'partenaire_demande', 'demande_id', 'partenaire_id')->withPivot('montant')->withTimestamps();
    }

    public function point_desservis()
    {
        return $this->belongsToMany('App\PointDesservi', 'pointdesservi_demande')->withTimestamps();
    }

    public function piste()
    {
        return $this->hasOne('App\Piste','demande_id');
    }

    public function porteur()
    {
        return $this->belongsTo('App\Porteur', 'porteur_projet_id');
    }

    public function piece()
    {
        return $this->hasMany('App\Piece');
    }

    public function session()
    {
        return $this->belongsTo('App\Session', 'session_id');
    }

    public function convention()
    {
        return $this->belongsTo('App\Convention', 'demande_id');
    }

    public function sourceFinancement()
    {
        return $this->belongsToMany('App\SourceFinancement', 'sourcefinancement_demande','demande_id', 'sourceFinancement_id')->withPivot('montant')->withTimestamps();
    }
}
