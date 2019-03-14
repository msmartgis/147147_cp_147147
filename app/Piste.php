<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Piste extends Model
{
    public function demande()
    {
        return $this->belongsTo('App\Demande', 'demande_id');
    }


    public function conventions()
    {
        return $this->hasMany('App\Convention', 'convention_id', 'id');
    }
}
