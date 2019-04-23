<?php
namespace App\Http\Controllers;
use App\SourceFinancement;
use Response;
use App\Demande;
use App\Commune;
use App\Piste;
use App\Porteur;
use App\PointDesservi;
use App\Piece;
use App\PartenaireType;
use App\Intervention;
use App\Session;
use App\Convention;
use App\PointDesserviCategorie;
use App\Moa;
use App\Projet;
use Carbon\Carbon;
use Illuminate\Http\Request;
//use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use DataTables;
use DB;


class DemandesController extends BaseController
{
    /*
     * TODO sperate realiser and programme demandes
     * */

    /**
     * for showing some data about demande (for accord defintif or affectation aux convention)
     * @param Request $request
     *
     * return $demande as json data
     */

    public function getDemandeData(Request $req)
    {
        $partenaire_id = PartenaireType::where('nom_fr','CP')->first()->id;
        $montant_global = Demande::find($req->id,['montant_global']);
        $demande_id = Demande::find($req->id,['id']);
        $demande = Demande::find($req->id);

        $pivot_all =  $demande->partenaires()
            ->get();

       $pivot =  $demande->partenaires()->where('partenaire_id','=',1)
           ->get();

       return response()->json(['id'=>$demande_id,'montantGlobal'=>$montant_global,'partenaire_id'=>$partenaire_id,'pivot'=>$pivot,'pivot_all' => $pivot_all]);
    }



    public function aTraiter(Request $request)
    {
        $ids = array();
        $ids = $request->demande_ids;
        $values = Demande::whereIn('id', $ids)->update(['decision' => 'a_traiter', 'etat' => 'sans']);
        return response()->json();
    }

    //restaurer demande to en cours again
    public function restaurerDemande(Request $request)
    {
        $ids = array();
        $ids = $request->demande_ids;
        $values = Demande::whereIn('id', $ids)->update(['decision' => 'en_cours', 'etat' => 'sans']);
        return response()->json();
    }

    //restaurer demande to en cours again from affectation
    public function restaurerDemandeFromAffectation(Request $request)
    {
        $ids = array();
        $ids = $request->demande_ids;
        $values = Demande::whereIn('id', $ids)->update(['is_affecter' => '0', 'decision' => 'en_cours', 'etat' => 'sans']);
        return response()->json();
    }

    /**
     * get the data from modal form
     *
     * verify if it's n 'accord ' or 'affectation'
     *
     * if it's an 'affectation' create new convention and  new project
     *
     * @return the success message and redirect
     */

    public function accordOrAffectation(Request $request)
    {
        $demande = Demande::find($request->id);

        if($request->affecter == '0')
        {
            //update demande
            Demande::where('id', $request->id)
                 ->update(['montant_global' => $request->montant_global]);


            //update decision
            Demande::where('id', $request->id)
                ->update(['decision' => 'accord_definitif']);


            //update montant cp
            $demande->partenaires()->updateExistingPivot($request->cp_id,array('montant' =>$request->montant_cp));

            //insert source de finacnement *****
            if (Input::has('source_financement_ids') !== null) {
                $source_financement_ids = (array)Input::get('source_financement_ids');
                //return $source_financement_ids;
                $montant_source = (array)Input::get('montant_source');
                for ($i = 0; $i < count($source_financement_ids); $i++) {
                    $demande->sourceFinancement()->attach($source_financement_ids[$i], ['montant' => $montant_source[$i]]);
                }
            }

            //update partenaires
            //$demande->partenaires()->updateExistingPivot($request->cp_id,array('montant' =>$request->montant_cp));

            if (Input::has('partnenaire_type_ids') !== null) {
                $partnenaire_type_ids = (array)Input::get('partnenaire_type_ids');
                //return $source_financement_ids;
                $montant = (array)Input::get('montant');
                $pivotData = array();
                for ($i = 0; $i < count($partnenaire_type_ids); $i++) {
                    array_push($pivotData,['montant' => $montant[$i]]);
                }

                $syncData = array_combine($partnenaire_type_ids,$pivotData);
                $demande->partenaires()->sync($syncData);
            }

            return redirect('/demande')->with('success', 'Accord definititf  avec succès');
        }

        //affectation aux convntion
        if($request->affecter == '1')
        {
            $convention_id = Convention::max('id') + 1;
            //$numero_ordre_cnv = Convention::max('num_ordre') + 1;
            $convention = new Convention;


            $demande = Demande::find($request->id);
            //update demande is_affecter
            DB::table('demandes')
                ->where('id', $demande->id)
                ->update(['is_affecter' => 1, 'decision' => 'affecter', 'etat' => 'sans']);


            if (Input::has('partnenaire_type_ids') !== null) {
                $partnenaire_type_ids = (array)Input::get('partnenaire_type_ids');
                //return $source_financement_ids;
                $montant = (array)Input::get('montant');
                $pivotData = array();
                for ($i = 0; $i < count($partnenaire_type_ids); $i++) {
                    array_push($pivotData,['montant' => $montant[$i]]);
                }
                $syncData = array_combine($partnenaire_type_ids,$pivotData);
                $demande->partenaires()->sync($syncData);
            }


            //update montant cp
            $demande->partenaires()->updateExistingPivot($request->cp_id,array('montant' =>$request->montant_cp));

            //insert source de finacnement *****
            if (Input::has('source_financement_ids') !== null) {
                $source_financement_ids = (array)Input::get('source_financement_ids');
                //return $source_financement_ids;
                $montant_source = (array)Input::get('montant_source');
                for ($i = 0; $i < count($source_financement_ids); $i++) {
                    $demande->sourceFinancement()->attach($source_financement_ids[$i], ['montant' => $montant_source[$i]]);
                }
            }


            //save to conventions
            $convention->demande_id = $demande->id;
            $convention->montant_global = $request->montant_global;
            $convention->save();

            if ($convention->save()) {
                $convention->moa_id = $request->moas;
            }

            return redirect('/demande')->with('success', 'Demande affectée aux conventions avec succès');
        }


    }

