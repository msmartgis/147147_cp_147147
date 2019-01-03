<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Commune extends Model
{
    public function demandes()
    {
        return $this->belongsToMany('App\Demande', 'commune_demande')->withTimestamps();
    }
}
