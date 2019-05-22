<?php

namespace App\Http\Controllers;


use App\Convention;
use App\Demande;
use Response;
use App\Commune;
use App\Intervention;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DataTables;
use DB;

class StatisticsController extends Controller
{

    public function getDemandes(Request $request)
    {
        $communes = Commune::with('demandes','conventions')->orderBy('nom_fr', 'asc');
        $demandes = Demande::with('communes','interventions');
        $total_demandes = Demande::where(function($q){
            $q->where('decision', '=', 'accord_definitif')->orWhere('decision', '=', 'en_cours');
        })->count('id');
        if ($request->ajax()) {
            $datatables = DataTables::eloquent($communes)

                ->addColumn('en_cours_nombre', function ($communes) {
                    $en_cours_nombre = $communes->demandes()->where([['decision', '=', 'en_cours']])
                        ->count('demande_id');
                    return $en_cours_nombre;
                })

                ->addColumn('accord_definitif_nombre', function ($communes) {
                    $accord_definitif_nombre = $communes->demandes()->where([['decision', '=', 'accord_definitif']])
                        ->count('demande_id');
                    return $accord_definitif_nombre;
                })

                ->addColumn('total_row', function ($communes) {
                    $total_row = $communes->demandes()->where(function($q){
                        $q->where('decision', '=', 'accord_definitif')
                            ->orWhere('decision', '=', 'en_cours');
                    })
                        ->count('demande_id');
                    return $total_row;
                })

                ->addColumn('row_taux',function ($communes) use($total_demandes) {
                    $total_row = $communes->demandes()->where(function($q){
                        $q->where('decision', '=', 'accord_definitif')
                            ->orWhere('decision', '=', 'en_cours');
                    })
                        ->count('demande_id');
                    return number_format(($total_row / $total_demandes)*100);
                });

        }

        //filter with intervention
        if ($interventions_id = $request->get('interventions')) {
            if ($interventions_id == "all") {
            } else {
                $communes->whereHas('demandes.interventions', function ($query) use ($interventions_id) {
                    $query->where('interventions.id', '=', $interventions_id);
                });
            }
        }
        return $datatables->make(true);
    }


    public function getDemandesDataChart(Request $request)
    {
        $total_demandes = Demande::where(function($q){
            $q->where('decision', '=', 'accord_definitif')->orWhere('decision', '=', 'en_cours');
        })->count('id');

                $intervention_id = $request->intervention;
                $annee = $request->annee;



            if($request->intervention == "all" && $request->annee == "all")
            {
                $number__demande_interv = DB::table('intervention_demande')
                    ->select(array(DB::raw('COUNT(DISTINCT intervention_demande.demande_id) as number__demande_interv')))
                    ->join('demandes', 'demandes.id', '=', 'intervention_demande.demande_id')
                    ->where(function($q){
                        $q->where('decision', '=', 'accord_definitif')->where('is_affecter', '=', 0)->orWhere('decision', '=', 'en_cours');
                    })
                    ->get();
            }

            if($request->intervention != "all" && $request->annee == "all")
            {
                $number__demande_interv = DB::table('intervention_demande')
                    ->select(array(DB::raw('COUNT(DISTINCT intervention_demande.demande_id) as number__demande_interv')))
                    ->join('demandes', 'demandes.id', '=', 'intervention_demande.demande_id')
                    ->where(function($q){
                        $q->where('decision', '=', 'accord_definitif')->where('is_affecter', '=', 0)->orWhere('decision', '=', 'en_cours');
                    })
                    ->where([['intervention_demande.intervention_id','=',$intervention_id]])
                    ->get();

            }

        if($request->intervention == "all" && $request->annee != "all") {
            $number__demande_interv = DB::table('intervention_demande')
                ->select(array(DB::raw('COUNT(DISTINCT intervention_demande.demande_id) as number__demande_interv')))
                ->join('demandes', 'demandes.id', '=', 'intervention_demande.demande_id')
                ->where(function($q){
                    $q->where('decision', '=', 'accord_definitif')->where('is_affecter', '=', 0)->orWhere('decision', '=', 'en_cours');
                })
                ->whereYear('demandes.date_reception','=',$annee)
                ->get();
        }


        if($request->intervention != "all" && $request->annee != "all") {
            $number__demande_interv = DB::table('intervention_demande')
                ->select(array(DB::raw('COUNT(intervention_demande.demande_id) as number__demande_interv')))
                ->join('demandes', 'demandes.id', '=', 'intervention_demande.demande_id')
                ->where(function($q){
                    $q->where('decision', '=', 'accord_definitif')->where('is_affecter', '=', 0)->orWhere('decision', '=', 'en_cours');
                })
                ->where([['intervention_demande.intervention_id','=',$intervention_id]])
                ->whereYear('demandes.date_reception','=',$annee)
                ->get();
        }


        return response()->json(array('nombre_total_demande'=>$total_demandes,'number_demande_interv' =>$number__demande_interv));
    }


