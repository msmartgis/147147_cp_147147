<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Porteur extends Model
{

    protected $table = 'porteursprojets';
    public function demande()
    {
        return $this->belongsTo('App\Demande');
    }
}
