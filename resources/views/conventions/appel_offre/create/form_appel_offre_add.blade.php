{{--TODO add remove option when adding partner or document--}}

{!! Form::model($appel_offre,['action' => 'AppelOffreController@store','method'=>'POST','class'=>'tab-wizard
        wizard-circle form-create','enctype' => 'multipart/form-data']) !!}

<!-- Step 1 -->
<h6>SELECTION DES PROJETS</h6>
<section>
    @include('conventions.appel_offre.create.filters')

    <div class="row" style="margin-bottom: 8px;margin-top: 8px">
        <div class="col-lg-2">
            {{Form::label('','Montant total des projets séléectionner :')}}
        </div>
        <div class="col-lg-3">
            <div class="form-group" >
                {{Form::text('montant_global','',['class'=>'form-control','id'=>'montant_global_ao','readonly'])}}
            </div>
        </div>

    </div>

    <hr>
    <div class="table-responsive">
        <table class="table table-hover table-striped datatables" id="appel_offre_datatables" style="width:100% ;" >
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

    <div id="list_conventions">

    </div>

</section>
<!-- Step 2 -->
<h6>INFOROMATIONS GENERALES</h6>
<section>

    <div class="row" >
            <div class="col-lg-6">
                {{Form::label('','Numero :')}}
                <div class="form-group" >
                    {{Form::text('numero','',['class'=>'form-control'])}}
                </div>
            </div>

            <div class="col-lg-6">
                {{Form::label('','Caution provisoire :')}}
                <div class="form-group" >
                    {{Form::text('caution_provisoire','',['class'=>'form-control'])}}
                </div>
            </div>
    </div>

    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="form-group">
                <h6>Objet (fr)</h6>
                <div class="controls">
                    {{Form::textarea('objet_fr','',['class'=>'form-control','placeholder'=>'saisir l\'objet en francais','rows'=>'2'])}}
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="form-group">
                <h6>Objet (ar)</h6>
                <div class="controls">
                    {{Form::textarea('objet_ar','',['class'=>'form-control','placeholder'=>'saisir l\'objet en arabe','rows'=>'2'])}}
                </div>
            </div>
        </div>
    </div>

    <div class="row" >
        <div class="col-md-6 col-sm-12 col-xs-12">
            <div class="form-group">
                <h6>MOA</h6>
                <select class="form-control select2" style="width: 100%;" name="moas" >
                    <option value="all" selected>Indifferent</option>
                    @foreach ($moas as $moa)
                        <option value="{{$moa->id}}">{{$moa->nom_fr}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

</section>
<!-- Step 3 -->
<h6>INFORMATION TECHNIQUES</h6>
<section>
    <div class="row">
        <div class="col-md-6 col-sm-12 col-xs-12">
            <div class="form-group">
                <h6>Etat du projet</h6>
                <select class="form-control select2" style="width: 100%;" name="etat" id="etat_selector">
                    <option value="en_preparation" selected>En péparation</option>
                    <option value="publie" >Publié</option>
                </select>
            </div>
        </div>
    </div>

    <div class="row etat-projet publie" id="publie" >
        <div class="form-group col-md-4">
            {{Form::label('','Date de publication:')}}
            <div class="input-group date">
                <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </div>
                {{Form::text('date_publication','',['class'=>'form-control pull-right','id'=>'datepicker'])}}
            </div>
            <!-- /.input group -->
        </div>

        <div class="form-group col-md-4">
            {{Form::label('','Date de d\'ouverture des plis:')}}
            <div class="input-group date">
                <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </div>
                {{Form::text('date_ouverture_plis','',['class'=>'form-control pull-right','id'=>'datepicker2'])}}
            </div>
            <!-- /.input group -->
        </div>
    </div>

    <div class="row" style="margin: 0 !important;">
        <h4>DOSSIER DE L'APPEL D'OFFRE</h4>
        <hr>
        <br>
        <div class="table-responsive" style="margin-top: 12px">
            <table class="table table-piece">
                <tr style="text-align: center;">
                    <th></th>
                    <th>Type</th>
                    <th>Upload</th>
                </tr>
                <tbody id="pieces_tbody">
                <tr>
                    <td>
                        <div class="form-group">
                            <div class="checkbox">
                                <input type="checkbox" id="row_0" name="record">
                                <label for="row_0"></label>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            {{Form::select('piece_type',
                            [
                            'cps' => 'CPS',
                            'rc' => 'RC',
                             'cps+rc' => 'CPS+RC',
                             'bordereau des prix' => 'BORDEREAU DES PRIX',
                             'avis de publication fr' => 'AVIS DE PUBLICATION FR',
                             'avis publication ar' => 'AVIS DE PUBLICATION AR'
                            ],
                            'cps',
                            [
                            'class'=>'form-control document',
                            'style'=>'width : 100%',
                            'name'=>'pieces_types[]'
                            ]
                            )
                            }}
                        </div>
                    </td>

                    <td>
                        <div class="form-group" style="text-align: center">
                            {{Form::file('pieces_uploads',['name'=>'pieces_uploads[]'])}}
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>

            <div style="text-align: center">
                <a href="#" id="add_piece"> <i class="fa fa-plus"></i>
                    <b> Ajouter Pièce</b>
                </a>
            </div>

            <button type="button" class="btn btn-warning delete-row"><i class="fa fa-close"></i> Supprimer Document</button>
        </div>
    </div>


</section>
<!-- Step 4 -->
<h6>OBSERVATIONS ET REMARQUES</h6>
<section>
    <div class="row">
        <div class="col-12">
            <div class="form-group">
                {{Form::textarea('observations','',['id'=>'editor1','placeholder'=>'saisir vos
                obsérvations','rows'=>'10','cols'=>'80'])}}
            </div>
        </div>
    </div>
</section>

{!! Form::close() !!}
