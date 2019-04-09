<?php

namespace App\Http\Controllers;

use App\SuiviVersement;
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
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\PointDesservi;
use Illuminate\Support\Facades\Input;
use DataTables;
use Illuminate\Support\Facades\Storage;


class SuiviVersementController extends Controller
{

    public function downloadFile(Request $request)
    {
        $versement = SuiviVersement::find($request->id);

        $local_path = 'local/uploaded_files/versements/';
        return Storage::disk('local')->download($local_path.$versement->id.'/'.$versement->path);
    }



    public function getVersementData(Request $request)
    {
       $montant_verse = SuiviVersement::where([['convention_id','=',$request->convention_id],['partenaire_id','=',$request->partenaire_id]])
                                        ->sum('montant');

        return response()->json(array('montant_verse' => $montant_verse));
    }


    public function addVersement(Request $request)
    {
        $convention_id = $request->convention_id;
        if($request->montant_de_versement <= $request->rest_a_verse_hidden )
        {

            $versement = new SuiviVersement();
            $versement_id = SuiviVersement::max('id') + 1;
            $versement->partenaire_id = $request->partenaire_id;
            $versement->convention_id = $request->convention_id;
            $versement->montant = $request->montant_de_versement;
            $versement->prise_en_charge = $request->pris_en_charge;

            $date_formatted = str_replace("/",'-',$request->date_versement);
            $versement->date_versement = Carbon::parse($date_formatted)->format('Y-m-d');
            $versement->document = $request->nom_document;


            // Handle File Upload
            if($request->hasFile('versement_file')){
                // Get filename with the extension
                $filenameWithExt = $request->file('versement_file')->getClientOriginalName();
                // Get just filename
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                // Get just ext
                $extension = $request->file('versement_file')->getClientOriginalExtension();
                // Filename to store
                $fileNameToStore= $filename.'_'.time().'.'.$extension;
                // Upload Image
                $path = $request->file('versement_file')->storeAs('local/uploaded_files/versements/'.$versement_id, $fileNameToStore);
            }


            $versement->path = $fileNameToStore;
            $versement->save();

            if($versement->save())
            {
                return redirect('convention/'.$convention_id.'/editVersement')->with('success','Versement ajouter avec succès');
            }

        }else{
            return redirect('convention/'.$convention_id.'/editVersement')->with('error','Veuillez verifiez les données saisis');
        }

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
        return view('conventions.suiviVersement.show.index')->with([
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SuiviVersement  $suiviVersement
     * @return \Illuminate\Http\Response
     */
    public function show(SuiviVersement $suiviVersement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SuiviVersement  $suiviVersement
     * @return \Illuminate\Http\Response
     */
    public function edit(SuiviVersement $suiviVersement)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SuiviVersement  $suiviVersement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SuiviVersement $suiviVersement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SuiviVersement  $suiviVersement
     * @return \Illuminate\Http\Response
     */
    public function destroy(SuiviVersement $suiviVersement)
    {
        $local_path = 'local/uploaded_files/versements/';
        Storage::disk('local')->deleteDirectory($local_path.$suiviVersement->id);
        SuiviVersement::destroy($suiviVersement->id);
        return response()->json();
    }
}