<?php

namespace App\Http\Controllers;

use App\Piste;
use Illuminate\Http\Request;


class PisteController extends Controller
{

    /*
     *
     *
     * get of one piste
     * @return Piste
     */

    public function getPisteDataHtml(Request $request)
    {

        $piste = Piste::with('demande','convention')->findOrFail($request->piste_id);
        $markup = '';
        $communes = [];
        $interventions = [];

            if($piste->demande != null)
            {
                foreach($piste->demande->communes as $commune){
                       array_push($communes,ucfirst($commune->nom_fr));
                }

                foreach($piste->demande->interventions as $interv){
                    array_push($interventions,ucfirst($interv->nom));
                }



                $markup = '<div class="row" style="margin : 0;padding:0">
                <div class="col-md-12 col-lg-12" style="margin : 0;padding:0">
                    <div class="box box-default" style="border: 0;margin:0">
                        <div style="width: calc(100% + 18px);background:#363638;margin-left:-9px;margin-top:-20px;border-radius: 3px 3px 0px 0px;"> 
                            <h4 class="box-title title-popup">Demande N° : '.$piste->demande->num_ordre.'</h4>
                        </div>
                        <div class="box-body">                            
                            <p class="box-text" style="margin: 4px 0;">
                            <table class="table-responsive" > 
                                <tr> 
                                    <td > 
                                    <h6>LONGUEUR : </h6>                                    
                                    </td>                                    
                                </tr>
                                <tr> 
                                    <td>'.$piste->longueur. ' KM</td>
                                </tr>
                                
                                <tr> 
                                    <td > 
                                    <h6>MONTANT GLOBAL : </h6>                                    
                                    </td>                                    
                                </tr>
                                <tr> 
                                    <td>'.number_format($piste->demande->montant_global). ' DH</td>
                                </tr>
                                
                                <tr> 
                                    <td > 
                                    <h6>COMMUNES : </h6>
                                    
                                    </td>                                    
                                </tr>
                                <tr>
                                  <td>'.implode(',',$communes).'</td>
                                </tr>
                                <tr> 
                                    <td><h6>INTERVENTIONS</h6></td>                                
                                </tr>
                                <tr> 
                                    <td>'.implode(',',$interventions).'</td>
                                </tr>
                            </table>
                            
                             </p>
                             <div style="text-align: center"> 
                             <a href="/demande/'.$piste->demande->id.'/edit" class="btn btn-secondary-table"><i class="fa fa-info-circle"></i> <b>Basculer vers les details</b> </a>                             
                             </div>
                            
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
                <!-- /.col -->               
            </div>';
            }

            return $markup;


    }





    // get Piste

    public function getPiste(Request $request)
    {
        //get piste
        $piste = Piste::with('demande','convention')
            ->find($request->piste_id);

        return response()->json($piste);

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       //get pistes
        $pistes = Piste::with('demande','convention')
            ->where('active',1)
            ->get();

        return response()->json($pistes);
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
     * @param  \App\Piste  $piste
     * @return \Illuminate\Http\Response
     */
    public function show(Piste $piste)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Piste  $piste
     * @return \Illuminate\Http\Response
     */
    public function edit(Piste $piste)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Piste  $piste
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Piste $piste)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Piste  $piste
     * @return \Illuminate\Http\Response
     */
    public function destroy(Piste $piste)
    {
        //
    }
}
