<?php

namespace App\Http\Controllers;

use App\AppelOffre;
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
use App\Device;
use Illuminate\Http\Request;
use App\PointDesservi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

use DataTables;
use DB;
use Illuminate\Support\Facades\Storage;

class ConventionController extends Controller
{
    //formatting date
    public function date_fromatting($date)
    {
        //formating date time
        $date_to_time = strtotime(str_replace("/",'-',$date));
        return $date_formatted = date('Y-m-d',$date_to_time);
    }
    /**
     * Diplay datatable data
     *
     */
    public function getConventions(Request $request)
    {
        $conventions = Convention::with( 'communes', 'interventions', 'partenaires','point_desservis','programme','moas')->where('is_project','=','0');
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

                ->addColumn('montantCP', function (Convention $convention) {
                    return $convention->partenaires->map(function ($partenaire) {
                        if ($partenaire->id == 1) {
                            return number_format($partenaire->pivot->montant);
                        }
                    })->implode(' ');
                })


                ->addColumn('moas', function (Convention $convention) {
                    return $convention->moas ? str_limit($convention->moas->nom_fr, 40, '...') : '';
                })

                ->addColumn('programme', function (Convention $convention) {
                    return $convention->programme ? str_limit($convention->programme->nom_fr, 40, '...') : '';
                })


                ->addColumn('checkbox', function ($conventions) {
                    return '<input type="checkbox" id="conventionCb_' . $conventions->id . '" name="checkbox" class="convention-checkbox" value="' . $conventions->id . '"  data-numero ="' . $conventions->num_ordre . '" class="chk-col-green"><label for="conventionCb_' . $conventions->id . '" class="block" ></label>';
                })

                ->addColumn('montant_global', function ($conventions) {
                    return number_format($conventions->montant_global);
                })


                ->addColumn('num_ordre', function ($conventions) {
                    return '<a href="convention/'.$conventions->id.'/edit">'.$conventions->num_ordre.'</a>';
                })


                ->rawColumns(['checkbox','num_ordre']);


        }

        //filter with communes
        if ($communes_id = $request->get('communes')) {
            if ($communes_id == "all") {
            } else {
                $conventions->whereHas('communes', function ($query) use ($communes_id) {
                    $query->where('communes.id', '=', $communes_id);
                });
            }
        }




        //filter with partenaire
        if ($partenaires_id = $request->get('partenaires')) {
            if ($partenaires_id == "all") {
            } else {
                $conventions->whereHas('partenaires', function ($query) use ($partenaires_id) {
                    $query->where('partenaires_types.id', '=', $partenaires_id);
                });
            }
        }

        //moa filter
        if ($moas_id = $request->get('moas')) {
            if ($moas_id == "all") {
            } else {
                $conventions->where('moa_id', '=', $moas_id);
            }
        }

        //programme filter
        if ($programmes_id = $request->get('programmes')) {
            if ($programmes_id == "all") {
            } else {
                $conventions->where('programme_id', '=', $programmes_id);
            }
        }

        //filter with localites
        if ($localites = $request->get('localites')) {
            if ($localites == "all") {
            } else {
                $conventions->whereHas('point_desservis', function ($query) use ($localites) {
                    $query->where('point_desservis.nom_fr', '=', $localites);
                });
            }
        }

        //filter with session
        if ($session_id = $request->get('session')) {
            if ($session_id == "all") {
            } else {
                $conventions->where('mois', '=', $session_id);
            }
        }


