<?php

namespace App\Http\Controllers;

use App\Porteur;
use Illuminate\Http\Request;

class PorteurController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $porteur = new Porteur();
        $porteur->type = 'assoc';
        $porteur->nom_porteur_fr = $request->nom_porteur_fr;
        $porteur->nom_porteur_ar = $request->nom_porteur_ar;
        $porteur->adresse = $request->adresse;
        $porteur->save();


        if($porteur)
        {
            return redirect('/parametres')->with('success', 'Association ajoutée avec succès');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Porteur  $porteur
     * @return \Illuminate\Http\Response
     */
    public function show(Porteur $porteur)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Porteur  $porteur
     * @return \Illuminate\Http\Response
     */
    public function edit(Porteur $porteur)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Porteur  $porteur
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Porteur $porteur)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Porteur  $porteur
     * @return \Illuminate\Http\Response
     */
    public function destroy(Porteur $porteur)
    {
        //
    }


    public function update_assoc(Request $request)
    {
        $assoc_to_update = Porteur::find($request->id);
        $assoc_to_update->nom_porteur_fr = $request->nom_porteur_fr;
        $assoc_to_update->nom_porteur_ar = $request->nom_porteur_ar;
        $assoc_to_update->adresse = $request->adresse;

        $assoc_to_update->save();
        return redirect("/parametres")->with('success', 'Modification a été éffectuer avec succès');
    }


    public function deleteAssoc(Request $req)
    {
        $assoc = Porteur::where('id','=',$req->id)->where('type','=','assoc');
        $assoc->delete();
        return response()->json();
    }


}
