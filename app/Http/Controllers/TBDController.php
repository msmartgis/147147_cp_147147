<?php

namespace App\Http\Controllers;

use App\AppelOffre;
use App\Convention;
use App\Programme;
use Illuminate\Http\Request;
use DataTables;
use App\Device;
use DB;
//use Request;
class TBDController extends Controller
{
    public function index(){


        $nombre_projet = Convention::all()->count();

        $nbr_projet_realise = Convention::where('realise','=',1)->count();
        $nbr_projet_en_cours = Convention::where('appel_offre_id','!=',null)
            ->whereHas('appelOffres',function($query){
                $query->where('ordre_service','!=',null);
            })
            ->where('realise','=',0)
            ->count();

        $nbr_projet_programmes = Convention::where('appel_offre_id','=',null)->count();

        $cout_total_projets = Convention::all()->sum('montant_global');

        $appel_offre = AppelOffre::all()->count();

        $cout_total_projets_MDH =  $cout_total_projets / 1000000;
        return view('dashboard.dashboard')->with([
            'nombre_projet' => $nombre_projet,
            'nbr_projet_realise'=> $nbr_projet_realise,
            'nbr_projet_en_cours' => $nbr_projet_en_cours,
            'nbr_projet_programmes' => $nbr_projet_programmes,
            'appel_offre' => $appel_offre,
            'cout_total_projets' => $cout_total_projets_MDH,
            'is_mobile' => Device::Device()
        ]);
    }


    public function nombreProjet(Request $request){

        $programmes = Programme::with('convention')->orderBy('nom_fr');
        if ($request->ajax()) {
            $datatables = DataTables::eloquent($programmes)
                ->addColumn('nbr_projet', function ($programmes) {
                    return $programmes->convention()->count('conventions.id');
                })
                ->addColumn('cout', function ($programmes) {
                    return ($programmes->convention()->sum('conventions.montant_global'))/1000000;
                })

                ->addColumn('realise', function ($programmes) {
                    $programme_id = $programmes->id;
                    $conventions = Convention::where('realise','=',1)->whereHas('programme',function($query) use ($programme_id){
                        $query->where('id','=',$programme_id);
                    })->get();
                    $longeur_realise = 0;
                    foreach($conventions as $cnv)
                    {
                        $longeur_realise += $cnv->piste->longueur;
                    }
                    return $longeur_realise;
                })

                ->addColumn('en_cours', function ($programmes) {
                    $programme_id = $programmes->id;
                    $conventions = Convention::where('appel_offre_id','!=',null)
                        ->whereHas('appelOffres',function($query){
                            $query->where('ordre_service','!=',null);
                        })
                        ->where('realise','=',0)
                        ->whereHas('programme',function($query) use ($programme_id){
                            $query->where('id','=',$programme_id);
                        })->get();
                    $longeur_en_cours = 0;
                    foreach($conventions as $cnv)
                    {
                        $longeur_en_cours += $cnv->piste->longueur;
                    }
                    return $longeur_en_cours;
                })


                ->addColumn('programmes', function ($programmes) {
                    $programme_id = $programmes->id;
                    $conventions = Convention::where('appel_offre_id','=',null)
                        ->whereHas('programme',function($query) use ($programme_id){
                            $query->where('id','=',$programme_id);
                        })->get();
                    $longeur_programmes = 0;
                    foreach($conventions as $cnv)
                    {
                        $longeur_programmes += $cnv->piste->longueur;
                    }
                    return $longeur_programmes;
                })



                ->addColumn('total', function ($programmes) {
                    $programme_id = $programmes->id;
                    $conventions_total = Convention::where('appel_offre_id','=',null)
                        ->whereHas('programme',function($query) use ($programme_id){
                            $query->where('id','=',$programme_id);
                        })->get();
                    $longeur_programmes = 0;
                    foreach($conventions_total as $cnv)
                    {
                        $longeur_programmes += $cnv->piste->longueur;
                    }


                    $conventions_en_cours = Convention::where('appel_offre_id','!=',null)
                        ->whereHas('appelOffres',function($query){
                            $query->where('ordre_service','!=',null);
                        })
                        ->where('realise','=',0)
                        ->whereHas('programme',function($query) use ($programme_id){
                            $query->where('id','=',$programme_id);
                        })->get();
                    $longeur_en_cours = 0;
                    foreach($conventions_en_cours as $cnv)
                    {
                        $longeur_en_cours += $cnv->piste->longueur;
                    }


                    $conventions_realise = Convention::where('realise','=',1)->whereHas('programme',function($query) use ($programme_id){
                        $query->where('id','=',$programme_id);
                    })->get();
                    $longeur_realise = 0;
                    foreach($conventions_realise as $cnv)
                    {
                        $longeur_realise += $cnv->piste->longueur;
                    }

                    return $longeur_programmes + $longeur_en_cours +  $longeur_realise;
                })


            ;

        }

        return $datatables->make(true);


    }