    //get demandes en cours for index tab en_cours datatables
    public function getDemandes(Request $request)
    {
        $demandes = Demande::with('porteur', 'communes', 'interventions', 'partenaires','point_desservis')->where([['decision', '=', 'en_cours'],['etat','=','sans'],['is_affecter','=',0]]);
        if ($request->ajax()) {
            $datatables = DataTables::eloquent($demandes)
                ->addColumn('communes', function (Demande $demande) {
                    return $demande->communes->map(function ($commune) {
                        return str_limit($commune->nom_fr, 15, '...');
                    })->implode(', ');
                })
                ->addColumn('porteur', function ($demande) {
                    return $demande->porteur ? str_limit($demande->porteur->nom_porteur_fr, 30, '...') : '';
                })

                ->addColumn('interventions', function (Demande $demande) {
                    return $demande->interventions->map(function ($intervention) {
                        return str_limit($intervention->nom, 30, '...');
                    })->implode(', ');
                })
                // i should have access to show parntenaire type name for every partenaire

                ->addColumn('partenaires', function (Demande $demande) {
                    return $demande->partenaires->map(function ($partenaire) {
                        return str_limit($partenaire->nom_fr, 30, '...');
                    })->implode(', ');
                })

                ->addColumn('montantCP', function (Demande $demande) {
                    return $demande->partenaires->map(function ($partenaire) {
                        if ($partenaire->id == 1) {
                            return number_format($partenaire->pivot->montant);
                        }
                    })->implode(' ');
                })




                ->addColumn('checkbox', function ($demandes) {
                    return '<input type="checkbox" id="demandeEnCoursCb_' . $demandes->id . '" name="checkbox" class="demande-en-cours-checkbox" value="' . $demandes->id . '"  data-numero ="' . $demandes->num_ordre . '" class="chk-col-green"><label for="demandeEnCoursCb_' . $demandes->id . '" class="block" ></label>';
                })


                ->addColumn('num_ordre', function ($demandes) {
                    return '<a href="demande/'.$demandes->id.'/edit">'.$demandes->num_ordre.'</a>';
                })

                ->addColumn('montant_global', function ($demandes) {
                    return number_format($demandes->montant_global);
                })

                ->addColumn('date_reception', function ($demandes) {
                    return $demandes->date_reception->format('d-m-Y');
                })
                ->rawColumns(['checkbox','num_ordre'])

                ->setRowClass(function ($demandes) {
                    return 'center-data';
                });


        }

        //filter with communes
        if ($communes_id = $request->get('communes')) {
            if ($communes_id == "all") {
            } else {
                $demandes->whereHas('communes', function ($query) use ($communes_id) {
                    $query->where('communes.id', '=', $communes_id);
                });
            }
        }

        //filter with partenaire
        if ($partenaires_id = $request->get('partenaires')) {
            if ($partenaires_id == "all") {
            } else {
                $demandes->whereHas('partenaires', function ($query) use ($partenaires_id) {
                    $query->where('partenaires_types.id', '=', $partenaires_id);
                });
            }
        }

        //filter with localites
        if ($localites = $request->get('localites')) {
            if ($localites == "all") {
            } else {
                $demandes->whereHas('point_desservis', function ($query) use ($localites) {
                    $query->where('point_desservis.nom_fr', '=', $localites);
                });
            }
        }

        //filter with session
        if ($session_id = $request->get('session')) {
            if ($session_id == "all") {
            } else {
                $demandes->where('mois', '=', $session_id);
            }
        }

        //filter with daterange
        if ($daterange = $request->get('daterange')) {
            $daterange_splite = explode('-', $daterange);
            $date_start = $daterange_splite[0];
            $date_start_formatted = date("Y-m-d", strtotime($date_start));
            $date_end = $daterange_splite[1];
            $date_end_formatted = date("Y-m-d", strtotime($date_end));

            $demandes->where([
                ['date_reception', '>=', trim($date_start_formatted)],
                ['date_reception', '<=', trim($date_end_formatted)],
            ]);

        }

        //filter with intervention
        if ($interventions_id = $request->get('interventions')) {
            if ($interventions_id == "all") {
            } else {
                $demandes->whereHas('interventions', function ($query) use ($interventions_id) {
                    $query->where('interventions.id', '=', $interventions_id);
                });
            }
        }
        return $datatables->make(true);
    }



