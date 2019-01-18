<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PartenaireType extends Model
{
    protected $table = 'partenaires_types';

    public function partenaires()
    {
        return $this->hasMany('App\Partenaire', 'partenaire_type_id', 'id');
    }
}