    public function interventionProjet(Request $request){

        $programmes = Programme::with('convention')->orderBy('nom_fr');
        if ($request->ajax()) {
            $datatables = DataTables::eloquent($programmes)
                ->addColumn('terrassement', function ($programmes) {
                    $programme_id = $programmes->id;
                    return $conventions = Convention::where('realise','=',1)
                        ->whereHas('programme',function($query) use ($programme_id){
                            $query->where('id','=',$programme_id);
                        })
                        ->whereHas('interventions',function($query) use ($programme_id){
                            $query->where('interventions.id','=',2);
                        })
                        ->count();
                })


                ->addColumn('revetement', function ($programmes) {
                    $programme_id = $programmes->id;
                    return $conventions = Convention::whereHas('programme',function($query) use ($programme_id){
                        $query->where('id','=',$programme_id);
                    })
                        ->whereHas('interventions',function($query) use ($programme_id){
                            $query->where('interventions.id','=',2);
                        })
                        ->count();
                })

                ->addColumn('dallage', function ($programmes) {
                    $programme_id = $programmes->id;
                    return $conventions = Convention::whereHas('programme',function($query) use ($programme_id){
                        $query->where('id','=',$programme_id);
                    })
                        ->whereHas('interventions',function($query) use ($programme_id){
                            $query->where('interventions.id','=',9);
                        })
                        ->count();
                })

                ->addColumn('pave', function ($programmes) {
                    $programme_id = $programmes->id;
                    return $conventions = Convention::whereHas('programme',function($query) use ($programme_id){
                        $query->where('id','=',$programme_id);
                    })
                        ->whereHas('interventions',function($query) use ($programme_id){
                            $query->where('interventions.id','=',4);
                        })
                        ->count();
                })

                ->addColumn('recallibrage', function ($programmes) {
                    $programme_id = $programmes->id;
                    return $conventions = Convention::whereHas('programme',function($query) use ($programme_id){
                        $query->where('id','=',$programme_id);
                    })
                        ->whereHas('interventions',function($query) use ($programme_id){
                            $query->where('interventions.id','=',5);
                        })
                        ->count();
                })

                ->addColumn('elargissement', function ($programmes) {
                    $programme_id = $programmes->id;
                    return $conventions = Convention::whereHas('programme',function($query) use ($programme_id){
                        $query->where('id','=',$programme_id);
                    })
                        ->whereHas('interventions',function($query) use ($programme_id){
                            $query->where('interventions.id','=',6);
                        })
                        ->count();
                })


                ->addColumn('renforcement', function ($programmes) {
                    $programme_id = $programmes->id;
                    return $conventions = Convention::whereHas('programme',function($query) use ($programme_id){
                        $query->where('id','=',$programme_id);
                    })
                        ->whereHas('interventions',function($query) use ($programme_id){
                            $query->where('interventions.id','=',11);
                        })
                        ->count();
                })


                ->addColumn('ouvrage', function ($programmes) {
                    $programme_id = $programmes->id;
                    return $conventions = Convention::whereHas('programme',function($query) use ($programme_id){
                        $query->where('id','=',$programme_id);
                    })
                        ->whereHas('interventions',function($query) use ($programme_id){
                            $query->where('interventions.id','=',8);
                        })
                        ->count();
                })


                ->addColumn('entretien', function ($programmes) {
                    $programme_id = $programmes->id;
                    return $conventions = Convention::whereHas('programme',function($query) use ($programme_id){
                        $query->where('id','=',$programme_id);
                    })
                        ->whereHas('interventions',function($query) use ($programme_id){
                            $query->where('interventions.id','=',10);
                        })
                        ->count();
                })

                ->addColumn('etude', function ($programmes) {
                    $programme_id = $programmes->id;
                    $nbr_etude = 0;
                    $conventions = Convention::whereHas('programme',function($query) use ($programme_id){
                        $query->where('id','=',$programme_id);
                    })
                        ->whereHas('interventions',function($query) use ($programme_id){
                            $query->where('interventions.id','=',10);
                        })
                        ->get();
                    foreach ($conventions as $cnv)
                    {
                        $nbr_etude++;
                    }
                    return $nbr_etude;
                })
                ->with('sum_balance', 5556)
            ;

        }

        return $datatables->make(true);



    }
}
