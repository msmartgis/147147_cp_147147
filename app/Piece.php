<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Piece extends Model
{
    public function demande()
    {
        return $this->belongsTo('App\Demande', 'demande_id');
    }


    public function convention()
    {
        return $this->belongsTo('App\Convention', 'convention_id');
    }

}
