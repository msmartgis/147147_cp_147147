<?php

namespace App\Http\Controllers;
use App\AppelOffre;
use App\Avancement;
use App\Commune;
use App\Convention;
use App\Demande;
use App\DossierAdjiducataire;
use App\Intervention;
use App\Moa;
use App\PartenaireType;
use App\Piece;
use App\Piste;
use App\PointDesserviCategorie;
use App\Porteur;
use App\Programme;
use App\Session;
use App\SuiviVersement;
use Illuminate\Http\Request;
use App\PointDesservi;
use Illuminate\Support\Facades\Input;
use DataTables;
use DB;

class AppelOffreController extends Controller
{

    //formatting date
    public function date_fromatting($date)
    {
        //formating date time
        $date_to_time = strtotime(str_replace("/",'-',$date));
        return $date_formatted = date('Y-m-d',$date_to_time);
    }


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
        return view('conventions.appel_offre.show.index')->with([
            'conventions' => $conventions,
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
        $appel_offre = new AppelOffre();
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
        return view('conventions.appel_offre.create.index')->with([
            'appel_offre' => $appel_offre,
            'conventions' => $conventions,
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, ['numero' => 'required']);
        $appelOffre = new AppelOffre();
        $actu_id = AppelOffre::max('id')+1;
        $appelOffre->numero = $request->numero;
        $appelOffre->montant_globale = $request->montant_global;
        $appelOffre->caution_provisoir = $request->caution_provisoire;
        $appelOffre->objet_fr = $request->objet_fr;
        $appelOffre->objet_ar = $request->objet_ar;
        $appelOffre->moa_id = $request->moas;
        $appelOffre->etat = $request->etat;

        $appelOffre->date_ouverture_plis = $this->date_fromatting($request->date_ouverture_plis);
        $appelOffre->date_commencement =  $this->date_fromatting($request->date_commencement);
        $appelOffre->observations = $request->observations;
        $appelOffre->save();


        if($appelOffre->save())
        {
            if(Input::has('conventions_ids'))
            {
                $ids_array = [];
                $items_number = 0;
                $items_number = count(Input::get('conventions_ids'));
                $ids_array = Input::get('conventions_ids');
                for($i=0; $i < $items_number ;$i++)
                {
                    Convention::where('id', '=', $ids_array[$i])
                        ->update(['appel_offre_id' => $actu_id]);
                }
            }
        }

        //verify if there is any piece
        if (Input::has('pieces_types')) {
            $array_combination_piece = array();
            $pieces_types_array = array();
            $piece_file_names = array();
            $pieces_types_array = Input::get('pieces_types');
            $items_number = count($pieces_types_array);
            $files = $request->file('pieces_uploads');
            //define a new piece

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
                    $path = $file->storeAs('local/uploaded_files/appel_offres/'.$actu_id, $fileNameToStore);
                }
            }

            for ($i = 0; $i < $items_number; $i++) {
                $piece = new DossierAdjiducataire();
                $piece->document = $pieces_types_array[$i];
                $piece->file_name = $piece_file_names[$i];
                $piece->appel_offre_id = $actu_id;
                $piece->save();
                //array_push($array_combination_piece, $piece);
            }

            /* foreach ($array_combination_piece as $p) {
                 $piec = new Piece;
                 $piec->type = $p->type;
                 $piec->nom = $p->nom;
                 $piec->path = $p->path;
             }*/
        }

        return redirect('/appelOffre')->with('success', 'Appel d\'offre crée avec succès');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\AppelOffre  $appelOffre
     * @return \Illuminate\Http\Response
     */
    public function show(AppelOffre $appelOffre)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\AppelOffre  $appelOffre
     * @return \Illuminate\Http\Response
     */
    public function edit(AppelOffre $appelOffre)
    {
        //for edit
        $interventions_edit = Intervention::orderBy('nom')->pluck('nom', 'id');
        $moas_edit = Moa::orderBy('nom_fr')->pluck('nom_fr', 'id');

        //for filters
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
        $appelOffre = AppelOffre::with(['conventions','moas'])->find($appelOffre->id);

        return view('conventions.appel_offre.edit.index_edit_ao')->with([
            'appelOffre' => $appelOffre,
            'conventions' => $conventions,
            'communes' => $communes,
            'localites' => $localites,
            'partenaires_types' => $partenaires_types,
            'moas' => $moas,
            'porteurs' => $porteurs,
            'sessions' => $sessions,
            'interventions' => $interventions,
            'programmes' => $programmes,
            'interventions_edit'=>$interventions_edit,
            'moas_edit' => $moas_edit,

        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\AppelOffre  $appelOffre
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AppelOffre $appelOffre)
    {
        $appelOffre = AppelOffre::find($appelOffre->id);
        $appelOffre->objet_fr = $request->objet_fr;
        $appelOffre->objet_ar = $request->objet_ar;
        $appelOffre->moa_id = $request->moa;
        $appelOffre->numero = $request->numero;
        $appelOffre->montant_globale = $request->montant_global;
        $appelOffre->caution_provisoir = $request->caution_provisoir;
        $appelOffre->etat = $request->etat;
        //return  $request->porteurporteur_projet;
        $appelOffre->save();

        return redirect("/appelOffre" . "/" . $appelOffre->id . "/edit")->with('success', 'Appel d\'offre modifier avec succès');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\AppelOffre  $appelOffre
     * @return \Illuminate\Http\Response
     */
    public function destroy(AppelOffre $appelOffre)
    {
        //
    }
}
