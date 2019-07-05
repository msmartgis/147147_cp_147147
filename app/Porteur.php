<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Porteur extends Model
{

    protected $table = 'porteurs_projets';
    public function demande()
    {
        return $this->hasMany('App\Demande', 'porteur_projet_id', 'id');
    }


    public function convention()
    {
        return $this->hasMany('App\Convention', 'porteur_projet_id', 'id');
    }


}
