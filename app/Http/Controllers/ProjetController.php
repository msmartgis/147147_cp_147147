<?php

namespace App\Http\Controllers;

use App\AppelOffre;
use App\Avancement;
use App\Commune;
use App\Convention;
use App\Demande;
use App\Etat;
use App\Gallery;
use App\Intervention;
use App\Moa;
use App\PartenaireType;
use App\Piece;
use App\Piste;
use App\PointDesserviCategorie;
use App\Porteur;
use App\Programme;
use App\Projet;
use App\Session;
use App\Device;
use App\SuiviVersement;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\PointDesservi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

use Illuminate\Support\Facades\Storage;
use Image;

use DataTables;
use DB;

class ProjetController extends Controller
{

    public function changeState(Request $request)
    {
        $projet = Convention::find($request->id);
        $projet->realise = $request->state;
        $projet->save();
        return response()->json();
    }

    public function getProjets(Request $request)
    {
        $conventions = Convention::with('communes', 'interventions', 'partenaires', 'point_desservis', 'programme', 'moas', 'etats')->where('appel_offre_id','=',null);
        if ($request->ajax()) {
            $datatables = DataTables::eloquent($conventions)
                ->addColumn('communes', function (Convention $convention) {
                    return $convention->communes->map(function ($commune) {
                        return str_limit($commune->nom_fr, 15, '...');
                    })->implode(', ');
                })

                ->addColumn('point_desservis', function (Convention $convention) {
                    return $convention->point_desservis->map(function ($point_desservi) {
                        return str_limit($point_desservi->nom_fr, 15, '...');
                    })->implode(', ');
                })

                ->addColumn('interventions', function (Convention $convention) {
                    return $convention->interventions->map(function ($intervention) {
                        return str_limit($intervention->nom, 30, '...');
                    })->implode(', ');
                })

                // i should have access to show parntenaire type name for every partenaire

                ->addColumn('partenaires', function (Convention $convention) {
                    return $convention->partenaires->map(function ($partenaire) {
                        return str_limit($partenaire->nom_fr, 30, '...');
                    })->implode(', ');
                })


                ->addColumn('moas', function (Convention $convention) {
                    return $convention->moas ? str_limit($convention->moas->nom_fr, 40, '...') : '';
                })

                ->addColumn('longueur', function (Convention $convention) {
                    return $convention->piste ? str_limit($convention->piste->longueur, 40, '...') : '';
                })

                ->addColumn('etats', function (Convention $convention) {
                    $collection =  $convention->etats->last();

                    return ucwords($collection['nom']);
                })


                ->addColumn('programme', function (Convention $convention) {
                    return $convention->programme ? str_limit($convention->programme->nom_fr, 40, '...') : '';
                })

                /*
                ->addColumn('checkbox', function ($conventions) {
                    return '<input type="checkbox" id="conventionCb_' . $conventions->id . '" name="checkbox" class="convention-checkbox" value="' . $conventions->id . '"  data-numero ="' . $conventions->num_ordre . '" class="chk-col-green"><label for="conventionCb_' . $conventions->id . '" class="block" ></label>';
                })
                */
                ->addColumn('num_ordre', function ($conventions) {
                        return '<a href="projet/' . $conventions->id . '/edit_projet">' . $conventions->num_ordre . '</a>';
                })
                ->rawColumns(['checkbox', 'num_ordre']);
        }

        //filter with communes
        if ($communes_id = $request->get('communes')) {
            if ($communes_id == "all") { } else {
                $conventions->whereHas('communes', function ($query) use ($communes_id) {
                    $query->where('communes.id', '=', $communes_id);
                });
            }
        }




        //filter with partenaire
        if ($partenaires_id = $request->get('partenaires')) {
            if ($partenaires_id == "all") { } else {
                $conventions->whereHas('partenaires', function ($query) use ($partenaires_id) {
                    $query->where('partenaires_types.id', '=', $partenaires_id);
                });
            }
        }

        //moa filter
        if ($moas_id = $request->get('moas')) {
            if ($moas_id == "all") { } else {
                $conventions->where('moa_id', '=', $moas_id);
            }
        }

        //programme filter
        if ($programmes_id = $request->get('programmes')) {
            if ($programmes_id == "all") { } else {
                $conventions->where('programme_id', '=', $programmes_id);
            }
        }

        //filter with localites
        if ($localites = $request->get('localites')) {
            if ($localites == "all") { } else {
                $conventions->whereHas('point_desservis', function ($query) use ($localites) {
                    $query->where('point_desservis.nom_fr', '=', $localites);
                });
            }
        }

        //filter with session
        if ($session_id = $request->get('session')) {
            if ($session_id == "all") { } else {
                $conventions->where('mois', '=', $session_id);
            }
        }

        //annee
        if ($annee = $request->get('annee')) {
            if ($annee == "all") { } else {
                $conventions->where('annee', '=', $annee);
            }
        }


        //filter with intervention
        if ($interventions_id = $request->get('interventions')) {
            if ($interventions_id == "all") { } else {
                $conventions->whereHas('interventions', function ($query) use ($interventions_id) {
                    $query->where('interventions.id', '=', $interventions_id);
                });
            }
        }
        return $datatables->make(true);
    }

