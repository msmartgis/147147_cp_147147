<?php

namespace App\Http\Controllers;

use App\Demande;
use App\Commune;
use App\Piste;
use App\Porteur;
use App\PointDesservi;
use App\Partenaire;
use App\Piece;
use App\Intervention;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;


class DemandesController extends BaseController
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $demandes = Demande::all();

        return view('demandes.index')->with('demandes', $demandes);
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
        $interventions = Intervention::orderBy('nom')->pluck('nom', 'id');
       
         //point desservis
        $localites = PointDesservi::all()->where('type_point', '=', 'localite');
        $etablissement_scols = PointDesservi::all()->where('type_point', '=', 'etablissement_scol');
      

        //find the max numero ordre and increment 
        $max_num_ordre = Demande::max('num_ordre');
        $current_numero_ordre = $max_num_ordre + 1;
        $demande = new Demande;
        return view('demandes.create')->with(
            [
                'demande' => $demande,
                'current_numero_ordre' => $current_numero_ordre,
                'communes' => $communes,
                'interventions' => $interventions,
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
        $interventions = $request->input('interventions');
        
        //find point desservis
        $point_desservi = $request->input('points');
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

        //save data in partenaire********
        if (Input::has('partnenaire_type')) {
            $actu_id_partenaire = Partenaire::max('id') + 1;
            $partners_ids = array();
        //itterate over tha array and save every partenaire
            $array_combination = array();
            $partner_type_array = Input::get('partnenaire_type');
            $partner_montant_array = Input::get('montant');
            $partner_pourcentage_array = Input::get('pourcentage');
            $items_number = count($partner_type_array);


            for ($i = 0; $i < $items_number; $i++) {
                $partenaire = new Partenaire;
                $partenaire->type = $partner_type_array[$i];
                $partenaire->montant = $partner_montant_array[$i];
                $partenaire->pourcentage = $partner_pourcentage_array[$i];
                array_push($array_combination, $partenaire);
            }


            foreach ($array_combination as $p) {
                array_push($partners_ids, $actu_id_partenaire);
                $partner = new Partenaire;
                $partner->type = $p->type;
                $partner->montant = $p->montant;
                $partner->pourcentage = $p->pourcentage;
                $actu_id_partenaire += 1;
                $partner->save();

            }
            //pivot table between partenaire and demande
            $demande->partenaire()->sync($partners_ids);
        }

        //partneaire********
        if (Input::has('partnenaire_type')) {
            $actu_id_partenaire = Partenaire::max('id') + 1;
            $partners_ids = array();
        //itterate over tha array and save every partenaire
            $array_combination = array();
            $partner_type_array = Input::get('partnenaire_type');
            $partner_montant_array = Input::get('montant');
            $partner_pourcentage_array = Input::get('pourcentage');
            $items_number = count($partner_type_array);


            for ($i = 0; $i < $items_number; $i++) {
                $partenaire = new Partenaire;
                $partenaire->type = $partner_type_array[$i];
                $partenaire->montant = $partner_montant_array[$i];
                $partenaire->pourcentage = $partner_pourcentage_array[$i];
                array_push($array_combination, $partenaire);
            }


            foreach ($array_combination as $p) {
                array_push($partners_ids, $actu_id_partenaire);
                $partner = new Partenaire;
                $partner->type = $p->type;
                $partner->montant = $p->montant;
                $partner->pourcentage = $p->pourcentage;
                $actu_id_partenaire += 1;
                $partner->save();

            }
            //pivot table between partenaire and demande
            $demande->partenaire()->sync($partners_ids);
        }


        //point desservi********
        
        
        //insert in pivot table 
        if ($demande->save()) {
            $commune_ids = Input::get('communes');
            $demande->communes()->sync($commune_ids);
            //intervention
            $intervention_ids = Input::get('interventions');
            $demande->interventions()->sync($intervention_ids);
            //insert localite id and demande id in pivot table 
            $point_desservi_ids = Input::get('points');
            $demande->point_desservi()->sync($point_desservi_ids);


        }
        
        //save data in piste*****
        $piste = new Piste;
        $piste->longueur = $request->input('longueur');
        $piste->demande_id = $actu_id_demande;
        $piste->save();

        //save data for piece******
        //verify if there is any piece
        if (Input::has('pieces_types')) {

            $array_combination_piece = array();
            $pieces_types_array = Input::get('pieces_types');
            $pieces_noms_array = Input::get('pieces_noms');
            $piece_file_names = array();
            $items_number = count($pieces_types_array);
            $files = $request->file('pieces_uploads');
            //files uploaded get path
            if ($request->hasFile('pieces_uploads')) {
                foreach ($files as $file) {
                        // Get filename with the extension
                    $filenameWithExt = $file->getClientOriginalName();
                        // Get just filename
                    $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                        // Get just ext
                    $extension = $file->getClientOriginalExtension();
                        // Filename to store
                    $fileNameToStore = $filename . '_' . time() . '.' . $extension;
                    array_push($piece_file_names, $fileNameToStore);
                        // Upload Image
                    $path = $file->storeAs('local/uploaded_files/demandes', $fileNameToStore);
                }

            } else {
                //bug when no file uploaded!!!!
                $fileNameToStore = 'noimage.jpg';
                $piece->path = $fileNameToStore;
            }

            for ($i = 0; $i < $items_number; $i++) {
                $piece = new Piece;
                $piece->type = $pieces_types_array[$i];
                $piece->nom = $pieces_noms_array[$i];
                $piece->path = $piece_file_names[$i];
                array_push($array_combination_piece, $piece);
            }


            foreach ($array_combination_piece as $p) {
                $piec = new Piece;
                $piec->type = $p->type;
                $piec->nom = $p->nom;
                $piec->path = $p->path;
                $piec->demande_id = $actu_id_demande;
                $piec->save();
            }
        }
        
        // Handle File Upload
        // if ($request->hasFile('piece_upload')) {
        //     // Get filename with the extension
        //     $filenameWithExt = $request->file('piece_upload')->getClientOriginalName();
        //     // Get just filename
        //     $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        //     // Get just ext
        //     $extension = $request->file('piece_upload')->getClientOriginalExtension();
        //     // Filename to store
        //     $fileNameToStore = $filename . '_' . time() . '.' . $extension;
        //     // Upload Image
        //     $path = $request->file('piece_upload')->storeAs('local/uploaded_files/demandes', $fileNameToStore);
        // } else {
        //     $fileNameToStore = 'noimage.jpg';
        // }

        // $piece = new Piece;
        // $piece->type = $request->input('piece_type');
        // $piece->nom = $request->input('piece_nom');
        // $piece->path = $fileNameToStore;
        // $piece->demande_id = $actu_id_demande;
        // $piece->save();

        //save data in porteur de demande*****
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
