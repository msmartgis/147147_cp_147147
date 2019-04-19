<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DossierAdjiducataire extends Model
{
    public function appelOffre()
    {
        return $this->belongsTo('App\AppelOffre', 'appel_offre_id');
    }
}