    public function getProjetsAppelOffre(Request $request)
    {
        $conventions = Convention::with('communes', 'interventions', 'partenaires', 'point_desservis', 'programme', 'moas', 'etats')
            ->where('appel_offre_id','!=',null)
            ->whereHas('appelOffres', function($query){
                $query->where('ordre_service','=',null);
            });
        if ($request->ajax()) {
            $datatables = DataTables::eloquent($conventions)
                ->addColumn('communes', function (Convention $convention) {
                    return $convention->communes->map(function ($commune) {
                        return str_limit($commune->nom_fr, 15, '...');
                    })->implode(', ');
                })

                ->addColumn('num_appel_offre', function (Convention $convention) {
                    return $convention->appelOffres->numero;
                })

                ->addColumn('point_desservis', function (Convention $convention) {
                    return $convention->point_desservis->map(function ($point_desservi) {
                        return str_limit($point_desservi->nom_fr, 15, '...');
                    })->implode(', ');
                })

                ->addColumn('interventions', function (Convention $convention) {
                    return $convention->interventions->map(function ($intervention) {
                        return str_limit($intervention->nom, 30, '...');
                    })->implode(', ');
                })

                // i should have access to show parntenaire type name for every partenaire

                ->addColumn('partenaires', function (Convention $convention) {
                    return $convention->partenaires->map(function ($partenaire) {
                        return str_limit($partenaire->nom_fr, 30, '...');
                    })->implode(', ');
                })


                ->addColumn('moas', function (Convention $convention) {
                    return $convention->moas ? str_limit($convention->moas->nom_fr, 40, '...') : '';
                })

                ->addColumn('longueur', function (Convention $convention) {
                    return $convention->piste ? str_limit($convention->piste->longueur, 40, '...') : '';
                })

                ->addColumn('etats', function (Convention $convention) {
                    $collection =  $convention->etats->last();

                    return ucwords($collection['nom']);
                })


                ->addColumn('programme', function (Convention $convention) {
                    return $convention->programme ? str_limit($convention->programme->nom_fr, 40, '...') : '';
                })

/*
                ->addColumn('checkbox', function ($conventions) {
                    return '<input type="checkbox" id="conventionCb_' . $conventions->id . '" name="checkbox" class="convention-checkbox" value="' . $conventions->id . '"  data-numero ="' . $conventions->num_ordre . '" class="chk-col-green"><label for="conventionCb_' . $conventions->id . '" class="block" ></label>';
                })
*/
                ->addColumn('num_ordre', function ($conventions) {
                    return '<a href="projet/' . $conventions->id . '/edit_projet">' . $conventions->num_ordre . '</a>';
                })
                ->rawColumns(['checkbox', 'num_ordre']);
        }

        //filter with communes
        if ($communes_id = $request->get('communes')) {
            if ($communes_id == "all") { } else {
                $conventions->whereHas('communes', function ($query) use ($communes_id) {
                    $query->where('communes.id', '=', $communes_id);
                });
            }
        }




        //filter with partenaire
        if ($partenaires_id = $request->get('partenaires')) {
            if ($partenaires_id == "all") { } else {
                $conventions->whereHas('partenaires', function ($query) use ($partenaires_id) {
                    $query->where('partenaires_types.id', '=', $partenaires_id);
                });
            }
        }

        //moa filter
        if ($moas_id = $request->get('moas')) {
            if ($moas_id == "all") { } else {
                $conventions->where('moa_id', '=', $moas_id);
            }
        }

        //programme filter
        if ($programmes_id = $request->get('programmes')) {
            if ($programmes_id == "all") { } else {
                $conventions->where('programme_id', '=', $programmes_id);
            }
        }

        //filter with localites
        if ($localites = $request->get('localites')) {
            if ($localites == "all") { } else {
                $conventions->whereHas('point_desservis', function ($query) use ($localites) {
                    $query->where('point_desservis.nom_fr', '=', $localites);
                });
            }
        }

        //filter with session
        if ($session_id = $request->get('session')) {
            if ($session_id == "all") { } else {
                $conventions->where('mois', '=', $session_id);
            }
        }

        //annee
        if ($annee = $request->get('annee')) {
            if ($annee == "all") { } else {
                $conventions->where('annee', '=', $annee);
            }
        }


        //filter with intervention
        if ($interventions_id = $request->get('interventions')) {
            if ($interventions_id == "all") { } else {
                $conventions->whereHas('interventions', function ($query) use ($interventions_id) {
                    $query->where('interventions.id', '=', $interventions_id);
                });
            }
        }
        return $datatables->make(true);

    }


