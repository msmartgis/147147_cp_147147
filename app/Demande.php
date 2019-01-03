<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Demande extends Model
{
    // protected $fillable = ['num_ordre', 'objet_fr', 'objet_ar'];

    public function communes()
    {
        return $this->belongsToMany('App\Commune', 'commune_projet')->withTimestamps();
    }

    public function point_desservi()
    {
        return $this->belongsToMany('App\PointDesservi', 'pointdesservi_demande')->withTimestamps();
    }

    public function piste()
    {
        return $this->hasOne('App\Commune');
    }

    public function porteur()
    {
        return $this->hasOne('App\Porteur');
    }
}
