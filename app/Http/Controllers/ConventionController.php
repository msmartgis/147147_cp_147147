<?php

namespace App\Http\Controllers;

use App\Avancement;
use App\Commune;
use App\Convention;
use App\Demande;
use App\Intervention;
use App\Moa;
use App\PartenaireType;
use App\Piece;
use App\Piste;
use App\PointDesserviCategorie;
use App\Porteur;
use App\Programme;
use App\Session;
use Illuminate\Http\Request;
use App\PointDesservi;
use Illuminate\Support\Facades\Input;

class ConventionController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $communes = Commune::orderBy('nom_fr')->get();
        //point desservis :: localite only
        $localites = PointDesserviCategorie::find(1)->point_desservis;
        $partenaires_types = PartenaireType::all();
        $moas = Moa::all();
        $sessions = Session::all();
        $interventions = Intervention::all();
        $porteurs = Porteur::all();
        $programmes = Programme::all();

        $conventions = Convention::with(['communes', 'partenaires', 'point_desservis', 'interventions', 'session'])->get();
        return view('conventions.show.index')->with([
            '$conventions' => $conventions,
            'communes' => $communes,
            'localites' => $localites,
            'partenaires_types' => $partenaires_types,
            'moas' => $moas,
            'porteurs' => $porteurs,
            'sessions' => $sessions,
            'interventions' => $interventions,
            'programmes' => $programmes,
        ]);
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
        $programmes = Programme::orderBy('nom_fr')->pluck('nom_fr', 'id');
        $interventions = Intervention::orderBy('nom')->pluck('nom', 'id');
        $partenaire_types = PartenaireType::all();
        //$sessions = Session::orderBy('nom')->pluck('mois', 'id');
        $porteur_projet = Porteur::distinct()->select('id', 'nom_porteur_fr')->get();
        //point desservis
        $localites = PointDesserviCategorie::find(1)->point_desservis;
        $categorie_points = PointDesserviCategorie::all();
        $etablissement_scols = PointDesservi::all()->where('type_point', '=', 'etab.scolaire');
        $moas = Moa::orderBy('nom_fr')->pluck('nom_fr', 'id');

        //creat a new object to send it in form for editing
        $convention = new Convention();
        return view('conventions.create.index_create_convention')->with(
            [
                'convention' => $convention,
                'communes' => $communes,
                'programmes' => $programmes,
                'interventions' => $interventions,
                'localites' => $localites,
                'etablissement_scols' => $etablissement_scols,
                'partenaire_types' => $partenaire_types,
                'porteur_projet' => $porteur_projet,
                'categorie_points' => $categorie_points,
                'moas' => $moas,
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
        //find the communes for this convention and put them in an array
        $communes = $request->input('communes');

        $interventions = $request->input('interventions');

        //get the localites
        $localites = $request->input('localites');
        //get the last id of conventions
        $actu_id_convention = Convention::max('id')+ 1;

        //create convention
        $convention = new Convention();
        $convention->num_ordre = $request->input('num_ordre');
        $convention->objet_fr = $request->input('objet_fr');
        $convention->objet_ar = $request->input('objet_ar');
        $convention->montant_global = $request->input('montant_global');
        $convention->observation = $request->input('observation');
        $convention->session_id = $request->input('session');
        $convention->programme_id = $request->input('programme');
        $convention->moa_id = $request->input('moa');
        $convention->save();

        //partenaire *****
        if (Input::has('partnenaire_type_ids')) {
            $partenaires_ids = (array)Input::get('partnenaire_type_ids');
            $montant_partenaire = (array)Input::get('montant');
            for ($i = 0; $i < count($partenaires_ids); $i++) {
                $convention->partenaires()->attach($partenaires_ids[$i], ['montant' => $montant_partenaire[$i]]);
            }
        }

        // Point desservis **************
        //insert in pivot table
        if ($convention->save()) {
            $commune_ids = Input::get('communes');
            $convention->communes()->sync($commune_ids);
            //intervention
            $intervention_ids = Input::get('interventions');
            $convention->interventions()->sync($intervention_ids);
            //insert localite id and demande id in pivot table
            $point_desservi_ids = Input::get('points');
            $convention->point_desservis()->sync($point_desservi_ids);
        }

        //save data in piste*****
        $piste = new Piste;
        $piste->longueur = $request->input('longueur');
        $piste->demande_id = $actu_id_convention;
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

            //define a new piece
            $piece = new Piece;
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
                    $path = $file->storeAs('local/uploaded_files/conventions', $fileNameToStore);
                }

            } else {
                //bug when no file uploaded!!!!
                $fileNameToStore = 'noimage.jpg';
                $piece->path = $fileNameToStore;
            }
            for ($i = 0; $i < $items_number; $i++) {
                $piece->type = $pieces_types_array[$i];
                $piece->nom = $pieces_noms_array[$i];
                if(!empty($piece_file_names))
                {
                    $piece->path = $piece_file_names[$i];
                }
                array_push($array_combination_piece, $piece);
            }

            foreach ($array_combination_piece as $p) {
                $piec = new Piece;
                $piec->type = $p->type;
                $piec->nom = $p->nom;
                $piec->path = $p->path;
                $piec->convention_id = $actu_id_convention;
                $piec->save();
            }
        }


        //save data in porteur de demande and add it as partenaire_type *****
        $partenaire_type = new PartenaireType;
        $moa_from_porteur = new Moa;



        //redirecting with success message
        return redirect('/convention')->with('success', 'Demande créee avec succès');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Convention  $convention
     * @return \Illuminate\Http\Response
     */
    public function show(Convention $convention)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Convention  $convention
     * @return \Illuminate\Http\Response
     */
    public function edit(Convention $convention)
    {
        $interventions = Intervention::orderBy('mois')->pluck('nom', 'id');
        $communes = Commune::orderBy('nom_fr')->pluck('nom_fr', 'id');
        $pieces = Piece::orderBy('type')->pluck('type');
        $moas = Moa::all();
        $partenaires_types = PartenaireType::all();

        //get piste
        $piste_id = Piste::where('convention_id', '=', $convention->id)->first()->id;
        $piste_longueur = Piste::where('convention_id', '=', $convention->id)->first()->longueur;


        $localites = PointDesservi::orderBy('nom_fr')->where('categorie_point_id', '=', 1)->pluck('nom_fr', 'id');
        $convention = Convention::with(['communes', 'partenaires', 'point_desservis', 'interventions', 'session', 'piece'])->find($convention->id);


        //return conventions;
        return view('conventions.edit.edit')->with([
            'conventions' => $convention,
            'interventions' => $interventions,
            'localites' => $localites,
            'partenaires_types' => $partenaires_types,
            'moas' => $moas,
            'communes' => $communes,
            'piste_id' => $piste_id,
            'piste_longueur' => $piste_longueur
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Convention  $convention
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Convention $convention)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Convention  $convention
     * @return \Illuminate\Http\Response
     */
    public function destroy(Convention $convention)
    {
        //
    }
}