    public function getProjetsEnCours(Request $request)
    {
        $conventions = Convention::with('communes', 'interventions', 'partenaires', 'point_desservis', 'programme', 'moas', 'etats')
            ->where('appel_offre_id','!=',null)
            ->where('realise','=',0)
           ->whereHas('appelOffres',function($query){
              $query->where('ordre_service','!=',null);
            })
        ;
        if ($request->ajax()) {
            $datatables = DataTables::eloquent($conventions)
                ->addColumn('communes', function (Convention $convention) {
                    return $convention->communes->map(function ($commune) {
                        return str_limit($commune->nom_fr, 15, '...');
                    })->implode(', ');
                })

                ->addColumn('point_desservis', function (Convention $convention) {
                    return $convention->point_desservis->map(function ($point_desservi) {
                        return str_limit($point_desservi->nom_fr, 15, '...');
                    })->implode(', ');
                })

                ->addColumn('interventions', function (Convention $convention) {
                    return $convention->interventions->map(function ($intervention) {
                        return str_limit($intervention->nom, 30, '...');
                    })->implode(', ');
                })

                // i should have access to show parntenaire type name for every partenaire

                ->addColumn('partenaires', function (Convention $convention) {
                    return $convention->partenaires->map(function ($partenaire) {
                        return str_limit($partenaire->nom_fr, 30, '...');
                    })->implode(', ');
                })


                ->addColumn('moas', function (Convention $convention) {
                    return $convention->moas ? str_limit($convention->moas->nom_fr, 40, '...') : '';
                })

                ->addColumn('longueur', function (Convention $convention) {
                    return $convention->piste ? str_limit($convention->piste->longueur, 40, '...') : '';
                })

                ->addColumn('etats', function (Convention $convention) {
                    $collection =  $convention->etats->last();

                    return ucwords($collection['nom']);
                })


                ->addColumn('programme', function (Convention $convention) {
                    return $convention->programme ? str_limit($convention->programme->nom_fr, 40, '...') : '';
                })

/*
                ->addColumn('checkbox', function ($conventions) {
                    return '<input type="checkbox" id="conventionCb_' . $conventions->id . '" name="checkbox" class="convention-checkbox" value="' . $conventions->id . '"  data-numero ="' . $conventions->num_ordre . '" class="chk-col-green"><label for="conventionCb_' . $conventions->id . '" class="block" ></label>';
                })
*/
                ->addColumn('num_ordre', function ($conventions) {
                    return '<a href="projet/' . $conventions->id . '/edit_projet">' . $conventions->num_ordre . '</a>';
                })
                ->rawColumns(['checkbox', 'num_ordre']);
        }

        //filter with communes
        if ($communes_id = $request->get('communes')) {
            if ($communes_id == "all") { } else {
                $conventions->whereHas('communes', function ($query) use ($communes_id) {
                    $query->where('communes.id', '=', $communes_id);
                });
            }
        }




        //filter with partenaire
        if ($partenaires_id = $request->get('partenaires')) {
            if ($partenaires_id == "all") { } else {
                $conventions->whereHas('partenaires', function ($query) use ($partenaires_id) {
                    $query->where('partenaires_types.id', '=', $partenaires_id);
                });
            }
        }

        //moa filter
        if ($moas_id = $request->get('moas')) {
            if ($moas_id == "all") { } else {
                $conventions->where('moa_id', '=', $moas_id);
            }
        }

        //programme filter
        if ($programmes_id = $request->get('programmes')) {
            if ($programmes_id == "all") { } else {
                $conventions->where('programme_id', '=', $programmes_id);
            }
        }

        //filter with localites
        if ($localites = $request->get('localites')) {
            if ($localites == "all") { } else {
                $conventions->whereHas('point_desservis', function ($query) use ($localites) {
                    $query->where('point_desservis.nom_fr', '=', $localites);
                });
            }
        }

        //filter with session
        if ($session_id = $request->get('session')) {
            if ($session_id == "all") { } else {
                $conventions->where('mois', '=', $session_id);
            }
        }

        //annee
        if ($annee = $request->get('annee')) {
            if ($annee == "all") { } else {
                $conventions->where('annee', '=', $annee);
            }
        }


        //filter with intervention
        if ($interventions_id = $request->get('interventions')) {
            if ($interventions_id == "all") { } else {
                $conventions->whereHas('interventions', function ($query) use ($interventions_id) {
                    $query->where('interventions.id', '=', $interventions_id);
                });
            }
        }
        return $datatables->make(true);

    }


