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
use Illuminate\Http\Request;
use App\PointDesservi;
use Illuminate\Support\Facades\Input;

use DataTables;


class SuiviVersementController extends Controller
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
        //
    }
}
