<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Partenaire extends Model
{
    public function demandes()
    {
        return $this->belongsToMany('App\Demande', 'partenaire_demande')->withTimestamps();
    }

    public function partenaire_type()
    {
        return $this->belongsTo('App\PartenaireType');
    }
}
