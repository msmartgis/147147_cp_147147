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
        /*$communes = DB::table('communes')->select(array('id','nom_fr','nom_ar'));

        $total_demandes = Demande::where(function($q){
            $q->where([['decision', '=', 'accord_definitif'],['is_affecter', '=', 0]])->orWhere('decision', '=', 'en_cours');
        })->count('id');

        return Datatables::of($communes)->make();*/

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


    public function getDemandesLongueur(Request $request)
    {
        $communes = Commune::with('demandes','conventions')->orderBy('nom_fr', 'asc');

        $demandes = Demande::with('piste')->where(function($q){
            $q->where('decision', '=', 'accord_definitif')->orWhere('decision', '=', 'en_cours');
        })->get();

        $longueur_total = 0;
        foreach($demandes as $demande)
        {
            $longueur_total += $demande->piste->longueur;
        }

        $en_cours_longeur = 0;
        $accord_def_longeur = 0;
        $total_row_longeur = 0;
        if ($request->ajax()) {
            $datatables = DataTables::eloquent($communes)
            ->addColumn('en_cours_longeur', function ($communes) use ($en_cours_longeur) {
                $en_cours_nombre_demandes = $communes->demandes()->where([['decision', '=', 'en_cours']])->get();

                foreach($en_cours_nombre_demandes as $demande_en_cours)
                {
                    $en_cours_longeur += $demande_en_cours->piste->longueur;
                }
                return $en_cours_longeur;
            })


            ->addColumn('accord_definitif_longeur', function ($communes) use ($accord_def_longeur) {
                $accord_def_nombre_demandes = $communes->demandes()->where([['decision', '=', 'accord_definitif']])->get();

                foreach($accord_def_nombre_demandes as $accord_def)
                {
                    $accord_def_longeur += $accord_def->piste->longueur;
                }
                return $accord_def_longeur;
            })

            ->addColumn('total_row_longeur', function ($communes) use ($total_row_longeur) {
                $demandes_row = $communes->demandes()->where(function($q){
                    $q->where('decision', '=', 'accord_definitif')
                        ->orWhere('decision', '=', 'en_cours');
                })->get();

                foreach($demandes_row as $demande_longeur_row)
                {
                    $total_row_longeur += $demande_longeur_row->piste->longueur;
                }
                return $total_row_longeur;
            })

            ->addColumn('taux_row_longeur', function ($communes) use ($longueur_total,$total_row_longeur) {
                $demandes_row = $communes->demandes()->where(function($q){
                    $q->where('decision', '=', 'accord_definitif')
                        ->orWhere('decision', '=', 'en_cours');
                })->get();

                foreach($demandes_row as $demande_longeur_row)
                {
                    $total_row_longeur += $demande_longeur_row->piste->longueur;
                }
                return number_format(($total_row_longeur/$longueur_total)*100);
            });
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



    public function getDemandesDataChartLongeur(Request $request)
    {
        $demandes = Demande::with('piste')->where(function($q){
            $q->where('decision', '=', 'accord_definitif')->orWhere('decision', '=', 'en_cours');
        })->get();

        $longueur_total = 0;
        foreach($demandes as $demande)
        {
            $longueur_total += $demande->piste->longueur;
        }



        $intervention_id = $request->intervention;
        $annee = $request->annee;

        $longeur_demande_intervention = 0;
        if($request->intervention == "all" && $request->annee == "all")
        {

            $demande_interv = Demande::with('interventions')->where(function($q){
                $q->where('decision', '=', 'accord_definitif')->orWhere('decision', '=', 'en_cours');
            })->get();


            foreach($demande_interv as $dm_interv)
            {

                $longeur_demande_intervention += $dm_interv->piste->longueur;

            }
        }

        if($request->intervention != "all" && $request->annee == "all")
        {
            $intervention_id = $request->intervention;

            $demande_interv = Demande::with('piste')->where(function($q){
                $q->where('decision', '=', 'accord_definitif')->orWhere('decision', '=', 'en_cours');
            })->whereHas('interventions',function($query) use ($intervention_id){
                $query->where('interventions.id','=',$intervention_id);
            })->get();
            //return $demande_interv;
            foreach($demande_interv as $dm_interv)
            {
                $longeur_demande_intervention += $dm_interv->piste->longueur;
            }
        }

        if($request->intervention == "all" && $request->annee != "all") {
            $annee_id = $request->annee;

            $demande_interv = Demande::with('piste')->whereYear('date_reception','=',$annee_id)->where(function($query){
                $query->where('decision', '=', 'accord_definitif')->orWhere('decision', '=', 'en_cours');
            })->get();

            foreach($demande_interv as $dm_interv)
            {
                $longeur_demande_intervention += $dm_interv->piste->longueur;
            }
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


        return response()->json(array('longueur_total'=>$longueur_total,'longeur_demande_intervention' =>$longeur_demande_intervention));

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


    public function getCommunesTauxLg(Request $request)
    {

        $demandes = Demande::with('piste')->where(function($q){
            $q->where('decision', '=', 'accord_definitif')->orWhere('decision', '=', 'en_cours');
        })->get();

        $longueur_total = 0;

        foreach($demandes as $demande)
        {
            $longueur_total += $demande->piste->longueur;
        }

        $communes = Commune::all();

        if(!isset($request->intervention) && !isset($request->annee))
        {
            foreach($communes as $commune)
            {
                $communes_selected =   $commune->demandes()->where(function($q){
                    $q->where('decision', '=', 'accord_definitif')->where('is_affecter', '=', 0)->orWhere('decision', '=', 'en_cours');
                })->get();

                foreach($communes_selected as $commune)
                {
                    $longeur_demandes += $communes_selected->piste->longueur;

                }


                $commune->taux = number_format(($longeur_demandes/$longueur_total)*100);
                $commune->nombre_demandes_for_commune = $nombre_demandes_for_commune;
                $commune->total_demandes = $total_demandes;
            }

        }

        if(isset($request->intervention) && isset($request->annee)){

            if($request->intervention == "all" && $request->annee == "all")
            {

                foreach($communes as $commune)
                {
                    $longeur_demandes_for_commune = 0;
                    $commune_id = $commune->id;
                    $demande_interv = Demande::with('piste')->where(function($q) use ($commune_id){
                        $q->where('decision', '=', 'accord_definitif')->orWhere('decision', '=', 'en_cours');
                    })
                        ->whereHas('communes',function($query) use ($commune_id){
                            $query->where('communes.id','=',$commune_id);
                        })
                        ->get();

                    foreach($demande_interv as $dm_interv)
                    {
                        $longeur_demandes_for_commune += $dm_interv->piste->longueur;
                    }

                    $commune->taux_lg = number_format(($longeur_demandes_for_commune/$longueur_total)*100);

                    $commune->longeur_demandes_for_commune = $longeur_demandes_for_commune;
                    $commune->total_longueur = $longueur_total;
                }
            }

            if($request->intervention != "all" && $request->annee == "all")
            {
                $intervention = $request->intervention;
                foreach($communes as $commune)
                {
                    $longeur_demandes_for_commune = 0;
                    $commune_id = $commune->id;
                    $demande_interv = Demande::with('piste')->where(function($q) use ($commune_id){
                        $q->where('decision', '=', 'accord_definitif')->orWhere('decision', '=', 'en_cours');
                    })
                        ->whereHas('communes',function($query) use ($commune_id){
                            $query->where('communes.id','=',$commune_id);
                        })
                        ->whereHas('interventions',function($query) use ($intervention){
                            $query->where('interventions.id','=',$intervention);
                        })
                        ->get();

                    foreach($demande_interv as $dm_interv)
                    {
                        $longeur_demandes_for_commune += $dm_interv->piste->longueur;
                    }


                    $commune->taux_lg = number_format(($longeur_demandes_for_commune/$longueur_total)*100);

                    $commune->longeur_demandes_for_commune = $longeur_demandes_for_commune;
                    $commune->total_longueur = $longueur_total;
                }
            }



            if($request->intervention == "all" && $request->annee != "all")
            {
                $annee = $request->annee;
                foreach($communes as $commune)
                {
                    $longeur_demandes_for_commune = 0;
                    $commune_id = $commune->id;
                    $demande_interv = Demande::with('piste')->where(function($q) use ($commune_id){
                        $q->where('decision', '=', 'accord_definitif')->orWhere('decision', '=', 'en_cours');
                    })
                        ->whereHas('communes',function($query) use ($commune_id){
                            $query->where('communes.id','=',$commune_id);
                        })->whereYear('date_reception','=',$annee)
                        ->get();

                    foreach($demande_interv as $dm_interv)
                    {
                        $longeur_demandes_for_commune += $dm_interv->piste->longueur;
                    }


                    $commune->taux_lg = number_format(($longeur_demandes_for_commune/$longueur_total)*100);

                    $commune->longeur_demandes_for_commune = $longeur_demandes_for_commune;
                    $commune->total_longueur = $longueur_total;
                }
            }

            if($request->intervention != "all" && $request->annee != "all")
            {
                $intervention = $request->intervention;
                $annee = $request->annee;
                foreach($communes as $commune)
                {
                    $longeur_demandes_for_commune = 0;
                    $commune_id = $commune->id;
                    $demande_interv = Demande::with('piste')->where(function($q) use ($commune_id){
                        $q->where('decision', '=', 'accord_definitif')->orWhere('decision', '=', 'en_cours');
                    })
                        ->whereHas('communes',function($query) use ($commune_id){
                            $query->where('communes.id','=',$commune_id);
                        })
                        ->whereHas('interventions',function($query) use ($intervention){
                            $query->where('interventions.id','=',$intervention);
                        })
                        ->whereYear('date_reception','=',$annee)
                        ->get();

                    foreach($demande_interv as $dm_interv)
                    {
                        $longeur_demandes_for_commune += $dm_interv->piste->longueur;
                    }


                    $commune->taux_lg = number_format(($longeur_demandes_for_commune/$longueur_total)*100);

                    $commune->longeur_demandes_for_commune = $longeur_demandes_for_commune;
                    $commune->total_longueur = $longueur_total;

                }
            }
        }

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
