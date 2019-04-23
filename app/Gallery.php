<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    public function convention()
    {
        return $this->belongsTo('App\Convention', 'convention_id');
    }
}
