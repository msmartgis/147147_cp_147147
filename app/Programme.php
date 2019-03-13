<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Programme extends Model
{
    public function conventions()
    {
        return $this->belongsToMany('App\Convention', 'programmes_convention')->withTimestamps();
    }

    public function projets()
    {
        return $this->belongsToMany('App\Projet', 'programmes_projets')->withTimestamps();
    }
}
