<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class organisation extends Model
{
    public function users()
    {
        return $this->hasMany('App\User', 'organisation_id', 'id');
    }
}
