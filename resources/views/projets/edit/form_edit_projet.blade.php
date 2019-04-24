
{!! Form::model($convention, ['route' => ['projet.update_projet', $convention->id],'method' => 'PUT','enctype' => 'multipart/form-data']) !!}
@include('projets.edit.tabs_projet')
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
                                                {{Form::select('moa', $moas, $convention->moas->id,
                                                [
                                                'data-placeholder' => 'Selectionner MOA',
                                                'class'=>'form-control select2',
                                                'name'=>'moa'
                                                ]
                                                )}}
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
                                                {{Form::select('programme', $programmes, $convention->programme->id,
                                                [
                                                'data-placeholder' => 'Selectionner commune(s)',
                                                'class'=>'form-control select2',
                                                'name'=>'programme'
                                                ]
                                                )}}
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
                                                {{Form::label('','Localites:')}}
                                                {{Form::select('localites', $localites, $convention->point_desservis->pluck('id'),
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

                                    <h5>SITUATION DU PROJET</h5>
                                    <hr>
                                    <div class="row" >
                                        <div class="table-responsive">
                                            <table class="table table-piece">
                                                <tr style="text-align: center;">
                                                    <th>Nom</th>
                                                    <th>Upload</th>
                                                    <th></th>
                                                </tr>
                                                <tbody id="etat_tbody">
                                                @foreach ($convention->etats as $item)
                                                    <tr>
                                                        <td style="text-align: center">
                                                            @switch($item->nom)
                                                            @case ('programme')
                                                            Programmé
                                                            @break
                                                            @case  ('en_cours_execution')
                                                            En cours d'execution
                                                            @break
                                                            @case ('a.o_pulie')
                                                            A.O Publi
                                                            @break
                                                            @case ('plis_ouvert')
                                                            Plis ouvert
                                                            @break
                                                            @case ('a.o_attribue')
                                                            A.O Attribué
                                                            @break
                                                            @case ('a.o_reporte')
                                                            A.O Reporté
                                                            @break
                                                            @case ('a.o_annule')
                                                            A.O Annule
                                                            @break
                                                            @case ('en_retard')
                                                            En retard
                                                            @break
                                                            @case ('en_etat_arret')
                                                            En état d'arrêt
                                                            @break
                                                            @case ('realise')
                                                            Réalisé
                                                            @break
                                                            @default

                                                            @endswitch

                                                        </td>

                                                        <td style="text-align: center">
                                                            {{$item->date}}
                                                        </td>

                                                        <td style="text-align: center">
                                                            <button type="button" class="btn btn-danger-table delete-etat" data-id="etat_{{$item->id}}"><i class="fa fa-close"></i>
                                                                Supprimer</button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                <tr>

                                                </tr>
                                                </tbody>
                                            </table>
                                            <div style="text-align: center">
                                                <a href="#" data-toggle="modal" data-target="#add_modal_etat"> <i class="fa fa-plus"></i>
                                                    <b> Ajouter Etat</b> </a>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            {{--tab localisation de projet--}}
                            <div class="tab-pane " id="dossier_technique_fincancier_tab" role="tabpanel">
                                <div class="pad">
                                    <div class="row">
                                        <div class="col-12" style="margin-top : 8px">
                                            <h5>DOSSIER TECHNIQUE</h5>
                                            <hr style="color:#2d353c;margin-top:0px;margin-bottom: 4px">
                                            <div class="table-responsive">
                                                <table class="table table-piece">
                                                    <tr style="text-align: center;">
                                                        <th>Nom</th>
                                                        <th>Upload</th>
                                                        @if(Auth::user()->organisation_id == $convention->organisation_id )
                                                            <th></th>
                                                            <th></th>
                                                        @endif
                                                    </tr>
                                                    <tbody id="pieces_tbody">
                                                    @foreach ($convention->piece as $item)
                                                        <tr>
                                                            <td style="text-align: center">
                                                                {{strtoupper($item->type)}}
                                                            </td>

                                                            <td style="text-align: center">
                                                                {{$item->path}}
                                                            </td>
                                                            @if(Auth::user()->organisation_id == $convention->organisation_id )
                                                                <td style="text-align: center;">
                                                                    <a href="/files/download/conventions/{{$convention->id}}/{{$item->path}}">
                                                                        <button type="button"  class="btn btn-secondary-table " >
                                                                            <i class="fa fa-download"></i>
                                                                            Télécharger</button>
                                                                    </a>
                                                                </td>
                                                                <td style="text-align: center">
                                                                    <button type="button" class="btn btn-danger-table delete-piece" data-id="conventionPiece_{{$item->id}}"><i class="fa fa-close"></i>
                                                                        Supprimer</button>
                                                                </td>
                                                            @endif
                                                        </tr>
                                                    @endforeach
                                                    <tr>

                                                    </tr>
                                                    </tbody>
                                                </table>
                                                @if(Auth::user()->organisation_id == $convention->organisation_id )
                                                    <div style="text-align: center">
                                                        <a href="#" data-toggle="modal" data-target="#add_modal_piece"> <i class="fa fa-plus"></i>
                                                            <b> Ajouter Pièce</b> </a>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row">
                                        <div class="col-12" style="margin-top : 8px">
                                            <h5>MONTAGE FINANCIER</h5>
                                            <hr style="color:#2d353c;margin-top:0px;margin-bottom: 4px">
                                            <div class="table-responsive">
                                                <table class="table table-piece">
                                                    <tr style="text-align: center;">
                                                        <th>Nom partenaire</th>
                                                        <th>Montant(DH)</th>
                                                        <th>Pourcentage(%)</th>
                                                        @if(Auth::user()->organisation_id == $convention->organisation_id )
                                                            <th></th>
                                                        @endif
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
                                                            @if(Auth::user()->organisation_id == $convention->organisation_id )
                                                                <td style="text-align: center">
                                                                    <button type="button" class="btn btn-danger-table delete-partenaire" data-id="{{$convention->id}}_{{$item->id}}"><i class="fa fa-close"></i>
                                                                        Supprimer</button>
                                                                </td>
                                                            @endif
                                                        </tr>
                                                    @endforeach
                                                    <tr>

                                                    </tr>
                                                    </tbody>
                                                </table>
                                                @if(Auth::user()->organisation_id == $convention->organisation_id )
                                                    <div style="text-align: center">
                                                        <a href="#" data-toggle="modal" data-target="#m-add-partenaire-edit">
                                                            <i class="fa fa-plus"></i>
                                                            <b> Ajouter Partenaire</b>
                                                        </a>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>


                                    <h5>GALERIES</h5>
                                    <hr>
                                    <div class="row">
                                        <br>
                                        <br>
                                        @if(count($convention->galleries) != null)
                                            <div class="container" style="margin-top: 8px">
                                                <div class="row">
                                                    <div class="col-lg-10">
                                                        <div class="main-img" style="border: #b0acac solid 1px;width:100%">
                                                            <img src="{{ url('storage/uploaded_files/galleries/projets_partenaire/'.$convention->id.'/'.$convention->galleries[0]['filename']) }}" id="current" data-convention = "{{$convention->id}}" data-filename ="{{$convention->galleries[0]['filename']}}">
                                                            @if(Auth::user()->organisation_id == $convention->organisation_id )
                                                                <a href="#" class="main-img-download" style="margin-left: 8px"><img src="{{asset('images/svg/download.svg')}}" style="width:50px;height:50px;"></a>
                                                                <a href="#" class="main-img-delete" style="margin-left: 8px"><img src="{{asset('images/svg/delete.svg')}}" style="width:50px;height:50px;"></a>
                                                            @endif
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-2">
                                                        <div class="imgs" style="margin-left: 8px;width : 100% !important;">
                                                            <table>
                                                                <tr>
                                                                    <th></th>
                                                                </tr>

                                                            @foreach($convention->galleries as $image)
                                                                <tr>
                                                                    <td>
                                                                        <img class="m-img" data-id="{{$convention->id}}" src="{{ url('storage/uploaded_files/galleries/projets_partenaire/thumbnail/'.$convention->id.'/'.$image->filename) }}" style="vertical-align: middle;width: 100px;height: 100px">
                                                                    </td>
                                                                </tr>

                                                            @endforeach
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <p style="padding : 8px">Aucune image Actuellement</p>
                                        @endif
                                    </div>

                                    <br>
                                    <div class="row" style="margin-top: 8px">
                                        <div class="col-lg-2">
                                            <label for="">Ajouter Images</label>
                                        </div>
                                       <input type="file"  name="imagesToUpload[]" multiple="multiple" accept="image/*" id="imagesToUpload"/>
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
                <div class="box-body no-padding mailbox-nav ">


                    <div class="form-group">
                        {{Form::label('','N°:')}}
                        {{Form::text('num_ordre',$convention->num_ordre,['class'=>'form-control','disabled'])}}
                    </div>

                    <div class="form-group">
                        {{Form::label('','Montant global DH:')}}
                        {{Form::text('montant_global',$convention->montant_global,['class'=>'form-control'])}}
                    </div>

                    <div class="form-group">
                        {{Form::hidden('id_pist',$convention->piste->id)}}
                        {{Form::label('','Longueur:')}}
                        {{Form::text('longueur',$convention->piste->longueur,['class'=>'form-control'])}}
                    </div>
                    <br>

                    @if($convention->is_project  != 1)
                        <div class="form-group">
                            {{Form::label('','Date publication:')}}
                            {{Form::text('date_publication',$convention->appelOffres->date_publication,['class'=>'form-control','readonly'])}}
                        </div>

                        <div class="form-group">
                            {{Form::label('','Date ouverture des plis:')}}
                            {{Form::text('date_ouverture_plis',$convention->appelOffres->date_ouverture_plis,['class'=>'form-control','readonly'])}}
                        </div>

                        <div class="form-group">
                            {{Form::label('','Caution provisoire(DH):')}}
                            {{Form::text('caution_provisoir',number_format($convention->appelOffres->caution_provisoir),['class'=>'form-control','readonly'])}}
                        </div>

                        <div class="form-group">
                            {{Form::label('','Durée d\'execution:')}}
                            {{Form::text('duree_execution',$convention->appelOffres->duree_execution,['class'=>'form-control','readonly'])}}
                        </div>

                        <br>
                        <div class="form-group">
                            {{Form::label('','Adjiducataire:')}}
                            {{Form::text('adjiducataire',$convention->appelOffres->adjiducataires->nom_fr,['class'=>'form-control','readonly'])}}
                        </div>
                        <div class="form-group">
                            {{Form::label('','Montant adjiducation(DH):')}}
                            {{Form::text('montant_adjiducation',number_format($convention->appelOffres->montant_adjiducation),['class'=>'form-control','readonly'])}}
                        </div>
                    @endif

                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    @if(Auth::user()->organisation_id == $convention->organisation_id )
                        {{Form::submit('Modifier/Telecharger image',['class'=>'btn btn-secondary col-12','style'=>'margin-top : 8px !important'])}}
                    @endif
                    {!! Form::close() !!}

                    @if(Auth::user()->organisation_id == $convention->organisation_id )
                        <button type="button" class="btn btn-warning col-12" id="supprimer_convention" data-id="{{$convention->id}}" style="margin-top: 8px !important">Supprimer</button>
                    @endif
                    {!! Form::model($convention, ['route' => ['convention.fiche', $convention->id],'method' => 'PUT']) !!}
                    {{Form::submit('Fiche de projet',['class'=>'btn btn-secondary col-12','style'=>'margin-top : 8px !important'])}}
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

