<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Commune extends Model
{
    public function demandes()
    {
        return $this->belongsToMany('App\Demande', 'commune_demande')->withTimestamps();
    }

    public function conventions()
    {
        return $this->belongsToMany('App\Convention', 'commune_convention')->withTimestamps();
    }
}