    /**
     * @param Request $request
     *
     * get demandes having decision a traiter
     * @return mixed
     */


    public function getDemandesATraiter(Request $request)
    {
        $demandes = Demande::with('porteur', 'communes', 'interventions', 'partenaires','point_desservis')->where([['decision', '=', 'a_traiter'],['etat','=','sans'],['is_affecter','=',0]]);
        if ($request->ajax()) {
            $datatables = DataTables::eloquent($demandes)
                ->addColumn('communes', function (Demande $demande) {
                    return $demande->communes->map(function ($commune) {
                        return str_limit($commune->nom_fr, 15, '...');
                    })->implode(', ');
                })
                ->addColumn('porteur', function (Demande $demande) {
                    return $demande->porteur ? str_limit($demande->porteur->nom_porteur_fr, 30, '...') : '';
                })

                ->addColumn('interventions', function (Demande $demande) {
                    return $demande->interventions->map(function ($intervention) {
                        return str_limit($intervention->nom, 30, '...');
                    })->implode(', ');
                })
                // i should have access to show parntenaire type name for every partenaire

                ->addColumn('partenaires', function (Demande $demande) {
                    return $demande->partenaires->map(function ($partenaire) {
                        return str_limit($partenaire->nom_fr, 30, '...');
                    })->implode(', ');
                })

                ->addColumn('montantCP', function (Demande $demande) {

                    return $demande->partenaires->map(function ($partenaire) {
                        if ($partenaire->id == 1) {
                            return number_format($partenaire->pivot->montant);
                        }
                    })->implode(' ');


                })


                ->addColumn('session', function (Demande $demande) {
                    return $demande->session ? str_limit($demande->session->nom, 30, '...') : '';
                })

                ->addColumn('checkbox', function ($demandes) {
                    return '<input type="checkbox" id="demandeATraiterCb_' . $demandes->id . '" name="checkbox_a_traiter" value="' . $demandes->id . '"  data-numero ="' . $demandes->num_ordre . '" class="chk-col-green"><label for="demandeATraiterCb_' . $demandes->id . '" class="block" ></label>';
                })
                ->addColumn('date_reception', function ($demandes) {
                    return $demandes->date_reception->format('d-m-Y');
                })
                ->addColumn('montant_global', function ($demandes) {
                    return number_format($demandes->montant_global);
                })
                ->addColumn('num_ordre', function ($demandes) {
                    return '<a href="demande/'.$demandes->id.'/edit">'.$demandes->num_ordre.'</a>';
                })
                ->rawColumns(['checkbox','num_ordre'])
                ->editColumn('id', '{{$id}}')
                ->setRowClass(function ($demandes) {
                    return 'center-data';
                });
        }

        //filter with communes
        if ($communes_id = $request->get('communes')) {
            if ($communes_id == "all") {
            } else {
                $demandes->whereHas('communes', function ($query) use ($communes_id) {
                    $query->where('communes.id', '=', $communes_id);
                });
            }
        }

        //filter with partenaire
        if ($partenaires_id = $request->get('partenaires')) {
            if ($partenaires_id == "all") {
            } else {
                $demandes->whereHas('partenaires', function ($query) use ($partenaires_id) {
                    $query->where('partenaires_types.id', '=', $partenaires_id);
                });
            }
        }

        //filter with localites
        if ($localites = $request->get('localites')) {
            if ($localites == "all") {
            } else {
                $demandes->whereHas('point_desservis', function ($query) use ($localites) {
                    $query->where('point_desservis.nom_fr', '=', $localites);
                });
            }
        }

        //filter with session
        if ($session_id = $request->get('session')) {
            if ($session_id == "all") {
            } else {
                $demandes->where('mois', '=', $session_id);
            }
        }

        //filter with daterange
        if ($daterange = $request->get('daterange')) {
            $daterange_splite = explode('-', $daterange);
            $date_start = $daterange_splite[0];
            $date_start_formatted = date("Y-m-d", strtotime($date_start));
            $date_end = $daterange_splite[1];
            $date_end_formatted = date("Y-m-d", strtotime($date_end));

            $demandes->where([
                ['date_reception', '>=', trim($date_start_formatted)],
                ['date_reception', '<=', trim($date_end_formatted)],
            ]);

        }

        //filter with intervention
        if ($interventions_id = $request->get('interventions')) {
            if ($interventions_id == "all") {
            } else {
                $demandes->whereHas('interventions', function ($query) use ($interventions_id) {
                    $query->where('interventions.id', '=', $interventions_id);
                });
            }
        }
        return $datatables->make(true);
    }


