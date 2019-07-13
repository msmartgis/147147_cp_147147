
{!! Form::model($convention, ['route' => ['projet.update_projet', $convention->id],'id'=>'form_projet_edit','method' => 'PUT','enctype' => 'multipart/form-data']) !!}
@include('projets.edit.tabs_projet')
<div class="row">
    <div class="col-lg-10">
        <div class="row">
            <div class="col-12">
                <div class="box" style="border-top: 0;border-bottom: 0">
                    <!-- /.box-header -->
                    <div class="box-body">
                    @if($is_mobile == 1)
                        @include('inc.go_back_btn_mobile')
                            @if(empty($convention->appelOffres))
                                <h5 style="text-align: center;background-color: #686868;color: #fff !important;border-radius: 2px;padding: 4px">
                                    PROGRAMME

                                </h5>

                            @else
                                @if($convention->realise == 0)
                                    @if($convention->appelOffres->ordre_service == 1)
                                        <h5 style="text-align: center;background-color: #686868;color: #fff !important;border-radius: 2px;padding: 4px">
                                            EN COURS D'EXECUTION
                                        </h5>
                                    @else
                                        <h5 style="text-align: center;background-color: #686868;color: #fff !important;border-radius: 2px;padding: 4px">
                                            APPEL D'OFFRE
                                        </h5>

                                    @endif
                                @else
                                    <h5 style="text-align: center;background-color: #686868;color: #fff !important;border-radius: 2px;padding: 4px">
                                        REALISE
                                    </h5>
                            @endif
                        @endif
                    @endif
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
                                                        'name'=>'moa',
                                                        'disabled' => 'disabled'
                                                    ]
                                                    )}}
                                                @else
                                                    {{Form::select('moa', $moas,'',
                                                    [
                                                        'data-placeholder' => 'Selectionner commune(s)',
                                                        'class'=>'form-control select2',
                                                        'name'=>'moa',
                                                        'disabled' => 'disabled'
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
                                                    'name'=>'programme',
                                                    'disabled' => 'disabled'
                                                    ]
                                                    )}}
                                                @else
                                                    {{Form::select('programme', $programmes,'',
                                                    [
                                                    'data-placeholder' => 'Selectionner commune(s)',
                                                    'class'=>'form-control select2',
                                                    'name'=>'programme',
                                                    'disabled' => 'disabled'
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
                                    @if($is_mobile == 1)
                                        <div class="row">
                                            <div class="col-lg-6 col-xl-6 col-md-6 col-12">
                                                <div class="form-group">

                                                    <div class="controls">
                                                        {{Form::textarea('objet_fr',$convention->objet_fr,['class'=>'form-control','rows'=>'2','style'=>'height: 52px !important' ,'disabled' => 'disabled'])}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="row" style="margin-top: 8px !important;">
                                            <div class="col-lg-6 col-xl-6 col-md-6 col-12">
                                                <div class="form-group">
                                                    <div class="controls">
                                                        {{Form::textarea('objet_ar',$convention->objet_ar,['class'=>'form-control','rows'=>'2','style'=>'height: 52px !important','disabled' => 'disabled'])}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    @else
                                    <div class="row" style="margin-top: 8px">
                                        <div class="col-lg-6">
                                            <div class="form-group">

                                                <div class="controls">
                                                    {{Form::textarea('objet_fr',$convention->objet_fr,['class'=>'form-control','rows'=>'2','style'=>'height: 52px !important','disabled' => 'disabled'])}}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <div class="controls">
                                                    {{Form::textarea('objet_ar',$convention->objet_ar,['class'=>'form-control','rows'=>'2','style'=>'height: 52px !important','disabled' => 'disabled'])}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
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
                                                'name'=>'interventions[]',
                                                'disabled' => 'disabled'
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
                                                'name'=>'communes[]',
                                                'disabled' => 'disabled'
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
                                                'name'=>'point_desservis[]',
                                                'disabled' => 'disabled'
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
                                            @if($is_mobile == 0)
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
                                            @endif
                                        </div>
                                    </div>
                                    @if($convention->is_project != 0 )
                                        <h5>SITUATION DU PROJET</h5>
                                        <hr>
                                        <div class="row" >
                                            <div class="table-responsive">
                                                <table class="table table-piece">
                                                    <tr style="text-align: center;">
                                                        <th>Nom</th>
                                                        <th>Upload</th>
                                                        @if($is_mobile == 0)
                                                            <th></th>
                                                        @endif
                                                    </tr>
                                                    <tbody id="etat_tbody">
                                                    @foreach ($etats as $item)
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
                                                                A.O Publié
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
                                                            @if($is_mobile == 0)
                                                                <td style="text-align: center">
                                                                    <button type="button" class="btn btn-danger-table delete-etat" data-id="etat_{{$item->id}}" style="display: none;"><i class="fa fa-close"></i>
                                                                        Supprimer</button>
                                                                </td>
                                                            @endif
                                                        </tr>
                                                    @endforeach
                                                    <tr>

                                                    </tr>
                                                    </tbody>
                                                </table>
                                                <div style="text-align: center">
                                                    <a href="#" data-toggle="modal" data-target="#add_modal_etat" style="display: none;"> <i class="fa fa-plus"></i>
                                                        <b> Ajouter Etat</b> </a>
                                                </div>
                                            </div>

                                        </div>
                                    @endif
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
                                                                    <button type="button" class="btn btn-danger-table delete-piece" data-id="conventionPiece_{{$item->id}}" style="display: none;"><i class="fa fa-close"></i>
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
                                                        <a href="#" data-toggle="modal" data-target="#add_modal_piece" style="display: none;"> <i class="fa fa-plus"></i>
                                                            <b> Ajouter Pièce</b> </a>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    @if(!empty($convention->appelOffres))
                                        <div class="row">
                                            <div class="col-12" style="margin-top : 8px">
                                            <h5>DOSSIER DE CONSULTATION DES ENTREPRISES (DCE)</h5>
                                            <hr style="color:#2d353c;margin-top:0px;margin-bottom: 4px">
                                            <div class="table-responsive">
                                                <table class="table table-piece">
                                                    <tr style="text-align: center;">
                                                        <th>Type</th>
                                                        <th>Nom</th>
                                                        <th></th>
                                                        <th></th>
                                                    </tr>
                                                    <tbody id="pieces_tbody_dce_projet">
                                                    @foreach ($convention->appelOffres->dce as $item)
                                                        <tr>
                                                            <td style="text-align: center">
                                                                {{strtoupper($item->document)}}
                                                            </td>
                                                            <td style="text-align: center">
                                                                {{$item->file_name}}
                                                            </td>

                                                            <td style="text-align: center;">
                                                                <a href="/files/download/appel_offres/{{$convention->appelOffres->id}}/{{$item->file_name}}">
                                                                    <button type="button"  class="btn btn-secondary-table " >
                                                                        <i class="fa fa-download"></i>
                                                                        Télécharger</button>
                                                                </a>
                                                            </td>

                                                            <td style="text-align: center">
                                                                <button type="button" class="btn btn-danger-table delete-piece-projet" data-route="{!! route('dce.delete_piece')!!}" data-directory="appel_offres" data-file="{{$item->file_name}}" data-id="{{$item->id}}" style="display: none;"><i class="fa fa-close"></i>
                                                                    Supprimer</button>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    <tr>

                                                    </tr>
                                                    </tbody>
                                                </table>
                                                <div style="text-align: center">
                                                    <a href="#" class="add-piece-projet" data-route="/pieces/add_piece_dce" style="display: none;"> <i class="fa fa-plus"></i>
                                                        <b> Ajouter Pièce</b> </a>
                                                </div>
                                            </div>
                                        </div>
                                        </div>


                                        <div class="row">
                                            <div class="col-12" style="margin-top : 8px">
                                                <h5>DOSSIER DE L'ADJIDUCATAIRE</h5>
                                                <hr style="color:#2d353c;margin-top:0px;margin-bottom: 4px">
                                                <div class="table-responsive">
                                                    <table class="table table-piece">
                                                        <tr style="text-align: center;">
                                                            <th>Type</th>
                                                            <th>Nom</th>
                                                            <th></th>
                                                            <th></th>
                                                        </tr>
                                                        <tbody id="pieces_tbody_adjiducataire_projet">
                                                        @foreach ($convention->appelOffres->dossierAdjiducataire as $item)
                                                            <tr>
                                                                <td style="text-align: center">
                                                                    {{strtoupper($item->document)}}
                                                                </td>
                                                                <td style="text-align: center">
                                                                    {{$item->file_name}}
                                                                </td>

                                                                <td style="text-align: center;">
                                                                    <a href="/files/download/appel_offres/{{$convention->appelOffres->id}}/{{$item->file_name}}">
                                                                        <button type="button"  class="btn btn-secondary-table " >
                                                                            <i class="fa fa-download"></i>
                                                                            Télécharger</button>
                                                                    </a>
                                                                </td>

                                                                <td style="text-align: center">
                                                                    <button type="button" class="btn btn-danger-table delete-piece-projet" data-route="{!! route('dossier_adjiducataire.delete_piece')!!}" data-directory="appel_offres" data-file="{{$item->file_name}}" data-id="{{$item->id}}" style="display: none;"><i class="fa fa-close"></i>
                                                                        Supprimer</button>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                        <tr>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                    <div style="text-align: center">
                                                        <a href="#" class="add-piece-projet"  data-route="/pieces/add_piece_dossier_adjiducataire" style="display: none;"> <i class="fa fa-plus"></i>
                                                            <b> Ajouter Pièce</b> </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

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
                                                                    <button type="button" class="btn btn-danger-table delete-partenaire" data-id="{{$convention->id}}_{{$item->id}}" style="display: none;"><i class="fa fa-close"></i>
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
                                                        <a href="#" data-toggle="modal" data-target="#m-add-partenaire-edit" style="display: none;">
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
                    @if($is_mobile == 0)
                        @include('inc.go_back_btn')

                        @if(empty($convention->appelOffres))
                            <h5 style="text-align: center;background-color: #686868;color: #fff !important;border-radius: 2px;padding: 4px">
                                PROGRAMME

                            </h5>

                            @else
                            @if($convention->realise == 0)
                                @if($convention->appelOffres->ordre_service == 1)
                                    <h5 style="text-align: center;background-color: #686868;color: #fff !important;border-radius: 2px;padding: 4px">
                                        EN COURS D'EXECUTION
                                    </h5>
                                @else
                                    <h5 style="text-align: center;background-color: #686868;color: #fff !important;border-radius: 2px;padding: 4px">
                                        APPEL D'OFFRE
                                    </h5>

                                @endif
                            @else
                                <h5 style="text-align: center;background-color: #686868;color: #fff !important;border-radius: 2px;padding: 4px">
                                    REALISE
                                </h5>
                            @endif
                        @endif

                    @endif


                    <div class="row row-edit" style="margin-top: 8px">
                        <div class="col-lg-3">
                            {{Form::label('','N°:',['style'=> 'font-size : 11px'])}}
                        </div>
                        <div class="col-lg-9">
                            <div class="form-group form-group-edit">
                                {{Form::text('num_ordre',$convention->num_ordre,['class'=>'form-control','disabled'])}}
                            </div>
                        </div>
                    </div>

                    <div class="row row-edit" style="margin-top: 8px">
                        <div class="col-lg-3">
                            {{Form::label('','M.Total(DHS):',['style'=> 'font-size : 11px'])}}
                        </div>
                        <div class="col-lg-9">
                            <div class="form-group form-group-edit">
                                {{Form::text('montant_global',$convention->montant_global,['class'=>'form-control','disabled'])}}
                            </div>
                        </div>
                    </div>



                    <div class="row row-edit" style="margin-top: 8px">
                        <div class="col-lg-3">
                            {{Form::label('','Longueur(KM):',['style'=> 'font-size : 11px'])}}
                        </div>
                        <div class="col-lg-9">
                            <div class="form-group form-group-edit">
                                {{Form::hidden('id_pist',$convention->piste->id,['id' => 'piste_id_input'])}}
                                {{Form::hidden('geometry',$convention->piste->geometry,['id' => 'geometry_input'])}}
                                {{Form::text('longueur',$convention->piste->longueur,['class'=>'form-control','disabled'])}}
                            </div>
                        </div>
                    </div>


                        @if(Auth::user()->organisation_id != 1 )
                            <div class="form-group">
                                {{Form::label('','Année:')}}
                                {{Form::text('annee',$convention->annee,['class'=>'form-control'])}}
                            </div>

                            <div class="form-group">
                                {{Form::label('','Date Commencement:')}}
                                {{Form::text('date_commencement',date('d/m/Y', strtotime($convention->date_commencement)),['class'=>'form-control
                            pull-right','id'=>'datepicker'])}}
                            </div>
                        @endif
                    <br>

                    @if(Auth::user()->organisation_id == $convention->organisation_id  && !empty($convention->appelOffres))
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

                        @if(!empty($convention->appelOffres->adjiducataires))
                            <div class="form-group">
                                {{Form::label('','Adjiducataire:')}}
                                {{Form::text('adjiducataire',$convention->appelOffres->adjiducataires->nom_fr,['class'=>'form-control','readonly'])}}
                            </div>
                        @endif

                        <div class="form-group">
                            {{Form::label('','Montant adjiducation(DH):')}}
                            {{Form::text('montant_adjiducation',number_format($convention->appelOffres->montant_adjiducation),['class'=>'form-control','readonly'])}}
                        </div>

                        <button class="btn btn-secondary-table-table pull-right" style="margin-top: 12px;margin-bottom: 18px;text-decoration: underline !important;">
                            <i class="fa fa-mail-forward"></i>
                            <a href="/appelOffre/{{$convention->appel_offre_id}}/edit">
                                Basculer vers les details de l'appel d'offre
                            </a>
                        </button>
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
                        <h5>Edition : </h5>
                        <hr>
                        <button type="button" id="activate_edit_btn" class="btn  btn-secondary-edit" style="color : #1118c5" ><i class="fa fa-edit" style="margin-right: 8px;"></i>Activer la modification</button>
                        <button type="submit" class="btn  btn-secondary-edit" style="color : #2bc509" ><i class="fa fa-save" style="margin-right: 8px;" disabled></i>Enregistrer les modifications</button>
                    @endif
                    {!! Form::close() !!}



                    @if(!empty($convention->appelOffres))
                        @if($convention->appelOffres->ordre_service == 1)
                                <button type="button" class="btn btn-secondary-edit" id="realise_projet_btn" data-projet_id="{{$convention->id}}" style="margin-top: 8px !important"

                                ><i class="fa fa-thumbs-o-up" style="margin-right: 8px;" disabled></i>Affecter Au projets realisés</button>
                        @endif
                    @endif

                    @if(Auth::user()->organisation_id == $convention->organisation_id )
                        <button type="button" class="btn btn-secondary-edit" id="supprimer_convention" data-id="{{$convention->id}}" style="margin-top: 8px !important;color : #ff0f0f"><i class="fa fa-trash" style="margin-right: 8px;" disabled></i>Supprimer</button>
                    @endif
                    <h5>Documents : </h5>
                    <hr>
                    <button type="button" class="btn  btn-secondary-edit" style="color : #1118c5" ><i class="fa fa-file" style="margin-right: 8px;"></i>Fiche de la demande</button>
                    <br>

                </div>
                <!-- /.box-body -->
            </div>
            <!-- /. box -->
        </div>
    </div>
    <!-- /.col -->
</div>
<!-- /.row -->

