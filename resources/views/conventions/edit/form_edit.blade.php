
{!! Form::model($convention, ['route' => ['convention.update', $convention->id],'method' => 'PUT']) !!}
@include('conventions.edit.tabs')
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
                                    <h5>Maitre D'OUVRAGE </h5>
                                    <hr style="color:#2d353c;margin:0">
                                    <div class="row" style="margin-top: 8px">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                @if(!empty($convention->moas))
                                                    {{Form::select('moa', $moas,$convention->moas->id,
                                                    [
                                                        'data-placeholder' => 'Selectionner commune(s)',
                                                        'class'=>'form-control select2',
                                                        'name'=>'moa'
                                                    ]
                                                    )}}
                                                @else
                                                    {{Form::select('moa', $moas,'',
                                                    [
                                                        'data-placeholder' => 'Selectionner commune(s)',
                                                        'class'=>'form-control select2',
                                                        'name'=>'moa'
                                                    ]
                                                    )}}
                                                @endif

                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                        </div>
                                    </div>


                                    <h5>PROGRAMME </h5>
                                    <hr style="color:#2d353c;margin:0">
                                    <div class="row" style="margin-top: 8px">
                                        <div class="col-lg-6">
                                            <div class="form-group">

                                                @if(!empty($convention->programme))
                                                    {{Form::select('programme', $programmes, $convention->programme->id,
                                                    [
                                                    'data-placeholder' => 'Selectionner commune(s)',
                                                    'class'=>'form-control select2',
                                                    'name'=>'programme'
                                                    ]
                                                    )}}
                                                @else
                                                    {{Form::select('programme', $programmes,'',
                                                    [
                                                    'data-placeholder' => 'Selectionner commune(s)',
                                                    'class'=>'form-control select2',
                                                    'name'=>'programme'
                                                    ]
                                                    )}}
                                                @endif


                                            </div>
                                        </div>
                                        <div class="col-lg-6">

                                        </div>
                                    </div>

                                    <h5>OBJET</h5>
                                    <hr style="color:#2d353c;margin:0">
                                    <div class="row" style="margin-top: 8px">
                                        <div class="col-lg-6">
                                            <div class="form-group">

                                                <div class="controls">
                                                    {{Form::textarea('objet_fr',$convention->objet_fr,['class'=>'form-control','rows'=>'2','style'=>'height: 52px !important'])}}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <div class="controls">
                                                    {{Form::textarea('objet_ar',$convention->objet_ar,['class'=>'form-control','rows'=>'2','style'=>'height: 52px !important'])}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.row -->
                                    <h5>INTERVENTIONS </h5>
                                    <hr style="color:#2d353c;margin:0">
                                    <div class="row">
                                        <div class="col-12" style="margin-top : 8px">
                                            <div class="form-group">
                                                {{Form::select('interventions', $interventions, $convention->interventions->pluck('id'),
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
                                                        <th></th>
                                                    </tr>
                                                    <tbody id="pieces_tbody">
                                                    @foreach ($convention->piece as $item)
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
                                                            <td style="text-align: center;">
                                                                    <a href="/files/download/conventions/{{$convention->id}}/{{$item->path}}">
                                                                        <button type="button"  class="btn btn-secondary-table " >
                                                                            <i class="fa fa-download"></i>
                                                                            Télécharger</button>
                                                                    </a>

                                                            </td>
                                                            <td style="text-align: center">
                                                                <button type="button" class="btn btn-danger-table delete-piece" data-file_name="{{$item->path}}" data-file_id="{{$item->id}}"  data-directory="conventions" data-object_id="{{$convention->id}}"><i class="fa fa-close"></i>
                                                                    Supprimer</button>
                                                            </td>
                                                        </tr>
                                                    @endforeach

                                                    <tr>

                                                    </tr>
                                                    </tbody>
                                                </table>
                                                <div style="text-align: center">
                                                    <a href="#" data-toggle="modal" data-target="#add_modal_piece"> <i class="fa fa-plus"></i>
                                                        <b> Ajouter Pièce</b> </a>
                                                </div>

                                            </div>
                                        </div>
                                    </div>


                                    <div class="row">
                                        <div class="col-12" style="margin-top : 8px">
                                            <h5>MONTAGE FINANCIER DEFINITIF</h5>
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
                                                    @foreach ($convention->partenaires as $item)
                                                        <tr>
                                                            <td style="text-align: center">
                                                                {{$item->nom_fr}}
                                                            </td>
                                                            <td style="text-align: center">
                                                                {{number_format($item->pivot->montant,2)}}

                                                            </td>
                                                            <td style="text-align: center">
                                                                {{number_format($item->pivot->montant/($convention->montant_global)*100,2)}}
                                                            </td>
                                                            <td style="text-align: center">
                                                                <button type="button" class="btn btn-danger-table delete-partenaire" data-id="{{$convention->id}}_{{$item->id}}"><i class="fa fa-close"></i>
                                                                    Supprimer</button>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    <tr>

                                                    </tr>
                                                    </tbody>
                                                </table>
                                                <div style="text-align: center">
                                                    <a href="#" data-toggle="modal" data-target="#m-add-partenaire-edit">
                                                        <i class="fa fa-plus"></i>
                                                        <b> Ajouter Partenaire</b>
                                                    </a>
                                                </div>
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
                                                {{Form::select('communes', $communes, $convention->communes->pluck('id'),
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
                                                {{Form::label('','POINTS DESSERVIS:')}}
                                                {{Form::select('point_desservis', $point_desservis, $convention->point_desservis->pluck('id'),
                                                [
                                                'data-placeholder' => 'Selectionner commune(s)',
                                                'class'=>'form-control select2 ',
                                                'style'=>'width:100%',
                                                'multiple'=>'multiple',
                                                'name'=>'point_desservis[]'
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

                                            {{Form::textarea('observation', $convention->observation, ['id' => 'editor1', 'class' => 'form-control', 'placeholder' => 'Body Text'])}}
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
                <div class="box-body no-padding mailbox-nav">

                    <div class="form-group">
                        {{Form::label('','N°:')}}
                        {{Form::text('num_ordre',$convention->num_ordre,['class'=>'form-control'])}}
                    </div>


                    <div class="form-group">
                        {{Form::label('','Montant global DH:')}}
                        {{Form::text('montant_global',$convention->montant_global,['class'=>'form-control'])}}
                    </div>

                    <div class="form-group">
                        {{Form::hidden('id_pist',$convention->piste->id,['id' => 'piste_id_input'])}}
                        {{Form::hidden('geometry','',['id' => 'geometry_input'])}}
                        {{Form::label('','Longueur:')}}
                        {{Form::text('longueur',$convention->piste->longueur,['class'=>'form-control','id'=>'longueur_input'])}}
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

                    {{Form::submit('Enregistrer les modifications',['class'=>'btn btn-secondary col-12','style'=>'margin-top : 8px !important'])}}
                    {!! Form::close() !!}


                    <button type="button" class="btn btn-warning col-12" id="supprimer_convention" data-id="{{$convention->id}}" style="margin-top: 8px !important">Supprimer</button>

                    {!! Form::model($convention, ['route' => ['convention.fiche', $convention->id],'method' => 'PUT']) !!}
                    {{Form::submit('Fiche de la convention',['class'=>'btn btn-secondary col-12','style'=>'margin-top : 8px !important'])}}
                    {!! Form::close() !!}

                </div>
                <!-- /.box-body -->
            </div>
            <!-- /. box -->
        </div>
    </div>
    <!-- /.col -->
</div>
<!-- /.row -->

