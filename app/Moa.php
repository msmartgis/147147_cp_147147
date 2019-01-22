<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Moa extends Model
{

    public function convention()
    {
        return $this->belongsToMany('App\Convention', 'moa_convention')->withTimestamps();
    }
}
