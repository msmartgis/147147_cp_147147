<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SourceFinancement extends Model
{
    protected $table = 'sourcesfinancements';
    public function demandes()
    {
        return $this->belongsToMany('App\Demande')->withPivot('montant')->withTimestamps();
    }
}
