<?php

namespace App\Http\Controllers;

use App\Etat;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EtatController extends Controller
{

    public function addEtat(Request $request)
    {
        $str_replace = date('Y-m-d');
        $etat  = new Etat();
        $etat->nom = $request->etat;
        $etat->convention_id = $request->convention_id;
        $str_replace =  str_replace("/",'-',$request->date);

        $etat->date = $str_replace;
        $etat->save();
        return response()->json($etat);
    }

    public function deleteEtat(Request $request)
    {
        $etat = Etat::find($request->etat_id)->delete();
        //redirecting with success message
        return response()->json();
    }
}