    public function getProjetsRealise(Request $request)
    {

        $conventions = Convention::with('communes', 'interventions', 'partenaires', 'point_desservis', 'programme', 'moas', 'etats')
            ->where('appel_offre_id','!=',null)
            ->where('realise','!=',0)
        ;
        if ($request->ajax()) {
            $datatables = DataTables::eloquent($conventions)
                ->addColumn('communes', function (Convention $convention) {
                    return $convention->communes->map(function ($commune) {
                        return str_limit($commune->nom_fr, 15, '...');
                    })->implode(', ');
                })

                ->addColumn('point_desservis', function (Convention $convention) {
                    return $convention->point_desservis->map(function ($point_desservi) {
                        return str_limit($point_desservi->nom_fr, 15, '...');
                    })->implode(', ');
                })

                ->addColumn('interventions', function (Convention $convention) {
                    return $convention->interventions->map(function ($intervention) {
                        return str_limit($intervention->nom, 30, '...');
                    })->implode(', ');
                })

                // i should have access to show parntenaire type name for every partenaire

                ->addColumn('partenaires', function (Convention $convention) {
                    return $convention->partenaires->map(function ($partenaire) {
                        return str_limit($partenaire->nom_fr, 30, '...');
                    })->implode(', ');
                })


                ->addColumn('moas', function (Convention $convention) {
                    return $convention->moas ? str_limit($convention->moas->nom_fr, 40, '...') : '';
                })

                ->addColumn('longueur', function (Convention $convention) {
                    return $convention->piste ? str_limit($convention->piste->longueur, 40, '...') : '';
                })

                ->addColumn('etats', function (Convention $convention) {
                    $collection =  $convention->etats->last();

                    return ucwords($collection['nom']);
                })


                ->addColumn('programme', function (Convention $convention) {
                    return $convention->programme ? str_limit($convention->programme->nom_fr, 40, '...') : '';
                })

/*
                ->addColumn('checkbox', function ($conventions) {
                    return '<input type="checkbox" id="conventionCb_' . $conventions->id . '" name="checkbox" class="convention-checkbox" value="' . $conventions->id . '"  data-numero ="' . $conventions->num_ordre . '" class="chk-col-green"><label for="conventionCb_' . $conventions->id . '" class="block" ></label>';
                })
*/
                ->addColumn('num_ordre', function ($conventions) {
                    return '<a href="projet/' . $conventions->id . '/edit_projet">' . $conventions->num_ordre . '</a>';
                })
                ->rawColumns(['checkbox', 'num_ordre']);
        }

        //filter with communes
        if ($communes_id = $request->get('communes')) {
            if ($communes_id == "all") { } else {
                $conventions->whereHas('communes', function ($query) use ($communes_id) {
                    $query->where('communes.id', '=', $communes_id);
                });
            }
        }




        //filter with partenaire
        if ($partenaires_id = $request->get('partenaires')) {
            if ($partenaires_id == "all") { } else {
                $conventions->whereHas('partenaires', function ($query) use ($partenaires_id) {
                    $query->where('partenaires_types.id', '=', $partenaires_id);
                });
            }
        }

        //moa filter
        if ($moas_id = $request->get('moas')) {
            if ($moas_id == "all") { } else {
                $conventions->where('moa_id', '=', $moas_id);
            }
        }

        //programme filter
        if ($programmes_id = $request->get('programmes')) {
            if ($programmes_id == "all") { } else {
                $conventions->where('programme_id', '=', $programmes_id);
            }
        }

        //filter with localites
        if ($localites = $request->get('localites')) {
            if ($localites == "all") { } else {
                $conventions->whereHas('point_desservis', function ($query) use ($localites) {
                    $query->where('point_desservis.nom_fr', '=', $localites);
                });
            }
        }

        //filter with session
        if ($session_id = $request->get('session')) {
            if ($session_id == "all") { } else {
                $conventions->where('mois', '=', $session_id);
            }
        }

        //annee
        if ($annee = $request->get('annee')) {
            if ($annee == "all") { } else {
                $conventions->where('annee', '=', $annee);
            }
        }


        //filter with intervention
        if ($interventions_id = $request->get('interventions')) {
            if ($interventions_id == "all") { } else {
                $conventions->whereHas('interventions', function ($query) use ($interventions_id) {
                    $query->where('interventions.id', '=', $interventions_id);
                });
            }
        }
        return $datatables->make(true);



    }