    /**
     * @param Request $request
     * @return datatables of elements from database having 'decision' = 'accord_definitif'
     */


    public function getDemandesAccordDefinitif(Request $request)
    {
        $demandes = Demande::with('porteur', 'communes', 'interventions', 'partenaires','point_desservis')->where([['decision', '=', 'accord_definitif'],['etat','=','sans'],['is_affecter','=',0]]);
        if ($request->ajax()) {
            $datatables = DataTables::eloquent($demandes)
                ->addColumn('communes', function (Demande $demande) {
                    return $demande->communes->map(function ($commune) {
                        return str_limit($commune->nom_fr, 15, '...');
                    })->implode(', ');
                })
                ->addColumn('porteur', function (Demande $demande) {
                    return $demande->porteur ? str_limit($demande->porteur->nom_porteur_fr, 30, '...') : '';
                })

                ->addColumn('interventions', function (Demande $demande) {
                    return $demande->interventions->map(function ($intervention) {
                        return str_limit($intervention->nom, 30, '...');
                    })->implode(', ');
                })
                // i should have access to show parntenaire type name for every partenaire

                ->addColumn('partenaires', function (Demande $demande) {
                    return $demande->partenaires->map(function ($partenaire) {
                        return str_limit($partenaire->nom_fr, 30, '...');
                    })->implode(', ');
                })

                ->addColumn('montantCP', function (Demande $demande) {

                    return $demande->partenaires->map(function ($partenaire) {
                        if ($partenaire->id == 1) {
                            return number_format($partenaire->pivot->montant);
                        }
                    })->implode(' ');


                })


                ->addColumn('checkbox', function ($demandes) {
                    return '<input type="checkbox" id="demandeAccordDefinitifCb_' . $demandes->id . '" name="checkbox_accord_definitif" value="' . $demandes->id . '"  data-numero ="' . $demandes->num_ordre . '" class="chk-col-green"><label for="demandeAccordDefinitifCb_' . $demandes->id . '" class="block" ></label>';
                })
                ->addColumn('num_ordre', function ($demandes) {
                    return '<a href="demande/'.$demandes->id.'/edit">'.$demandes->num_ordre.'</a>';
                })
                ->addColumn('montant_global', function ($demandes) {
                    return number_format($demandes->montant_global);
                })
                ->addColumn('date_reception', function ($demandes) {
                    return $demandes->date_reception->format('d-m-Y');
                })
                ->rawColumns(['checkbox','num_ordre'])
                ->editColumn('id', '{{$id}}')
                ->setRowClass(function ($demandes) {
                    return 'center-data';
                });
        }

        //filter with communes
        if ($communes_id = $request->get('communes')) {
            if ($communes_id == "all") {
            } else {
                $demandes->whereHas('communes', function ($query) use ($communes_id) {
                    $query->where('communes.id', '=', $communes_id);
                });
            }
        }

        //filter with partenaire
        if ($partenaires_id = $request->get('partenaires')) {
            if ($partenaires_id == "all") {
            } else {
                $demandes->whereHas('partenaires', function ($query) use ($partenaires_id) {
                    $query->where('partenaires_types.id', '=', $partenaires_id);
                });
            }
        }

        //filter with localites
        if ($localites = $request->get('localites')) {
            if ($localites == "all") {
            } else {
                $demandes->whereHas('point_desservis', function ($query) use ($localites) {
                    $query->where('point_desservis.nom_fr', '=', $localites);
                });
            }
        }

        //filter with session
        if ($session_id = $request->get('session')) {
            if ($session_id == "all") {
            } else {
                $demandes->where('session_id', '=', $session_id);
            }
        }

        //filter with daterange
        if ($daterange = $request->get('daterange')) {
            $daterange_splite = explode('-', $daterange);
            $date_start = $daterange_splite[0];
            $date_end = $daterange_splite[1];
            $demandes->where([
                ['date_reception', '>=', trim($date_start)],
                ['date_reception', '<=', trim($date_end)],
            ]);
        }

        //filter with intervention
        if ($interventions_id = $request->get('interventions')) {
            if ($interventions_id == "all") {
            } else {
                $demandes->whereHas('interventions', function ($query) use ($interventions_id) {
                    $query->where('interventions.id', '=', $interventions_id);
                });
            }
        }
        return $datatables->make(true);
    }


