<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Avancement extends Model
{
    protected $table = 'avancement';
    public function conventions()
    {
        return $this->hasMany('App\Convention', 'avancement_id', 'id');
    }
}
