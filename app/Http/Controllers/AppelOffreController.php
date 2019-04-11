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
use App\SuiviVersement;
use Illuminate\Http\Request;
use App\PointDesservi;
use Illuminate\Support\Facades\Input;

use DataTables;
use DB;

class AppelOffreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('appel_offre.show.index');
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
        //point desservis
        $localites = PointDesserviCategorie::find(1)->point_desservis;
        $categorie_points = PointDesserviCategorie::all();
        $etablissement_scols = PointDesservi::all()->where('type_point', '=', 'etab.scolaire');
        $moas = Moa::orderBy('nom_fr')->pluck('nom_fr', 'id');

        //creat a new object to send it in form for editing
        $convention = new Convention();
        return view('appel_offre.create.index')->with(
            [
                'convention' => $convention,
                'communes' => $communes,
                'programmes' => $programmes,
                'interventions' => $interventions,
                'localites' => $localites,
                'etablissement_scols' => $etablissement_scols,
                'partenaire_types' => $partenaire_types,
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
        //
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
        //
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
        //
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
