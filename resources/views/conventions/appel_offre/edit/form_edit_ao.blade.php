
{!! Form::model($appelOffre, ['route' => ['appelOffre.update', $appelOffre->id],'id'=>'form_ao_edit','method' => 'PUT']) !!}

<div class="row">
    <div class="col-lg-10">
        <div class="row">
            <div class="col-12">
                <div class="box" style="border-top: 0;border-bottom: 0">
                    <!-- /.box-header -->
                    <div class="box-body">
                    @if($is_mobile == 1)
                        @include('inc.go_back_btn_mobile')
                    @endif
                    <!-- Tab panes -->
                        <div class="tab-content">
                            {{--tab informations generales--}}
                            <div class="tab-pane active" id="projet_tab" role="tabpanel">
                                <div class="pad">
                                    @if($is_mobile == 1)
                                        <h4 style="text-align: center;text-decoration: underline">PROJETS CONCERNES</h4>
                                    @endif
                                    <h5>OBJET </h5>
                                    <hr style="color:#2d353c;margin:0">
                                    @if($is_mobile == 1)
                                        <div class="row">
                                            <div class="col-lg-6 col-xl-6 col-md-6 col-12">
                                                <div class="form-group">

                                                    <div class="controls">
                                                        {{Form::textarea('objet_fr',$appelOffre->objet_fr,['class'=>'form-control','rows'=>'2','style'=>'height: 52px !important' ,'disabled' => 'disabled'])}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="row" style="margin-top: 8px !important;">
                                            <div class="col-lg-6 col-xl-6 col-md-6 col-12">
                                                <div class="form-group">
                                                    <div class="controls">
                                                        {{Form::textarea('objet_ar',$appelOffre->objet_ar,['class'=>'form-control','rows'=>'2','style'=>'height: 52px !important','disabled' => 'disabled'])}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <div class="row" style="margin-top: 8px">
                                            <div class="col-lg-6">
                                                <div class="form-group">

                                                    <div class="controls">
                                                        {{Form::textarea('objet_fr',$appelOffre->objet_fr,['class'=>'form-control','rows'=>'2','style'=>'height: 52px !important','disabled'=>'disabled'])}}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <div class="controls">
                                                        {{Form::textarea('objet_ar',$appelOffre->objet_ar,['class'=>'form-control','rows'=>'2','style'=>'height: 52px !important','disabled'=>'disabled'])}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif


                                    <h5>Maitre D'OUVRAGE </h5>
                                    <hr style="color:#2d353c;margin:0">
                                    <div class="row" style="margin-top: 8px">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                {{Form::select('moa', $moas_edit, $appelOffre->moas->id,
                                                [
                                                'data-placeholder' => 'Selectionner commune(s)',
                                                'class'=>'form-control select2',
                                                'name'=>'moa',
                                                'style'=> 'width : 100%',
                                                'disabled'=>'disabled'
                                                ]
                                                )}}
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                        </div>
                                    </div>

                                    <h5>COMMUNES CONCERNEES </h5>
                                    <hr style="color:#2d353c;margin:0">
                                    <div class="row">
                                        <div class="col-12" style="@if($is_mobile == 0) margin-top : 8px @endif">
                                            <div class="form-group">
                                                {{Form::select('interventions', $communes,$communes_concernees,
                                                [
                                                'data-placeholder' => 'Selectionner commune(s)',
                                                'class'=>'form-control select2',
                                                'multiple'=>'multiple',
                                                'name'=>'communes[]',
                                                'disabled' => true
                                                ]
                                                )}}
                                            </div>
                                        </div>
                                    </div>

                                    <h5>INTERVENTIONS </h5>
                                    <hr style="color:#2d353c;margin:0">
                                    <div class="row">
                                        <div class="col-12" style="@if($is_mobile == 0) margin-top : 8px @endif">
                                            <div class="form-group">
                                                {{Form::select('interventions', $interventions,$interventions_ids,
                                                [
                                                'data-placeholder' => 'Selectionner commune(s)',
                                                'class'=>'form-control select2',
                                                'multiple'=>'multiple',
                                                'name'=>'interventions[]',
                                                'disabled' => true
                                                ]
                                                )}}
                                            </div>
                                        </div>
                                    </div>

                                    <?php
                                        $longueurTotal = 0 ;
                                        $montantTotal = 0;
                                    ?>
                                    @foreach($appelOffre->conventions as $cv)
                                        @if(!empty($cv->piste))
                                            <?php $longueurTotal += $cv->piste->longueur ?>
                                        @endif
                                    @endforeach

                                    @foreach($appelOffre->conventions as $cv)
                                        @if(!empty($cv->montant_global))
                                            <?php $montantTotal += $cv->montant_global ?>
                                        @endif
                                    @endforeach


                                    <div class="row" style="margin-top: 8px">
                                        <div style="margin-right : 8px;margin-left: 12px">
                                            <label>
                                                Longeur Total (KM) :
                                            </label>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                {{Form::text('longueur_total',$longueurTotal,['class'=>'form-control','readonly','disabled'=>'disabled'])}}
                                            </div>
                                        </div>


                                        <div style="margin-right : 8px;margin-left: 12px">
                                            <label>
                                                Montant Total (DH) :
                                            </label>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                {{Form::text('montant_total',$montantTotal,['class'=>'form-control','readonly','disabled'=>'disabled'])}}
                                            </div>
                                        </div>

                                    </div>
                                    <?php
                                        $prj_number = 1;
                                        $point_desservis_ids = array();
                                        $partenaire_ids = array();
                                    ?>
                                    @foreach($appelOffre->conventions as $cv)
                                        @foreach($cv->point_desservis as $pt)
                                            <?php
                                            array_push($point_desservis_ids,$pt->id )
                                            ?>

                                        @endforeach

                                        @foreach($cv->partenaires as $part)
                                            <?php
                                            array_push($partenaire_ids,$part->id )
                                            ?>

                                        @endforeach
                                            <br>


                                            <h5 style="color : #e7430f !important;">PROJET {{$prj_number}} : </h5>
                                            <hr style="background-color : #e7430f !important;">
                                            <div class="row" style="margin-top:18px">
                                                <div class="col-lg-1 col-md-1">
                                                    <label style="margin-top: 8px;">
                                                        L.Routière :
                                                    </label>
                                                </div>
                                                <div class="col-lg-11 col-md-11">
                                                    <div class="form-group">
                                                        {{Form::select('liaison_routiere', $pointdesservis,$point_desservis_ids,
                                                        [
                                                        'data-placeholder' => 'Selectionner commune(s)',
                                                        'class'=>'form-control select2',
                                                        'multiple'=>'multiple',
                                                        'name'=>'liaison_routiere[]',
                                                        'disabled' => true,'readonly'
                                                        ]
                                                        )}}
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row" style="margin-top:8px">
                                                <div class="col-lg-1">
                                                    <label style="margin-top: 8px;">
                                                        Partenaires :
                                                    </label>
                                                </div>
                                                <div class="col-lg-11">
                                                    <div class="form-group">
                                                        {{Form::select('', $partenaires_types,$partenaire_ids,
                                                        [
                                                        'data-placeholder' => 'Selectionner commune(s)',
                                                        'class'=>'form-control select2',
                                                        'multiple'=>'multiple',
                                                        'name'=>'liaison_routiere[]',
                                                        'disabled' => true,'readonly'
                                                        ]
                                                        )}}
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row" style="margin-top:8px">
                                                <div class="col-lg-1">
                                                    <label for="">
                                                        M.Total(DH):
                                                    </label>
                                                </div>
                                                <div class="col-lg-2">
                                                    <div class="form-group">
                                                        {{Form::text('',$cv->montant_global,['class'=>'form-control','readonly','style'=>'border : 0 !important','disabled'=>'disabled'])}}
                                                    </div>
                                                </div>

                                                <div class="col-lg-1">
                                                    <label for="">
                                                        M.CP(DH):
                                                    </label>
                                                </div>
                                                <div class="col-lg-2">
                                                    <div class="form-group">
                                                        @foreach($cv->partenaires as $part)
                                                            @if($part->id  == 1)
                                                                {{Form::text('',$part->pivot->montant,['class'=>'form-control','readonly','style'=>'border : 0 !important','disabled'=>'disabled'])}}
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                </div>

                                                <div class="col-lg-1">
                                                    <label for="">
                                                        M.Versé(DH):
                                                    </label>
                                                </div>
                                                <?php $montant_verse = 0 ?>
                                                @foreach($cv->versements as $versement)
                                                    <?php $montant_verse += $versement->montant ?>
                                                @endforeach
                                                <div class="col-lg-2">
                                                    <div class="form-group">
                                                        {{Form::text('',$montant_verse,['class'=>'form-control','readonly','style'=>'border : 0 !important','disabled'=>'disabled'])}}
                                                    </div>
                                                </div>

                                                <div class="col-lg-1">
                                                    <label for="">
                                                        Etat(%):
                                                    </label>
                                                </div>
                                                <?php $etat = 0 ?>
                                                <div class="col-lg-2">
                                                    <div class="form-group">

                                                        <?php $etat =  ($montant_verse/$cv->montant_global)*100 ?>

                                                        {{Form::text('',number_format($etat),['class'=>'form-control','readonly','style'=>'border : 0 !important','disabled'=>'disabled'])}}
                                                    </div>
                                                </div>

                                            </div>


                                            <br>
                                            <hr>
                                            <button class="btn btn-secondary-table-table pull-right" style="margin-top: 12px;margin-bottom: 18px;text-decoration: underline !important;">
                                                <i class="fa fa-mail-forward"></i>
                                                <a href="/convention/{{$cv->id}}/edit">
                                                    Basculer vers les details
                                                </a>
                                            </button>

                                        <?php $prj_number++ ?>
                                    @endforeach

                                </div>
                            </div>

                            {{--tab localisation de projet--}}
                            <div class="tab-pane " id="autres_info_tab" role="tabpanel">
                                <div class="pad">
                                    @if($is_mobile == 1)
                                        <h4 style="text-align: center;text-decoration: underline">AUTRES INFORMATIONS ET OBSERVATIONS</h4>
                                    @endif
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
                                                        @if($is_mobile == 0)
                                                            <th></th>
                                                        @endif
                                                    </tr>
                                                    <tbody id="pieces_tbody_dce">
                                                    @foreach ($appelOffre->dce as $item)
                                                        <tr>
                                                            <td style="text-align: center">
                                                                {{strtoupper($item->document)}}
                                                            </td>
                                                            <td style="text-align: center">
                                                                {{ str_limit($item->file_name, 15, '...') }}
                                                            </td>

                                                            <td style="text-align: center;">
                                                                <a href="/files/download/appel_offres/{{$appelOffre->id}}/{{$item->file_name}}">
                                                                    <button type="button"  class="btn btn-secondary-table " >
                                                                        <i class="fa fa-download"></i>
                                                                        Télécharger</button>

                                                                </a>

                                                            </td>
                                                            @if($is_mobile == 0)
                                                                <td style="text-align: center">
                                                                    <button type="button" class="btn btn-danger-table delete-piece" data-route="{!! route('dce.delete_piece')!!}" data-directory="appel_offres" data-file="{{$item->file_name}}" data-ao="{{$appelOffre->id}}" data-id="{{$item->id}}"><i class="fa fa-close"></i>
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
                                                    <a href="#" class="add-piece" data-route="/pieces/add_piece_dce" style="display: none"> <i class="fa fa-plus"></i>
                                                        <b> Ajouter Pièce</b> </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    @if($appelOffre->etat == "attribue")
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
                                                        <tbody id="pieces_tbody_adjiducataire">
                                                        @foreach ($appelOffre->dossierAdjiducataire as $item)
                                                            <tr>
                                                                <td style="text-align: center">
                                                                    {{strtoupper($item->document)}}
                                                                </td>
                                                                <td style="text-align: center">
                                                                    {{$item->file_name}}
                                                                </td>

                                                                <td style="text-align: center;">
                                                                    <a href="/files/download/appel_offres/{{$appelOffre->id}}/{{$item->file_name}}">
                                                                        <button type="button"  class="btn btn-secondary-table " >
                                                                            <i class="fa fa-download"></i>
                                                                            Télécharger</button>
                                                                    </a>

                                                                </td>

                                                                <td style="text-align: center">
                                                                    <button type="button" class="btn btn-danger-table delete-piece" data-route="{!! route('dossier_adjiducataire.delete_piece')!!}" data-directory="appel_offres" data-file="{{$item->file_name}}" data-id="{{$item->id}}" data-ao="{{$appelOffre->id}}"><i class="fa fa-close"></i>
                                                                        Supprimer</button>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                        <tr>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                    <div style="text-align: center">
                                                        <a href="#" class="add-piece"  data-route="/pieces/add_piece_dossier_adjiducataire"> <i class="fa fa-plus"></i>
                                                            <b> Ajouter Pièce</b> </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    <h5>OBSERVATIONS ET REMARQUES</h5>
                                    <hr>
                                    <div class="col-12" style="margin-top : 8px">
                                        <div class="form-group">
                                            {{Form::textarea('observation', $appelOffre->observations, ['id' => 'editor1', 'class' => 'form-control', 'placeholder' => 'Body Text','disabled'=>'disabled'])}}
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

                        @switch($appelOffre->etat)
                        @case('publie')
                            PUBLIE
                        @break

                        @case('attribue')
                            ATTRIBUE
                        @break

                        @case('attribue')
                            ATTRIBUE
                        @break

                        @case('reporte')
                            REPORTE
                        @break

                        @case('en_preparation')
                        EN PREPARATION
                        @break

                        @case('annule')
                        ANNULE
                        @break

                        @case('en_cours_execution')
                        EN COURS D'EXECUTION
                        @break

                        @default
                        ETAT INCONNU
                        @endswitch
                    </h5>

                    <!--hidden id appel offre-->
                    {{Form::hidden('id',$appelOffre->id,['class'=>'form-control',''])}}

                    <div class="form-group">
                        {{Form::label('','Appel d\'offre N°:')}}
                        {{Form::text('numero',$appelOffre->numero,['class'=>'form-control','','disabled'=>'disabled'])}}

                    </div>
                    <div class="form-group">
                        {{Form::label('','Montant global (DH):')}}
                        {{Form::text('montant_global',$appelOffre->montant_globale,['class'=>'form-control currency-input','id'=>'montant_global_ao','disabled'=>'disabled'])}}
                    </div>

                    <div class="form-group" >
                        {{Form::label('','Caution Provisoire (DH):')}}
                        {{Form::text('caution_provisoir',$appelOffre->caution_provisoir,['class'=>'form-control','','disabled'=>'disabled'])}}
                    </div>

                    <div class="form-group" style="margin-top: 8px;">
                        {{Form::select('etat', ['publie'=>'Publié','en_preparation'=>'En Préparation'], $appelOffre->etat,
                        [
                        'data-placeholder' => '',
                        'class'=>'form-control select2',
                        'name'=>'etat',
                        'id' => 'etat_selector',
                        'style'=> 'width : 100%'
                        ]
                        )}}
                    </div>

                    @if($appelOffre->etat == 'publie' || $appelOffre->etat == 'attribue' || $appelOffre->etat == 'reporte')
                        <div class=" etat-projet publie" id="publie">
                            <div class="form-group">
                                {{Form::label('','Date Publication:')}}
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    {{Form::text('date_publication',date('d/m/Y', strtotime($appelOffre->date_publication)),['class'=>'form-control
                                    pull-right','id'=>'datepicker','disabled'=>'disabled'])}}
                                </div>
                                <!-- /.input group -->
                            </div>

                            <div class="form-group">
                                {{Form::label('','Date ouverture des plis:')}}
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    {{Form::text('date_ouverture_plis',date('d/m/Y', strtotime($appelOffre->date_ouverture_plis)),['class'=>'form-control
                                    pull-right','id'=>'ouverture_plis_input','disabled'=>'disabled'])}}
                                </div>
                                <!-- /.input group -->
                            </div>
                        </div>
                    @endif



                    <div class="form-group">
                        {{Form::label('','Delai d\'execution:')}}
                        <div class="input-group date">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            @if($appelOffre->delai_execution != null)
                                {{Form::text('delai_execution',date('d/m/Y', strtotime($appelOffre->delai_execution)),['class'=>'form-control
                                                                   pull-right','id'=>'datepicker3','disabled'=>'disabled'])}}
                            @elseif($appelOffre->delai_execution == null)
                                {{Form::text('delai_execution','',['class'=>'form-control
                                   pull-right','id'=>'datepicker','disabled'=>'disabled'])}}
                            @endif

                        </div>
                        <!-- /.input group -->
                    </div>

                    <div class="form-group">
                        {{Form::label('','Duree d\'execution:')}}
                        <div class="input-group ">
                            {{Form::text('duree_execution',$appelOffre->duree_execution,['class'=>'form-control
                            pull-right','disabled'=>'disabled'])}}
                        </div>
                        <!-- /.input group -->
                    </div>

                    <br>
                    <br>
                    <br>

                    <div class="form-group">
                        {{Form::label('','Adjiducataire:')}}
                        <div class="input-group ">
                            @if(!empty($appelOffre->adjiducataires))
                                {{Form::text('adjiducataire',$appelOffre->adjiducataires->nom_fr,['class'=>'form-control pull-right','disabled'=>'disabled'])}}
                                <input type="hidden" name="id_adjiducataire" value="{{$appelOffre->adjiducataires->id}}">
                            @else
                                {{Form::text('adjiducataire','',['class'=>'form-control pull-right','disabled'=>'disabled'])}}
                            @endif
                        </div>
                        <!-- /.input group -->
                    </div>

                    <div class="form-group">
                        {{Form::label('','Montant:')}}
                        <div class="input-group ">
                                {{Form::text('montant_adjiducataire',$appelOffre->montant_adjiducation,['class'=>'form-control pull-right currency-input','disabled'=>'disabled'])}}
                        </div>
                        <!-- /.input group -->
                    </div>

                    @if($appelOffre->etat == 'en_cours_execution')
                        <div class="form-group date_commencement_input" id="datepicker2" >
                            {{Form::label('','Date Commencement:')}}
                            <div class="input-group">
                                {{Form::text('date_commencement',$appelOffre->date_commencement,['class'=>'form-control pull-right','disabled'=>'disabled'])}}
                            </div>
                            <!-- /.input group -->
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
                    <h5>Edition : </h5>
                    <hr>
                    @if($is_mobile == 0)
                    <button type="button" id="activate_edit_btn" class="btn  btn-secondary-edit" style="color : #1118c5" ><i class="fa fa-edit" style="margin-right: 8px;"></i>Activer la modification</button>
                    <button type="submit" class="btn  btn-secondary-edit" style="color : #2bc509" ><i class="fa fa-save" style="margin-right: 8px;" disabled></i>Enregistrer</button>
                    @endif
                    {!! Form::close() !!}


                    <button type="button" class="btn btn-secondary-edit" id="attribuer_appel_offre_btn"  data-id="{{$appelOffre->id}}" style="margin-top: 8px !important;margin-right: 8px;color:#0fff1c"
                    @if($appelOffre->etat == 'attribue')
                        disabled
                            @endif
                    ><i class="fa fa-thumbs-o-up" style="margin-right: 8px;" @if($is_mobile == 0) disabled @endif></i>Attribuer l'appel d'offre</button>

                    <button type="button" class="btn btn-secondary-edit" id="reporter_appel_offre_btn"  data-id="{{$appelOffre->id}}" style="margin-top: 8px !important;color:#ff540a"
                            @if($appelOffre->etat == 'reporte')
                            disabled
                            @endif
                    ><i class="fa fa-clock-o" style="margin-right: 8px;" @if($is_mobile == 0) disabled @endif></i>Reporter l'appel d'offre</button>

                    <button type="button" class="btn btn-secondary-edit" id="annuler_appel_offre_btn"  data-id="{{$appelOffre->id}}" style="margin-top: 8px !important;color:#bc1d36"
                            @if($appelOffre->etat == 'annule')
                            disabled
                            @endif
                    ><i class="fa fa-close" style="margin-right: 8px;" @if($is_mobile == 0) disabled @endif></i>Annuler l'appel d'offre</button>

                    <button type="button"  class="btn btn-secondary-edit" id="ordre_service_btn"  data-id="{{$appelOffre->id}}" style="margin-top: 8px !important;color:#2bc509"
                            @if($appelOffre->etat == 'en_cours_execution')
                            disabled
                            @endif
                    ><i class="fa fa-thumb-tack" style="margin-right: 8px;" @if($is_mobile == 0) disabled @endif></i>Ordre de Service</button>

                    <button type="button" class="btn btn-secondary-edit " id="supprimer_ao" data-id="{{$appelOffre->id}}" style="margin-top: 8px !important ;color:#ff0f0f"><i class="fa fa-trash" style="margin-right: 8px;" @if($is_mobile == 0) disabled @endif></i>Supprimer</button>

                 </div>
                <!-- /.box-body -->
            </div>
            <!-- /. box -->
        </div>
    </div>
    <!-- /.col -->
</div>
<!-- /.row -->

