<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DCE extends Model
{
    protected  $table = 'dce';
    public function appelOffre()
    {
        return $this->belongsTo('App\AppelOffre', 'appel_offre_id');
    }
}
