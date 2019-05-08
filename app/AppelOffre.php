<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Uuids;
use Webpatser\Uuid\Uuid;

class AppelOffre extends Model
{
    protected $table = "appel_offres";
    protected $fillable = ['id'];
    public $incrementing = false;

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->id = (string) Uuid::generate();
        });
    }

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