    /**
     * Fetch the datatabase for demande having is_affecte = 1
     *
     * @return datatable of elements
     */
    public function getDemandesAffectees(Request $request)
    {
        $demandes = Demande::with('porteur', 'communes', 'interventions', 'partenaires', 'session', 'point_desservis')->where('is_affecter', '=', 1);
        if ($request->ajax()) {
            $datatables = DataTables::eloquent($demandes)
                ->addColumn('communes', function (Demande $demande) {
                    return $demande->communes->map(function ($commune) {
                        return str_limit($commune->nom_fr, 15, '...');
                    })->implode(', ');
                })
                ->addColumn('porteur', function (Demande $demande) {
                    return $demande->porteur ? str_limit($demande->porteur->nom_porteur_fr, 30, '...') : '';
                })

                ->addColumn('interventions', function (Demande $demande) {
                    return $demande->interventions->map(function ($intervention) {
                        return str_limit($intervention->nom, 30, '...');
                    })->implode(', ');
                })
                // i should have access to show parntenaire type name for every partenaire

                ->addColumn('partenaires', function (Demande $demande) {
                    return $demande->partenaires->map(function ($partenaire) {
                        return str_limit($partenaire->nom_fr, 30, '...');
                    })->implode(', ');
                })

                ->addColumn('montantCP', function (Demande $demande) {

                    return $demande->partenaires->map(function ($partenaire) {
                        if ($partenaire->id == 1) {
                            return number_format($partenaire->pivot->montant);
                        }
                    })->implode(' ');


                })


                ->addColumn('session', function (Demande $demande) {
                    return $demande->session ? str_limit($demande->session->nom, 30, '...') : '';
                })

                ->addColumn('checkbox', function ($demandes) {
                    return '<input type="checkbox" id="demandeAffecteCb_' . $demandes->id . '" name="checkbox_affectees" value="' . $demandes->id . '" data-id="' . $demandes->id . '"  data-numero ="' . $demandes->num_ordre . '" class="chk-col-green"><label for="demandeAffecteCb_' . $demandes->id . '" class="block" ></label>';
                })
                ->addColumn('montant_global', function ($demandes) {
                    return number_format($demandes->montant_global);
                })
                ->addColumn('date_reception', function ($demandes) {
                    return $demandes->date_reception->format('d-m-Y');
                })
                ->rawColumns(['checkbox'])
                ->editColumn('id', '{{$id}}')
                ->setRowClass(function ($demandes) {
                    return 'center-data';
                });
        }

        //filter with communes
        if ($communes_id = $request->get('communes')) {
            if ($communes_id == "all") {
            } else {
                $demandes->whereHas('communes', function ($query) use ($communes_id) {
                    $query->where('communes.id', '=', $communes_id);
                });
            }
        }

        //filter with partenaire
        if ($partenaires_id = $request->get('partenaires')) {
            if ($partenaires_id == "all") {
            } else {
                $demandes->whereHas('partenaires', function ($query) use ($partenaires_id) {
                    $query->where('partenaires_types.id', '=', $partenaires_id);
                });
            }
        }

        //filter with localites
        if ($localites = $request->get('localites')) {
            if ($localites == "all") {
            } else {
                $demandes->whereHas('point_desservis', function ($query) use ($localites) {
                    $query->where('point_desservis.nom_fr', '=', $localites);
                });
            }
        }

        //filter with session
        if ($session_id = $request->get('session')) {
            if ($session_id == "all") {
            } else {
                $demandes->where('session_id', '=', $session_id);
            }
        }

        //filter with daterange
        if ($daterange = $request->get('daterange')) {
            $daterange_splite = explode('-', $daterange);
            $date_start = $daterange_splite[0];
            $date_end = $daterange_splite[1];
            $demandes->where([
                ['date_reception', '>=', trim($date_start)],
                ['date_reception', '<=', trim($date_end)],
            ]);
        }

        //filter with intervention
        if ($interventions_id = $request->get('interventions')) {
            if ($interventions_id == "all") {
            } else {
                $demandes->whereHas('interventions', function ($query) use ($interventions_id) {
                    $query->where('interventions.id', '=', $interventions_id);
                });
            }
        }
        return $datatables->make(true);
    }


    /**
     * @param Request $request
     *
     * fetch the database to get demande having etat realise
     * @return mixed
     */

