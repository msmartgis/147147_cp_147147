<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Geometry extends Model
{
    public function piste()
    {
        return $this->belongsTo('App\Piste', 'piste_id');
    }
}
