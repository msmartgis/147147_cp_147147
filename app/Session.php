<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    public function demandes()
    {
        return $this->hasMany('App\Demande', 'session_id', 'id');
    }

    public function conventions()
    {
        return $this->hasMany('App\Convention', 'session_id', 'id');
    }
}
