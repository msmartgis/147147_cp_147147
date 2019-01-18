<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PointDesserviCategorie extends Model
{
    protected $table = 'point_desservi_categories';

    public function point_desservis()
    {
        return $this->hasMany('App\PointDesservi', 'categorie_point_id', 'id');
    }
}
