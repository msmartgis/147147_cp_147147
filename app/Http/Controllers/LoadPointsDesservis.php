<?php

namespace App\Http\Controllers;

use App\PointDesservi;
use Response;
use Illuminate\Http\Request;



class LoadPointsDesservis extends Controller
{

    public function load_points_desservis(Request $request)
    {

        return response()->json($request);
    }

}
