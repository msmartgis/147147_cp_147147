<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Adjiducataire extends Model
{
    public function appelOffres()
    {
        return $this->hasMany('App\AppelOffre', 'adjiducataire_id', 'id');
    }
}
