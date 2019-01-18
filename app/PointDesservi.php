<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PointDesservi extends Model
{

    public function demandes()
    {
        return $this->belongsToMany('App\Demande', 'pointdesservi_demande')->withTimestamps();
    }

    public function point_desservi_categories()
    {
        return $this->belongsTo('App\PointDesserviCategorie');
    }

}
