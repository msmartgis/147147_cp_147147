<?php

namespace App\Http\Controllers;

use App\Demande;
use App\Commune;
use App\Piste;
use App\Porteur;
use App\PointDesservi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class DemandesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('demandes.show');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        //communes list
        $communes = Commune::orderBy('nom_fr')->pluck('nom_fr', 'id');
        
         //point desservis
        $localites = PointDesservi::where('type_point', 'localite')
            ->orderBy('nom_fr')
            ->pluck('nom_fr', 'id');

        //find the max numero ordre and increment 
        $max_num_ordre = Demande::max('num_ordre');
        $current_numero_ordre = $max_num_ordre + 1;
        return view('demandes.create')->with(
            [
                'current_numero_ordre' => $current_numero_ordre,
                'communes' => $communes,
                'localites' => $localites,
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, ['num_ordre' => 'required']);   
        
        //find the communes for this demande and put them in an array
        $communes = $request->input('communes');        
        
        //get the last id of demandes
        $id_demande = Demande::max('id');
        $actu_id_demande = $id_demande + 1;
        //create demande
        $demande = new Demande;
        $demande->num_ordre = $request->input('num_ordre');
        $demande->date_reception = $request->input('date_reception');
        $demande->objet_fr = $request->input('objet_fr');
        $demande->objet_ar = $request->input('objet_ar');
        $demande->montant_global = $request->input('montant_global');
        $demande->observation = $request->input('observation');
        $demande->etat = $request->input('etat');



        $demande->save();
        //insert in pivot table 
        if ($demande->save()) {
            $commune_ids = Input::get('communes');
            $demande->communes()->sync($commune_ids);

        }

        //save date in piste
        $piste = new Piste;
        $piste->longueur = $request->input('longueur');
        $piste->demande_id = $actu_id_demande;
        $piste->save();

        //save data in porteur de demande
        $porteur = new Porteur;
        $porteur->nom_porteur_fr = $request->input('nom_porteur_fr');
        $porteur->nom_porteur_ar = $request->input('nom_porteur_ar');
        $porteur->demande_id = $actu_id_demande;
        $porteur->save();

        //redirecting with success message
        return redirect('/demandes')->with('success', 'Demande créee avec succès');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Demande  $demande
     * @return \Illuminate\Http\Response
     */
    public function show(Demande $demande)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Demande  $demande
     * @return \Illuminate\Http\Response
     */
    public function edit(Demande $demande)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Demande  $demande
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Demande $demande)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Demande  $demande
     * @return \Illuminate\Http\Response
     */
    public function destroy(Demande $demande)
    {
        //
    }
}
