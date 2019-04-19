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
use Illuminate\Http\Request;
use App\PointDesservi;
use Illuminate\Support\Facades\Input;

use DataTables;
use DB;

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
        $conventions = Convention::with( 'communes', 'interventions', 'partenaires','point_desservis','programme','moas');
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
            ->whereNull('appel_offre_id');
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
        $appelOffres = AppelOffre::with('conventions','moas','adjiducataires')->where('etat','!=','annule');
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
                        ->distinct('appel_offre_id')->count('appel_offre_id');
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
        $actu_id_convention = Convention::max('id')+ 1;

        //create convention
        $convention = new Convention();
        $convention->num_ordre = $request->input('num_ordre');
        $convention->objet_fr = $request->input('objet_fr');
        $convention->objet_ar = $request->input('objet_ar');
        $convention->montant_global = $request->input('montant_global');
        $convention->observation = $request->input('observation');
        $convention->session_id = $request->input('session');
        $convention->programme_id = $request->input('programme');
        $convention->moa_id = $request->input('moas');
        $convention->save();

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
        $piste = new Piste;
        $piste->longueur = $request->input('longueur');
        $piste->convention_id = $actu_id_convention;
        $piste->save();


        //save data for piece******
        //verify if there is any piece
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
                    $path = $file->storeAs('local/uploaded_files/conventions/'.$actu_id_convention, $fileNameToStore);
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



            /* foreach ($array_combination_piece as $p) {
                 $piec = new Piece;
                 $piec->type = $p->type;
                 $piec->nom = $p->nom;
                 $piec->path = $p->path;


             }*/
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
        $localites = PointDesservi::orderBy('nom_fr')->where('categorie_point_id', '=', 1)->pluck('nom_fr', 'id');
        $convention = Convention::with(['communes', 'partenaires', 'piste', 'point_desservis',  'interventions', 'piece','programme','moas'])->find($convention->id);

        return view('conventions.edit.edit')->with([
            'convention' => $convention,
            'interventions' => $interventions,
            'localites' => $localites,
            'partenaires_types' => $partenaires_types,
            'moas' => $moas,
            'communes' => $communes,
            'programmes' => $programmes
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
            'versements' => $versements
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
            ->update(['longueur' => $request->longueur]);


        //update localites
        $localites_ids = Input::get('localites');
        $convention->point_desservis()->sync($localites_ids);
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
        Convention::destroy($convention->id);
        return response()->json();
    }
}