    public function getDemandesRealisee(Request $request)
    {
        $demandes = Demande::with('porteur', 'communes', 'interventions', 'partenaires', 'session', 'point_desservis')->where([['decision','=','sans'],['etat','=','realisee'],['is_affecter','=',0]]);
        if ($request->ajax()) {
            $datatables = DataTables::eloquent($demandes)
                ->addColumn('communes', function (Demande $demande) {
                    return $demande->communes->map(function ($commune) {
                        return str_limit($commune->nom_fr, 15, '...');
                    })->implode(',');
                })
                ->addColumn('porteur', function (Demande $demande) {
                    return $demande->porteur ? str_limit($demande->porteur->nom_porteur_fr, 30, '...') : '';
                })

                ->addColumn('interventions', function (Demande $demande) {
                    return $demande->interventions->map(function ($intervention) {
                        return str_limit($intervention->nom, 30, '...');
                    })->implode(',');
                })
                // i should have access to show parntenaire type name for every partenaire

                ->addColumn('partenaires', function (Demande $demande) {
                    return $demande->partenaires->map(function ($partenaire) {
                        return str_limit($partenaire->nom_fr, 30, '...');
                    })->implode(',');
                })

                ->addColumn('montantCP', function (Demande $demande) {

                    return $demande->partenaires->map(function ($partenaire) {
                        if ($partenaire->id == 1) {
                            return number_format($partenaire->pivot->montant);
                        }
                    })->implode(' ');


                })
                ->addColumn('date_reception', function ($demandes) {
                    return $demandes->date_reception->format('d-m-Y');
                })
                ->addColumn('montant_global', function ($demandes) {
                    return number_format($demandes->montant_global);
                })

                ->addColumn('checkbox', function ($demandes) {
                    return '<input type="checkbox" id="' . $demandes->id . '" name="checkbox_programmee" value="' . $demandes->id . '"  data-numero ="' . $demandes->num_ordre . '" class="chk-col-green"><label for="' . $demandes->id . '" class="block" ></label>';
                })
                ->rawColumns(['checkbox'])
                ->editColumn('id', '{{$id}}')
                ->setRowClass(function ($demandes) {
                    return 'center-data';
                });
        }

        //filter with communes
        if ($communes_id = $request->get('communes')) {
            if ($communes_id == "all") {
            } else {
                $demandes->whereHas('communes', function ($query) use ($communes_id) {
                    $query->where('communes.id', '=', $communes_id);
                });
            }
        }

        //filter with partenaire
        if ($partenaires_id = $request->get('partenaires')) {
            if ($partenaires_id == "all") {
            } else {
                $demandes->whereHas('partenaires', function ($query) use ($partenaires_id) {
                    $query->where('partenaires_types.id', '=', $partenaires_id);
                });
            }
        }

        //filter with localites
        if ($localites = $request->get('localites')) {
            if ($localites == "all") {
            } else {
                $demandes->whereHas('point_desservis', function ($query) use ($localites) {
                    $query->where('point_desservis.nom_fr', '=', $localites);
                });
            }
        }

        //filter with session
        if ($session_id = $request->get('session')) {
            if ($session_id == "all") {
            } else {
                $demandes->where('session_id', '=', $session_id);
            }
        }

        //filter with daterange
        if ($daterange = $request->get('daterange')) {
            $daterange_splite = explode('-', $daterange);
            $date_start = $daterange_splite[0];
            $date_end = $daterange_splite[1];
            $demandes->where([
                ['date_reception', '>=', trim($date_start)],
                ['date_reception', '<=', trim($date_end)],
            ]);
        }

        //filter with intervention
        if ($interventions_id = $request->get('interventions')) {
            if ($interventions_id == "all") {
            } else {
                $demandes->whereHas('interventions', function ($query) use ($interventions_id) {
                    $query->where('interventions.id', '=', $interventions_id);
                });
            }
        }
        return $datatables->make(true);
    }


    /**
     * @param Request $request
     *
     * fetch the database to get demande having etat realise
     * @return mixed
     */

