<?php

namespace App\Http\Controllers;

use App\Piste;
use Illuminate\Http\Request;

class PisteRelationshipController extends Controller
{
    public function geometry(Piste $piste)
    {
        return new GeometryIdentifierResource($piste->geometries);
    }

}
