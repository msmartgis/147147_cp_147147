<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SourceFinancement extends Model
{
    protected $table = 'sourcesfinancements';
    public function demandes()
    {
        return $this->belongsToMany('App\Demande','sourcefinancement_demande','sourceFinancement_id','demande_id')->withPivot('montant')->withTimestamps();
    }


    public function conventions()
    {
        return $this->belongsToMany('App\Convention')->withPivot('montant')->withTimestamps();
    }
}