    public function getDemandesProgrammee(Request $request)
    {
        $demandes = Demande::with('porteur', 'communes', 'interventions', 'partenaires', 'session', 'point_desservis')->where([['decision','=','sans'],['etat','=','programmee'],['is_affecter','=',0]]);
        if ($request->ajax()) {
            $datatables = DataTables::eloquent($demandes)
                ->addColumn('communes', function (Demande $demande) {
                    return $demande->communes->map(function ($commune) {
                        return str_limit($commune->nom_fr, 15, '...');
                    })->implode(',');
                })
                ->addColumn('porteur', function (Demande $demande) {
                    return $demande->porteur ? str_limit($demande->porteur->nom_porteur_fr, 30, '...') : '';
                })

                ->addColumn('interventions', function (Demande $demande) {
                    return $demande->interventions->map(function ($intervention) {
                        return str_limit($intervention->nom, 30, '...');
                    })->implode(',');
                })
                // i should have access to show parntenaire type name for every partenaire

                ->addColumn('partenaires', function (Demande $demande) {
                    return $demande->partenaires->map(function ($partenaire) {
                        return str_limit($partenaire->nom_fr, 30, '...');
                    })->implode(',');
                })

                ->addColumn('montantCP', function (Demande $demande) {

                    return $demande->partenaires->map(function ($partenaire) {
                        if ($partenaire->id == 1) {
                            return number_format($partenaire->pivot->montant);
                        }
                    })->implode(' ');


                })
                ->addColumn('date_reception', function ($demandes) {
                    return $demandes->date_reception->format('d-m-Y');
                })
                ->addColumn('montant_global', function ($demandes) {
                    return number_format($demandes->montant_global);
                })

                ->addColumn('checkbox', function ($demandes) {
                    return '<input type="checkbox" id="' . $demandes->id . '" name="checkbox_programmee" value="' . $demandes->id . '"  data-numero ="' . $demandes->num_ordre . '" class="chk-col-green"><label for="' . $demandes->id . '" class="block" ></label>';
                })
                ->rawColumns(['checkbox'])
                ->editColumn('id', '{{$id}}')
                ->setRowClass(function ($demandes) {
                    return 'center-data';
                });
        }

        //filter with communes
        if ($communes_id = $request->get('communes')) {
            if ($communes_id == "all") {
            } else {
                $demandes->whereHas('communes', function ($query) use ($communes_id) {
                    $query->where('communes.id', '=', $communes_id);
                });
            }
        }

        //filter with partenaire
        if ($partenaires_id = $request->get('partenaires')) {
            if ($partenaires_id == "all") {
            } else {
                $demandes->whereHas('partenaires', function ($query) use ($partenaires_id) {
                    $query->where('partenaires_types.id', '=', $partenaires_id);
                });
            }
        }

        //filter with localites
        if ($localites = $request->get('localites')) {
            if ($localites == "all") {
            } else {
                $demandes->whereHas('point_desservis', function ($query) use ($localites) {
                    $query->where('point_desservis.nom_fr', '=', $localites);
                });
            }
        }

        //filter with session
        if ($session_id = $request->get('session')) {
            if ($session_id == "all") {
            } else {
                $demandes->where('session_id', '=', $session_id);
            }
        }

        //filter with daterange
        if ($daterange = $request->get('daterange')) {
            $daterange_splite = explode('-', $daterange);
            $date_start = $daterange_splite[0];
            $date_end = $daterange_splite[1];
            $demandes->where([
                ['date_reception', '>=', trim($date_start)],
                ['date_reception', '<=', trim($date_end)],
            ]);
        }

        //filter with intervention
        if ($interventions_id = $request->get('interventions')) {
            if ($interventions_id == "all") {
            } else {
                $demandes->whereHas('interventions', function ($query) use ($interventions_id) {
                    $query->where('interventions.id', '=', $interventions_id);
                });
            }
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
        $porteurs = Porteur::all();

        $sourceFincancement = SourceFinancement::all();

        $demandes = Demande::with(['communes', 'partenaires', 'piste', 'point_desservis', 'porteur', 'interventions', 'session'])->get();
        
        //$demandes = $demandes_collec->toJson();
        return view('demandes.index')->with([
            'demandes' => $demandes,
            'communes' => $communes,
            'localites' => $localites,
            'partenaires_types' => $partenaires_types,
            'moas' => $moas,
            'porteurs' => $porteurs,
            'sessions' => $sessions,
            'interventions' => $interventions,
            'sourceFincancement'=> $sourceFincancement
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
        $interventions = Intervention::orderBy('nom')->pluck('nom', 'id');
        $partenaire_types = PartenaireType::all();
        $porteur_projet = Porteur::distinct()->select('id','nom_porteur_fr')->get();

         //point desservis
        $localites = PointDesserviCategorie::find(1)->point_desservis;
        $categorie_points = PointDesserviCategorie::all();
        $etablissement_scols = PointDesservi::all()->where('type_point', '=', 'etab.scolaire');
      

        //find the max numero ordre and increment 
        $max_num_ordre = Demande::max('num_ordre');
        $current_numero_ordre = $max_num_ordre + 1;
        $demande = new Demande;
        return view('demandes.create')->with(
            [
                'demande' => $demande,
                'current_numero_ordre' => $current_numero_ordre,
                'communes' => $communes,
                'interventions' => $interventions,
                'localites' => $localites,
                'etablissement_scols' => $etablissement_scols,
                'partenaire_types' => $partenaire_types,
                'porteur_projet' => $porteur_projet,
                'categorie_points' => $categorie_points,
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
        //find the communes for this demande and put them in an array
        $communes = $request->input('communes');

        $interventions = $request->input('interventions');        
      
        //get the localites
        $localites = $request->input('localites');        
        //get the last id of demandes
        $id_demande = Demande::max('id');
        $actu_id_demande = $id_demande + 1;
        //create demande
        $demande = new Demande;

        $demande->num_ordre = $request->input('num_ordre');
        //formating date time
        $date_to_time = strtotime(str_replace("/",'-',$request->date_reception));
        $date_formatted = date('Y-m-d',$date_to_time);
        $demande->date_reception = $date_formatted;
        $demande->objet_fr = $request->input('objet_fr');
        $demande->objet_ar = $request->input('objet_ar');
        $demande->montant_global = $request->input('montant_global');
        $demande->observation = $request->input('observation');
        $demande->etat = $request->input('etat');
        $demande->session_id = $request->input('session');
        $demande->is_affecter = 0;
        $demande->porteur_projet_id = $request->input('porteur_projet');
        $demande->decision = 'en_cours';
        $demande->save();

        //partenaire *****
        if (Input::has('partnenaire_type_ids')) {
            $partenaires_ids = (array)Input::get('partnenaire_type_ids');
            $montant_partenaire = (array)Input::get('montant');
            for ($i = 0; $i < count($partenaires_ids); $i++) {
                $demande->partenaires()->attach($partenaires_ids[$i], ['montant' => $montant_partenaire[$i]]);
            }
        }

      // Point desservis **************
        
        //insert in pivot table 
        if ($demande->save()) {
            $commune_ids = Input::get('communes');
            $demande->communes()->sync($commune_ids);
            //intervention
            $intervention_ids = Input::get('interventions');
            $demande->interventions()->sync($intervention_ids);
            //insert localite id and demande id in pivot table 
            $point_desservi_ids = Input::get('points');
            $demande->point_desservis()->sync($point_desservi_ids);
        }
        
        //save data in piste*****
        $piste = new Piste;
        $piste->longueur = $request->input('longueur');
        $piste->demande_id = $actu_id_demande;
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
                    $path = $file->storeAs('public/uploaded_files/demandes/'.$actu_id_demande, $fileNameToStore);
                }

            }



            for ($i = 0; $i < $items_number; $i++) {
                $piece = new Piece;
                $piece->type = $pieces_types_array[$i];
                $piece->nom = $pieces_noms_array[$i];
                $piece->path = $piece_file_names[$i];
                $piece->demande_id = $actu_id_demande;
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
        return redirect('/demande')->with('success', 'Demande créee avec succès');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Demande  $demande
     * @return \Illuminate\Http\Response
     */
    public function show(Demande $demande)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Demande  $demande
     * @return \Illuminate\Http\Response
     */
    public function edit(Demande $demande)
    {
        $interventions = Intervention::orderBy('nom')->pluck('nom', 'id');
        $communes = Commune::orderBy('nom_fr')->pluck('nom_fr', 'id');
        $pieces = Piece::orderBy('type')->pluck('type');
        $moas = Moa::all();
        $partenaires_types = PartenaireType::all();
        $sourceFincancement = SourceFinancement::all();
        $porteur_projet = Porteur::orderBy('nom_porteur_fr')->pluck('nom_porteur_fr', 'id');
        $localites = PointDesservi::orderBy('nom_fr')->where('categorie_point_id', '=', 1)->pluck('nom_fr', 'id');
        $demande = Demande::with(['communes', 'partenaires', 'piste', 'point_desservis', 'porteur', 'interventions', 'session', 'piece','sourceFinancement'])->find($demande->id);


        //return $demande;
        return view('demandes.edit.edit')->with([
            'demande' => $demande,
            'interventions' => $interventions,
            'localites' => $localites,
            'partenaires_types' => $partenaires_types,
            'moas' => $moas,
            'communes' => $communes,
            'sourceFincancement' => $sourceFincancement,
            'porteur_projet' => $porteur_projet
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Demande  $demande
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Demande $demande)
    {
        //$request->validate($request, ['num_ordre' => 'required']);
        $demande_to_update = Demande::find($demande->id);
        $demande_to_update->porteur_projet_id = $request->porteur_projet;
        $demande_to_update->objet_fr = $request->objet_fr;
        $demande_to_update->objet_ar = $request->objet_ar;
        $demande_to_update->observation = $request->observation;
        $date_formatted = str_replace("/",'-',$request->date_reception);
        $demande_to_update->date_reception = Carbon::parse($date_formatted)->format('Y-m-d');

        //return  $request->porteur_projet;
        $demande_to_update->save();


        //update interventions
        $intervention_ids = Input::get('interventions');
        $demande->interventions()->sync($intervention_ids);
        //update communes
        $communes_ids = Input::get('communes');
        $demande->communes()->sync($communes_ids);

        //update pistes 
        Piste::where('id', $request->id_pist)
            ->update(['longueur' => $request->longueur]);


         //update localites
        $localites_ids = Input::get('localites');
        $demande->point_desservis()->sync($localites_ids);
        return redirect("/demande" . "/" . $demande->id . "/edit")->with('success', 'Demande modifier avec succès');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Demande  $demande
     * @return \Illuminate\Http\Response
     */
    public function destroy(Demande $demande)
    {
        Demande::destroy($demande->id);
        return response()->json();
    }
}
