<?php

namespace App\Http\Controllers;

use App\Demande;
use App\Commune;
use App\Piste;
use App\Porteur;
use App\PointDesservi;
use App\Partenaire;
use App\Piece;
use Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;


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
        $localites = PointDesservi::all()->where('type_point', '=', 'localite');
        $etablissement_scols = PointDesservi::all()->where('type_point', '=', 'etablissement_scol');
      

        //find the max numero ordre and increment 
        $max_num_ordre = Demande::max('num_ordre');
        $current_numero_ordre = $max_num_ordre + 1;
        return view('demandes.create')->with(
            [
                'current_numero_ordre' => $current_numero_ordre,
                'communes' => $communes,
                'localites' => $localites,
                'etablissement_scols' => $etablissement_scols,
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
        
        //get the localites
        $localites = $request->input('localites');
        
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

        //save data in partenaire
        $partenaire = new Partenaire;
        return $request->input('partenaire') . $request->input('montant') . ' ' . $request->input('pourcentage') . "hello";
        $partenaire->type = $request->input('partenaire');
        $partenaire->montant = $request->input('montant');
        $partenaire->pourcentage = $request->input('pourcentage');
        $partenaire->save();
        //insert in pivot table 
        if ($demande->save()) {
            $commune_ids = Input::get('communes');
            $demande->communes()->sync($commune_ids);

            //insert localite id and demande id in pivot table 
            $point_desservi = Input::get('localites');
            $demande->point_desservi()->sync($point_desservi);

            //pivot table between partenaire and demande
            $partenaire_ids = Input::get('partenaire');
            $demande->partenaire()->sync($partenaire_ids);

        }

        
        //save data in piste
        $piste = new Piste;
        $piste->longueur = $request->input('longueur');
        $piste->demande_id = $actu_id_demande;
        $piste->save();

        //save data for piece
        // Handle File Upload
        if ($request->hasFile('piece_upload')) {
            // Get filename with the extension
            $filenameWithExt = $request->file('piece_upload')->getClientOriginalName();
            // Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just ext
            $extension = $request->file('piece_upload')->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore = $filename . '_' . time() . '.' . $extension;
            // Upload Image
            $path = $request->file('piece_upload')->storeAs('local/uploaded_files/demandes', $fileNameToStore);
        } else {
            $fileNameToStore = 'noimage.jpg';
        }

        $piece = new Piece;
        $piece->type = $request->input('piece_type');
        $piece->nom = $request->input('piece_nom');
        $piece->path = $fileNameToStore;
        $piece->demande_id = $actu_id_demande;
        $piece->save();

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