    public function getProjetsPartenaire(Request $request)
    {
        $conventions = Convention::with('communes', 'interventions', 'partenaires', 'point_desservis', 'programme', 'moas', 'etats');
        if ($request->ajax()) {
            $datatables = DataTables::eloquent($conventions)
                ->addColumn('communes', function (Convention $convention) {
                    return $convention->communes->map(function ($commune) {
                        return str_limit($commune->nom_fr, 15, '...');
                    })->implode(', ');
                })

                ->addColumn('point_desservis', function (Convention $convention) {
                    return $convention->point_desservis->map(function ($point_desservi) {
                        return str_limit($point_desservi->nom_fr, 15, '...');
                    })->implode(', ');
                })

                // i should have access to show parntenaire type name for every partenaire

                ->addColumn('partenaires', function (Convention $convention) {
                    return $convention->partenaires->map(function ($partenaire) {
                        return str_limit($partenaire->nom_fr, 30, '...');
                    })->implode(', ');
                })


                ->addColumn('moas', function (Convention $convention) {
                    return $convention->moas ? str_limit($convention->moas->nom_fr, 40, '...') : '';
                })

                ->addColumn('longueur', function (Convention $convention) {
                    return $convention->piste ? str_limit($convention->piste->longueur, 40, '...') : '';
                })

                ->addColumn('etats', function (Convention $convention) {
                    $collection =  $convention->etats->where('active','=',1);
                    foreach($collection as $cl)
                    {
                        return ucwords($cl->nom);
                    }

                })


                ->addColumn('programme', function (Convention $convention) {
                    return $convention->programme ? str_limit($convention->programme->nom_fr, 40, '...') : '';
                })

/*
                ->addColumn('checkbox', function ($conventions) {
                    return '<input type="checkbox" id="conventionCb_' . $conventions->id . '" name="checkbox" class="convention-checkbox" value="' . $conventions->id . '"  data-numero ="' . $conventions->num_ordre . '" class="chk-col-green"><label for="conventionCb_' . $conventions->id . '" class="block" ></label>';
                })
*/
                ->addColumn('num_ordre', function ($conventions) {
                    return '<a href="projet/' . $conventions->id . '/edit_projet">' . $conventions->num_ordre . '</a>';
                })
                ->rawColumns(['checkbox', 'num_ordre']);
        }

        //filter with communes
        if ($communes_id = $request->get('communes')) {
            if ($communes_id == "all") { } else {
                $conventions->whereHas('communes', function ($query) use ($communes_id) {
                    $query->where('communes.id', '=', $communes_id);
                });
            }
        }




        //filter with partenaire
        if ($partenaires_id = $request->get('partenaires')) {
            if ($partenaires_id == "all") { } else {
                $conventions->whereHas('partenaires', function ($query) use ($partenaires_id) {
                    $query->where('partenaires_types.id', '=', $partenaires_id);
                });
            }
        }

        //moa filter
        if ($moas_id = $request->get('moas')) {
            if ($moas_id == "all") { } else {
                $conventions->where('moa_id', '=', $moas_id);
            }
        }

        //programme filter
        if ($programmes_id = $request->get('programmes')) {
            if ($programmes_id == "all") { } else {
                $conventions->where('programme_id', '=', $programmes_id);
            }
        }

        //filter with localites
        if ($localites = $request->get('localites')) {
            if ($localites == "all") { } else {
                $conventions->whereHas('point_desservis', function ($query) use ($localites) {
                    $query->where('point_desservis.nom_fr', '=', $localites);
                });
            }
        }

        //filter with session
        if ($session_id = $request->get('session')) {
            if ($session_id == "all") { } else {
                $conventions->where('mois', '=', $session_id);
            }
        }

        //annee
        if ($annee = $request->get('annee')) {
            if ($annee == "all") { } else {
                $conventions->where('annee', '=', $annee);
            }
        }


        //filter with intervention
        if ($interventions_id = $request->get('interventions')) {
            if ($interventions_id == "all") { } else {
                $conventions->whereHas('interventions', function ($query) use ($interventions_id) {
                    $query->where('interventions.id', '=', $interventions_id);
                });
            }
        }
        return $datatables->make(true);
    }