    public function getCommunesTaux(Request $request)
    {

        $total_demandes = Demande::where(function($q){
            $q->where([['decision', '=', 'accord_definitif'],['is_affecter', '=', 0]])->orWhere('decision', '=', 'en_cours');
        })->count('id');

        $communes = Commune::all();
        $array_nombre_demandes = array();

        if(!isset($request->intervention) && !isset($request->annee))
        {


            foreach($communes as $commune)
            {
                 $nombre_demandes_for_commune =   $commune->demandes()->where(function($q){
                     $q->where('decision', '=', 'accord_definitif')->where('is_affecter', '=', 0)->orWhere('decision', '=', 'en_cours');
                 })->count();

                $commune->taux = number_format(($nombre_demandes_for_commune/$total_demandes)*100);
                $commune->nombre_demandes_for_commune = $nombre_demandes_for_commune;
                $commune->total_demandes = $total_demandes;

            }

        }

        if(isset($request->intervention) && isset($request->annee)){

            if($request->intervention == "all" && $request->annee == "all")
            {
                foreach($communes as $commune)
                {
                    $nombre_demandes_for_commune =   $commune->demandes()->where(function($q){
                        $q->where('decision', '=', 'accord_definitif')->where('is_affecter', '=', 0)->orWhere('decision', '=', 'en_cours');
                    })->count();

                    $commune->taux = number_format(($nombre_demandes_for_commune/$total_demandes)*100);
                    $commune->nombre_demandes_for_commune = $nombre_demandes_for_commune;
                    $commune->total_demandes = $total_demandes;
                }
            }

            if($request->intervention != "all" && $request->annee == "all")
            {
                $intervention = $request->intervention;
                foreach($communes as $commune)
                {
                    $nombre_demandes_for_commune =   $commune->demandes()->whereHas('interventions', function ($query) use ($intervention) {
                        $query->where('interventions.id', '=',$intervention);
                    })->where(function($q){
                        $q->where('decision', '=', 'accord_definitif')->where('is_affecter', '=', 0)->orWhere('decision', '=', 'en_cours');
                    })->count();

                    array_push($array_nombre_demandes,$nombre_demandes_for_commune);

                    $commune->taux = number_format(($nombre_demandes_for_commune/$total_demandes)*100);
                    $commune->nombre_demandes_for_commune = $nombre_demandes_for_commune;
                    $commune->total_demandes = $total_demandes;

                }

            }



            if($request->intervention == "all" && $request->annee != "all")
            {
                $annee = $request->annee;
                foreach($communes as $commune)
                {
                    $nombre_demandes_for_commune =   $commune->demandes()->where(function($q) use ($annee)  {
                        $q->where('decision', '=', 'accord_definitif')->where('is_affecter', '=', 0)->orWhere('decision', '=', 'en_cours');
                    })->whereYear('date_reception','=',$annee)->count();

                    $commune->taux = number_format(($nombre_demandes_for_commune/$total_demandes)*100);
                    $commune->nombre_demandes_for_commune = $nombre_demandes_for_commune;
                    $commune->total_demandes = $total_demandes;

                }

            }

            if($request->intervention != "all" && $request->annee != "all")
            {
                $intervention = $request->intervention;
                $annee = $request->annee;
                foreach($communes as $commune)
                {
                    $nombre_demandes_for_commune =   $commune->demandes()->whereHas('interventions', function ($query) use ($intervention) {
                        $query->where('interventions.id', '=',$intervention);
                    })->where(function($q) use ($annee){
                        $q->where('decision', '=', 'accord_definitif')->where('is_affecter', '=', 0)->orWhere('decision', '=', 'en_cours');
                    })->whereYear('date_reception','=',$annee)->count();

                    array_push($array_nombre_demandes,$nombre_demandes_for_commune);

                    $commune->taux = number_format(($nombre_demandes_for_commune/$total_demandes)*100);
                    $commune->nombre_demandes_for_commune = $nombre_demandes_for_commune;
                    $commune->total_demandes = $total_demandes;

                }
            }

        }
/*
        if(isset($request->intervention) && !isset($request->annee))
        {
            $intervention = $request->intervention;
            if($intervention == "all")
            {


            }else{

            }
        }

        if(!isset($request->intervention) && isset($request->annee))
        {
            $annee = $request->annee;
            if($annee == "all")
            {
                foreach($communes as $commune)
                {
                    $nombre_demandes_for_commune =   $commune->demandes()->where(function($q){
                        $q->where('decision', '=', 'accord_definitif')->where('is_affecter', '=', 0)->orWhere('decision', '=', 'en_cours');
                    })->count();

                    $commune->taux = number_format(($nombre_demandes_for_commune/$total_demandes)*100);
                    $commune->nombre_demandes_for_commune = $nombre_demandes_for_commune;
                    $commune->total_demandes = $total_demandes;

                }

            }else{
                foreach($communes as $commune)
                {
                    $nombre_demandes_for_commune =   $commune->demandes()->where(function($q) use ($annee){
                         $q->where('decision', '=', 'accord_definitif')->whereYear('date_reception',"=",$annee)->where('is_affecter', '=', 0)->orWhere('decision', '=', 'en_cours');
                     })->count();



                    array_push($array_nombre_demandes,$nombre_demandes_for_commune);

                    $commune->taux = number_format(($nombre_demandes_for_commune/$total_demandes)*100);
                    $commune->nombre_demandes_for_commune = $nombre_demandes_for_commune;
                    $commune->total_demandes = $total_demandes;

                }
            }

        }
*/



        return $communes;

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $interventions = Intervention::all();
        $actu_time = Carbon::now();
        $actu_year =  $actu_time->toDateString();

        $year_number = 0;
        $year_number = (int) substr($actu_year,0,4);

        return view('statistics.index_statistics_show')->with([
            'interventions' => $interventions,
            'year_number' => $year_number
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
