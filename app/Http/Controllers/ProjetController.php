<?php

namespace App\Http\Controllers;

use App\Avancement;
use App\Commune;
use App\Convention;
use App\Intervention;
use App\Moa;
use App\PartenaireType;
use App\PointDesserviCategorie;
use App\Porteur;
use App\Programme;
use App\Projet;
use App\Session;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ProjetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $year_actu = Carbon::now()->format('Y');
        $communes = Commune::orderBy('nom_fr')->get();
        //point desservis :: localite only
        $localites = PointDesserviCategorie::find(1)->point_desservis;
        $partenaires_types = PartenaireType::all();
        $moas = Moa::all();
        $sessions = Session::all();
        $interventions = Intervention::all();
        $porteurs = Porteur::all();
        $avancement = Avancement::all();
        $programmes = Programme::all();
        $conventions = Convention::with(['communes', 'partenaires', 'point_desservis', 'interventions', 'session'])->get();
        return view('projets.show.index')->with([
            '$conventions' => $conventions,
            'communes' => $communes,
            'localites' => $localites,
            'partenaires_types' => $partenaires_types,
            'moas' => $moas,
            'porteurs' => $porteurs,
            'sessions' => $sessions,
            'interventions' => $interventions,
            'avancement' => $avancement,
            'programmes' => $programmes,
            'year_actu' => $year_actu
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
     * @param  \App\Projet  $projet
     * @return \Illuminate\Http\Response
     */
    public function show(Projet $projet)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Projet  $projet
     * @return \Illuminate\Http\Response
     */
    public function edit(Projet $projet)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Projet  $projet
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Projet $projet)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Projet  $projet
     * @return \Illuminate\Http\Response
     */
    public function destroy(Projet $projet)
    {
        //
    }
}
