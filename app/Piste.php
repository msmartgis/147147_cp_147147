<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Uuids;
use Webpatser\Uuid\Uuid;

class Piste extends Model
{
    protected $fillable = ['id'];

    public $incrementing = false;

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->id = (string) Uuid::generate();
        });
    }

    public function demande()
    {
        return $this->belongsTo('App\Demande', 'demande_id');
    }


    public function convention()
    {
        return $this->belongsTo('App\Convention', 'convention_id');
    }

}
