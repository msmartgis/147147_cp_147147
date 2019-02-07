{!! Form::model($demande, ['route' => ['demandes.update', $demande->id],'method' => 'PUT']) !!}
<div class="row">
    <div class="col-lg-9 col-12">
        <div class="box bg-transparent no-shadow">
            <div class="box-header with-border">
                <h4 class="box-title">LA DEMANDE NUMERO : {{$demande->id}}</h4>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="row" style="margin-top: 8px">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <h6>Objet (fr)</h6>
                            <div class="controls">
                                {{Form::textarea('objet_fr',$demande->objet_fr,['class'=>'form-control','rows'=>'2'])}}
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <h6>Objet (ar)</h6>
                            <div class="controls">
                                {{Form::textarea('objet_ar',$demande->objet_ar,['class'=>'form-control','rows'=>'2'])}}
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /. box -->

        <div class="box box-default  box-solid">
            <div class="box-header with-border">
                <ul class="box-controls">
                    <li><a class="box-btn-slide" href="#"></a></li>
                </ul>
                <h5 class="box-title">TYPES D'INTERVENTIONS</h5>
                <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
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
            <!-- /.box-body -->
        </div>
        <!-- /.box -->

        <div class="box box-default box-solid">
            <div class="box-header with-border">
                <h5 class="box-title">LOCALISATION DU PROJET</h5>
                <ul class="box-controls pull-right">
                    <li><a class="box-btn-slide" href="#"></a></li>
                </ul>
                <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="col-12" style="margin-top : 8px">
                    <div class="form-group">
                        {{Form::label('','Communes:')}}
                        {{Form::select('communes', $communes, $demande->communes->pluck('id'),
                        [
                        'data-placeholder' => 'Selectionner commune(s)',
                        'class'=>'form-control select2',
                        'multiple'=>'multiple',
                        'name'=>'communes[]'
                        ]
                        )}}
                    </div>
                </div>

                <div class="col-12" style="margin-top : 8px">
                    <div class="form-group">
                        {{Form::label('','Localites:')}}
                        {{Form::select('localites', $localites, $demande->point_desservis->pluck('id'),
                        [
                        'data-placeholder' => 'Selectionner commune(s)',
                        'class'=>'form-control select2',
                        'multiple'=>'multiple',
                        'name'=>'localites[]'
                        ]
                        )}}
                    </div>
                </div>
                <div class="col-12">
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
            <!-- /.box-body -->
        </div>
        <!-- /.box -->


        <div class="box box-default box-solid">
            <div class="box-header with-border">
                <h5 class="box-title">PIECES TECHNIQUES</h5>
                <ul class="box-controls pull-right">
                    <li><a class="box-btn-slide" href="#"></a></li>
                </ul>
                <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="col-12" style="margin-top : 8px">
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
                                    <td colspan="4" style="text-align: center"><a href="#" data-toggle="modal"
                                            data-target="#add_modal_piece"> <i class="fa fa-plus"></i>
                                            <b> Ajouter Pièce</b> </a>
                                    </td>
                                </tr>
                            </tbody>

                        </table>
                    </div>
                </div>

            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->


        <div class="box box-default box-solid">
            <div class="box-header with-border">
                <h5 class="box-title">MONTAGE FINANCIER PROPOSE</h5>
                <ul class="box-controls pull-right">
                    <li><a class="box-btn-slide" href="#"></a></li>
                </ul>
                <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="col-12" style="margin-top : 8px">
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
            <!-- /.box-body -->
        </div>
        <!-- /.box -->


        <div class="box box-default box-solid">
            <div class="box-header with-border">
                <h5 class="box-title">Remarques et Observations</h5>
                <ul class="box-controls pull-right">
                    <li><a class="box-btn-slide" href="#"></a></li>
                </ul>
                <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="col-12" style="margin-top : 8px">
                  <div class="form-group">
                    
                    {{Form::textarea('observation', $demande->observation, ['id' => 'editor1', 'class' => 'form-control', 'placeholder' => 'Body Text'])}}
                </div>
                </div>

            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->

    </div>
    <!-- /.col -->
    <div class="col-lg-3 col-12 ">
        <div class="h-p100 p-15 bg-light bg-secondary-gradient">
            <div class="box bg-transparent no-border no-shadow ">
                <div class="box-body no-padding mailbox-nav ">
                    <div class="form-group">
                        {{Form::label('','Date de récéption:')}}
                        <div class="input-group date">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            {{Form::text('date_reception',$demande->date_reception,['class'=>'form-control
                            pull-right','id'=>'datepicker'])}}
                        </div>
                        <!-- /.input group -->
                    </div>

                    <div class="form-group">
                        {{Form::label('','Décision :')}}
                        @switch($demande->decision)
                        @case("en_cours")
                        {{Form::text('','En cours',['class'=>'form-control'])}}
                        @break
                        @case("a_traiter")
                        {{Form::text('','A traiter',['class'=>'form-control'])}}
                        @break
                        @case("accord_definitif")
                        {{Form::text('','Accord définitif',['class'=>'form-control'])}}
                        @break
                        @default
                        {{Form::text('',' ',['class'=>'form-control'])}}
                        @endswitch

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

