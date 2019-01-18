<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    public function demandes()
    {
        return $this->hasMany('App\Demande', 'session_id', 'id');
    }
}
