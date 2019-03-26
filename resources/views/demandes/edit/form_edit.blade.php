
{!! Form::model($demande, ['route' => ['demande.update', $demande->id],'method' => 'PUT']) !!}


<div class="row">
    <div class="col-lg-10">
        <div class="row">
            <div class="col-12">
                <div class="box" style="border-top: 0;border-bottom: 0">
                    <!-- /.box-header -->
                    <div class="box-body">
                    <!-- Tab panes -->
                        <div class="tab-content">
                            {{--tab informations generales--}}
                            <div class="tab-pane active" id="information_generale_tab" role="tabpanel">
                                <div class="pad">
                                    <h5>PORTEUR DE PROJET </h5>
                                    <hr style="color:#2d353c;margin:0">
                                    <div class="row" style="margin-top: 8px">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                {{Form::hidden('id_porteur',$demande->porteur->id)}}
                                                {{Form::hidden('nom_porteur_fr_old',$demande->porteur->nom_porteur_fr)}}
                                                <div class="controls">
                                                    {{Form::textarea('nom_porteur_fr',$demande->porteur->nom_porteur_fr,['class'=>'form-control','rows'=>'2','style'=>'height: 52px !important'])}}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <div class="controls">
                                                    {{Form::textarea('nom_porteur_ar',$demande->porteur->nom_porteur_ar,['class'=>'form-control','rows'=>'2','style'=>'height: 52px !important'])}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <h5>OBJET</h5>
                                    <hr style="color:#2d353c;margin:0">
                                    <div class="row" style="margin-top: 8px">
                                        <div class="col-lg-6">
                                            <div class="form-group">

                                                <div class="controls">
                                                    {{Form::textarea('objet_fr',$demande->objet_fr,['class'=>'form-control','rows'=>'2','style'=>'height: 52px !important'])}}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <div class="controls">
                                                    {{Form::textarea('objet_ar',$demande->objet_ar,['class'=>'form-control','rows'=>'2','style'=>'height: 52px !important'])}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.row -->
                                    <div class="row">
                                        <div class="col-12" style="margin-top : 8px">
                                            <div class="form-group">
                                                {{Form::label('','Interventions:')}}

                                                {{Form::select('interventions', $interventions, $demande->interventions->pluck('id'),
                                                [
                                                'data-placeholder' => 'Selectionner commune(s)',
                                                'class'=>'form-control select2',
                                                'multiple'=>'multiple',
                                                'name'=>'interventions[]'
                                                ]
                                                )}}
                                            </div>
                                        </div>

                                    </div>



                                    <div class="row">
                                        <div class="col-12" style="margin-top : 8px">
                                            <h5>PIECES TECHNIQUES</h5>
                                            <hr style="color:#2d353c;margin-top:0px;margin-bottom: 4px">
                                            <div class="table-responsive">
                                                <table class="table table-piece">
                                                    <tr style="text-align: center;">
                                                        <th>Type</th>
                                                        <th>Nom</th>
                                                        <th>Upload</th>
                                                        <th></th>
                                                    </tr>
                                                    <tbody id="pieces_tbody">
                                                    @foreach ($demande->piece as $item)
                                                        <tr>
                                                            <td style="text-align: center">

                                                                @switch($item->type)
                                                                @case("etude")
                                                                Etude
                                                                @break
                                                                @case("fiche_technique")
                                                                Fiche Technique
                                                                @break
                                                                @default
                                                                Etude
                                                                @endswitch
                                                            </td>
                                                            <td style="text-align: center">

                                                                @switch($item->nom)
                                                                @case("approuve")
                                                                Approuvée
                                                                @break
                                                                @case("disponible")
                                                                Disponible
                                                                @break
                                                                @case("en_cours_approbation")
                                                                En cour d'approbation
                                                                @break
                                                                @default
                                                                Approuvée
                                                                @endswitch
                                                            </td>
                                                            <td style="text-align: center">
                                                                {{$item->path}}
                                                            </td>
                                                            <td style="text-align: center">
                                                                <button type="button" class="btn btn-warning delete-piece" data-id="{{$item->id}}"><i class="fa fa-close"></i>
                                                                    Supprimer</button>
                                                            </td>
                                                        </tr>
                                                    @endforeach

                                                    <tr>
                                                        <td colspan="4" style="text-align: center">
                                                            <a href="#" data-toggle="modal" data-target="#add_modal_piece"> <i class="fa fa-plus"></i>
                                                                <b> Ajouter Pièce</b> </a>
                                                        </td>
                                                    </tr>
                                                    </tbody>

                                                </table>
                                            </div>
                                        </div>

                                    </div>


                                    <div class="row">
                                        <div class="col-12" style="margin-top : 8px">
                                            <h5>MONTAGE FINANCIER PROPOSE</h5>
                                            <hr style="color:#2d353c;margin-top:0px;margin-bottom: 4px">
                                            <div class="table-responsive">
                                                <table class="table table-piece">
                                                    <tr style="text-align: center;">
                                                        <th>Nom partenaire</th>
                                                        <th>Montant(DH)</th>
                                                        <th>Pourcentage(%)</th>
                                                        <th></th>
                                                    </tr>
                                                    <tbody id="partenaire_tbody">
                                                    @foreach ($demande->partenaires as $item)
                                                        <tr>
                                                            <td style="text-align: center">
                                                                {{$item->nom_fr}}
                                                            </td>
                                                            <td style="text-align: center">
                                                                {{number_format($item->pivot->montant,2)}}

                                                            </td>
                                                            <td style="text-align: center">
                                                                {{number_format($item->pivot->montant/($demande->montant_global)*100,2)}}
                                                            </td>
                                                            <td style="text-align: center">
                                                                <button type="button" class="btn btn-warning delete-partenaire" data-demande="{{$demande->id}}" data-partenaire="{{$item->id}}"><i class="fa fa-close"></i>
                                                                    Supprimer</button>
                                                            </td>
                                                        </tr>
                                                    @endforeach

                                                    <tr>
                                                        <td colspan="4" style="text-align: center"><a href="#" data-toggle="modal"
                                                                                                      data-target="#m-add-partenaire-edit"> <i class="fa fa-plus"></i>
                                                                <b> Ajouter Partenaire</b> </a>
                                                        </td>
                                                    </tr>
                                                    </tbody>

                                                </table>
                                            </div>
                                        </div>

                                    </div>


                                </div>
                            </div>

                            {{--tab localisation de projet--}}
                            <div class="tab-pane " id="localisation_projet_tab" role="tabpanel">
                                <div class="pad">

                                        <div class="row" style="margin-top: 8px">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    {{Form::label('','Communes:')}}
                                                    {{Form::select('communes', $communes, $demande->communes->pluck('id'),
                                                    [
                                                    'data-placeholder' => 'Selectionner commune(s)',
                                                    'class'=>'form-control select2',
                                                    'style'=>'width:100%',
                                                    'multiple'=>'multiple',
                                                    'name'=>'communes[]'
                                                    ]
                                                    )}}
                                                </div>
                                            </div>
                                        </div>


                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                {{Form::label('','Localites:')}}
                                                {{Form::select('localites', $localites, $demande->point_desservis->pluck('id'),
                                                [
                                                'data-placeholder' => 'Selectionner commune(s)',
                                                'class'=>'form-control select2 ',
                                                'style'=>'width:100%',
                                                'multiple'=>'multiple',
                                                'name'=>'localites[]'
                                                ]
                                                )}}
                                            </div>
                                        </div>
                                    </div>

                                    <h5>LOCALISATION SUR LA CARTE </h5>
                                    <hr style="color:#2d353c;margin:0">
                                    <div class="row">
                                        <div class=" col-12">
                                            <div id="map" style="border: solid 1px #666666;box-shadow: 0px 5px 20px rgba(0, 0, 0, 0.05);"></div>

                                            <div class="cmodali active" style=" width: 300px;  height: 100px;left:calc(100% - 320px);top:calc(100% - 72px);z-index:1;">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <img id="satellite_btn" cl class="baselayer_btn active" src="{{asset('images/satellite.png')}}" />
                                                    </div>
                                                    <div class="col-md-3">
                                                        <img id="hybrid_btn" class="baselayer_btn" src="{{asset('images/hybrid.png')}}" />
                                                    </div>
                                                    <div class="col-md-3">
                                                        <img id="road_btn" class="baselayer_btn" src="{{asset('images/road.png')}}" />
                                                    </div>
                                                    <div class="col-md-3">
                                                        <img id="none_btn" class="baselayer_btn" src="{{asset('images/none.png')}}" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>


                            {{--tab observation et remarques--}}
                            <div class="tab-pane" id="observation_remarques_tab" role="tabpanel">
                                <div class="pad">

                                    <div class="col-12" style="margin-top : 8px">
                                        <div class="form-group">

                                            {{Form::textarea('observation', $demande->observation, ['id' => 'editor1', 'class' => 'form-control', 'placeholder' => 'Body Text'])}}
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </div>

    </div>
    <!-- /.col -->
    <div class="col-lg-2" style="padding-left: 0px !important;">
        <div class="h-p100  bg-light bg-secondary-gradient" style="padding-right: 5px">
            <div class="box bg-transparent no-border no-shadow ">
                <div class="box-body no-padding mailbox-nav ">
                    <h5 style="text-align: center;background-color: #686868;color: #fff !important;border-radius: 2px;padding: 4px">
                        @switch($demande->decision)
                        @case("en_cours")
                        En cours
                        @break
                        @case("a_traiter")
                        A traiter
                        @break
                        @case("accord_definitif")
                        Accord définitif
                        @break
                        @default

                        @endswitch
                    </h5>

                    <div class="form-group">
                        {{Form::label('','Demande N°:')}}
                        {{Form::text('num_ordre',$demande->num_ordre,['class'=>'form-control'])}}
                    </div>
                    <div class="form-group">
                        {{Form::label('','Date de récéption:')}}
                        <div class="input-group date">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            {{Form::text('date_reception',date('d/m/Y', strtotime($demande->date_reception)),['class'=>'form-control
                            pull-right','id'=>'datepicker'])}}
                        </div>
                        <!-- /.input group -->
                    </div>



                    <div class="form-group">
                        {{Form::label('','Montant global DH:')}}
                        {{Form::text('montant_global',$demande->montant_global,['class'=>'form-control'])}}
                    </div>

                    <div class="form-group">
                        {{Form::hidden('id_pist',$demande->piste->id)}}
                        {{Form::label('','Longueur:')}}
                        {{Form::text('longueur',$demande->piste->longueur,['class'=>'form-control'])}}
                    </div>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>

                    {{Form::submit('Modifier',['class'=>'btn btn-secondary col-12','style'=>'margin-top : 8px !important'])}}
                    {!! Form::close() !!}                    
                <button type="button" id="affect_aux_convention_btn" data-id="{{$demande->id}}" data-numero="{{$demande->num_ordre}}" class="btn btn-secondary col-12" style="margin-top: 8px !important" @if ($demande->decision != "accord_definitif")
                        disabled
                    @endif>Affectation aux conventions</button>

                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle col-md-12" type="button" data-toggle="dropdown" style="margin-top:8px !important">Décision</button>
                        <div class="dropdown-menu col-md-12">
                            <a class="dropdown-item" href="#">
                            <div @if($demande->decision == "a_traiter" || $demande->decision == "en_cours")
                        id="accord_definitif" 
                    @endif data-id="{{$demande->id}}"><i class="fa fa-thumbs-up"></i> Accord défintif</div>
                            </a>
                            <a class="dropdown-item" href="#" >
                                <div @if($demande->decision == "accord_definitif" || $demande->decision == "en_cours")
                        id="a_traiter"
                    @endif  data-id="{{$demande->id}}"><i class="fa fa-clock-o"></i> A traiter</div>
                            </a>

                        </div>
                    </div>

                    <button type="button" class="btn btn-secondary col-12" id="restaurer" data-id="{{$demande->id}}" style="margin-top: 8px !important" @if ($demande->decision == "en_cours")
                        disabled
                    @endif>Restaurer (En cours)</button>

                    <button type="button" class="btn btn-warning col-12" id="supprimer_demande" data-id="{{$demande->id}}" style="margin-top: 8px !important">Supprimer</button>
                
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /. box -->
        </div>
    </div>
    <!-- /.col -->
</div>
<!-- /.row -->

