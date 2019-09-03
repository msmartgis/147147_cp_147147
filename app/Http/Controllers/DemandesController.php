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
use App\Device;
use App\PointDesserviCategorie;
use App\Moa;
use App\Projet;
use Carbon\Carbon;
use Illuminate\Http\Request;
//use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
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

        $pivot_source_financement =  $demande->sourceFinancement()
            ->get();

       $pivot =  $demande->partenaires()->where('partenaire_id','=',1)
           ->get();


       return response()->json(['id'=>$demande_id,'montantGlobal'=>$montant_global,'partenaire_id'=>$partenaire_id,'pivot'=>$pivot,'pivot_all' => $pivot_all,'pivot_source_financement' => $pivot_source_financement]);
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
                 ->update(['montant_global' =>str_replace(',','',$request->montant_global) ]);


            //update decision
            Demande::where('id', $request->id)
                ->update(['decision' => 'accord_definitif']);


            //update montant cp
            $demande->partenaires()->updateExistingPivot($request->cp_id,array('montant' =>str_replace(',','',$request->montant_cp)));

            //insert source de finacnement *****
            if (Input::has('source_financement_ids') !== null) {
                $source_financement_ids = (array)Input::get('source_financement_ids');
                //return $source_financement_ids;
                $montant_source = (array)Input::get('montant_source');
                for ($i = 0; $i < count($source_financement_ids); $i++) {
                    $demande->sourceFinancement()->attach($source_financement_ids[$i], ['montant' => str_replace(',','',$montant_source[$i]) ]);
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
                    array_push($pivotData,['montant' => str_replace(',','',$montant[$i])]);
                }

                $syncData = array_combine($partnenaire_type_ids,$pivotData);
                $demande->partenaires()->sync($syncData);
            }



            return redirect('/demande')->with('success', 'Accord definititf  avec succès');
        }

        //affectation aux convntion
        if($request->affecter == '1')
        {
            $convention_new = new Convention();

            $convention_new->save();

            if($convention_new->save())
            {
                $convention_id = $convention_new->id;

            }


            $demande = Demande::with('communes','interventions','partenaires','point_desservis','piste','porteur','piece','sourceFinancement')
                ->find($request->id);


            //update demande is_affecter
            DB::table('demandes')
                ->where('id', $demande->id)
                ->update(['is_affecter' => 1, 'decision' => 'affecter', 'etat' => 'sans']);


            //affect data to convention
            $convention = Convention::find($convention_new->id);
            $convention->num_ordre = $demande->num_ordre;
            $convention->objet_fr =  $demande->objet_fr;
            $convention->objet_ar =  $demande->objet_ar;
            $convention->montant_global =  $demande->montant_global;
            $convention->observation =  $demande->observation;
            $convention->session_id =  $demande->session_id;
            $convention->organisation_id = Auth::user()->organisation_id;
            $convention->is_project = 0;
            $convention->affected_from_demande = 1;
            $convention->porteur_projet_id = $demande->porteur_projet_id;
            //$convention->demande_id = $demande->id;
            $convention->save();

            $convention->interventions()->attach($demande->interventions);
            $convention->communes()->attach($demande->communes);
            $convention->point_desservis()->attach($demande->point_desservis);


            //pieces management
            if(count($demande->piece) > 0 )
            {
                foreach($demande->piece as $piece)
                {
                    $new_piece = new Piece();
                    $new_piece->type = $piece->type;
                    $new_piece->nom = $piece->nom;
                    $new_piece->path = $piece->path;
                    $new_piece->convention_id = $convention_id;

                    if (Storage::disk('uploads')->exists("demandes/".$demande->id)) {
                        Storage::disk('uploads')->copy("demandes/".$demande->id."/".$piece->path, "conventions/".$convention_id."/".$piece->path);

                    }


                    //rename(storage_path("app/public/uploaded_files/demandes/".$demande->id."/".$piece->path),storage_path("app/public/uploaded_files/conventions/".$convention_id."/".$piece->path));
                    $new_piece->save();
                }
            }

            //new piste for convention
            $piste = Piste::find($demande->piste->id);

            $piste->demande_id = '';
            $piste->geometry = str_replace('demande','convention',$piste->geometry);
            $piste->longueur = $demande->piste->longueur;
            $piste->convention_id = $convention_id;
            $piste->save();

            //partenaire *****
            if (Input::has('partnenaire_type_ids')) {
                $partenaires_ids = (array)Input::get('partnenaire_type_ids');
                $montant_partenaire = (array)Input::get('montant');
                for ($i = 0; $i < count($partenaires_ids); $i++) {
                    $convention->partenaires()->attach($partenaires_ids[$i], ['montant' => str_replace(',','',$montant_partenaire[$i])]);
                }
            }


            //insert source de finacnement *****
            if (Input::has('source_financement_ids')) {
                $source_financement_ids = (array)Input::get('source_financement_ids');
                //return $source_financement_ids;
                $montant_source = (array)Input::get('montant_source');


                //detaching
                    $demande->sourceFinancement()->detach();

                //attaching
                for ($i = 0; $i < count($source_financement_ids); $i++) {
                    $demande->sourceFinancement()->attach($source_financement_ids[$i], ['montant' =>str_replace(',','',$montant_source[$i]) ]);
                }
            }


            //save to conventions
            $convention->montant_global = str_replace(',','',$request->montant_global) ;
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
        $demandes = Demande::with('porteur', 'communes', 'interventions', 'partenaires','point_desservis')->where([['decision', '=', 'en_cours'],['etat','=','sans'],['is_affecter','=',0]])->orderBy('num_ordre');
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
                    return '<input type="checkbox" id="demandeEnCoursCb_' . $demandes->id . '" name="checkbox" class="demande-en-cours-checkbox" value="' . $demandes->id . '"  data-numero ="' . $demandes->num_ordre . '" data-id="' . $demandes->id . '" class="chk-col-green"><label for="demandeEnCoursCb_' . $demandes->id . '" class="block" ></label>';
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
                ->rawColumns(['checkbox','num_ordre']);
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
        if ($session_id = $request->get('session_id')) {
            if ($session_id == "all") {
            } else {
                $demandes->where('session_id', '=', $session_id);
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


    //demandes for cartographie
    public function getDemandesCarto(Request $request)
    {
        $demandes = Demande::with('porteur', 'communes', 'interventions', 'partenaires','point_desservis')->orderBy('num_ordre');
        if ($request->ajax()) {
            $datatables = DataTables::eloquent($demandes)
                ->addColumn('communes', function (Demande $demande) {
                    return $demande->communes->map(function ($commune) {
                        return str_limit($commune->nom_fr, 15, '...');
                    })->implode(', ');
                })


                ->addColumn('longueur', function (Demande $demande) {
                    return $demande->piste ? str_limit($demande->piste->longueur, 40, '...') : '';
                })


                ->addColumn('etat', function (Demande $demande) {
                    if($demande->is_affecter == 0)
                    {
                        if($demande->etat == 'sans')
                        {
                            if($demande->decision == 'en_cours')
                            {
                                return 'En cours';
                            }


                            if($demande->decision == 'accord_definitif')
                            {
                                return 'Accord définitif';
                            }

                            if($demande->decision == 'a_traiter')
                            {
                                return 'A traiter';
                            }

                            if($demande->decision == 'en_cours')
                            {
                                return 'En cours';
                            }

                        }else{
                            if($demande->etat == "programme")
                            {
                                return 'Programmée';
                            }

                            if($demande->etat == "realise")
                            {
                                return 'Réalisée';
                            }

                        }
                    }
                })
                ->addColumn('date_reception', function ($demandes) {
                    return $demandes->date_reception->format('d-m-Y');
                })
            ;
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
        $demandes = Demande::with('porteur', 'communes', 'interventions', 'partenaires','point_desservis')->where([['decision', '=', 'a_traiter'],['etat','=','sans'],['is_affecter','=',0]])->orderBy('num_ordre');
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
                    return '<input type="checkbox" id="demandeATraiterCb_' . $demandes->id . '" name="checkbox_a_traiter" value="' . $demandes->id . '" data-id="' . $demandes->id . '"  data-numero ="' . $demandes->num_ordre . '" class="chk-col-green"><label for="demandeATraiterCb_' . $demandes->id . '" class="block" ></label>';
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
                ->editColumn('id', '{{$id}}');
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
        if ($session_id = $request->get('session_id')) {
            if ($session_id == "all") {
            } else {
                $demandes->where('session_id', '=', $session_id);
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
        $demandes = Demande::with('porteur', 'communes', 'interventions', 'partenaires','point_desservis')->where([['decision', '=', 'accord_definitif'],['etat','=','sans'],['is_affecter','=',0]])->orderBy('num_ordre');
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
                    return '<input type="checkbox" id="demandeAccordDefinitifCb_' . $demandes->id . '" name="checkbox_accord_definitif" value="' . $demandes->id . '" data-id="' . $demandes->id . '"  data-numero ="' . $demandes->num_ordre . '" class="chk-col-green"><label for="demandeAccordDefinitifCb_' . $demandes->id . '" class="block" ></label>';
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
                ->editColumn('id', '{{$id}}');
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
        if ($session_id = $request->get('session_id')) {
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
        $conventions = Convention::with( 'communes', 'interventions', 'partenaires','point_desservis')->where('affected_from_demande', '=', 1)->orderBy('num_ordre');
        if ($request->ajax()) {
            $datatables = DataTables::eloquent($conventions)
                ->addColumn('communes', function (Convention $convention) {
                    return $convention->communes->map(function ($commune) {
                        return str_limit($commune->nom_fr, 15, '...');
                    })->implode(', ');
                })


                ->addColumn('interventions', function (Convention $convention) {
                    return $convention->interventions->map(function ($intervention) {
                        return str_limit($intervention->nom, 30, '...');
                    })->implode(', ');
                })

                ->addColumn('porteur', function (Convention $convention) {
                    return $convention->porteur ? str_limit($convention->porteur->nom_porteur_fr, 30, '...') : '';
                })
                // i should have access to show parntenaire type name for every partenaire

                ->addColumn('partenaires', function (Convention $convention) {
                    return $convention->partenaires->map(function ($partenaire) {
                        return str_limit($partenaire->nom_fr, 30, '...');
                    })->implode(', ');
                })

                ->addColumn('session', function (Convention $convention) {
                    return $convention->session ? str_limit($convention->session->nom, 30, '...') : '';
                })

                ->addColumn('montantCP', function (Convention $convention) {

                    return $convention->partenaires->map(function ($partenaire) {
                        if ($partenaire->id == 1) {
                            return number_format($partenaire->pivot->montant);
                        }
                    })->implode(' ');
                })



                ->addColumn('checkbox', function ($conventions) {
                    return '<input type="checkbox" id="demandeAffecteCb_' . $conventions->id . '" name="checkbox_affectees" value="' . $conventions->id . '" data-id="' . $conventions->id . '"  data-numero ="' . $conventions->num_ordre . '" class="chk-col-green"><label for="demandeAffecteCb_' . $conventions->id . '" class="block" ></label>';
                })
                ->addColumn('num_ordre', function ($conventions) {
                    return '<a href="convention/'.$conventions->id.'/edit">'.$conventions->num_ordre.'</a>';
                })
                ->addColumn('montant_global', function ($conventions) {
                    return number_format($conventions->montant_global);
                })
                /*
                ->addColumn('date_reception', function ($conventions) {
                    return $conventions->date_reception->format('d-m-Y');
                })*/
                ->rawColumns(['checkbox','num_ordre'])
                ->editColumn('id', '{{$id}}');
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
                $conventions->where('session_id', '=', $session_id);
            }
        }

        //filter with daterange
        if ($daterange = $request->get('daterange')) {
            $daterange_splite = explode('-', $daterange);
            $date_start = $daterange_splite[0];
            $date_end = $daterange_splite[1];
            $conventions->where([
                ['date_reception', '>=', trim($date_start)],
                ['date_reception', '<=', trim($date_end)],
            ]);
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


    /**
     * @param Request $request
     *
     * fetch the database to get demande having etat realise
     * @return mixed
     */

    public function getDemandesRealisee(Request $request)
    {
        $demandes = Demande::with('porteur', 'communes', 'interventions', 'partenaires', 'session', 'point_desservis')->where([['etat','=','realisee'],['is_affecter','=',0]])->orderBy('num_ordre');
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

                ->addColumn('num_ordre', function ($demandes) {
                    return '<a href="demande/'.$demandes->id.'/edit">'.$demandes->num_ordre.'</a>';
                })

                ->addColumn('checkbox', function ($demandes) {
                    return '<input type="checkbox" id="' . $demandes->id . '" name="checkbox_programmee" value="' . $demandes->id . '" data-id="' . $demandes->id . '" data-numero ="' . $demandes->num_ordre . '" class="chk-col-green"><label for="' . $demandes->id . '" class="block" ></label>';
                })
                ->rawColumns(['checkbox','num_ordre'])
                ->editColumn('id', '{{$id}}');
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
     * fetch the database to get demande having etat realise
     * @return mixed
     */

    public function getDemandesProgrammee(Request $request)
    {
        $demandes = Demande::with('porteur', 'communes', 'interventions', 'partenaires', 'session', 'point_desservis')->where([['etat','=','programmee'],['is_affecter','=',0]])->orderBy('num_ordre');
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

                ->addColumn('num_ordre', function ($demandes) {
                    return '<a href="demande/'.$demandes->id.'/edit">'.$demandes->num_ordre.'</a>';
                })

                ->addColumn('checkbox', function ($demandes) {
                    return '<input type="checkbox" id="' . $demandes->id . '" name="checkbox_programmee" value="' . $demandes->id . '" data-id="' . $demandes->id . '"  data-numero ="' . $demandes->num_ordre . '" class="chk-col-green"><label for="' . $demandes->id . '" class="block" ></label>';
                })
                ->rawColumns(['checkbox','num_ordre'])
                ->editColumn('id', '{{$id}}');
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
            'sourceFincancement'=> $sourceFincancement,
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
        $interventions = Intervention::orderBy('nom')->pluck('nom', 'id');
        $partenaire_types = PartenaireType::all();
        $sessions = Session::all();
        $porteur_projet = Porteur::distinct()->select('id','nom_porteur_fr')->get();

         //point desservis
        $localites = PointDesserviCategorie::find(1)->point_desservis;
        $categorie_points = PointDesserviCategorie::all();
        $etablissement_scols = PointDesservi::all()->where('type_point', '=', 'etab.scolaire');


        //find the max numero ordre and increment
        $current_numero_ordre = Demande::max('num_ordre') + 1;

        //create a new demande to reserve
        $demande = new Demande();

        //create a new piste to reserve id
        $piste = new Piste();
        $piste->active = 0;
        $piste->save();
        if($piste->save())
        {
           $piste_id=  $piste->id;
        }

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
                'piste_id' => $piste_id,
                'sessions' => $sessions,
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
        //find the communes for this demande and put them in an array
        $communes = $request->input('communes');

        $interventions = $request->input('interventions');        
      
        //get the localites
        $localites = $request->input('localites');        
        //get the last id of demandes
        //$id_demande = Demande::max('id');
        //$actu_id_demande = $id_demande + 1;
        //create demande
        $demande = new Demande;

        $demande->num_ordre = $request->input('num_ordre');
        $demande->session_id = $request->input('session_id');
        //formating date time
        $date_to_time = strtotime(str_replace("/",'-',$request->date_reception));
        $date_formatted = date('Y-m-d',$date_to_time);
        $demande->date_reception = $date_formatted;
        $demande->objet_fr = $request->input('objet_fr');
        $demande->objet_ar = $request->input('objet_ar');
        $demande->montant_global = str_replace(',','',$request->input('montant_global')) ;
        $demande->observation = $request->input('observation');
        $demande->etat = $request->input('etat');
        $demande->session_id = $request->input('session');
        $demande->is_affecter = 0;
        $demande->porteur_projet_id = $request->input('porteur_projet');
        if($request->input('etat') == 'sans')
        {
            $demande->decision = 'en_cours';
        }

        $demande->save();
        if($demande->save())
        {
            $actu_id_demande = $demande->id;
        }


        //partenaire *****
        if (Input::has('partnenaire_type_ids')) {
            $partenaires_ids = (array)Input::get('partnenaire_type_ids');
            $montant_partenaire = (array)Input::get('montant');
            for ($i = 0; $i < count($partenaires_ids); $i++) {
                $demande->partenaires()->attach($partenaires_ids[$i], ['montant' => str_replace(',','',$montant_partenaire[$i])]);
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
        $piste = Piste::find($request->piste_id);
        $piste->longueur = $request->input('longueur');
        $piste->demande_id = $actu_id_demande;
        //get geojson
        $piste->geometry = $request->geometry;
        $piste->active = 1;
        //return $piste;
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
                if(count($piece_file_names) > 0)
                {
                    $piece->path = $piece_file_names[$i];
                }else{
                    $piece->path = '';
                }

                $piece->demande_id = $actu_id_demande;
                $piece->save();
                //array_push($array_combination_piece, $piece);
            }
        }

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
        $is_mobile = 0;
        $useragent=$_SERVER['HTTP_USER_AGENT'];
        if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4)))
        {
            $is_mobile = 1;
        }
        $interventions = Intervention::orderBy('nom')->pluck('nom', 'id');
        $communes = Commune::orderBy('nom_fr')->pluck('nom_fr', 'id');
        $pieces = Piece::orderBy('type')->pluck('type');
        $moas = Moa::all();
        $partenaires_types = PartenaireType::all();
        $sourceFincancement = SourceFinancement::all();
        $porteur_projet = Porteur::orderBy('nom_porteur_fr')->pluck('nom_porteur_fr', 'id');
        //$localites = PointDesservi::orderBy('nom_fr')->where('categorie_point_id', '=', 1)->pluck('nom_fr', 'id');
        $point_desservis = PointDesservi::orderBy('nom_fr')->pluck('nom_fr', 'id');
        $demande = Demande::with(['communes', 'partenaires', 'piste', 'point_desservis', 'porteur', 'interventions', 'session', 'piece','sourceFinancement'])->find($demande->id);


        //return $demande;
        return view('demandes.edit.edit')->with([
            'demande' => $demande,
            'interventions' => $interventions,
            'point_desservis' => $point_desservis,
            'partenaires_types' => $partenaires_types,
            'moas' => $moas,
            'communes' => $communes,
            'sourceFincancement' => $sourceFincancement,
            'porteur_projet' => $porteur_projet,
            'is_mobile' => $is_mobile
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
            ->update(['longueur' => $request->longueur,'geometry'=>$request->geometry]);


         //update points desservis
        $point_desservis = Input::get('point_desservis');
        $demande->point_desservis()->sync($point_desservis);
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
        Storage::disk('uploads')->deleteDirectory('demandes/'.$demande->id);
        $demande->communes()->detach();
        $demande->partenaires()->detach();
        $demande->interventions()->detach();
        $demande->sourceFinancement()->detach();
        $demande->piste()->delete();
        $demande->piece()->delete();
        Demande::destroy($demande->id);
        return response()->json();
    }
}
