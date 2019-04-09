<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SuiviVersement extends Model
{
    protected $table = "versements";
    public function partenaire()
    {
        return $this->belongsTo('App\PartenaireType', 'partenaire_id');
    }


    public function convention()
    {
        return $this->belongsTo('App\Convention', 'convention_id');
    }
}
