<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Intervention extends Model
{
    public function demandes()
    {
        return $this->belongsToMany('App\Demande', 'intervention_demande','intervention_id', 'demande_id')->withTimestamps();
    }

    public function conventions()
    {
        return $this->belongsToMany('App\Convention', 'intervention_convention')->withTimestamps();
    }
}