        //filter with intervention
        if ($interventions_id = $request->get('interventions')) {
            if ($interventions_id == "all") {
            } else {
                $conventions->whereHas('interventions', function ($query) use ($interventions_id) {
                    $query->where('interventions.id', '=', $interventions_id);
                });
            }
        }
        return $datatables->make(true);

    }

    // VERSEMENTS
    public function getVersements(Request $request)
    {
        $conventions = Convention::with('communes', 'interventions', 'partenaires', 'point_desservis', 'programme', 'moas', 'versements');
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
                ->addColumn('montantCP', function (Convention $convention) {
                    return $convention->partenaires->map(function ($partenaire) {
                        if ($partenaire->id == 1) {
                            return number_format($partenaire->pivot->montant);
                        }
                    })->implode(' ');
                })
                ->addColumn('moas', function (Convention $convention) {
                    return $convention->moas ? str_limit($convention->moas->nom_fr, 40, '...') : '';
                })
                ->addColumn('programme', function (Convention $convention) {
                    return $convention->programme ? str_limit($convention->programme->nom_fr, 40, '...') : '';
                })
                ->addColumn('checkbox', function ($conventions) {
                    return '<input type="checkbox" id="conventionCb_' . $conventions->id . '" name="checkbox" class="convention-checkbox" value="' . $conventions->id . '"  data-numero ="' . $conventions->num_ordre . '" class="chk-col-green"><label for="conventionCb_' . $conventions->id . '" class="block" ></label>';
                })
                ->addColumn('num_ordre', function ($conventions) {
                    return '<a href="convention/' . $conventions->id . '/editVersement">' . $conventions->num_ordre . '</a>';
                })
                ->addColumn('montant_global', function ($conventions) {
                    return number_format($conventions->montant_global);
                })
                ->addColumn('montant_verse', function ($conventions) {
                    $montant_verse = SuiviVersement::where([['convention_id', '=', $conventions->id]])
                        ->sum('montant');

                    return number_format($montant_verse);

                })
                ->addColumn('etat_versement', function ($conventions) {
                    if($conventions->montant_global != 0 )
                    {
                        $montant_verse = SuiviVersement::where([['convention_id', '=', $conventions->id]])
                                ->sum('montant') / $conventions->montant_global * 100;
                    }else{
                        $montant_verse = 0;
                    }


                    return  number_format($montant_verse);

                })
                ->rawColumns(['checkbox', 'num_ordre']);


        }


        //filter etat

        if ($versement_from = $request->get('etat_versement_from')) {
            if ($versement_from == "all") {
            } else {


                //$montant_global = $conventions->montant_global;
                /*
                $conventions->whereHas('versements', function ($query) use ($versement_from) {
                   // $query->sum('montant')/5000*100 > $versement_from;

                    $query->select(DB::raw("SUM(montant) as paidsum"))->where('paidsum', '>=',$versement_from);
                });*/
            }


            //filter with communes
            if ($communes_id = $request->get('communes')) {
                if ($communes_id == "all") {
                } else {
                    $conventions->whereHas('communes', function ($query) use ($communes_id) {
                        $query->where('communes.id', '=', $communes_id);
                    });
                }
            }

            //filter with partenaire
            if ($partenaires_id = $request->get('partenaires')) {
                if ($partenaires_id == "all") {
                } else {
                    $conventions->whereHas('partenaires', function ($query) use ($partenaires_id) {
                        $query->where('partenaires_types.id', '=', $partenaires_id);
                    });
                }
            }

            //moa filter
            if ($moas_id = $request->get('moas')) {
                if ($moas_id == "all") {
                } else {
                    $conventions->where('moa_id', '=', $moas_id);
                }
            }

            //programme filter
            if ($programmes_id = $request->get('programmes')) {
                if ($programmes_id == "all") {
                } else {
                    $conventions->where('programme_id', '=', $programmes_id);
                }
            }

            //filter with localites
            if ($localites = $request->get('localites')) {
                if ($localites == "all") {
                } else {
                    $conventions->whereHas('point_desservis', function ($query) use ($localites) {
                        $query->where('point_desservis.nom_fr', '=', $localites);
                    });
                }
            }

            //filter with session
            if ($session_id = $request->get('session')) {
                if ($session_id == "all") {
                } else {
                    $conventions->where('mois', '=', $session_id);
                }
            }


            //filter with intervention
            if ($interventions_id = $request->get('interventions')) {
                if ($interventions_id == "all") {
                } else {
                    $conventions->whereHas('interventions', function ($query) use ($interventions_id) {
                        $query->where('interventions.id', '=', $interventions_id);
                    });
                }
            }
            return $datatables->make(true);

        }
    }

    // APPEL OFFRE SHOW CONVENTIONS
    public function getConventionsAppelOffre(Request $request)
    {
        $conventions = Convention::with('communes', 'interventions', 'partenaires', 'point_desservis', 'programme', 'moas', 'versements')
            ->where('is_project','=',0)
            ->whereNull('appel_offre_id')->orderBy('created_at');
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
                ->addColumn('montantCP', function (Convention $convention) {
                    return $convention->partenaires->map(function ($partenaire) {
                        if ($partenaire->id == 1) {
                            return number_format($partenaire->pivot->montant);
                        }
                    })->implode(' ');
                })
                ->addColumn('moas', function (Convention $convention) {
                    return $convention->moas ? str_limit($convention->moas->nom_fr, 40, '...') : '';
                })
                ->addColumn('programme', function (Convention $convention) {
                    return $convention->programme ? str_limit($convention->programme->nom_fr, 40, '...') : '';
                })
                ->addColumn('checkbox', function ($conventions) {
                    return '<input type="checkbox" id="conventionCb_' . $conventions->id . '" name="checkbox_convention_appel_offre"  class="convention-checkbox" value="' . $conventions->id . '" data-montant="' . $conventions->montant_global . '"  data-id="' . $conventions->id . '" data-numero ="' . $conventions->num_ordre . '" class="chk-col-green"><label for="conventionCb_' . $conventions->id . '" class="block" ></label>';
                })
                ->addColumn('num_ordre', function ($conventions) {
                    return '<a href="convention/' . $conventions->id . '/editVersement">' . $conventions->num_ordre . '</a>';
                })
                ->addColumn('montant_global', function ($conventions) {
                    return number_format($conventions->montant_global);
                })
                ->addColumn('montant_verse', function ($conventions) {
                    $montant_verse = SuiviVersement::where([['convention_id', '=', $conventions->id]])
                        ->sum('montant');

                    return number_format($montant_verse);

                })
                ->addColumn('etat_versement', function ($conventions) {
                    $montant_verse = SuiviVersement::where([['convention_id', '=', $conventions->id]])
                            ->sum('montant') / $conventions->montant_global * 100;

                    return number_format($montant_verse);

                })
                ->rawColumns(['checkbox', 'num_ordre']);
        }


        //filter etat
        if ($versement_from = $request->get('etat_versement_from')) {
            if ($versement_from == "all") {
            } else {

                //$montant_global = $conventions->montant_global;
                /*
                $conventions->whereHas('versements', function ($query) use ($versement_from) {
                   // $query->sum('montant')/5000*100 > $versement_from;

                    $query->select(DB::raw("SUM(montant) as paidsum"))->where('paidsum', '>=',$versement_from);
                });*/
            }
        }


        //filter with communes
        if ($communes_id = $request->get('communes')) {
            if ($communes_id == "all") {
            } else {
                $conventions->whereHas('communes', function ($query) use ($communes_id) {
                    $query->where('communes.id', '=', $communes_id);
                });
            }
        }

        //filter with partenaire
        if ($partenaires_id = $request->get('partenaires')) {
            if ($partenaires_id == "all") {
            } else {
                $conventions->whereHas('partenaires', function ($query) use ($partenaires_id) {
                    $query->where('partenaires_types.id', '=', $partenaires_id);
                });
            }
        }

        //moa filter
        if ($moas_id = $request->get('moas')) {
            if ($moas_id == "all") {
            } else {
                $conventions->where('moa_id', '=', $moas_id);
            }
        }

        //programme filter
        if ($programmes_id = $request->get('programmes')) {
            if ($programmes_id == "all") {
            } else {
                $conventions->where('programme_id', '=', $programmes_id);
            }
        }

        //filter with localites
        if ($localites = $request->get('localites')) {
            if ($localites == "all") {
            } else {
                $conventions->whereHas('point_desservis', function ($query) use ($localites) {
                    $query->where('point_desservis.nom_fr', '=', $localites);
                });
            }
        }

        //filter with session
        if ($session_id = $request->get('session')) {
            if ($session_id == "all") {
            } else {
                $conventions->where('mois', '=', $session_id);
            }
        }


        //filter with intervention
        if ($interventions_id = $request->get('interventions')) {
            if ($interventions_id == "all") {
            } else {
                $conventions->whereHas('interventions', function ($query) use ($interventions_id) {
                    $query->where('interventions.id', '=', $interventions_id);
                });
            }
        }
        return $datatables->make(true);
    }

    // APPEL OFFRES SHOW
    public function getAppelOffre(Request $request)
    {
        $appelOffres = AppelOffre::with('conventions','moas','adjiducataires')->where('etat','!=','annule')->orderBy('created_at');
        if ($request->ajax()) {
            $datatables = DataTables::eloquent($appelOffres)

                ->addColumn('numero', function ($appelOffres) {
                    return '<a href="appelOffre/' . $appelOffres->id . '/edit">' . $appelOffres->numero . '</a>';
                })
                ->addColumn('montant_global', function ($appelOffres) {
                    return number_format($appelOffres->montant_globale);
                })

                ->addColumn('moas', function (AppelOffre $appelOffre) {
                    return $appelOffre->moas ? str_limit($appelOffre->moas->nom_fr, 40, '...') : '';
                })

                ->addColumn('nombre_projet', function ($appelOffres) {
                    $nombre_projet = Convention::where([['appel_offre_id', '=', $appelOffres->id]])
                        ->count('appel_offre_id');
                    return $nombre_projet;
                })

                ->addColumn('adjiducataire', function (AppelOffre $appelOffre) {
                    return $appelOffre->adjiducataires ? str_limit($appelOffre->adjiducataires->nom_fr, 40, '...') : '';
                })
                ->addColumn('etat', function ($appelOffres) {
                    if($appelOffres->etat == "publie")
                    {
                        return "Publié";
                    }

                    if($appelOffres->etat == "en_preparation")
                    {
                        return "En Préparation";
                    }
                })
                //to render to html markup
                ->rawColumns([ 'numero']);
        }

        //moa filter
        if ($moas_id = $request->get('moas')) {
            if ($moas_id == "all") {
            } else {
                $appelOffres->where('moa_id', '=', $moas_id);
            }
        }


        //intervention filter
        if ($interventions_id = $request->get('interventions')) {
            if ($interventions_id == "all") {
            } else {
                $appelOffres->whereHas('conventions.interventions', function ($query) use ($interventions_id) {
                    $query->where('interventions.id', '=', $interventions_id);
                });
            }
        }

        //etat filter
        if ($etat = $request->get('etat')) {
            if ($etat == "all") {
            } else {
                $appelOffres->where('etat', '=', $etat);
            }
        }


        //filter with daterange date publication
        /*  if ($daterange_publication = $request->get('daterange_publication')) {
              $daterangepublication_splite = explode('-', $daterange_publication);
              $date_publication_start = $this->date_fromatting($daterangepublication_splite[0]) ;
              $date_publication_end = $this->date_fromatting($daterangepublication_splite[1]);
              $appelOffres->where([
                  ['date_publication', '>=', trim($date_publication_start)],
                  ['date_publication', '<=', trim($date_publication_end)],
              ]);
          }

          //filter with daterange date ouverture des plis
          if ($daterange_ouverture_plis = $request->get('daterange_ouverture_plis')) {
              $daterange_ouverture_pli_splite = explode('-', $daterange_ouverture_plis);
              $date_ouverture_plis_start =  $this->date_fromatting($daterange_ouverture_pli_splite[0]);
              $date_ouverture_plis_end =  $this->date_fromatting($daterange_ouverture_pli_splite[1]);
              $appelOffres->where([
                  ['date_ouverture_plis', '>=', trim($date_ouverture_plis_start)],
                  ['date_ouverture_plis', '<=', trim($date_ouverture_plis_end)],
              ]);
          }*/



        return $datatables->make(true);
    }

    public function getAppelOffreId($id)
    {
        return $appel_offre_id = AppelOffre::where('id','=',$id);

    }

    public function fiche(Request $request, Convention $convention)
    {

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $is_mobile = 0;
        $useragent=$_SERVER['HTTP_USER_AGENT'];
        if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4)))
        {
            $is_mobile = 1;
        }


        $communes = Commune::orderBy('nom_fr')->get();
        //point desservis :: localite only
        $localites = PointDesserviCategorie::find(1)->point_desservis;
        $partenaires_types = PartenaireType::all();
        $moas = Moa::all();
        $sessions = Session::all();
        $interventions = Intervention::all();
        $programmes = Programme::all();

        $conventions = Convention::with(['communes', 'partenaires', 'point_desservis', 'interventions', 'session'])->get();
        return view('conventions.show.index')->with([
            'conventions' => $conventions,
            'communes' => $communes,
            'localites' => $localites,
            'partenaires_types' => $partenaires_types,
            'moas' => $moas,
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
        return view('conventions.create.index_create_convention')->with(
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
        $this->validate($request, ['num_ordre' => 'required','longueur' => 'required']);
        //find the communes for this convention and put them in an array

        //get the last id of conventions
        //$actu_id_convention = Convention::max('id')+ 1;
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
        $convention->organisation_id = Auth::user()->organisation_id;
        $convention->is_project = 0;
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
                $convention->partenaires()->attach($partenaires_ids[$i], ['montant' => str_replace(',','',$montant_partenaire[$i])]);
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
        $piste = Piste::find($request->piste_id);
        $piste->longueur = $request->input('longueur');
        $piste->convention_id = $actu_id_convention;
        //get geojson
        $piste->geometry = $request->geometry;
        $piste->active = 1;
        //return $piste;
        $piste->save();


        //save data for piece******
        //verify if there is any piece
        /*if (Input::has('pieces_types')) {
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
                $piece->path = $piece_file_names[$i];
                $piece->convention_id = $actu_id_convention;
                $piece->save();
                //array_push($array_combination_piece, $piece);
            }

        }*/


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
        return redirect('/convention')->with('success', 'Convention créee avec succès');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Convention  $convention
     * @return \Illuminate\Http\Response
     */
    public function show(Convention $convention)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Convention  $convention
     * @return \Illuminate\Http\Response
     */
    public function edit(Convention $convention)
    {
        $interventions = Intervention::orderBy('nom')->pluck('nom', 'id');
        $communes = Commune::orderBy('nom_fr')->pluck('nom_fr', 'id');
        $pieces = Piece::orderBy('type')->pluck('type');
        $moas = Moa::orderBy('nom_fr')->pluck('nom_fr', 'id');
        $programmes = Programme::orderBy('nom_fr')->pluck('nom_fr', 'id');
        $partenaires_types = PartenaireType::all();
        $point_desservis = PointDesservi::orderBy('nom_fr')->pluck('nom_fr', 'id');
        $convention = Convention::with(['communes', 'partenaires', 'piste', 'point_desservis',  'interventions', 'piece','programme','moas'])->find($convention->id);

        return view('conventions.edit.edit')->with([
            'convention' => $convention,
            'interventions' => $interventions,
            'point_desservis' => $point_desservis,
            'partenaires_types' => $partenaires_types,
            'moas' => $moas,
            'communes' => $communes,
            'programmes' => $programmes,
            'is_mobile' => Device::Device()
        ]);
    }


    public function editVersement(Convention $convention)
    {
        $interventions = Intervention::orderBy('nom')->pluck('nom', 'id');
        $communes = Commune::orderBy('nom_fr')->pluck('nom_fr', 'id');
        $pieces = Piece::orderBy('type')->pluck('type');
        $moas = Moa::orderBy('nom_fr')->pluck('nom_fr', 'id');
        $programmes = Programme::orderBy('nom_fr')->pluck('nom_fr', 'id');
        $partenaires_types = PartenaireType::all();
        $versements = SuiviVersement::with('partenaire')->where([['convention_id','=',$convention->id]])->orderBy('date_versement','asc')->get();
        $localites = PointDesservi::orderBy('nom_fr')->where('categorie_point_id', '=', 1)->pluck('nom_fr', 'id');
        $convention = Convention::with(['communes', 'partenaires', 'piste', 'point_desservis',  'interventions', 'piece','programme','moas','versements'])->find($convention->id);

        return view('conventions.suiviVersement.edit.edit')->with([
            'convention' => $convention,
            'interventions' => $interventions,
            'localites' => $localites,
            'partenaires_types' => $partenaires_types,
            'moas' => $moas,
            'communes' => $communes,
            'programmes' => $programmes,
            'versements' => $versements,
            'is_mobile' => Device::Device()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Convention  $convention
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Convention $convention)
    {
        //$request->validate($request, ['num_ordre' => 'required']);
        $convention_to_update = Convention::find($convention->id);
        $convention_to_update->moa_id = $request->moa;
        $convention_to_update->programme_id = $request->programme;
        $convention_to_update->objet_fr = $request->objet_fr;
        $convention_to_update->num_ordre = $request->num_ordre;
        $convention_to_update->objet_ar = $request->objet_ar;
        $convention_to_update->observation = $request->observation;

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


        $point_desservis = Input::get('point_desservis');
        $convention->point_desservis()->sync($point_desservis);

        return redirect("/convention" . "/" . $convention->id . "/edit")->with('success', 'Convention modifier avec succès');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Convention  $convention
     * @return \Illuminate\Http\Response
     */
    public function destroy(Convention $convention)
    {
        Storage::disk('uploads')->deleteDirectory('conventions/'.$convention->id);
        $convention->communes()->detach();
        $convention->interventions()->detach();
        $convention->point_desservis()->detach();
        $convention->partenaires()->detach();
        $convention->piste()->delete();
        $convention->piece()->delete();
        $convention->versements()->delete();
        $convention->etats()->delete();
        $convention->galleries()->delete();

        Convention::destroy($convention->id);
        return response()->json();
    }
}
