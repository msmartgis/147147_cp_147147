<?php

namespace App\Http\Controllers;

use App\Porteur;
use App\Session;
use App\SourceFinancement;
use App\User;
use App\Organisation;
use Illuminate\Http\Request;
use App\Device;
use DataTables;
use DB;
use Illuminate\Support\Collection;

class ParametresController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function getDataElement(Request $request)
    {
        $organisations = Organisation::all();
        $markup_organisation = '';



        $model =  $request->model;

        if($model == "user")
        {
            $res = User::find($request->route('id'));

            foreach ($organisations as $organisation){
                if($organisation->id == $res->organisation_id)
                {
                    $markup_organisation .= '<option value='.$organisation->id.' selected>'.$organisation->nom_fr.'</option>';

                }else{
                    $markup_organisation .= '<option value='.$organisation->id.'>'.$organisation->nom_fr.'</option>';
                }
            }

            $markup  = '
                        <form action="/user/update_user" method="POST"  class="user-form">
                            <input type="hidden" name="id" value="'.$res->id.'">
                            <input type="hidden" name="_token" value="'.csrf_token().'">
                            <div class="row" style="padding: 12px;">
                                <div class="row col-12">
                                    <div class="col-lg-3 col-md-3">
                                        <label>Nom : </label>
                                    </div>
                                    <div class="col-lg-3 col-md-3">
                                        <input type="text" name="last_name" value='.$res->last_name.' class="form-control" required>
                                    </div>
                            
                            
                                    <div class="col-lg-3 col-md-3">
                                        <label>Prénom : </label>
                                    </div>
                                    <div class="col-lg-3 col-md-3">
                                        <input type="text" name="first_name" value='.$res->first_name.' class="form-control" required>
                                    </div>                    
                                </div>
                        
                        
                                <div class="row col-12" style="margin-top: 8px">
                                    <div class="col-lg-3 col-md-3">
                                        <label>Identification : </label>
                                    </div>
                                    <div class="col-lg-3 col-md-3">
                                        <input type="text" name="username" value='.$res->username.' class="form-control" required>
                                    </div>
                                    
                                    
                                     <div class="col-lg-3 col-md-3">
                                        <label>Intervenant : </label>
                                    </div>
                            
                                    <div class="col-lg-3 col-md-3">
                                        <div class="form-group">
                                            <select placeholder="Porteur de projet" class="form-control select2" style="width: 100%;" name="organisation_id">'.$markup_organisation.'</select>
                                        </div>
                                    </div> 
                                </div>  
                            </div>
                        </form>
            ';

        }


        if($model =="assoc")
        {
            $res = Porteur::find($request->route('id'));



            $markup  = '
                        <form action="/porteur/update_assoc" method="POST"  class="assoc-form">
                            <input type="hidden" name="id" value="'.$res->id.'">
                            <input type="hidden" name="_token" value="'.csrf_token().'">
                            <div class="row" style="padding: 12px;">
                                <div class="row col-12">
                                    <div class="col-lg-3 col-md-3">
                                        <label>Raison fr : </label>
                                    </div>
                                    <div class="col-lg-3 col-md-3">
                                        <input type="text" name="nom_porteur_fr" value='.$res->nom_porteur_fr.' class="form-control" required>
                                    </div>
                            
                            
                                    <div class="col-lg-3 col-md-3">
                                        <label>Raison ar : </label>
                                    </div>
                                    <div class="col-lg-3 col-md-3">
                                        <input type="text" name="nom_porteur_ar" value='.$res->nom_porteur_ar.' class="form-control" required>
                                    </div>                    
                                </div>
                        
                        
                                <div class="row col-12" style="margin-top: 8px">
                                    <div class="col-lg-3 col-md-3">
                                        <label>Adresse : </label>
                                    </div>
                                    <div class="col-lg-3 col-md-3">
                                        <input type="text" name="adresse" value='.$res->adresse.' class="form-control" required>
                                    </div>
                                    
                                    
                                    
                                </div>  
                            </div>
                        </form>
            ';
        }



        if($model =="src")
        {
            $res = SourceFinancement::find($request->route('id'));



            $markup  = '
                        <form action="/src/update_src" method="POST"  class="src-form">
                            <input type="hidden" name="id" value="'.$res->id.'">
                            <input type="hidden" name="_token" value="'.csrf_token().'">
                            <div class="row" style="padding: 12px;">
                                <div class="row col-12">
                                    <div class="col-lg-3 col-md-3">
                                        <label>Source : </label>
                                    </div>
                                    <div class="col-lg-3 col-md-3">
                                        <input type="text" name="source" value='.$res->source.' class="form-control" required>
                                    </div>
                            
                            
                                    <div class="col-lg-3 col-md-3">
                                        <label>Code : </label>
                                    </div>
                                    <div class="col-lg-3 col-md-3">
                                        <input type="text" name="reference" value='.$res->reference.' class="form-control" required>
                                    </div>                    
                                </div>
                        
                        
                                <div class="row col-12" style="margin-top: 8px">
                                    <div class="col-lg-3 col-md-3">
                                        <label>Montant crédit : </label>
                                    </div>
                                    <div class="col-lg-3 col-md-3">
                                        <input type="text" name="montant_credit" value='.$res->montant_credit.' class="form-control" required>
                                    </div>   
                                </div>  
                            </div>
                        </form>
            ';
        }


        if($model =="session")
        {
            $res = Session::find($request->route('id'));




            $markup  = '
                <form action="/session/update_session" method="POST"  class="session-form">
                    <input type="hidden" name="id" value="'.$res->id.'">
                    <input type="hidden" name="_token" value="'.csrf_token().'">
                    <div class="row" style="padding: 12px;">
                        <div class="row col-12">
                            <div class="col-lg-3 col-md-3">
                                <label>N° session : </label>
                            </div>
                            <div class="col-lg-3 col-md-3">
                                <input type="text" name="mois" value='.$res->mois.' class="form-control" required>
                            </div>
                    
                    
                            <div class="col-lg-3 col-md-3">
                                <label> Type : </label>
                            </div>
                            <div class="col-lg-3 col-md-3">
                                <div class="form-group">
                                    <select  class="form-control select2" style="width: 100%;" name="type">
                                        <option value="ordinaire" '.($res->type == "ordinaire" ? 'selected' : '').'  >Ordinaire</option>
                                        <option value="extraordinaire" '.($res->type == "extraordinaire" ? 'selected' : '').' >Extraordinaire</option>                                            
                                    </select>
                                </div>
                            </div>                    
                        </div>
                
                
                        <div class="row col-12" style="margin-top: 8px">
                            <div class="col-lg-3 col-md-3">
                                <label>Date : </label>
                            </div>
                            <div class="col-lg-3 col-md-3">
                                <input type="text" name="date" value='.$res->date.' class="form-control" id="datepicker" required>
                            </div>   
                        </div>  
                    </div>
                </form>
            ';
        }

        return $markup;
    }

    public function index()
    {
        $user = new User();
        $organisations = Organisation::all();
        return view('parametres.index_settings')->with([
            'is_mobile' => Device::Device(),
            'user' => $user,
            'organisations' => $organisations
        ]);
    }

    public function getUsers(Request $request)
    {
        $users = User::orderBy('organisation_id');
        if ($request->ajax()) {
            $datatables = DataTables::eloquent($users)
                ->addColumn('organisation', function ($users) {
                    return $users->organisation->nom_fr;
                })

                ->addColumn('actions', function ($users) {
                    return '<button class="edit-user-btn" style="background: none;border: none;" id="userEditBtn_'.$users->id. '"><i class="fa fa-edit "  style="margin-right: 5px;color: #219009"></i></button><button class="delete-user-btn" style="background: none;border: none;" id="userDeleteBtn_' .$users->id. '"><i class="fa fa-trash "  style="color: #ff1308"></i>';
                })
                ->rawColumns(['actions']);
            ;


        }
        return $datatables->make(true);
    }


    public function getAssoc(Request $request)
    {
        $assocs = Porteur::where('type','=','assoc')->orderBy('id');
        if ($request->ajax()) {
            $datatables = DataTables::eloquent($assocs)

                ->addColumn('actions', function ($assocs) {
                    return '<button class="edit-assoc-btn" style="background: none;border: none;" id="assocEditBtn_'.$assocs->id. '"><i class="fa fa-edit "  style="margin-right: 5px;color: #219009"></i></button><button class="delete-assoc-btn" style="background: none;border: none;" id="assocDeleteBtn_' .$assocs->id. '"><i class="fa fa-trash "  style="color: #ff1308"></i>';
                })
                ->rawColumns(['actions']);
            ;
        }
        return $datatables->make(true);
    }

    //SOURCES ****
    public function getSource(Request $request)
    {
        $sources = SourceFinancement::orderBy('id');
        if ($request->ajax()) {
            $datatables = DataTables::eloquent($sources)

                ->addColumn('actions', function ($sources) {
                    return '<button class="edit-src-btn" style="background: none;border: none;" id="srcEditBtn_'.$sources->id. '"><i class="fa fa-edit "  style="margin-right: 5px;color: #219009"></i></button><button class="delete-src-btn" style="background: none;border: none;" id="srcDeleteBtn_' .$sources->id. '"><i class="fa fa-trash "  style="color: #ff1308"></i>';
                })
                ->rawColumns(['actions']);
            ;
        }
        return $datatables->make(true);
    }


    //SESSIONS ****************
    public function getSession(Request $request)
    {
        $sessions = Session::orderBy('id');
        if ($request->ajax()) {
            $datatables = DataTables::eloquent($sessions)

                ->addColumn('actions', function ($sessions) {
                    return '<button class="edit-session-btn" style="background: none;border: none;" id="sessionEditBtn_'.$sessions->id. '"><i class="fa fa-edit "  style="margin-right: 5px;color: #219009"></i></button><button class="delete-session-btn" style="background: none;border: none;" id="sessionDeleteBtn_' .$sessions->id. '"><i class="fa fa-trash "  style="color: #ff1308"></i>';
                })

                ->addColumn('type', function ($sessions) {
                    if($sessions->type == "ordinaire")
                    {
                        return "Ordinaire";
                    }else{
                        return "Extraordinaire";
                    }
                })
                ->rawColumns(['actions']);
            ;
        }
        return $datatables->make(true);
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
