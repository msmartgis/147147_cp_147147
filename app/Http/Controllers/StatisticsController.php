<?php

namespace App\Http\Controllers;


use App\Convention;
use App\Demande;
use App\Moa;
use App\Programme;
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


        if($request->interventions == "all" && $request->annee == "all")
        {

        }

        if($request->interventions != "all" && $request->annee == "all")
        {

            $interventions_id =$request->interventions;
            $annee =$request->annee;

            if ($request->ajax()) {
                $datatables_intervention_annee = DataTables::eloquent($communes)

                    ->addColumn('en_cours_nombre', function ($communes) use($interventions_id) {
                        $en_cours_nombre = $communes->demandes()->where([['decision', '=', 'en_cours']])
                            ->whereHas('interventions', function($query) use ($interventions_id) {
                                $query->where('interventions.id','=',$interventions_id);
                            })
                            ->count('demande_id');
                        return $en_cours_nombre;
                    })

                    ->addColumn('accord_definitif_nombre', function ($communes) use ($interventions_id) {
                        $accord_definitif_nombre = $communes->demandes()->where([['decision', '=', 'accord_definitif']])
                            ->whereHas('interventions', function($query) use ($interventions_id) {
                                $query->where('interventions.id','=',$interventions_id);
                            })
                            ->count('demande_id');
                        return $accord_definitif_nombre;
                    })

                    ->addColumn('total_row', function ($communes) use ($interventions_id) {
                        $total_row = $communes->demandes()->where(function($q){
                            $q->where('decision', '=', 'accord_definitif')
                                ->orWhere('decision', '=', 'en_cours');
                        })
                            ->whereHas('interventions', function($query) use ($interventions_id) {
                                $query->where('interventions.id','=',$interventions_id);
                            })
                            ->count('demande_id');
                        return $total_row;
                    })

                    ->addColumn('row_taux',function ($communes) use($total_demandes,$interventions_id) {
                        $total_row = $communes->demandes()->where(function($q){
                            $q->where('decision', '=', 'accord_definitif')
                                ->orWhere('decision', '=', 'en_cours');
                        })
                            ->whereHas('interventions', function($query) use ($interventions_id) {
                                $query->where('interventions.id','=',$interventions_id);
                            })
                            ->count('demande_id');
                        return number_format(($total_row / $total_demandes)*100);
                    });
            }
            return $datatables_intervention_annee->make(true);
        }


        if($request->interventions == "all" && $request->annee != "all")
        {
            $interventions_id =$request->interventions;
            $annee =$request->annee;
            if ($request->ajax()) {
                $datatables_intervention_annee = DataTables::eloquent($communes)

                    ->addColumn('en_cours_nombre', function ($communes) use($interventions_id,$annee) {
                        $en_cours_nombre = $communes->demandes()->where([['decision', '=', 'en_cours']])
                            ->whereYear('date_reception','=',$annee)
                            ->count('demande_id');
                        return $en_cours_nombre;
                    })

                    ->addColumn('accord_definitif_nombre', function ($communes) use ($interventions_id,$annee) {
                        $accord_definitif_nombre = $communes->demandes()->where([['decision', '=', 'accord_definitif']])
                            ->whereYear('date_reception','=',$annee)
                            ->count('demande_id');
                        return $accord_definitif_nombre;
                    })

                    ->addColumn('total_row', function ($communes) use ($annee) {
                        $total_row = $communes->demandes()->where(function($q){
                            $q->where('decision', '=', 'accord_definitif')
                                ->orWhere('decision', '=', 'en_cours');
                        })
                            ->whereYear('date_reception','=',$annee)
                            ->count('demande_id');
                        return $total_row;
                    })

                    ->addColumn('row_taux',function ($communes) use($total_demandes,$annee) {
                        $total_row = $communes->demandes()->where(function($q){
                            $q->where('decision', '=', 'accord_definitif')
                                ->orWhere('decision', '=', 'en_cours');
                        })
                            ->whereYear('date_reception','=',$annee)
                            ->count('demande_id');
                        return number_format(($total_row / $total_demandes)*100);
                    });
            }
            return $datatables_intervention_annee->make(true);

        }


        if($request->interventions != "all" && $request->annee != "all")
        {
            $interventions_id =$request->interventions;
            $annee =$request->annee;

            if ($request->ajax()) {
                $datatables_intervention_annee = DataTables::eloquent($communes)

                    ->addColumn('en_cours_nombre', function ($communes) use($interventions_id,$annee) {
                        $en_cours_nombre = $communes->demandes()->where([['decision', '=', 'en_cours']])
                            ->whereHas('interventions', function($query) use ($interventions_id) {
                                $query->where('interventions.id','=',$interventions_id);
                            })
                            ->whereYear('date_reception','=',$annee)
                            ->count('demande_id');
                        return $en_cours_nombre;
                    })

                    ->addColumn('accord_definitif_nombre', function ($communes) use ($interventions_id,$annee) {
                        $accord_definitif_nombre = $communes->demandes()->where([['decision', '=', 'accord_definitif']])
                            ->whereHas('interventions', function($query) use ($interventions_id) {
                                $query->where('interventions.id','=',$interventions_id);
                            })
                            ->whereYear('date_reception','=',$annee)
                            ->count('demande_id');
                        return $accord_definitif_nombre;
                    })

                    ->addColumn('total_row', function ($communes) use ($interventions_id,$annee) {
                        $total_row = $communes->demandes()->where(function($q){
                            $q->where('decision', '=', 'accord_definitif')
                                ->orWhere('decision', '=', 'en_cours');
                        })
                            ->whereHas('interventions', function($query) use ($interventions_id) {
                                $query->where('interventions.id','=',$interventions_id);
                            })
                            ->whereYear('date_reception','=',$annee)
                            ->count('demande_id');
                        return $total_row;
                    })

                    ->addColumn('row_taux',function ($communes) use($total_demandes,$interventions_id,$annee) {
                        $total_row = $communes->demandes()->where(function($q){
                            $q->where('decision', '=', 'accord_definitif')
                                ->orWhere('decision', '=', 'en_cours');
                        })
                            ->whereHas('interventions', function($query) use ($interventions_id) {
                                $query->where('interventions.id','=',$interventions_id);
                            })
                            ->whereYear('date_reception','=',$annee)
                            ->count('demande_id');
                        return number_format(($total_row / $total_demandes)*100);
                    });
            }
            return $datatables_intervention_annee->make(true);

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


        if($request->interventions == "all" && $request->annee == "all")
        {

        }

        if($request->interventions != "all" && $request->annee == "all")
        {
            $interventions_id =$request->interventions;
            $annee =$request->annee;
            $longeur_demandes_for_commune_en_cours =0;
            $longeur_demandes_for_commune_accord_definitif =0;
            $longeur_demandes_for_commune_total_row =0;
            if ($request->ajax()) {

                $datatables_intervention_annee = DataTables::eloquent($communes)
                    ->addColumn('en_cours_longeur', function ($communes) use ($en_cours_longeur,$interventions_id,$longeur_demandes_for_commune_en_cours) {
                        $commune_id = $communes->id;
                        $demande_interv = Demande::with('piste')->where(function($q) use ($commune_id){
                            $q->where('decision', '=', 'en_cours');
                        })
                            ->whereHas('communes',function($query) use ($commune_id){
                                $query->where('communes.id','=',$commune_id);
                            })
                            ->whereHas('interventions', function($query) use ($interventions_id) {
                                $query->where('interventions.id','=',$interventions_id);
                            })
                            ->get();


                        foreach($demande_interv as $dm_interv)
                        {
                            $longeur_demandes_for_commune_en_cours += $dm_interv->piste->longueur;
                        }
                        return $longeur_demandes_for_commune_en_cours;
                    })

                    ->addColumn('accord_definitif_longeur', function ($communes) use ($en_cours_longeur,$interventions_id,$longeur_demandes_for_commune_accord_definitif) {
                        $commune_id = $communes->id;
                        $demande_interv = Demande::with('piste')->where(function($q) use ($commune_id){
                            $q->where('decision', '=', 'accord_definitif');
                        })
                            ->whereHas('communes',function($query) use ($commune_id){
                                $query->where('communes.id','=',$commune_id);
                            })
                            ->whereHas('interventions', function($query) use ($interventions_id) {
                                $query->where('interventions.id','=',$interventions_id);
                            })
                            ->get();


                        foreach($demande_interv as $dm_interv)
                        {
                            $longeur_demandes_for_commune_accord_definitif += $dm_interv->piste->longueur;
                        }
                        return $longeur_demandes_for_commune_accord_definitif;
                    })

                    ->addColumn('total_row_longeur', function ($communes) use ($en_cours_longeur,$interventions_id,$longeur_demandes_for_commune_total_row) {
                        $commune_id = $communes->id;
                        $demande_interv = Demande::with('piste')->where(function($q) use ($commune_id){
                            $q->where('decision', '=', 'accord_definitif')->orWhere('decision', '=', 'en_cours');
                        })
                            ->whereHas('communes',function($query) use ($commune_id){
                                $query->where('communes.id','=',$commune_id);
                            })
                            ->whereHas('interventions', function($query) use ($interventions_id) {
                                $query->where('interventions.id','=',$interventions_id);
                            })
                            ->get();


                        foreach($demande_interv as $dm_interv)
                        {
                            $longeur_demandes_for_commune_total_row += $dm_interv->piste->longueur;
                        }
                        return $longeur_demandes_for_commune_total_row;
                    })

                    ->addColumn('taux_row_longeur', function ($communes) use ($en_cours_longeur,$interventions_id,$longeur_demandes_for_commune_total_row,$longueur_total) {
                        $commune_id = $communes->id;
                        $demande_interv = Demande::with('piste')->where(function($q) use ($commune_id){
                            $q->where('decision', '=', 'accord_definitif')->orWhere('decision', '=', 'en_cours');
                        })
                            ->whereHas('communes',function($query) use ($commune_id){
                                $query->where('communes.id','=',$commune_id);
                            })
                            ->whereHas('interventions', function($query) use ($interventions_id) {
                                $query->where('interventions.id','=',$interventions_id);
                            })
                            ->get();


                        foreach($demande_interv as $dm_interv)
                        {
                            $longeur_demandes_for_commune_total_row += $dm_interv->piste->longueur;
                        }
                        return number_format(($longeur_demandes_for_commune_total_row/$longueur_total)*100) ;
                    });
            }

            return $datatables_intervention_annee->make(true);

        }

        if($request->interventions == "all" && $request->annee != "all")
        {

            $interventions_id =$request->interventions;
            $annee =$request->annee;
            $longeur_demandes_for_commune_en_cours =0;
            $longeur_demandes_for_commune_accord_definitif =0;
            $longeur_demandes_for_commune_total_row =0;
            if ($request->ajax()) {

                $datatables_intervention_annee = DataTables::eloquent($communes)
                    ->addColumn('en_cours_longeur', function ($communes) use ($en_cours_longeur,$annee,$longeur_demandes_for_commune_en_cours) {
                        $commune_id = $communes->id;
                        $demande_interv = Demande::with('piste')->where(function($q) use ($commune_id){
                            $q->where('decision', '=', 'en_cours');
                        })
                            ->whereHas('communes',function($query) use ($commune_id){
                                $query->where('communes.id','=',$commune_id);
                            })
                            ->whereYear('date_reception','=',$annee)
                            ->get();


                        foreach($demande_interv as $dm_interv)
                        {
                            $longeur_demandes_for_commune_en_cours += $dm_interv->piste->longueur;
                        }
                        return $longeur_demandes_for_commune_en_cours;
                    })

                    ->addColumn('accord_definitif_longeur', function ($communes) use ($en_cours_longeur,$annee,$longeur_demandes_for_commune_accord_definitif) {
                        $commune_id = $communes->id;
                        $demande_interv = Demande::with('piste')->where(function($q) use ($commune_id){
                            $q->where('decision', '=', 'accord_definitif');
                        })
                            ->whereHas('communes',function($query) use ($commune_id){
                                $query->where('communes.id','=',$commune_id);
                            })
                            ->whereYear('date_reception','=',$annee)
                            ->get();


                        foreach($demande_interv as $dm_interv)
                        {
                            $longeur_demandes_for_commune_accord_definitif += $dm_interv->piste->longueur;
                        }
                        return $longeur_demandes_for_commune_accord_definitif;
                    })

                    ->addColumn('total_row_longeur', function ($communes) use ($en_cours_longeur,$annee,$longeur_demandes_for_commune_total_row) {
                        $commune_id = $communes->id;
                        $demande_interv = Demande::with('piste')->where(function($q) use ($commune_id){
                            $q->where('decision', '=', 'accord_definitif')->orWhere('decision', '=', 'en_cours');
                        })
                            ->whereHas('communes',function($query) use ($commune_id){
                                $query->where('communes.id','=',$commune_id);
                            })
                            ->whereYear('date_reception','=',$annee)
                            ->get();


                        foreach($demande_interv as $dm_interv)
                        {
                            $longeur_demandes_for_commune_total_row += $dm_interv->piste->longueur;
                        }
                        return $longeur_demandes_for_commune_total_row;
                    })

                    ->addColumn('taux_row_longeur', function ($communes) use ($en_cours_longeur,$annee,$longeur_demandes_for_commune_total_row,$longueur_total) {
                        $commune_id = $communes->id;
                        $demande_interv = Demande::with('piste')->where(function($q) use ($commune_id){
                            $q->where('decision', '=', 'accord_definitif')->orWhere('decision', '=', 'en_cours');
                        })
                            ->whereHas('communes',function($query) use ($commune_id){
                                $query->where('communes.id','=',$commune_id);
                            })
                            ->whereYear('date_reception','=',$annee)
                            ->get();


                        foreach($demande_interv as $dm_interv)
                        {
                            $longeur_demandes_for_commune_total_row += $dm_interv->piste->longueur;
                        }
                        return number_format(($longeur_demandes_for_commune_total_row/$longueur_total)*100) ;
                    });
            }

            return $datatables_intervention_annee->make(true);

        }

        if($request->interventions != "all" && $request->annee != "all")
        {

            $interventions_id =$request->interventions;
            $annee =$request->annee;
            $longeur_demandes_for_commune_en_cours =0;
            $longeur_demandes_for_commune_accord_definitif =0;
            $longeur_demandes_for_commune_total_row =0;
            if ($request->ajax()) {

                $datatables_intervention_annee = DataTables::eloquent($communes)
                    ->addColumn('en_cours_longeur', function ($communes) use ($en_cours_longeur,$annee,$interventions_id,$longeur_demandes_for_commune_en_cours) {
                        $commune_id = $communes->id;
                        $demande_interv = Demande::with('piste')->where(function($q) use ($commune_id){
                            $q->where('decision', '=', 'en_cours');
                        })
                            ->whereHas('communes',function($query) use ($commune_id){
                                $query->where('communes.id','=',$commune_id);
                            })
                            ->whereHas('interventions', function($query) use ($interventions_id) {
                                $query->where('interventions.id','=',$interventions_id);
                            })
                            ->whereYear('date_reception','=',$annee)
                            ->get();


                        foreach($demande_interv as $dm_interv)
                        {
                            $longeur_demandes_for_commune_en_cours += $dm_interv->piste->longueur;
                        }
                        return $longeur_demandes_for_commune_en_cours;
                    })

                    ->addColumn('accord_definitif_longeur', function ($communes) use ($en_cours_longeur,$annee,$interventions_id,$longeur_demandes_for_commune_accord_definitif) {
                        $commune_id = $communes->id;
                        $demande_interv = Demande::with('piste')->where(function($q) use ($commune_id){
                            $q->where('decision', '=', 'accord_definitif');
                        })
                            ->whereHas('communes',function($query) use ($commune_id){
                                $query->where('communes.id','=',$commune_id);
                            })
                            ->whereHas('interventions', function($query) use ($interventions_id) {
                                $query->where('interventions.id','=',$interventions_id);
                            })
                            ->whereYear('date_reception','=',$annee)
                            ->get();


                        foreach($demande_interv as $dm_interv)
                        {
                            $longeur_demandes_for_commune_accord_definitif += $dm_interv->piste->longueur;
                        }
                        return $longeur_demandes_for_commune_accord_definitif;
                    })

                    ->addColumn('total_row_longeur', function ($communes) use ($en_cours_longeur,$annee,$interventions_id,$longeur_demandes_for_commune_total_row) {
                        $commune_id = $communes->id;
                        $demande_interv = Demande::with('piste')->where(function($q) use ($commune_id){
                            $q->where('decision', '=', 'accord_definitif')->orWhere('decision', '=', 'en_cours');
                        })
                            ->whereHas('communes',function($query) use ($commune_id){
                                $query->where('communes.id','=',$commune_id);
                            })
                            ->whereHas('interventions', function($query) use ($interventions_id) {
                                $query->where('interventions.id','=',$interventions_id);
                            })
                            ->whereYear('date_reception','=',$annee)
                            ->get();


                        foreach($demande_interv as $dm_interv)
                        {
                            $longeur_demandes_for_commune_total_row += $dm_interv->piste->longueur;
                        }
                        return $longeur_demandes_for_commune_total_row;
                    })

                    ->addColumn('taux_row_longeur', function ($communes) use ($en_cours_longeur,$annee,$interventions_id,$longeur_demandes_for_commune_total_row,$longueur_total) {
                        $commune_id = $communes->id;
                        $demande_interv = Demande::with('piste')->where(function($q) use ($commune_id){
                            $q->where('decision', '=', 'accord_definitif')->orWhere('decision', '=', 'en_cours');
                        })
                            ->whereHas('communes',function($query) use ($commune_id){
                                $query->where('communes.id','=',$commune_id);
                            })
                            ->whereHas('interventions', function($query) use ($interventions_id) {
                                $query->where('interventions.id','=',$interventions_id);
                            })
                            ->whereYear('date_reception','=',$annee)
                            ->get();


                        foreach($demande_interv as $dm_interv)
                        {
                            $longeur_demandes_for_commune_total_row += $dm_interv->piste->longueur;
                        }
                        return number_format(($longeur_demandes_for_commune_total_row/$longueur_total)*100) ;
                    });
            }

            return $datatables_intervention_annee->make(true);

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
        return $communes;
    }


    public function getCommunesTauxLg(Request $request)
    {
        $demandes = Demande::with('piste')->where(function($q){
            $q->where('decision', '=', 'accord_definitif')->orWhere('decision', '=', 'en_cours');
        })->get();

        $longueur_total = 0;
        $longeur_demandes = 0;

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
                $commune->longueur_demande_for_commune = $longeur_demandes;
                $commune->total_longueur_demande = $longueur_total;
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


    public function getProjets(Request $request)
    {
        $communes = Commune::with('demandes','conventions')->orderBy('nom_fr', 'asc');
        $total_projet = Convention::all()->count('id');

        $programmes_nombre = 0;
        $appel_offre = 0;
        $en_cours = 0;
        $realise = 0;

        if ($request->ajax()) {
            $datatables = DataTables::eloquent($communes)
                ->addColumn('programme', function ($communes) use ($programmes_nombre) {
                    $conventions_per_commune = $communes->conventions()->get();

                    foreach($conventions_per_commune as $cnv)
                    {
                        if($cnv->appel_offre_id == null)
                        {
                            $programmes_nombre++;
                        }
                    }
                    return $programmes_nombre;
                })
                ->addColumn('appel_offre', function ($communes) use ($appel_offre) {
                    $conventions_per_commune = $communes->conventions()->get();

                    foreach($conventions_per_commune as $cnv)
                    {
                        if($cnv->appel_offre_id != null && $cnv->appelOffres->ordre_service == null)
                        {
                            $appel_offre++;
                        }
                    }
                    return $appel_offre;
                })

                ->addColumn('en_cours', function ($communes) use ($en_cours) {
                    $conventions_per_commune = $communes->conventions()->get();

                    foreach($conventions_per_commune as $cnv)
                    {
                        if($cnv->appel_offre_id != null && $cnv->appelOffres->ordre_service != null && $cnv->realise == 0)
                        {
                            $en_cours++;
                        }
                    }
                    return $en_cours;
                })

                ->addColumn('realise', function ($communes) use ($realise) {
                    $conventions_per_commune = $communes->conventions()->get();

                    foreach($conventions_per_commune as $cnv)
                    {
                        if($cnv->appel_offre_id != null && $cnv->realise != 0)
                        {
                            $realise++;
                        }
                    }
                    return $realise;
                })


                ->addColumn('total_row', function ($communes) use ($realise,$en_cours,$appel_offre,$programmes_nombre) {
                    $conventions_per_commune = $communes->conventions()->get();
                    foreach($conventions_per_commune as $cnv)
                    {
                        if($cnv->appel_offre_id == null)
                        {
                            $programmes_nombre++;
                        }
                        if($cnv->appel_offre_id != null && $cnv->appelOffres->ordre_service == null)
                        {
                            $appel_offre++;
                        }
                        if($cnv->appel_offre_id != null && $cnv->appelOffres->ordre_service != null && $cnv->realise == 0)
                        {
                            $en_cours++;
                        }
                        if($cnv->appel_offre_id != null && $cnv->realise != 0)
                        {
                            $realise++;
                        }
                    }
                    return $programmes_nombre+$appel_offre+$en_cours+$realise;
                })


                ->addColumn('taux_row', function ($communes) use ($realise,$en_cours,$appel_offre,$programmes_nombre,$total_projet) {
                    $conventions_per_commune = $communes->conventions()->get();
                    foreach($conventions_per_commune as $cnv)
                    {
                        if($cnv->appel_offre_id == null)
                        {
                            $programmes_nombre++;
                        }
                        if($cnv->appel_offre_id != null && $cnv->appelOffres->ordre_service == null)
                        {
                            $appel_offre++;
                        }
                        if($cnv->appel_offre_id != null && $cnv->appelOffres->ordre_service != null && $cnv->realise == 0)
                        {
                            $en_cours++;
                        }
                        if($cnv->appel_offre_id != null && $cnv->realise != 0)
                        {
                            $realise++;
                        }
                    }
                    return number_format((($programmes_nombre+$appel_offre+$en_cours+$realise)/$total_projet)*100);
                })

            ;
        }

        if($request->interventions == "all")
        {

        }else{
            $interventions_id =$request->interventions;
            $annee =$request->annee;
            $appel_offre_inter = 0;
            if ($request->ajax()) {
                $datatables = DataTables::eloquent($communes)

                    ->addColumn('programme', function ($communes) use($interventions_id) {
                        $programme = $communes->conventions()->where([['appel_offre_id', '=', null]])
                            ->whereHas('interventions', function($query) use ($interventions_id) {
                                $query->where('interventions.id','=',$interventions_id);
                            })
                            ->count('convention_id');
                        return $programme;
                    })
                    ->addColumn('appel_offre', function ($communes) use($interventions_id) {
                        $appel_offre = $communes->conventions()->where([['appel_offre_id', '!=', null]])
                            ->whereHas('interventions', function($query) use ($interventions_id) {
                                $query->where('interventions.id','=',$interventions_id);
                            })
                            ->whereHas('appelOffres',function($query){
                                $query->where('ordre_service','=',null);
                            })
                            ->count('convention_id');
                        return $appel_offre;
                    })

                    ->addColumn('en_cours', function ($communes) use($interventions_id) {
                        $en_cours = $communes->conventions()->where([['appel_offre_id', '!=', null]])
                            ->where([['realise', '=', 0]])
                            ->whereHas('interventions', function($query) use ($interventions_id) {
                                $query->where('interventions.id','=',$interventions_id);
                            })
                            ->whereHas('appelOffres',function($query){
                                $query->where('ordre_service','!=',null);
                            })
                            ->count('convention_id');
                        return $en_cours;
                    })

                    ->addColumn('realise',function ($communes) use($interventions_id) {
                        $realise = $communes->conventions()->where([['appel_offre_id', '!=', null]])
                            ->where([['realise', '!=', 0]])
                            ->whereHas('interventions', function($query) use ($interventions_id) {
                                $query->where('interventions.id','=',$interventions_id);
                            })
                            ->count('convention_id');
                        return $realise;
                    })


                    ->addColumn('total_row', function ($communes) use ($interventions_id) {
                        $realise = $communes->conventions()->where([['appel_offre_id', '!=', null]])
                            ->where([['realise', '!=', 0]])
                            ->whereHas('interventions', function($query) use ($interventions_id) {
                                $query->where('interventions.id','=',$interventions_id);
                            })
                            ->count('convention_id');

                        $en_cours = $communes->conventions()->where([['appel_offre_id', '!=', null]])
                            ->where([['realise', '=', 0]])
                            ->whereHas('interventions', function($query) use ($interventions_id) {
                                $query->where('interventions.id','=',$interventions_id);
                            })
                            ->whereHas('appelOffres',function($query){
                                $query->where('ordre_service','!=',null);
                            })
                            ->count('convention_id');

                        $appel_offre = $communes->conventions()->where([['appel_offre_id', '!=', null]])
                            ->whereHas('interventions', function($query) use ($interventions_id) {
                                $query->where('interventions.id','=',$interventions_id);
                            })
                            ->whereHas('appelOffres',function($query){
                                $query->where('ordre_service','=',null);
                            })
                            ->count('convention_id');

                        $programme = $communes->conventions()->where([['appel_offre_id', '=', null]])
                            ->whereHas('interventions', function($query) use ($interventions_id) {
                                $query->where('interventions.id','=',$interventions_id);
                            })
                            ->count('convention_id');

                        return $programme+$appel_offre+$en_cours+$realise;
                    })


                    ->addColumn('taux_row', function ($communes) use ($interventions_id,$total_projet) {
                        $realise = $communes->conventions()->where([['appel_offre_id', '!=', null]])
                            ->where([['realise', '!=', 0]])
                            ->whereHas('interventions', function($query) use ($interventions_id) {
                                $query->where('interventions.id','=',$interventions_id);
                            })
                            ->count('convention_id');

                        $en_cours = $communes->conventions()->where([['appel_offre_id', '!=', null]])
                            ->where([['realise', '=', 0]])
                            ->whereHas('interventions', function($query) use ($interventions_id) {
                                $query->where('interventions.id','=',$interventions_id);
                            })
                            ->whereHas('appelOffres',function($query){
                                $query->where('ordre_service','!=',null);
                            })
                            ->count('convention_id');

                        $appel_offre = $communes->conventions()->where([['appel_offre_id', '!=', null]])
                            ->whereHas('interventions', function($query) use ($interventions_id) {
                                $query->where('interventions.id','=',$interventions_id);
                            })
                            ->whereHas('appelOffres',function($query){
                                $query->where('ordre_service','=',null);
                            })
                            ->count('convention_id');

                        $programme = $communes->conventions()->where([['appel_offre_id', '=', null]])
                            ->whereHas('interventions', function($query) use ($interventions_id) {
                                $query->where('interventions.id','=',$interventions_id);
                            })
                            ->count('convention_id');


                        return number_format((($programme+$appel_offre+$en_cours+$realise)/$total_projet)*100);
                    });
            }

        }

        if($request->annee == "all"){

        }else{
            $interventions_id = $request->interventions;
            $annee = $request->annee;

            if ($request->ajax()) {
                $datatables = DataTables::eloquent($communes)
                    ->addColumn('programme', function ($communes) use($annee) {
                        $programme = $communes->conventions()->where([['appel_offre_id', '=', null]])
                            ->where('annee','=',$annee)
                            // ->whereHas('interventions', function($query) use ($interventions_id) {
                            //      $query->where('interventions.id','=',$interventions_id);
                            // })
                            ->count('convention_id');
                        return $programme;
                    })
                    ->addColumn('appel_offre', function ($communes) use($annee) {
                        $appel_offre = $communes->conventions()->where([['appel_offre_id', '!=', null]])
                            ->where('annee','=',$annee)
                            ->whereHas('appelOffres',function($query){
                                $query->where('ordre_service','=',null);
                            })
                            ->count('convention_id');
                        return $appel_offre;
                    })

                    ->addColumn('en_cours', function ($communes) use($annee) {
                        $en_cours = $communes->conventions()->where([['appel_offre_id', '!=', null]])
                            ->where([['realise', '=', 0]])
                            ->where('annee','=',$annee)
                            ->whereHas('appelOffres',function($query){
                                $query->where('ordre_service','!=',null);
                            })
                            ->count('convention_id');
                        return $en_cours;
                    })

                    ->addColumn('realise',function ($communes) use($annee) {
                        $realise = $communes->conventions()->where([['appel_offre_id', '!=', null]])
                            ->where([['realise', '!=', 0]])
                            ->where('annee','=',$annee)
                            ->count('convention_id');
                        return $realise;
                    })


                    ->addColumn('total_row', function ($communes) use ($annee) {
                        $realise = $communes->conventions()->where([['appel_offre_id', '!=', null]])
                            ->where([['realise', '!=', 0]])
                            ->where('annee','=',$annee)
                            ->count('convention_id');

                        $en_cours = $communes->conventions()->where([['appel_offre_id', '!=', null]])
                            ->where([['realise', '=', 0]])
                            ->where('annee','=',$annee)
                            ->whereHas('appelOffres',function($query){
                                $query->where('ordre_service','!=',null);
                            })
                            ->count('convention_id');

                        $appel_offre = $communes->conventions()->where([['appel_offre_id', '!=', null]])
                            ->where('annee','=',$annee)
                            ->whereHas('appelOffres',function($query){
                                $query->where('ordre_service','=',null);
                            })
                            ->count('convention_id');

                        $programme = $communes->conventions()->where([['appel_offre_id', '=', null]])
                            ->where('annee','=',$annee)
                            ->count('convention_id');

                        return $programme+$appel_offre+$en_cours+$realise;
                    })


                    ->addColumn('taux_row', function ($communes) use ($annee,$total_projet) {
                        $realise = $communes->conventions()->where([['appel_offre_id', '!=', null]])
                            ->where([['realise', '!=', 0]])
                            ->where('annee','=',$annee)
                            ->count('convention_id');

                        $en_cours = $communes->conventions()->where([['appel_offre_id', '!=', null]])
                            ->where([['realise', '=', 0]])
                            ->where('annee','=',$annee)
                            ->whereHas('appelOffres',function($query){
                                $query->where('ordre_service','!=',null);
                            })
                            ->count('convention_id');

                        $appel_offre = $communes->conventions()->where([['appel_offre_id', '!=', null]])
                            ->where('annee','=',$annee)
                            ->whereHas('appelOffres',function($query){
                                $query->where('ordre_service','=',null);
                            })
                            ->count('convention_id');

                        $programme = $communes->conventions()->where([['appel_offre_id', '=', null]])
                            ->where('annee','=',$annee)
                            ->count('convention_id');


                        return number_format((($programme+$appel_offre+$en_cours+$realise)/$total_projet)*100);
                    });
            }

        }

        if($request->moa == "all"){

        }else{
            $moa =$request->moa;
            $appel_offre_inter = 0;
            if ($request->ajax()) {
                $datatables = DataTables::eloquent($communes)

                    ->addColumn('programme', function ($communes) use($moa) {
                        $programme = $communes->conventions()->where([['appel_offre_id', '=', null]])
                            ->whereHas('moas', function($query) use ($moa) {
                                $query->where('id','=',$moa);
                            })
                            ->count('convention_id');
                        return $programme;
                    })
                    ->addColumn('appel_offre', function ($communes) use($moa) {
                        $appel_offre = $communes->conventions()->where([['appel_offre_id', '!=', null]])
                            ->whereHas('moas', function($query) use ($moa) {
                                $query->where('id','=',$moa);
                            })
                            ->whereHas('appelOffres',function($query){
                                $query->where('ordre_service','=',null);
                            })
                            ->count('convention_id');
                        return $appel_offre;
                    })

                    ->addColumn('en_cours', function ($communes) use($moa) {
                        $en_cours = $communes->conventions()->where([['appel_offre_id', '!=', null]])
                            ->where([['realise', '=', 0]])
                            ->whereHas('moas', function($query) use ($moa) {
                                $query->where('id','=',$moa);
                            })
                            ->whereHas('appelOffres',function($query){
                                $query->where('ordre_service','!=',null);
                            })
                            ->count('convention_id');
                        return $en_cours;
                    })

                    ->addColumn('realise',function ($communes) use($moa) {
                        $realise = $communes->conventions()->where([['appel_offre_id', '!=', null]])
                            ->where([['realise', '!=', 0]])
                            ->whereHas('moas', function($query) use ($moa) {
                                $query->where('id','=',$moa);
                            })
                            ->count('convention_id');
                        return $realise;
                    })


                    ->addColumn('total_row', function ($communes) use ($moa) {
                        $realise = $communes->conventions()->where([['appel_offre_id', '!=', null]])
                            ->where([['realise', '!=', 0]])
                            ->whereHas('moas', function($query) use ($moa) {
                                $query->where('id','=',$moa);
                            })
                            ->count('convention_id');

                        $en_cours = $communes->conventions()->where([['appel_offre_id', '!=', null]])
                            ->where([['realise', '=', 0]])
                            ->whereHas('moas', function($query) use ($moa) {
                                $query->where('id','=',$moa);
                            })
                            ->whereHas('appelOffres',function($query){
                                $query->where('ordre_service','!=',null);
                            })
                            ->count('convention_id');

                        $appel_offre = $communes->conventions()->where([['appel_offre_id', '!=', null]])
                            ->whereHas('moas', function($query) use ($moa) {
                                $query->where('id','=',$moa);
                            })
                            ->whereHas('appelOffres',function($query){
                                $query->where('ordre_service','=',null);
                            })
                            ->count('convention_id');

                        $programme = $communes->conventions()->where([['appel_offre_id', '=', null]])
                            ->whereHas('moas', function($query) use ($moa) {
                                $query->where('id','=',$moa);
                            })
                            ->count('convention_id');

                        return $programme+$appel_offre+$en_cours+$realise;
                    })


                    ->addColumn('taux_row', function ($communes) use ($moa,$total_projet) {
                        $realise = $communes->conventions()->where([['appel_offre_id', '!=', null]])
                            ->where([['realise', '!=', 0]])
                            ->whereHas('moas', function($query) use ($moa) {
                                $query->where('id','=',$moa);
                            })
                            ->count('convention_id');

                        $en_cours = $communes->conventions()->where([['appel_offre_id', '!=', null]])
                            ->where([['realise', '=', 0]])
                            ->whereHas('moas', function($query) use ($moa) {
                                $query->where('id','=',$moa);
                            })
                            ->whereHas('appelOffres',function($query){
                                $query->where('ordre_service','!=',null);
                            })
                            ->count('convention_id');

                        $appel_offre = $communes->conventions()->where([['appel_offre_id', '!=', null]])
                            ->whereHas('moas', function($query) use ($moa) {
                                $query->where('id','=',$moa);
                            })
                            ->whereHas('appelOffres',function($query){
                                $query->where('ordre_service','=',null);
                            })
                            ->count('convention_id');

                        $programme = $communes->conventions()->where([['appel_offre_id', '=', null]])
                            ->whereHas('moas', function($query) use ($moa) {
                                $query->where('id','=',$moa);
                            })
                            ->count('convention_id');


                        return number_format((($programme+$appel_offre+$en_cours+$realise)/$total_projet)*100);
                    });
            }
        }


        if($request->programme == "all"){

        }else{
            $programme =$request->programme;
            $appel_offre_inter = 0;
            if ($request->ajax()) {
                $datatables = DataTables::eloquent($communes)

                    ->addColumn('programme', function ($communes) use($programme) {
                        $programme = $communes->conventions()->where([['appel_offre_id', '=', null]])
                            ->whereHas('programme', function($query) use ($programme) {
                                $query->where('id','=',$programme);
                            })
                            ->count('convention_id');
                        return $programme;
                    })
                    ->addColumn('appel_offre', function ($communes) use($programme) {
                        $appel_offre = $communes->conventions()->where([['appel_offre_id', '!=', null]])
                            ->whereHas('programme', function($query) use ($programme) {
                                $query->where('id','=',$programme);
                            })
                            ->whereHas('appelOffres',function($query){
                                $query->where('ordre_service','=',null);
                            })
                            ->count('convention_id');
                        return $appel_offre;
                    })

                    ->addColumn('en_cours', function ($communes) use($programme) {
                        $en_cours = $communes->conventions()->where([['appel_offre_id', '!=', null]])
                            ->where([['realise', '=', 0]])
                            ->whereHas('programme', function($query) use ($programme) {
                                $query->where('id','=',$programme);
                            })
                            ->whereHas('appelOffres',function($query){
                                $query->where('ordre_service','!=',null);
                            })
                            ->count('convention_id');
                        return $en_cours;
                    })

                    ->addColumn('realise',function ($communes) use($programme) {
                        $realise = $communes->conventions()->where([['appel_offre_id', '!=', null]])
                            ->where([['realise', '!=', 0]])
                            ->whereHas('programme', function($query) use ($programme) {
                                $query->where('id','=',$programme);
                            })
                            ->count('convention_id');
                        return $realise;
                    })


                    ->addColumn('total_row', function ($communes) use ($programme) {
                        $realise = $communes->conventions()->where([['appel_offre_id', '!=', null]])
                            ->where([['realise', '!=', 0]])
                            ->whereHas('programme', function($query) use ($programme) {
                                $query->where('id','=',$programme);
                            })
                            ->count('convention_id');

                        $en_cours = $communes->conventions()->where([['appel_offre_id', '!=', null]])
                            ->where([['realise', '=', 0]])
                            ->whereHas('programme', function($query) use ($programme) {
                                $query->where('id','=',$programme);
                            })
                            ->whereHas('appelOffres',function($query){
                                $query->where('ordre_service','!=',null);
                            })
                            ->count('convention_id');

                        $appel_offre = $communes->conventions()->where([['appel_offre_id', '!=', null]])
                            ->whereHas('programme', function($query) use ($programme) {
                                $query->where('id','=',$programme);
                            })
                            ->whereHas('appelOffres',function($query){
                                $query->where('ordre_service','=',null);
                            })
                            ->count('convention_id');

                        $programme = $communes->conventions()->where([['appel_offre_id', '=', null]])
                            ->whereHas('programme', function($query) use ($programme) {
                                $query->where('id','=',$programme);
                            })
                            ->count('convention_id');

                        return $programme+$appel_offre+$en_cours+$realise;
                    })


                    ->addColumn('taux_row', function ($communes) use ($programme,$total_projet) {
                        $realise = $communes->conventions()->where([['appel_offre_id', '!=', null]])
                            ->where([['realise', '!=', 0]])
                            ->whereHas('programme', function($query) use ($programme) {
                                $query->where('id','=',$programme);
                            })
                            ->count('convention_id');

                        $en_cours = $communes->conventions()->where([['appel_offre_id', '!=', null]])
                            ->where([['realise', '=', 0]])
                            ->whereHas('programme', function($query) use ($programme) {
                                $query->where('id','=',$programme);
                            })
                            ->whereHas('appelOffres',function($query){
                                $query->where('ordre_service','!=',null);
                            })
                            ->count('convention_id');

                        $appel_offre = $communes->conventions()->where([['appel_offre_id', '!=', null]])
                            ->whereHas('programme', function($query) use ($programme) {
                                $query->where('id','=',$programme);
                            })
                            ->whereHas('appelOffres',function($query){
                                $query->where('ordre_service','=',null);
                            })
                            ->count('convention_id');

                        $programme = $communes->conventions()->where([['appel_offre_id', '=', null]])
                            ->whereHas('programme', function($query) use ($programme) {
                                $query->where('id','=',$programme);
                            })
                            ->count('convention_id');
                        return number_format((($programme+$appel_offre+$en_cours+$realise)/$total_projet)*100);
                    });
            }

        }

        /*

        if($request->moa == "all")
        {

        }else{
            $moa =$request->moa;
            $appel_offre_inter = 0;
            if ($request->ajax()) {
                $datatables_moa = DataTables::eloquent($communes)
                    ->addColumn('programme', function ($communes) use($moa) {
                        $programme = $communes->conventions()->where([['appel_offre_id', '=', null]])
                            ->whereHas('moas', function($query) use ($moa) {
                                $query->where('id','=',$moa);
                            })
                            ->count('convention_id');
                        return $programme;
                    })
                    ->addColumn('appel_offre',function ($communes) use($moa) {
                        $appel_offre = $communes->conventions()->where([['appel_offre_id', '!=', null]])
                            ->whereHas('moas', function($query) use ($moa) {
                                $query->where('id','=',$moa);
                            })
                            ->whereHas('appelOffres',function($query){
                                $query->where('ordre_service','=',null);
                            })
                            ->count('convention_id');
                        return $appel_offre;
                    })

                    ->addColumn('en_cours', function ($communes) use($moa) {
                        $en_cours = $communes->conventions()->where([['appel_offre_id', '!=', null]])
                            ->where([['realise', '=', 0]])
                            ->whereHas('moas', function($query) use ($moa) {
                                $query->where('id','=',$moa);
                            })
                            ->whereHas('appelOffres',function($query){
                                $query->where('ordre_service','!=',null);
                            })
                            ->count('convention_id');
                        return $en_cours;
                    })

                    ->addColumn('realise',function ($communes) use($moa) {
                        $realise = $communes->conventions()->where([['appel_offre_id', '!=', null]])
                            ->where([['realise', '!=', 0]])
                            ->whereHas('moas', function($query) use ($moa) {
                                $query->where('id','=',$moa);
                            })
                            ->count('convention_id');
                        return $realise;
                    })


                    ->addColumn('total_row', function ($communes) use ($moa) {
                        $realise = $communes->conventions()->where([['appel_offre_id', '!=', null]])
                            ->where([['realise', '!=', 0]])
                            ->whereHas('moas', function($query) use ($moa) {
                                $query->where('id','=',$moa);
                            })
                            ->count('convention_id');

                        $en_cours = $communes->conventions()->where([['appel_offre_id', '!=', null]])
                            ->where([['realise', '=', 0]])
                            ->whereHas('moas', function($query) use ($moa) {
                                $query->where('id','=',$moa);
                            })
                            ->whereHas('appelOffres',function($query){
                                $query->where('ordre_service','!=',null);
                            })
                            ->count('convention_id');

                        $appel_offre = $communes->conventions()->where([['appel_offre_id', '!=', null]])
                            ->whereHas('moas', function($query) use ($moa) {
                                $query->where('id','=',$moa);
                            })
                            ->whereHas('appelOffres',function($query){
                                $query->where('ordre_service','=',null);
                            })
                            ->count('convention_id');

                        $programme = $communes->conventions()->where([['appel_offre_id', '=', null]])
                            ->whereHas('moas', function($query) use ($moa) {
                                $query->where('id','=',$moa);
                            })
                            ->count('convention_id');

                        return $programme+$appel_offre+$en_cours+$realise;
                    })


                    ->addColumn('taux_row', function ($communes) use ($moa,$total_projet) {
                        $realise = $communes->conventions()->where([['appel_offre_id', '!=', null]])
                            ->where([['realise', '!=', 0]])
                            ->whereHas('moas', function($query) use ($moa) {
                                $query->where('id','=',$moa);
                            })
                            ->count('convention_id');

                        $en_cours = $communes->conventions()->where([['appel_offre_id', '!=', null]])
                            ->where([['realise', '=', 0]])
                            ->whereHas('moas', function($query) use ($moa) {
                                $query->where('id','=',$moa);
                            })
                            ->whereHas('appelOffres',function($query){
                                $query->where('ordre_service','!=',null);
                            })
                            ->count('convention_id');

                        $appel_offre = $communes->conventions()->where([['appel_offre_id', '!=', null]])
                            ->whereHas('moas', function($query) use ($moa) {
                                $query->where('id','=',$moa);
                            })
                            ->whereHas('appelOffres',function($query){
                                $query->where('ordre_service','=',null);
                            })
                            ->count('convention_id');

                        $programme = $communes->conventions()->where([['appel_offre_id', '=', null]])
                            ->whereHas('moas', function($query) use ($moa) {
                                $query->where('id','=',$moa);
                            })
                            ->count('convention_id');


                        return number_format((($programme+$appel_offre+$en_cours+$realise)/$total_projet)*100);
                    });
            }
            return $datatables_moa->make(true);
        }


        if($request->programme == "all")
        {

        }else {
            $programme =$request->programme;
            $appel_offre_inter = 0;
            if ($request->ajax()) {
                $datatables_moa = DataTables::eloquent($communes)

                    ->addColumn('programme', function ($communes) use($programme) {
                        $programme = $communes->conventions()->where([['appel_offre_id', '=', null]])
                            ->whereHas('programme', function($query) use ($programme) {
                                $query->where('id','=',$programme);
                            })
                            ->count('convention_id');
                        return $programme;
                    })
                    ->addColumn('appel_offre',function ($communes) use($programme) {
                        $appel_offre = $communes->conventions()->where([['appel_offre_id', '!=', null]])
                            ->whereHas('programme', function($query) use ($programme) {
                                $query->where('id','=',$programme);
                            })
                            ->whereHas('appelOffres',function($query){
                                $query->where('ordre_service','=',null);
                            })
                            ->count('convention_id');
                        return $appel_offre;
                    })

                    ->addColumn('en_cours', function ($communes) use($programme) {
                        $en_cours = $communes->conventions()->where([['appel_offre_id', '!=', null]])
                            ->where([['realise', '=', 0]])
                            ->whereHas('programme', function($query) use ($programme) {
                                $query->where('id','=',$programme);
                            })
                            ->whereHas('appelOffres',function($query){
                                $query->where('ordre_service','!=',null);
                            })
                            ->count('convention_id');
                        return $en_cours;
                    })

                    ->addColumn('realise',function ($communes) use($programme) {
                        $realise = $communes->conventions()->where([['appel_offre_id', '!=', null]])
                            ->where([['realise', '!=', 0]])
                            ->whereHas('programme', function($query) use ($programme) {
                                $query->where('id','=',$programme);
                            })
                            ->count('convention_id');
                        return $realise;
                    })


                    ->addColumn('total_row', function ($communes) use ($programme) {
                        $realise = $communes->conventions()->where([['appel_offre_id', '!=', null]])
                            ->where([['realise', '!=', 0]])
                            ->whereHas('programme', function($query) use ($programme) {
                                $query->where('id','=',$programme);
                            })
                            ->count('convention_id');

                        $en_cours = $communes->conventions()->where([['appel_offre_id', '!=', null]])
                            ->where([['realise', '=', 0]])
                            ->whereHas('programme', function($query) use ($programme) {
                                $query->where('id','=',$programme);
                            })
                            ->whereHas('appelOffres',function($query){
                                $query->where('ordre_service','!=',null);
                            })
                            ->count('convention_id');

                        $appel_offre = $communes->conventions()->where([['appel_offre_id', '!=', null]])
                            ->whereHas('programme', function($query) use ($programme) {
                                $query->where('id','=',$programme);
                            })
                            ->whereHas('appelOffres',function($query){
                                $query->where('ordre_service','=',null);
                            })
                            ->count('convention_id');

                        $programme = $communes->conventions()->where([['appel_offre_id', '=', null]])
                            ->whereHas('programme', function($query) use ($programme) {
                                $query->where('id','=',$programme);
                            })
                            ->count('convention_id');

                        return $programme+$appel_offre+$en_cours+$realise;
                    })


                    ->addColumn('taux_row', function ($communes) use ($programme,$total_projet) {
                        $realise = $communes->conventions()->where([['appel_offre_id', '!=', null]])
                            ->where([['realise', '!=', 0]])
                            ->whereHas('programme', function($query) use ($programme) {
                                $query->where('id','=',$programme);
                            })
                            ->count('convention_id');

                        $en_cours = $communes->conventions()->where([['appel_offre_id', '!=', null]])
                            ->where([['realise', '=', 0]])
                            ->whereHas('programme', function($query) use ($programme) {
                                $query->where('id','=',$programme);
                            })
                            ->whereHas('appelOffres',function($query){
                                $query->where('ordre_service','!=',null);
                            })
                            ->count('convention_id');

                        $appel_offre = $communes->conventions()->where([['appel_offre_id', '!=', null]])
                            ->whereHas('programme', function($query) use ($programme) {
                                $query->where('id','=',$programme);
                            })
                            ->whereHas('appelOffres',function($query){
                                $query->where('ordre_service','=',null);
                            })
                            ->count('convention_id');

                        $programme = $communes->conventions()->where([['appel_offre_id', '=', null]])
                            ->whereHas('programme', function($query) use ($programme) {
                                $query->where('id','=',$programme);
                            })
                            ->count('convention_id');


                        return number_format((($programme+$appel_offre+$en_cours+$realise)/$total_projet)*100);
                    });
            }
            return $datatables_moa->make(true);
        }*/

        return $datatables->make(true);
    }


    public function getProjetsLongueur(Request $request)
    {
        $communes = Commune::with('demandes','conventions')->orderBy('nom_fr', 'asc');
        $conventions = Convention::with('piste')->get();

        $longueur_total = 0;
        foreach($conventions as $cnv)
        {
            $longueur_total += $cnv->piste->longueur;
        }


        $programmes_lg = 0;
        $appel_offre_lg = 0;
        $en_cours_lg = 0;
        $realise_lg = 0;

        if ($request->ajax()) {
            $datatables = DataTables::eloquent($communes)
                ->addColumn('programme', function ($communes) use ($programmes_lg) {
                    $conventions_per_commune = $communes->conventions()->get();
                    //return $conventions_per_commune;
                    foreach($conventions_per_commune as $cnv)
                    {
                        if($cnv->appel_offre_id == null)
                        {
                            $programmes_lg += $cnv->piste->longueur;
                        }
                    }
                    return $programmes_lg;
                })
                ->addColumn('appel_offre', function ($communes) use ($appel_offre_lg) {
                    $conventions_per_commune = $communes->conventions()->get();

                    foreach($conventions_per_commune as $cnv)
                    {
                        if($cnv->appel_offre_id != null && $cnv->appelOffres->ordre_service == null)
                        {
                            $appel_offre_lg += $cnv->piste->longueur;
                        }
                    }
                    return $appel_offre_lg;
                })

                ->addColumn('en_cours', function ($communes) use ($en_cours_lg) {
                    $conventions_per_commune = $communes->conventions()->get();

                    foreach($conventions_per_commune as $cnv)
                    {
                        if($cnv->appel_offre_id != null && $cnv->appelOffres->ordre_service != null && $cnv->realise == 0)
                        {
                            $en_cours_lg += $cnv->piste->longueur;
                        }
                    }
                    return $en_cours_lg;
                })

                ->addColumn('realise', function ($communes) use ($realise_lg) {
                    $conventions_per_commune = $communes->conventions()->get();

                    foreach($conventions_per_commune as $cnv)
                    {
                        if($cnv->appel_offre_id != null && $cnv->realise != 0)
                        {
                            $realise_lg += $cnv->piste->longueur;
                        }
                    }
                    return $realise_lg;
                })


                ->addColumn('total_row', function($communes) use ($programmes_lg,$appel_offre_lg,$en_cours_lg,$realise_lg) {
                    $conventions_per_commune = $communes->conventions()->get();
                    foreach($conventions_per_commune as $cnv)
                    {
                        if($cnv->appel_offre_id == null)
                        {
                            $programmes_lg += $cnv->piste->longueur;
                        }
                        if($cnv->appel_offre_id != null && $cnv->appelOffres->ordre_service == null)
                        {
                            $appel_offre_lg+= $cnv->piste->longueur;
                        }
                        if($cnv->appel_offre_id != null && $cnv->appelOffres->ordre_service != null && $cnv->realise == 0)
                        {
                            $en_cours_lg+= $cnv->piste->longueur;
                        }
                        if($cnv->appel_offre_id != null && $cnv->realise != 0)
                        {
                            $realise_lg+= $cnv->piste->longueur;
                        }
                    }
                    return $realise_lg+$en_cours_lg+$appel_offre_lg+$programmes_lg;
                })


                ->addColumn('taux_row', function($communes) use ($programmes_lg,$appel_offre_lg,$en_cours_lg,$realise_lg,$longueur_total) {
                    $conventions_per_commune = $communes->conventions()->get();
                    foreach($conventions_per_commune as $cnv)
                    {
                        if($cnv->appel_offre_id == null)
                        {
                            $programmes_lg += $cnv->piste->longueur;
                        }
                        if($cnv->appel_offre_id != null && $cnv->appelOffres->ordre_service == null)
                        {
                            $appel_offre_lg+= $cnv->piste->longueur;
                        }
                        if($cnv->appel_offre_id != null && $cnv->appelOffres->ordre_service != null && $cnv->realise == 0)
                        {
                            $en_cours_lg+= $cnv->piste->longueur;
                        }
                        if($cnv->appel_offre_id != null && $cnv->realise != 0)
                        {
                            $realise_lg+= $cnv->piste->longueur;
                        }
                    }
                    return number_format((($realise_lg+$en_cours_lg+$appel_offre_lg+$programmes_lg)/$longueur_total)*100) ;
                })
            ;
        }

        if($request->interventions == "all" && $request->annee == "all")
        {

        }

        if($request->interventions != "all" && $request->annee == "all")
        {
            $interventions_id =$request->interventions;
            $annee =$request->annee;
            $appel_offre_inter = 0;
            $programme_lg = 0;
            $appel_offre_lg = 0;
            $en_cours_lg = 0;
            $realise_lg = 0;
            if ($request->ajax()) {
                $datatables_intervention_annee = DataTables::eloquent($communes)

                    ->addColumn('programme', function ($communes) use ($programme_lg,$interventions_id) {
                        $commune_id = $communes->id;
                        $convention_interv = Convention::with('piste')
                            ->whereHas('communes',function($query) use ($commune_id){
                                $query->where('communes.id','=',$commune_id);
                            })
                            ->whereHas('interventions', function($query) use ($interventions_id) {
                                $query->where('interventions.id','=',$interventions_id);
                            })
                            ->get();


                        foreach($convention_interv as $cnv_interv)
                        {

                            if($cnv_interv->appel_offre_id == null)
                            {
                                $programme_lg += $cnv_interv->piste->longueur;
                            }
                        }
                        return $programme_lg;
                    })
                    ->addColumn('appel_offre', function ($communes) use ($appel_offre_lg,$interventions_id) {
                        $commune_id = $communes->id;
                        $convention_interv = Convention::with('piste')
                            ->whereHas('communes',function($query) use ($commune_id){
                                $query->where('communes.id','=',$commune_id);
                            })
                            ->whereHas('interventions', function($query) use ($interventions_id) {
                                $query->where('interventions.id','=',$interventions_id);
                            })
                            ->get();


                        foreach($convention_interv as $cnv_interv)
                        {
                            if($cnv_interv->appel_offre_id != null)
                            {
                                $appel_offre_lg += $cnv_interv->piste->longueur;
                            }
                        }
                        return $appel_offre_lg;
                    })

                    ->addColumn('en_cours', function ($communes) use ($en_cours_lg,$interventions_id) {
                        $commune_id = $communes->id;
                        $convention_interv = Convention::with('piste')
                            ->whereHas('communes',function($query) use ($commune_id){
                                $query->where('communes.id','=',$commune_id);
                            })
                            ->whereHas('interventions', function($query) use ($interventions_id) {
                                $query->where('interventions.id','=',$interventions_id);
                            })
                            ->get();

                        foreach($convention_interv as $cnv_interv)
                        {
                            if($cnv_interv->appel_offre_id != null && $cnv_interv->appelOffres->ordre_service != null && $cnv_interv->realise == 0)
                            {
                                $en_cours_lg += $cnv_interv->piste->longueur;
                            }
                        }
                        return $en_cours_lg;
                    })

                    ->addColumn('realise',function ($communes) use ($realise_lg,$interventions_id) {
                        $commune_id = $communes->id;
                        $convention_interv = Convention::with('piste')
                            ->whereHas('communes',function($query) use ($commune_id){
                                $query->where('communes.id','=',$commune_id);
                            })
                            ->whereHas('interventions', function($query) use ($interventions_id) {
                                $query->where('interventions.id','=',$interventions_id);
                            })
                            ->get();

                        foreach($convention_interv as $cnv_interv)
                        {
                            if($cnv_interv->appel_offre_id != null && $cnv_interv->realise != 0)
                            {
                                $realise_lg += $cnv_interv->piste->longueur;
                            }
                        }
                        return $realise_lg;
                    })


                    ->addColumn('total_row', function ($communes) use ($en_cours_lg,$programmes_lg,$appel_offre_lg,$realise_lg,$interventions_id) {
                        $commune_id = $communes->id;
                        $convention_interv = Convention::with('piste')
                            ->whereHas('communes',function($query) use ($commune_id){
                                $query->where('communes.id','=',$commune_id);
                            })
                            ->whereHas('interventions', function($query) use ($interventions_id) {
                                $query->where('interventions.id','=',$interventions_id);
                            })
                            ->get();

                        foreach($convention_interv as $cnv)
                        {
                            if($cnv->appel_offre_id == null)
                            {
                                $programmes_lg += $cnv->piste->longueur;
                            }
                            if($cnv->appel_offre_id != null && $cnv->appelOffres->ordre_service == null)
                            {
                                $appel_offre_lg+= $cnv->piste->longueur;
                            }
                            if($cnv->appel_offre_id != null && $cnv->appelOffres->ordre_service != null && $cnv->realise == 0)
                            {
                                $en_cours_lg+= $cnv->piste->longueur;
                            }
                            if($cnv->appel_offre_id != null && $cnv->realise != 0)
                            {
                                $realise_lg+= $cnv->piste->longueur;
                            }
                        }
                        return $realise_lg+$en_cours_lg+$appel_offre_lg+$programmes_lg;
                    })
                    ->addColumn('taux_row', function ($communes) use ($en_cours_lg,$programmes_lg,$appel_offre_lg,$realise_lg,$interventions_id,$longueur_total) {
                        $commune_id = $communes->id;
                        $convention_interv = Convention::with('piste')
                            ->whereHas('communes',function($query) use ($commune_id){
                                $query->where('communes.id','=',$commune_id);
                            })
                            ->whereHas('interventions', function($query) use ($interventions_id) {
                                $query->where('interventions.id','=',$interventions_id);
                            })
                            ->get();

                        foreach($convention_interv as $cnv)
                        {
                            if($cnv->appel_offre_id == null)
                            {
                                $programmes_lg += $cnv->piste->longueur;
                            }
                            if($cnv->appel_offre_id != null && $cnv->appelOffres->ordre_service == null)
                            {
                                $appel_offre_lg+= $cnv->piste->longueur;
                            }
                            if($cnv->appel_offre_id != null && $cnv->appelOffres->ordre_service != null && $cnv->realise == 0)
                            {
                                $en_cours_lg+= $cnv->piste->longueur;
                            }
                            if($cnv->appel_offre_id != null && $cnv->realise != 0)
                            {
                                $realise_lg+= $cnv->piste->longueur;
                            }
                        }
                        return number_format((($realise_lg+$en_cours_lg+$appel_offre_lg+$programmes_lg)/$longueur_total)*100);
                    });
            }
            return $datatables_intervention_annee->make(true);
        }


        if($request->interventions == "all" && $request->annee != "all")
        {
            $interventions_id =$request->interventions;
            $annee =$request->annee;
            $appel_offre_inter = 0;
            $programme_lg = 0;
            $appel_offre_lg = 0;
            $en_cours_lg = 0;
            $realise_lg = 0;
            if ($request->ajax()) {
                $datatables_intervention_annee = DataTables::eloquent($communes)

                    ->addColumn('programme', function ($communes) use ($programme_lg,$annee) {
                        $commune_id = $communes->id;
                        $convention_interv = Convention::with('piste')
                            ->where('annee','=',$annee)
                            ->whereHas('communes',function($query) use ($commune_id){
                                $query->where('communes.id','=',$commune_id);
                            })
                            // ->whereHas('interventions', function($query) use ($interventions_id) {
                            //     $query->where('interventions.id','=',$interventions_id);
                            // })
                            ->get();


                        foreach($convention_interv as $cnv_interv)
                        {

                            if($cnv_interv->appel_offre_id == null)
                            {
                                $programme_lg += $cnv_interv->piste->longueur;
                            }
                        }
                        return $programme_lg;
                    })
                    ->addColumn('appel_offre', function ($communes) use ($appel_offre_lg,$annee) {
                        $commune_id = $communes->id;
                        $convention_interv = Convention::with('piste')
                            ->where('annee','=',$annee)
                            ->whereHas('communes',function($query) use ($commune_id){
                                $query->where('communes.id','=',$commune_id);
                            })
                            ->get();


                        foreach($convention_interv as $cnv_interv)
                        {
                            if($cnv_interv->appel_offre_id != null)
                            {
                                $appel_offre_lg += $cnv_interv->piste->longueur;
                            }
                        }
                        return $appel_offre_lg;
                    })

                    ->addColumn('en_cours', function ($communes) use ($en_cours_lg,$annee) {
                        $commune_id = $communes->id;
                        $convention_interv = Convention::with('piste')
                            ->where('annee','=',$annee)
                            ->whereHas('communes',function($query) use ($commune_id){
                                $query->where('communes.id','=',$commune_id);
                            })
                            ->get();

                        foreach($convention_interv as $cnv_interv)
                        {
                            if($cnv_interv->appel_offre_id != null && $cnv_interv->appelOffres->ordre_service != null && $cnv_interv->realise == 0)
                            {
                                $en_cours_lg += $cnv_interv->piste->longueur;
                            }
                        }
                        return $en_cours_lg;
                    })

                    ->addColumn('realise',function ($communes) use ($realise_lg,$annee) {
                        $commune_id = $communes->id;
                        $convention_interv = Convention::with('piste')
                            ->where('annee','=',$annee)
                            ->whereHas('communes',function($query) use ($commune_id){
                                $query->where('communes.id','=',$commune_id);
                            })

                            ->get();

                        foreach($convention_interv as $cnv_interv)
                        {
                            if($cnv_interv->appel_offre_id != null && $cnv_interv->realise != 0)
                            {
                                $realise_lg += $cnv_interv->piste->longueur;
                            }
                        }
                        return $realise_lg;
                    })


                    ->addColumn('total_row', function ($communes) use ($en_cours_lg,$programmes_lg,$appel_offre_lg,$realise_lg,$annee) {
                        $commune_id = $communes->id;
                        $convention_interv = Convention::with('piste')
                            ->where('annee','=',$annee)
                            ->whereHas('communes',function($query) use ($commune_id){
                                $query->where('communes.id','=',$commune_id);
                            })
                            ->get();

                        foreach($convention_interv as $cnv)
                        {
                            if($cnv->appel_offre_id == null)
                            {
                                $programmes_lg += $cnv->piste->longueur;
                            }
                            if($cnv->appel_offre_id != null && $cnv->appelOffres->ordre_service == null)
                            {
                                $appel_offre_lg+= $cnv->piste->longueur;
                            }
                            if($cnv->appel_offre_id != null && $cnv->appelOffres->ordre_service != null && $cnv->realise == 0)
                            {
                                $en_cours_lg+= $cnv->piste->longueur;
                            }
                            if($cnv->appel_offre_id != null && $cnv->realise != 0)
                            {
                                $realise_lg+= $cnv->piste->longueur;
                            }
                        }
                        return $realise_lg+$en_cours_lg+$appel_offre_lg+$programmes_lg;
                    })
                    ->addColumn('taux_row', function ($communes) use ($en_cours_lg,$programmes_lg,$appel_offre_lg,$realise_lg,$annee,$longueur_total) {
                        $commune_id = $communes->id;
                        $convention_interv = Convention::with('piste')
                            ->where('annee','=',$annee)
                            ->whereHas('communes',function($query) use ($commune_id){
                                $query->where('communes.id','=',$commune_id);
                            })
                            ->get();

                        foreach($convention_interv as $cnv)
                        {
                            if($cnv->appel_offre_id == null)
                            {
                                $programmes_lg += $cnv->piste->longueur;
                            }
                            if($cnv->appel_offre_id != null && $cnv->appelOffres->ordre_service == null)
                            {
                                $appel_offre_lg+= $cnv->piste->longueur;
                            }
                            if($cnv->appel_offre_id != null && $cnv->appelOffres->ordre_service != null && $cnv->realise == 0)
                            {
                                $en_cours_lg+= $cnv->piste->longueur;
                            }
                            if($cnv->appel_offre_id != null && $cnv->realise != 0)
                            {
                                $realise_lg+= $cnv->piste->longueur;
                            }
                        }
                        return number_format((($realise_lg+$en_cours_lg+$appel_offre_lg+$programmes_lg)/$longueur_total)*100);
                    });
            }
            return $datatables_intervention_annee->make(true);
        }


        if($request->interventions != "all" && $request->annee != "all")
        {
            $interventions_id =$request->interventions;
            $annee =$request->annee;
            $appel_offre_inter = 0;
            $programme_lg = 0;
            $appel_offre_lg = 0;
            $en_cours_lg = 0;
            $realise_lg = 0;
            if ($request->ajax()) {
                $datatables_intervention_annee = DataTables::eloquent($communes)

                    ->addColumn('programme', function ($communes) use ($programme_lg,$annee,$interventions_id) {
                        $commune_id = $communes->id;
                        $convention_interv = Convention::with('piste')
                            ->where('annee','=',$annee)
                            ->whereHas('communes',function($query) use ($commune_id){
                                $query->where('communes.id','=',$commune_id);
                            })
                            ->whereHas('interventions', function($query) use ($interventions_id) {
                                $query->where('interventions.id','=',$interventions_id);
                            })
                            ->get();


                        foreach($convention_interv as $cnv_interv)
                        {

                            if($cnv_interv->appel_offre_id == null)
                            {
                                $programme_lg += $cnv_interv->piste->longueur;
                            }
                        }
                        return $programme_lg;
                    })
                    ->addColumn('appel_offre', function ($communes) use ($appel_offre_lg,$annee,$interventions_id) {
                        $commune_id = $communes->id;
                        $convention_interv = Convention::with('piste')
                            ->where('annee','=',$annee)
                            ->whereHas('communes',function($query) use ($commune_id){
                                $query->where('communes.id','=',$commune_id);
                            })
                            ->whereHas('interventions', function($query) use ($interventions_id) {
                                $query->where('interventions.id','=',$interventions_id);
                            })
                            ->get();


                        foreach($convention_interv as $cnv_interv)
                        {
                            if($cnv_interv->appel_offre_id != null)
                            {
                                $appel_offre_lg += $cnv_interv->piste->longueur;
                            }
                        }
                        return $appel_offre_lg;
                    })

                    ->addColumn('en_cours', function ($communes) use ($en_cours_lg,$annee,$interventions_id) {
                        $commune_id = $communes->id;
                        $convention_interv = Convention::with('piste')
                            ->where('annee','=',$annee)
                            ->whereHas('communes',function($query) use ($commune_id){
                                $query->where('communes.id','=',$commune_id);
                            })
                            ->whereHas('interventions', function($query) use ($interventions_id) {
                                $query->where('interventions.id','=',$interventions_id);
                            })
                            ->get();

                        foreach($convention_interv as $cnv_interv)
                        {
                            if($cnv_interv->appel_offre_id != null && $cnv_interv->appelOffres->ordre_service != null && $cnv_interv->realise == 0)
                            {
                                $en_cours_lg += $cnv_interv->piste->longueur;
                            }
                        }
                        return $en_cours_lg;
                    })

                    ->addColumn('realise',function ($communes) use ($realise_lg,$annee,$interventions_id) {
                        $commune_id = $communes->id;
                        $convention_interv = Convention::with('piste')
                            ->where('annee','=',$annee)
                            ->whereHas('communes',function($query) use ($commune_id){
                                $query->where('communes.id','=',$commune_id);
                            })
                            ->whereHas('interventions', function($query) use ($interventions_id) {
                                $query->where('interventions.id','=',$interventions_id);
                            })
                            ->get();

                        foreach($convention_interv as $cnv_interv)
                        {
                            if($cnv_interv->appel_offre_id != null && $cnv_interv->realise != 0)
                            {
                                $realise_lg += $cnv_interv->piste->longueur;
                            }
                        }
                        return $realise_lg;
                    })


                    ->addColumn('total_row', function ($communes) use ($en_cours_lg,$programmes_lg,$appel_offre_lg,$realise_lg,$annee,$interventions_id) {
                        $commune_id = $communes->id;
                        $convention_interv = Convention::with('piste')
                            ->where('annee','=',$annee)
                            ->whereHas('communes',function($query) use ($commune_id){
                                $query->where('communes.id','=',$commune_id);
                            })
                            ->whereHas('interventions', function($query) use ($interventions_id) {
                                $query->where('interventions.id','=',$interventions_id);
                            })
                            ->get();

                        foreach($convention_interv as $cnv)
                        {
                            if($cnv->appel_offre_id == null)
                            {
                                $programmes_lg += $cnv->piste->longueur;
                            }
                            if($cnv->appel_offre_id != null && $cnv->appelOffres->ordre_service == null)
                            {
                                $appel_offre_lg+= $cnv->piste->longueur;
                            }
                            if($cnv->appel_offre_id != null && $cnv->appelOffres->ordre_service != null && $cnv->realise == 0)
                            {
                                $en_cours_lg+= $cnv->piste->longueur;
                            }
                            if($cnv->appel_offre_id != null && $cnv->realise != 0)
                            {
                                $realise_lg+= $cnv->piste->longueur;
                            }
                        }
                        return $realise_lg+$en_cours_lg+$appel_offre_lg+$programmes_lg;
                    })
                    ->addColumn('taux_row', function ($communes) use ($en_cours_lg,$programmes_lg,$appel_offre_lg,$realise_lg,$annee,$interventions_id,$longueur_total) {
                        $commune_id = $communes->id;
                        $convention_interv = Convention::with('piste')
                            ->where('annee','=',$annee)
                            ->whereHas('communes',function($query) use ($commune_id){
                                $query->where('communes.id','=',$commune_id);
                            })
                            ->whereHas('interventions', function($query) use ($interventions_id) {
                                $query->where('interventions.id','=',$interventions_id);
                            })
                            ->get();

                        foreach($convention_interv as $cnv)
                        {
                            if($cnv->appel_offre_id == null)
                            {
                                $programmes_lg += $cnv->piste->longueur;
                            }
                            if($cnv->appel_offre_id != null && $cnv->appelOffres->ordre_service == null)
                            {
                                $appel_offre_lg+= $cnv->piste->longueur;
                            }
                            if($cnv->appel_offre_id != null && $cnv->appelOffres->ordre_service != null && $cnv->realise == 0)
                            {
                                $en_cours_lg+= $cnv->piste->longueur;
                            }
                            if($cnv->appel_offre_id != null && $cnv->realise != 0)
                            {
                                $realise_lg+= $cnv->piste->longueur;
                            }
                        }
                        return number_format((($realise_lg+$en_cours_lg+$appel_offre_lg+$programmes_lg)/$longueur_total)*100);
                    });
            }
            return $datatables_intervention_annee->make(true);
        }



        if($request->moa == "all")
        {

        }else{

            $moa =$request->moa;
            $appel_offre_inter = 0;
            $programme_lg = 0;
            $appel_offre_lg = 0;
            $en_cours_lg = 0;
            $realise_lg = 0;
            if ($request->ajax()) {
                $datatables_intervention_annee = DataTables::eloquent($communes)

                    ->addColumn('programme', function ($communes) use ($programme_lg,$moa) {
                        $commune_id = $communes->id;
                        $convention_interv = Convention::with('piste')
                            ->whereHas('communes',function($query) use ($commune_id){
                                $query->where('communes.id','=',$commune_id);
                            })
                            ->whereHas('moas', function($query) use ($moa) {
                                $query->where('id','=',$moa);
                            })
                            ->get();


                        foreach($convention_interv as $cnv_interv)
                        {

                            if($cnv_interv->appel_offre_id == null)
                            {
                                $programme_lg += $cnv_interv->piste->longueur;
                            }
                        }
                        return $programme_lg;
                    })
                    ->addColumn('appel_offre', function ($communes) use ($appel_offre_lg,$moa) {
                        $commune_id = $communes->id;
                        $convention_interv = Convention::with('piste')
                            ->whereHas('communes',function($query) use ($commune_id){
                                $query->where('communes.id','=',$commune_id);
                            })
                            ->whereHas('moas', function($query) use ($moa) {
                                $query->where('id','=',$moa);
                            })
                            ->get();


                        foreach($convention_interv as $cnv_interv)
                        {
                            if($cnv_interv->appel_offre_id != null)
                            {
                                $appel_offre_lg += $cnv_interv->piste->longueur;
                            }
                        }
                        return $appel_offre_lg;
                    })

                    ->addColumn('en_cours', function ($communes) use ($en_cours_lg,$moa) {
                        $commune_id = $communes->id;
                        $convention_interv = Convention::with('piste')
                            ->whereHas('communes',function($query) use ($commune_id){
                                $query->where('communes.id','=',$commune_id);
                            })
                            ->whereHas('moas', function($query) use ($moa) {
                                $query->where('id','=',$moa);
                            })
                            ->get();

                        foreach($convention_interv as $cnv_interv)
                        {
                            if($cnv_interv->appel_offre_id != null && $cnv_interv->appelOffres->ordre_service != null && $cnv_interv->realise == 0)
                            {
                                $en_cours_lg += $cnv_interv->piste->longueur;
                            }
                        }
                        return $en_cours_lg;
                    })

                    ->addColumn('realise',function ($communes) use ($realise_lg,$moa) {
                        $commune_id = $communes->id;
                        $convention_interv = Convention::with('piste')
                            ->whereHas('communes',function($query) use ($commune_id){
                                $query->where('communes.id','=',$commune_id);
                            })
                            ->whereHas('moas', function($query) use ($moa) {
                                $query->where('id','=',$moa);
                            })
                            ->get();

                        foreach($convention_interv as $cnv_interv)
                        {
                            if($cnv_interv->appel_offre_id != null && $cnv_interv->realise != 0)
                            {
                                $realise_lg += $cnv_interv->piste->longueur;
                            }
                        }
                        return $realise_lg;
                    })


                    ->addColumn('total_row', function ($communes) use ($en_cours_lg,$programmes_lg,$appel_offre_lg,$realise_lg,$moa) {
                        $commune_id = $communes->id;
                        $convention_interv = Convention::with('piste')
                            ->whereHas('communes',function($query) use ($commune_id){
                                $query->where('communes.id','=',$commune_id);
                            })
                            ->whereHas('moas', function($query) use ($moa) {
                                $query->where('id','=',$moa);
                            })
                            ->get();

                        foreach($convention_interv as $cnv)
                        {
                            if($cnv->appel_offre_id == null)
                            {
                                $programmes_lg += $cnv->piste->longueur;
                            }
                            if($cnv->appel_offre_id != null && $cnv->appelOffres->ordre_service == null)
                            {
                                $appel_offre_lg+= $cnv->piste->longueur;
                            }
                            if($cnv->appel_offre_id != null && $cnv->appelOffres->ordre_service != null && $cnv->realise == 0)
                            {
                                $en_cours_lg+= $cnv->piste->longueur;
                            }
                            if($cnv->appel_offre_id != null && $cnv->realise != 0)
                            {
                                $realise_lg+= $cnv->piste->longueur;
                            }
                        }
                        return $realise_lg+$en_cours_lg+$appel_offre_lg+$programmes_lg;
                    })
                    ->addColumn('taux_row', function ($communes) use ($en_cours_lg,$programmes_lg,$appel_offre_lg,$realise_lg,$moa,$longueur_total) {
                        $commune_id = $communes->id;
                        $convention_interv = Convention::with('piste')
                            ->whereHas('communes',function($query) use ($commune_id){
                                $query->where('communes.id','=',$commune_id);
                            })
                            ->whereHas('moas', function($query) use ($moa) {
                                $query->where('id','=',$moa);
                            })
                            ->get();

                        foreach($convention_interv as $cnv)
                        {
                            if($cnv->appel_offre_id == null)
                            {
                                $programmes_lg += $cnv->piste->longueur;
                            }
                            if($cnv->appel_offre_id != null && $cnv->appelOffres->ordre_service == null)
                            {
                                $appel_offre_lg+= $cnv->piste->longueur;
                            }
                            if($cnv->appel_offre_id != null && $cnv->appelOffres->ordre_service != null && $cnv->realise == 0)
                            {
                                $en_cours_lg+= $cnv->piste->longueur;
                            }
                            if($cnv->appel_offre_id != null && $cnv->realise != 0)
                            {
                                $realise_lg+= $cnv->piste->longueur;
                            }
                        }
                        return number_format((($realise_lg+$en_cours_lg+$appel_offre_lg+$programmes_lg)/$longueur_total)*100);
                    });
            }
            return $datatables_intervention_annee->make(true);
        }

        if($request->programme == "all")
        {

        }else{
            $programme =$request->programme;
            $appel_offre_inter = 0;
            $programme_lg = 0;
            $appel_offre_lg = 0;
            $en_cours_lg = 0;
            $realise_lg = 0;
            if ($request->ajax()) {
                $datatables_intervention_annee = DataTables::eloquent($communes)

                    ->addColumn('programme', function ($communes) use ($programme_lg,$programme) {
                        $commune_id = $communes->id;
                        $convention_interv = Convention::with('piste')
                            ->whereHas('communes',function($query) use ($commune_id){
                                $query->where('communes.id','=',$commune_id);
                            })
                            ->whereHas('programme', function($query) use ($programme) {
                                $query->where('id','=',$programme);
                            })
                            ->get();


                        foreach($convention_interv as $cnv_interv)
                        {

                            if($cnv_interv->appel_offre_id == null)
                            {
                                $programme_lg += $cnv_interv->piste->longueur;
                            }
                        }
                        return $programme_lg;
                    })
                    ->addColumn('appel_offre', function ($communes) use ($appel_offre_lg,$programme) {
                        $commune_id = $communes->id;
                        $convention_interv = Convention::with('piste')
                            ->whereHas('communes',function($query) use ($commune_id){
                                $query->where('communes.id','=',$commune_id);
                            })
                            ->whereHas('programme', function($query) use ($programme) {
                                $query->where('id','=',$programme);
                            })
                            ->get();


                        foreach($convention_interv as $cnv_interv)
                        {
                            if($cnv_interv->appel_offre_id != null)
                            {
                                $appel_offre_lg += $cnv_interv->piste->longueur;
                            }
                        }
                        return $appel_offre_lg;
                    })

                    ->addColumn('en_cours', function ($communes) use ($en_cours_lg,$programme) {
                        $commune_id = $communes->id;
                        $convention_interv = Convention::with('piste')
                            ->whereHas('communes',function($query) use ($commune_id){
                                $query->where('communes.id','=',$commune_id);
                            })
                            ->whereHas('programme', function($query) use ($programme) {
                                $query->where('id','=',$programme);
                            })
                            ->get();

                        foreach($convention_interv as $cnv_interv)
                        {
                            if($cnv_interv->appel_offre_id != null && $cnv_interv->appelOffres->ordre_service != null && $cnv_interv->realise == 0)
                            {
                                $en_cours_lg += $cnv_interv->piste->longueur;
                            }
                        }
                        return $en_cours_lg;
                    })

                    ->addColumn('realise',function ($communes) use ($realise_lg,$programme) {
                        $commune_id = $communes->id;
                        $convention_interv = Convention::with('piste')
                            ->whereHas('communes',function($query) use ($commune_id){
                                $query->where('communes.id','=',$commune_id);
                            })
                            ->whereHas('programme', function($query) use ($programme) {
                                $query->where('id','=',$programme);
                            })
                            ->get();

                        foreach($convention_interv as $cnv_interv)
                        {
                            if($cnv_interv->appel_offre_id != null && $cnv_interv->realise != 0)
                            {
                                $realise_lg += $cnv_interv->piste->longueur;
                            }
                        }
                        return $realise_lg;
                    })


                    ->addColumn('total_row', function ($communes) use ($en_cours_lg,$programmes_lg,$appel_offre_lg,$realise_lg,$programme) {
                        $commune_id = $communes->id;
                        $convention_interv = Convention::with('piste')
                            ->whereHas('communes',function($query) use ($commune_id){
                                $query->where('communes.id','=',$commune_id);
                            })
                            ->whereHas('programme', function($query) use ($programme) {
                                $query->where('id','=',$programme);
                            })
                            ->get();

                        foreach($convention_interv as $cnv)
                        {
                            if($cnv->appel_offre_id == null)
                            {
                                $programmes_lg += $cnv->piste->longueur;
                            }
                            if($cnv->appel_offre_id != null && $cnv->appelOffres->ordre_service == null)
                            {
                                $appel_offre_lg+= $cnv->piste->longueur;
                            }
                            if($cnv->appel_offre_id != null && $cnv->appelOffres->ordre_service != null && $cnv->realise == 0)
                            {
                                $en_cours_lg+= $cnv->piste->longueur;
                            }
                            if($cnv->appel_offre_id != null && $cnv->realise != 0)
                            {
                                $realise_lg+= $cnv->piste->longueur;
                            }
                        }
                        return $realise_lg+$en_cours_lg+$appel_offre_lg+$programmes_lg;
                    })
                    ->addColumn('taux_row', function ($communes) use ($en_cours_lg,$programmes_lg,$appel_offre_lg,$realise_lg,$programme,$longueur_total) {
                        $commune_id = $communes->id;
                        $convention_interv = Convention::with('piste')
                            ->whereHas('communes',function($query) use ($commune_id){
                                $query->where('communes.id','=',$commune_id);
                            })
                            ->whereHas('programme', function($query) use ($programme) {
                                $query->where('id','=',$programme);
                            })
                            ->get();

                        foreach($convention_interv as $cnv)
                        {
                            if($cnv->appel_offre_id == null)
                            {
                                $programmes_lg += $cnv->piste->longueur;
                            }
                            if($cnv->appel_offre_id != null && $cnv->appelOffres->ordre_service == null)
                            {
                                $appel_offre_lg+= $cnv->piste->longueur;
                            }
                            if($cnv->appel_offre_id != null && $cnv->appelOffres->ordre_service != null && $cnv->realise == 0)
                            {
                                $en_cours_lg+= $cnv->piste->longueur;
                            }
                            if($cnv->appel_offre_id != null && $cnv->realise != 0)
                            {
                                $realise_lg+= $cnv->piste->longueur;
                            }
                        }
                        return number_format((($realise_lg+$en_cours_lg+$appel_offre_lg+$programmes_lg)/$longueur_total)*100);
                    });
            }
            return $datatables_intervention_annee->make(true);


        }

        return $datatables->make(true);
    }



    public function getProjetCommunesTaux(Request $request)
    {
        $total_projet = Convention::all()->count('id');



        $communes = Commune::all();

        if(!isset($request->intervention) && !isset($request->annee) && !isset($request->moa) && !isset($request->programme))
        {

            foreach($communes as $commune)
            {
                $nombre_projet = 0;
                $commune_id = $commune->id;
                $nombre_projet = $commune->conventions()->count('conventions.id');

                $commune->taux = number_format(($nombre_projet/$total_projet)*100);
                $commune->nombre_convention_for_commune = $nombre_projet;
                $commune->total_nombre_convention = $total_projet;
            }

        }


        if(isset($request->intervention) && isset($request->annee) && isset($request->moa) && isset($request->programme)){
            $intervention =  $request->intervention;
            $annee =  $request->annee;
            $moa =  $request->moa;
            $programme =  $request->programme;
            foreach($communes as $commune)
            {
                $nombre_projet =0 ;
                $commune_id = $commune->id;

                $convtions_for_commune = Convention::whereHas('communes',function($query) use ($commune_id){
                    $query->where('communes.id','=',$commune_id);
                });
                ;


                if($request->intervention != "all")
                {
                    $convtions_for_commune_inter = $convtions_for_commune->whereHas('interventions', function ($query) use ($intervention) {
                        $query->where('interventions.id', '=',$intervention);
                    })->get();

                }


                if($request->annee != "all")
                {
                    $convtions_for_commune_inter = $convtions_for_commune->where('annee','=',$annee)->get();
                }

                if($request->moa != "all")
                {
                    $convtions_for_commune_inter = $convtions_for_commune->whereHas('moas', function ($query) use ($moa) {
                        $query->where('id', '=',$moa);
                    })->get();
                }

                if($request->programme != "all")
                {
                    $convtions_for_commune_inter = $convtions_for_commune->whereHas('programme', function ($query) use ($programme) {
                        $query->where('id', '=',$programme);
                    })->get();
                }

                $nombre_projet = $convtions_for_commune_inter->count('conventions.id');

                $commune->taux = number_format(($nombre_projet/$total_projet)*100);
                $commune->longueur_convention_for_commune = $nombre_projet;
                $commune->total_longueur_convention = number_format($total_projet);
            }


        }
        return $communes;
    }


    public function getProjetLGCommunesTaux(Request $request)
    {
        $conventions = Convention::with('piste')->get();

        $longueur_total = 0;
        foreach($conventions as $cnv)
        {
            $longueur_total += $cnv->piste->longueur;
        }


        $communes = Commune::all();
        $array_nombre_projet = array();

        if(!isset($request->intervention) && !isset($request->annee) && !isset($request->moa) && !isset($request->programme))
        {

            foreach($communes as $commune)
            {
                $longeur_projet = 0;
                $commune_id = $commune->id;
                $convtions_for_commune =  Convention::whereHas('communes',function($query) use ($commune_id){
                    $query->where('communes.id','=',$commune_id);
                })->get();


                foreach($convtions_for_commune as $cnv)
                {
                    $longeur_projet += $cnv->piste->longueur;
                }


                $commune->taux = number_format(($longeur_projet/$longueur_total)*100);
                $commune->longueur_convention_for_commune = $longeur_projet;
                $commune->total_longueur_convention = $longueur_total;
            }

        }


        if(isset($request->intervention) && isset($request->annee) && isset($request->moa) && isset($request->programme)){
            $intervention =  $request->intervention;
            $annee =  $request->annee;
            $moa =  $request->moa;
            $programme =  $request->programme;
            foreach($communes as $commune)
            {
                $longeur_conventions =0 ;
                $commune_id = $commune->id;

                $convtions_for_commune = Convention::whereHas('communes',function($query) use ($commune_id){
                    $query->where('communes.id','=',$commune_id);
                });
                ;


                if($request->intervention != "all")
                {
                    $convtions_for_commune_inter = $convtions_for_commune->whereHas('interventions', function ($query) use ($intervention) {
                        $query->where('interventions.id', '=',$intervention);
                    })->get();

                }


                if($request->annee != "all")
                {
                    $convtions_for_commune_inter = $convtions_for_commune->where('annee','=',$annee)->get();
                }

                if($request->moa != "all")
                {
                    $convtions_for_commune_inter = $convtions_for_commune->whereHas('moas', function ($query) use ($moa) {
                        $query->where('id', '=',$moa);
                    })->get();
                }

                if($request->programme != "all")
                {
                    $convtions_for_commune_inter = $convtions_for_commune->whereHas('programme', function ($query) use ($programme) {
                        $query->where('id', '=',$programme);
                    })->get();
                }

                foreach($convtions_for_commune_inter as $cnv)
                {
                    $longeur_conventions += $cnv->piste->longueur;
                }

                $commune->taux = number_format(($longeur_conventions/$longueur_total)*100);
                $commune->longueur_convention_for_commune = $longeur_conventions;
                $commune->total_longueur_convention = number_format($longueur_total);
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
        $moas = Moa::all();

        $programmes = Programme::all();
        $actu_time = Carbon::now();
        $actu_year =  $actu_time->toDateString();
        $year_number = (int) substr($actu_year,0,4);

        return view('statistics.index_statistics_show')->with([
            'interventions' => $interventions,
            'year_number' => $year_number,
            'moas' => $moas,
            'programmes' => $programmes
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
