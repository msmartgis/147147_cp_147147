<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Piste extends Model
{
    public function demande()
    {
        return $this->belongsTo('App\Demande');
    }
}