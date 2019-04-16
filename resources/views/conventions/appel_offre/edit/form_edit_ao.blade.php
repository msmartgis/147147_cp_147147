
{!! Form::model($appelOffre, ['route' => ['appelOffre.update', $appelOffre->id],'method' => 'PUT']) !!}

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
                            <div class="tab-pane active" id="projet_tab" role="tabpanel">
                                <div class="pad">
                                    <h5>SELECTION DES PROJETS </h5>
                                    <hr style="color:#2d353c;margin:0">
                                    @include('conventions.appel_offre.edit.filters_edit_ao')
                                    <div class="row" style="margin-top: 8px">

                                        <div class="table-responsive">
                                            <table class="table table-hover table-striped datatables" id="appel_offre_edit_datatables" style="width:100% ;" >
                                                <thead>
                                                <th ></th>
                                                <th >N°ordre</th>
                                                <th >Liaison Routière</th>
                                                <th >Communes</th>
                                                <th >Maitre D'ouvrage</th>
                                                <th >Interventions</th>
                                                <th >Partenaire</th>
                                                <th >Programme</th>
                                                <th >M.Totol</th>
                                                <th >M.CP</th>
                                                <th >M.Verse</th>
                                                <th >Etat (%)</th>
                                                </thead>
                                            </table>
                                        </div>

                                    </div>

                                </div>
                            </div>

                            {{--tab localisation de projet--}}
                            <div class="tab-pane " id="information_general_tab" role="tabpanel">
                                <div class="pad">
                                    <h5>OBJET </h5>
                                    <hr style="color:#2d353c;margin:0">
                                    <div class="row" style="margin-top: 8px">
                                        <div class="col-lg-6">
                                            <div class="form-group">

                                                <div class="controls">
                                                    {{Form::textarea('objet_fr',$appelOffre->objet_fr,['class'=>'form-control','rows'=>'2','style'=>'height: 52px !important'])}}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <div class="controls">
                                                    {{Form::textarea('objet_ar',$appelOffre->objet_ar,['class'=>'form-control','rows'=>'2','style'=>'height: 52px !important'])}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>

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
                                                'style'=> 'width : 100%'
                                                ]
                                                )}}
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
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
                                                        <th></th>
                                                        <th></th>
                                                    </tr>
                                                    <tbody id="pieces_tbody">
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
                                                                <button type="button" class="btn btn-danger-table delete-piece" data-directory="appel_offres" data-file="{{$item->file_name}}" data-id="{{$item->id}}"><i class="fa fa-close"></i>
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

                                </div>
                            </div>


                            {{--tab observation et remarques--}}
                            <div class="tab-pane" id="observation_remarques_tab" role="tabpanel">
                                <div class="pad">
                                    <div class="col-12" style="margin-top : 8px">
                                        <div class="form-group">
                                            {{Form::textarea('observation', $appelOffre->observations, ['id' => 'editor1', 'class' => 'form-control', 'placeholder' => 'Body Text'])}}
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
                        @if($appelOffre->etat == 'publie')
                            PUBLIE
                        @endif

                            @if($appelOffre->etat == 'en_preparation')
                                EN PREPARATION
                            @endif
                    </h5>

                    <!--hidden id appel offre-->
                    {{Form::hidden('id',$appelOffre->id,['class'=>'form-control',''])}}

                    <div class="form-group">
                        {{Form::label('','Appel d\'offre N°:')}}
                        {{Form::text('numero',$appelOffre->numero,['class'=>'form-control',''])}}

                    </div>
                    <div class="form-group">
                        {{Form::label('','Montant global (DH):')}}
                        {{Form::text('montant_global',$appelOffre->montant_globale,['class'=>'form-control',''])}}
                    </div>

                    <div class="form-group" >
                        {{Form::label('','Caution Provisoire (DH):')}}
                        {{Form::text('caution_provisoir',$appelOffre->caution_provisoir,['class'=>'form-control',''])}}
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

                    @if($appelOffre->etat == 'publie')
                        <div class=" etat-projet publie" id="publie">
                            <div class="form-group">
                                {{Form::label('','Date Publication:')}}
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    {{Form::text('date_publication',date('d/m/Y', strtotime($appelOffre->date_publication)),['class'=>'form-control
                                    pull-right','id'=>'datepicker'])}}
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
                                    pull-right','id'=>'datepicker2'])}}
                                </div>
                                <!-- /.input group -->
                            </div>
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
                    {{Form::submit('Modifier',['class'=>'btn btn-secondary col-12','style'=>'margin-top : 8px !important'])}}
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

