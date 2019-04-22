<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Etat extends Model
{
    protected $table = "etat_projets";

    public function convention()
    {
        return $this->belongsTo('App\Convention', 'convention_id');
    }
}
