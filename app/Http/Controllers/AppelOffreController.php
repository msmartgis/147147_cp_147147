<?php

namespace App\Http\Controllers;
use App\Adjiducataire;
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
use App\DCE;
use App\PointDesserviCategorie;
use App\Porteur;
use App\Programme;
use App\Session;
use App\Device;
use App\SuiviVersement;
use Carbon\Carbon;
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

    public function changeState(Request $request)
    {
        $appelOffre = AppelOffre::find($request->id);
        if($request->state == "reporte")
        {
            $appelOffre->date_ouverture_plis =  $this->date_fromatting($request->data);
        }

        if($request->state == "en_cours_execution")
        {
            $appelOffre->ordre_service =  1;
        }

        $appelOffre->etat = $request->state;
        $appelOffre->save();
        return response()->json();

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
            'is_mobile' => Device::Device()
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
            'is_mobile' => Device::Device()
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
        //$actu_id = AppelOffre::max('id')+1;
        $appelOffre->numero = $request->numero;
        $appelOffre->montant_globale = $request->montant_global;
        $appelOffre->caution_provisoir = $request->caution_provisoire;
        $appelOffre->objet_fr = $request->objet_fr;
        $appelOffre->objet_ar = $request->objet_ar;
        $appelOffre->moa_id = $request->moas;
        $appelOffre->etat = $request->etat;
        $appelOffre->delai_execution = $request->delai_execution;
        $appelOffre->duree_execution = $request->duree_execution;

        $appelOffre->date_ouverture_plis = $this->date_fromatting($request->date_ouverture_plis);
        $appelOffre->date_commencement =  $this->date_fromatting($request->date_commencement);
        $appelOffre->observations = $request->observations;
        $appelOffre->save();

        if($appelOffre->save())
        {
            $actu_id = $appelOffre->id;
        }


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
                    $path = $file->storeAs('public/uploaded_files/appel_offres/'.$actu_id, $fileNameToStore);
                }
            }

            for ($i = 0; $i < $items_number; $i++) {
                $piece = new DCE();
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
        $communes = Commune::orderBy('nom_fr')->pluck('nom_fr', 'id');
        //point desservis :: localite only
        $localites = PointDesserviCategorie::find(1)->point_desservis;
        $pointdesservis = PointDesservi::orderBy('nom_fr')->pluck('nom_fr', 'id');
        $partenaires_types = PartenaireType::orderBy('nom_fr')->pluck('nom_fr', 'id');
        $moas = Moa::all();
        $sessions = Session::all();
        $interventions = Intervention::orderBy('nom')->pluck('nom', 'id');
        $porteurs = Porteur::all();
        $programmes = Programme::all();
        $conventions = Convention::with(['communes', 'partenaires', 'point_desservis', 'interventions', 'session'])->get();
        $appelOffre = AppelOffre::with(['conventions','moas','adjiducataires'])->find($appelOffre->id);

        //interventions concernees
        $intervention_ids = array();
        $intervention_ids_looping = array();
        foreach ($appelOffre->conventions as $cv)
        {
          array_push($intervention_ids,$cv->interventions->pluck('id'));
        }

        foreach($intervention_ids as $ids)
        {

            for($i=0;$i<count($ids);$i++)
            {
                array_push($intervention_ids_looping,$ids[$i]);
            }

        }
        $interventions_ids =  array_unique($intervention_ids_looping);

        //communes concernees
        $all_communes = array();
        $communes_fetch = array();
        foreach ($appelOffre->conventions as $cv)
        {
            array_push($all_communes,$cv->communes->pluck('id'));
        }

        foreach($all_communes as $ids)
        {
            for($i=0;$i<count($ids);$i++)
            {
                array_push($communes_fetch,$ids[$i]);
            }

        }
        $communes_concernees =  array_unique($communes_fetch);


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
            'interventions_ids' => $interventions_ids,
            'communes_concernees'=> $communes_concernees,
            'pointdesservis'=>$pointdesservis,
            'is_mobile' => Device::Device()

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

        $date_formatted = str_replace("/",'-',$request->date_commencement);
        $appelOffre->date_commencement = Carbon::parse($date_formatted)->format('Y-m-d');
        if($appelOffre->etat != 'pulbie' || $appelOffre->etat != 'en_preparation')
        {

        }else{
            $appelOffre->etat = $request->etat;
        }

        $date_formatted_delai_exec = str_replace("/",'-',$request->delai_execution);
        $appelOffre->delai_execution = Carbon::parse($date_formatted_delai_exec)->format('Y-m-d');
        //$appelOffre->delai_execution = $request->delai_execution;
        $appelOffre->duree_execution = $request->duree_execution;
        $appelOffre->montant_adjiducation = $request->montant_adjiducataire;
        //return  $request->porteurporteur_projet;


        //add new adjiducataire
        if(!isset($request->id_adjiducataire))
        {
            $adjiducataire = new Adjiducataire();
            $adjiducataire_id = Adjiducataire::max('id')+1;
            $appelOffre->adjiducataire_id = $adjiducataire_id;
            $adjiducataire->nom_fr = $request->adjiducataire;
            $adjiducataire->save();
        }else{
            $adjiducataire = Adjiducataire::find($request->id_adjiducataire);
            $adjiducataire->nom_fr = $request->adjiducataire;
            $adjiducataire->save();
        }
        $appelOffre->save();


        //update conventions
        if(Input::get('conventions_ids'))
        {
            $conventions_ids_array = Input::get('conventions_ids');
            //return $conventions_ids_array;
            for($i = 0 ; $i < count($conventions_ids_array) ; $i++)
            {
                $convention = Convention::find($conventions_ids_array[$i]);
                $convention->appel_offre_id = $appelOffre->id;
                $convention->save();
            }

            if(Input::get('conventions_hidden_ids'))
            {
                $conventions_hidden_ids_array = Input::get('conventions_hidden_ids');
                //return $conventions_hidden_ids_array;
                $dif_array = array_diff($conventions_hidden_ids_array, $conventions_ids_array ) ;
                //return $dif_array;
                foreach($dif_array as $dif)
                {
                    $convention = Convention::find($dif);
                    $convention->appel_offre_id = null;
                    $convention->save();
                }
            }
        }


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
        AppelOffre::destroy($appelOffre->id);
        return response()->json();
    }
}