    //projet for cartographie
    public function getProjetsCarto(Request $request)
    {
        $conventions = Convention::with( 'communes', 'interventions', 'partenaires','point_desservis');
        if ($request->ajax()) {
            $datatables = DataTables::eloquent($conventions)
                ->addColumn('communes', function (Convention $convention) {
                    return $convention->communes->map(function ($commune) {
                        return str_limit($commune->nom_fr, 15, '...');
                    })->implode(', ');
                })

                ->addColumn('longueur', function (Convention $convention) {
                    return $convention->piste ? str_limit($convention->piste->longueur, 40, '...') : '';
                })

                ->addColumn('programme', function (Convention $convention) {
                    return $convention->programme ? str_limit($convention->programme->nom_fr, 40, '...') : '';
                })


                ->addColumn('etat', function (Convention $convention) {
                    $collection =  $convention->etats->where('active','=',1);
                    foreach($collection as $cl)
                    {
                        switch ($cl->nom) {

                            case 'programme':
                                return 'Programmé';
                            break;
                            case 'en_cours_execution':
                                return 'En cours d\'executions';
                                break;

                            case 'a.o_pulie':
                                return 'A.O publié';
                                break;
                            case 'plis_ouvert':
                                return 'Plis ouverts';
                                break;
                            case 'a.o_attribue':
                                return 'A.O attribué';
                                break;

                            case 'a.o_reporte':
                                return 'A.O reporté';
                                break;

                            case 'a.o_annule':
                                return 'A.O annulé';
                                break;

                            case 'en_retard':
                                return 'En retard';
                                break;

                            case 'en_etat_arret':
                            return 'En etat d\'arrêt';
                            break;

                            case 'realise':
                                return 'Realisé';
                                break;

                            default:
                               return  'Porgrammé';
                        }
                    }

                })
            ;
        }

        return $datatables->make(true);
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
        $programmes = Programme::all();

        $actu_time = Carbon::now();
        $actu_year =  $actu_time->toDateString();
        $year_number = (int) substr($actu_year,0,4);

        $conventions = Convention::with(['communes', 'partenaires', 'point_desservis', 'interventions', 'session'])->get();
        return view('projets.show.index_projet_show')->with([
            'conventions' => $conventions,
            'communes' => $communes,
            'localites' => $localites,
            'partenaires_types' => $partenaires_types,
            'moas' => $moas,
            'sessions' => $sessions,
            'interventions' => $interventions,
            'year_number' => $year_number,
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

        //create a new piste to reserve id
        $piste = new Piste();
        $piste->active = 0;
        $piste->save();
        if($piste->save())
        {
            $piste_id=  $piste->id;
        }

        //creat a new object to send it in form for editing
        $convention = new Convention();
        return view('projets.create.index_create_projet')->with(
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
                'piste_id' => $piste_id,
                'is_mobile' => Device::Device()
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
        $this->validate($request, ['num_ordre' => 'required']);
        //find the communes for this convention and put them in an array
        $communes = $request->input('communes');

        $interventions = $request->input('interventions');

        //get the localites
        $localites = $request->input('localites');
        //get the last id of conventions
        $actu_id_convention = '';

        //create convention
        $convention = new Convention();
        $convention->num_ordre = $request->input('num_ordre');
        $convention->objet_fr = $request->input('objet_fr');
        $convention->objet_ar = $request->input('objet_ar');
        $convention->montant_global = str_replace(',','',$request->input('montant_global'));
        $convention->observation = $request->input('observation');
        $convention->session_id = $request->input('session');
        $convention->programme_id = $request->input('programme');
        $convention->moa_id = $request->input('moas');
        $convention->is_project = 1;
        $convention->annee = $request->annee;

        $date_to_time = strtotime(str_replace("/",'-',$request->date_commencement));

        $date_formatted = date('Y-m-d',$date_to_time);
        $convention->date_commencement = $date_formatted;
        $convention->organisation_id = Auth::user()->organisation_id;
        $convention->save();
        if($convention->save())
        {
            $actu_id_convention = $convention->id;
        }

        //partenaire *****
        if (Input::has('partnenaire_type_ids')) {
            $partenaires_ids = (array)Input::get('partnenaire_type_ids');
            $montant_partenaire = (array)Input::get('montant');
            for ($i = 0; $i < count($partenaires_ids); $i++) {
                $convention->partenaires()->attach($partenaires_ids[$i], ['montant' => $montant_partenaire[$i]]);
            }
        }

        // Point desservis **************
        //insert in pivot table
        if ($convention->save()) {
            $commune_ids = Input::get('communes');
            $convention->communes()->sync($commune_ids);
            //intervention
            $intervention_ids = Input::get('interventions');
            $convention->interventions()->sync($intervention_ids);
            //insert localite id and demande id in pivot table
            $point_desservi_ids = Input::get('points');
            $convention->point_desservis()->sync($point_desservi_ids);
        }

        //save data in piste*****
        //save data in piste*****
        $piste = Piste::find($request->piste_id);
        $piste->longueur = $request->input('longueur');
        $piste->convention_id = $actu_id_convention;
        //get geojson
        $piste->geometry = $request->geometry;
        $piste->active = 1;
        //return $piste;
        $piste->save();


        //save data for piece******
        if (Input::has('pieces_types')) {
            $array_combination_piece = array();
            $pieces_types_array = array();
            $pieces_noms_array = array();
            $piece_file_names = array();
            $pieces_types_array = Input::get('pieces_types');
            $pieces_noms_array = Input::get('pieces_noms');
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
                    $path = $file->storeAs('public/uploaded_files/conventions/'.$actu_id_convention, $fileNameToStore);
                }

            }



            for ($i = 0; $i < $items_number; $i++) {
                $piece = new Piece;
                $piece->type = $pieces_types_array[$i];
                $piece->nom = $pieces_noms_array[$i];
                if(count($piece_file_names) > 0)
                {
                    $piece->path = $piece_file_names[$i];
                }else{
                    $piece->path = '';
                }

                $piece->convention_id = $actu_id_convention;
                $piece->save();
                //array_push($array_combination_piece, $piece);
            }

        }


        //save data in porteur de demande and add it as partenaire_type *****
        $partenaire_type = new PartenaireType;
        $moa_from_porteur = new Moa;

        //redirecting with success message
        return redirect('/projet')->with('success', 'Convention créee avec succès');
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

    public function edit_projet(Convention $convention)
    {
        $interventions = Intervention::orderBy('nom')->pluck('nom', 'id');
        $communes = Commune::orderBy('nom_fr')->pluck('nom_fr', 'id');
        $pieces = Piece::orderBy('type')->pluck('type');
        $moas = Moa::orderBy('nom_fr')->pluck('nom_fr', 'id');
        $programmes = Programme::orderBy('nom_fr')->pluck('nom_fr', 'id');
        $partenaires_types = PartenaireType::all();
        $point_desservis = PointDesservi::orderBy('nom_fr')->pluck('nom_fr', 'id');
        $convention = Convention::with(['communes', 'partenaires', 'piste', 'point_desservis',  'interventions', 'piece', 'programme', 'moas','appelOffres'])->find($convention->id);
        //return $convention;

        $etats = Etat::orderBy('date')->where('convention_id','=',$convention->id)->get();

        return view('projets.edit.edit_projet')->with([
            'convention' => $convention,
            'interventions' => $interventions,
            'point_desservis' => $point_desservis,
            'partenaires_types' => $partenaires_types,
            'moas' => $moas,
            'communes' => $communes,
            'programmes' => $programmes,
            'etats' => $etats,
            'is_mobile' => Device::Device()
        ]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Projet  $projet
     * @return \Illuminate\Http\Response
     */


    public function update_projet(Request $request, Convention $convention)
    {
        //$request->validate($request, ['num_ordre' => 'required']);
        $convention_to_update = Convention::find($convention->id);
        $convention_to_update->moa_id = $request->moa;
        $convention_to_update->programme_id = $request->programme;
        $convention_to_update->objet_fr = $request->objet_fr;
        $convention_to_update->objet_ar = $request->objet_ar;
        $convention_to_update->observation = $request->observation;
        $convention_to_update->annee = $request->annee;

        $date_formatted = str_replace("/",'-',$request->date_commencement);
        $convention_to_update->date_commencement = Carbon::parse($date_formatted)->format('Y-m-d');

        //return  $request->porteurporteur_projet;
        $convention_to_update->save();
        //update interventions
        $intervention_ids = Input::get('interventions');
        $convention->interventions()->sync($intervention_ids);
        //update communes
        $communes_ids = Input::get('communes');
        $convention->communes()->sync($communes_ids);


        //update pistes
        Piste::where('id', $request->id_pist)
            ->update(['longueur' => $request->longueur,'geometry'=>$request->geometry]);

        //update $point_desservis
        $point_desservis = Input::get('point_desservis');
        $convention->point_desservis()->sync($point_desservis);


        //gallery
        $actu_id_convention = $convention->id;

        if (Input::has('imagesToUpload')) {
            $files = $request->file('imagesToUpload');
            //return $files;
            //files uploaded get path
            if ($request->hasFile('imagesToUpload')) {
                foreach ($files as $file) {
                    // Get filename with the extension
                    $filenameWithExt = $file->getClientOriginalName();
                    // Get just filename
                    $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                    // Get just ext
                    $extension = $file->getClientOriginalExtension();
                    // Filename to store
                    $fileNameToStore = $filename . '_' . time() . '.' . $extension;

                    // Upload Image
                    $path = $file->storeAs('public/uploaded_files/galleries/projets_partenaire/' . $actu_id_convention, $fileNameToStore);
                    $path_t = $file->storeAs('public/uploaded_files/galleries/projets_partenaire/thumbnail/' . $actu_id_convention, $fileNameToStore);


                    //Resize image here
                    $thumbnailpath = storage_path("app/public/uploaded_files/galleries/projets_partenaire/thumbnail/".$actu_id_convention.'/'.$fileNameToStore);
                    $img = Image::make($thumbnailpath)->resize(300, 200, function($constraint) {
                        $constraint->aspectRatio();
                    });
                    $img->save($thumbnailpath);

                    $gallery = new Gallery();
                    $gallery->convention_id = $actu_id_convention;
                    $gallery->filename = $fileNameToStore;
                    $gallery->save();
                }
            }
        }
        return redirect("/projet" . "/" . $convention->id . "/edit_projet")->with('success', 'Projet modifier avec succès');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Projet  $projet
     * @return \Illuminate\Http\Response
     */
    public function destroy(Convention $projet)
    {
        Storage::disk('uploads')->deleteDirectory('conventions/'.$projet->id);
        $projet->communes()->detach();
        $projet->interventions()->detach();
        $projet->point_desservis()->detach();
        $projet->piece()->delete();
        $projet->moas()->delete();
        $projet->partenaires()->detach();
        Convention::destroy($projet->id);
        return response()->json();
    }
}
