<?php

namespace App\Http\Controllers;

use App\Convention;
use App\Demande;
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
        $point_desservis = [];


            if(strpos($piste->geometry,'demande') !== false)
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
                        <div style="width: calc(100% + 18px);background:#4c9505;margin-left:-9px;margin-top:-20px;border-radius: 3px 3px 0px 0px;"> 
                            <h4 class="box-title title-popup">Demande N° : '.$piste->demande->num_ordre.'</h4>
                        </div>
                        <div class="box-body">                            
                            <p class="box-text" style="margin: 4px 0;">
                            <table class="table-responsive" > 
                                <tr> 
                                    <td > 
                                    <h6>OBJET : </h6>                                    
                                    </td>                                    
                                </tr>
                                <tr> 
                                    <td>'.$piste->demande->objet_fr. '</td>
                                </tr>
                                
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



            //coventions
        if(strpos($piste->geometry,'convention') !== false)
        {
            $moas = '';
            $programme = '';

            foreach($piste->convention->communes as $commune){
                array_push($communes,ucfirst($commune->nom_fr));
            }


            foreach($piste->convention->interventions as $interv){
                array_push($interventions,ucfirst($interv->nom));
            }


            foreach($piste->convention->point_desservis as $point){
                array_push($point_desservis,ucfirst($point->nom_fr));
            }


            if($piste->convention->is_project == 1)
            {
                $color = '#434343';
                $item = 'Projet';
            }
            else{
                $color = '#EA3A0A';
                $item = 'Convention';
            }

           // return $piste->convention->programme;
            if($piste->convention->moas)
            {
                $moas = $piste->convention->moas->nom_fr;
            }else{
                $moas;
            }

            if($piste->convention->programme)
            {
                $programme = $piste->convention->programme->nom_fr;
            }else{
                $programme;
            }
            $markup = '<div class="row" style="margin : 0;padding:0">
                <div class="col-md-12 col-lg-12" style="margin : 0;padding:0">
                    <div class="box box-default" style="border: 0;margin:0">                    
                        <div style="width: calc(100% + 18px);background:'.$color.';margin-left:-9px;margin-top:-20px;border-radius: 3px 3px 0px 0px;"> 
                            <h5 class="box-title title-popup">'.$item .' N° : '.$piste->convention->num_ordre.'</h5>
                        </div>
                        <div class="box-body">                            
                            <p class="box-text" style="margin: 4px 0;">
                            <table class="table-responsive" > 
                                <tr> 
                                    <td > 
                                        <h6>M.O.A : </h6>                                    
                                    </td>                                    
                                </tr>
                                <tr> 
                                    <td>'.$moas. '</td>
                                </tr>
                                
                                <tr> 
                                    <td > 
                                        <h6>LIAISON ROUTIERE : </h6>                                    
                                    </td>                                    
                                </tr>
                                <tr> 
                                    <td>'.implode(',',$point_desservis). '</td>
                                </tr>
                                
                                
                                <tr> 
                                    <td > 
                                        <h6>PROGRAMME : </h6>                                    
                                    </td>                                    
                                </tr>
                                <tr> 
                                    <td>'.$programme. '</td>
                                </tr>
                                
                                <tr> 
                                    <td > 
                                        <h6>ANNEE : </h6>                                    
                                    </td>                                    
                                </tr>
                                <tr> 
                                    <td>'.$piste->convention->annee. '</td>
                                </tr>
                                
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
                                <a href="/convention/'.$piste->convention->id.'/edit" class="btn btn-secondary-table"><i class="fa fa-info-circle"></i> <b>Basculer vers les details</b> </a>                             
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

    //get piste with demande or convention id
    public function getPisteCartoDatatables(Request $request)
    {
        if(isset($request->demande_id))
        {
            $demande_id = $request->demande_id;
            //get piste
            $piste = Piste::where('demande_id','=',$demande_id)->get();
        }

        if(isset($request->convention_id))
        {
            $convention_id = $request->convention_id;
            //get piste
            $piste = Piste::where('convention_id','=',$convention_id)->get();
        }


        return response()->json($piste);

    }


    public function pisteFilter(Request $request)
    {
        $name = $request->name;
        $value = $request->value;
        //get piste
        $cnv = Convention::with('piste');

        $pistes = [];
        if($name  == "programme")
        {
            $piste_cnv = $cnv->whereHas('programme',function($query) use ($value){
                $query->where('id','=',$value);
            })->get();


        }
        foreach($piste_cnv as $pist_cnv)
        {
            array_push($pistes,$pist_cnv->piste);

        }

        return response()->json($pistes);
    }


    public function getpistesCarto(Request $request)
    {
        //get pistes
        $pistes = Piste::with('demande','convention')
            ->where('active',1)
            ->get();
        $conventions = Convention::with('programme','moas','interventions','piste','communes','etats')
         //   ->whereHas('etats',function($query){
          //      $query->where('active','=',1);
        //})
            ->get();
        $demandes = Demande::with('interventions','piste','communes')->get();
        return response()->json(['pistes' => $pistes,'conventions' => $conventions,'demandes'=> $demandes]);
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
