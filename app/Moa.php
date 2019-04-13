<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Moa extends Model
{

    public function conventions()
    {
        return $this->hasMany('App\Convention', 'moa_id', 'id');
    }

    public function appelOffres()
    {
        return $this->hasMany('App\AppelOffre', 'moa_id', 'id');
    }


}
