<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Programme extends Model
{
       public function convention()
     {
         return $this->hasMany('App\Convention', 'programme_id', 'id');
     }

    public function projets()
    {
        return $this->belongsToMany('App\Projet', 'programmes_projets')->withTimestamps();
    }

}
