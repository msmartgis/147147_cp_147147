{{--TODO add remove option when adding partner or document--}}

{!! Form::model($convention,['action' => 'ConventionController@store','method'=>'POST','class'=>'tab-wizard
        wizard-circle form-create','enctype' => 'multipart/form-data']) !!}

<!-- Step 1 -->
<h6>Information Général</h6>
<section>
    <div class="row">
        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <div class="form-group">
                {{Form::label('','N° d\'ordre :')}}
                {{Form::text('num_ordre','',['class'=>'form-control'])}}
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <div class="form-group">
                {{Form::label('','Session:')}}
                {{Form::select(
                'size',
                 array(
                 '1' => 'Janvier',
                  '2' => 'Fevrier',
                  '3' => 'Mars',
                  '4' => 'Avril',
                  '5' => 'Mai',
                  '6' => 'Juin',
                  '7' => 'Juillet',
                  '8' => 'Aout',
                  '9' => 'Septembre',
                  '10' => 'Octobre',
                  '11' => 'Novembre',
                  '12' => 'Decembre',
                  ),
                  '1',
                ['class'=>'form-control']
                )}}

            </div>
        </div>

        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="form-group">
                {{Form::label('','Commune:')}}
                {{Form::select('communes', $communes, null,
                [
                'data-placeholder' => 'Selectionner commune(s)',
                'class'=>'form-control select2',
                'multiple'=>'multiple',
                'name'=>'communes[]'
                ]
                )}}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
            <div class="form-group">
                {{Form::label('','Longueur :')}}
                {{Form::text('longueur','',['class'=>'form-control'])}}
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
            <div class="form-group">
                {{Form::label('','Progamme:')}}
                {{Form::select('programme', $programmes, null,
                [
                'data-placeholder' => 'Selectionner commune(s)',
                'class'=>'form-control select2',
                'name'=>'programme'
                ]
                )}}
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">

        </div>

        <div class="col-lg-12 col-md-4 col-sm-12 col-xs-12">
            <div id="map" style="border: solid 1px #666666;box-shadow: 0px 5px 20px rgba(0, 0, 0, 0.05);"></div>

            <div class="cmodali active" style=" width: 300px;  height: 100px;left:calc(100% - 320px);top:calc(100% - 72px);z-index:99998;">
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
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="form-group">
                {{Form::label('','MOA:')}}
                {{Form::select('moas', $moas, null,
                [
                'data-placeholder' => 'Selectionner commune(s)',
                'class'=>'form-control select2',
                'name'=>'moas'
                ]
                )}}
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">

        </div>
    </div>
</section>
<!-- Step 2 -->
<h6>Informations techniques</h6>
<section>
    <h5>LES POINTS DESSERVIS</h5>
    <hr>
    <div class="row" style="margin: 0 !important;">
        <div class="table-responsive" style="margin-top: 12px">
            <table class="table table-points">
                <tr style="text-align: center;">
                    <th>Type</th>
                    <th>Nom</th>
                </tr>
                <tbody>
                <tr>
                    <td style="width: 40%">
                        <div class="form-group">
                            <select class="form-control  type_point select2" name="type_point[]"
                                    style="width : 100%">
                                @foreach($categorie_points as $categorie_point)
                                    <option value="{{ $categorie_point->id }}">{{ $categorie_point->nom_fr }}</option>
                                @endforeach
                            </select>
                        </div>
                    </td>
                    <td style="width: 60%" >
                        <div class="form-group ">
                            <select class="form-control select2 point-desservis " name="points[]"
                                    style="width : 100%">
                                @foreach($localites as $localite)
                                    <option value="{{ $localite->id}}">{{ $localite->nom_fr}}</option>
                                @endforeach
                            </select>
                        </div>
                    </td>

                </tr>

                <tr>
                    <td colspan="2" style="text-align: center" >
                    </td>


                </tr>
                </tbody>
            </table>

            <div style="text-align: center">
                <div class="response-div-point-desservi">
                    <a href="#" id="add_point" > <i class="fa fa-plus"></i>
                        <b> Ajouter point</b>
                    </a>
                </div>

                <div id="loading-point-desservi">
                    <img src="{{asset('images/loader/loader4.gif')}}" >
                </div>
            </div>

        </div>
    </div>

    <h5>LES PIECES TECHNIQUES</h5>
    <hr>
    <div class="row" style="margin: 0 !important;">
        <div class="table-responsive" style="margin-top: 12px">
            <table class="table table-piece">
                <tr style="text-align: center;">
                    <th>Type</th>
                    <th>Nom</th>
                    <th>Upload</th>
                </tr>
                <tbody>
                <tr>
                    <td>
                        <div class="form-group">

                            {{Form::select('piece_type',
                            [
                            'etude' => 'Etude',
                            'fiche_technique' => 'Fiche technique'
                            ],
                            'etude',
                            [
                            'data-placeholder' => 'Document',
                            'class'=>'form-control document',
                            'style'=>'width : 100%',
                            'name'=>'pieces_types[]'
                            ]
                            )
                            }}
                        </div>
                    </td>
                    <td>
                        <div class="form-group ">

                            {{Form::select('piece_nom',
                            [
                            'approuve' => 'Approuvée',
                            'disponible' => 'Disponible',
                            'en_cours_approbation' => 'En cours d\'approbation'
                            ],
                            'approuve',
                            [
                            'data-placeholder' => 'Document',
                            'class'=>'form-control etat',
                            'style'=>'width : 100%',
                            'name'=>'pieces_noms[]',

                            ]
                            )
                            }}
                        </div>
                    </td>

                    <td>
                        <div class="form-group" style="text-align: center">
                            {{Form::file('piece_upload',['name'=>'pieces_uploads[]'])}}
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
        </div>
    </div>


    <div class="row">
        <div class="col-6">
            <div class="form-group">
                {{Form::label('','Type d\'interventions:')}}
                {{Form::select('inertventions', $interventions, null,
                [
                'data-placeholder' => 'Selectionner interventions(s)',
                'class'=>'form-control select2',
                'multiple'=>'multiple',
                'name'=>'interventions[]',
                'style'=>'width:100%'
                ]
                )}}

            </div>
        </div>
    </div>
</section>
<!-- Step 3 -->
<h6>Information sur le financement du projet</h6>
<section>
    <div class="row">
        <div class="col-6">
            <div class="form-group">
                {{Form::label('','Montant global TTC (DH) :')}}

                {{Form::text(
                'montant_global',
                '',
                [
                'class'=>'form-control input-element',
                'id'=>'montant_g',
                'data-validation-containsnumber-regex'=>'(\d)+',
                'data-validation-containsnumber-message'=>'Veuillez saisir des numeros seulement'
                ]
                )}}
            </div>
        </div>
    </div>
    <br>
    <div class="row" style="margin: 0 !important;">
        <h5>MONTAGE FINANCIER PROPOSE</h5>
        <hr>
        <div class="col-12" style="margin-top: 8px">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead style="text-align: center">
                    <tr>
                        <th>#</th>
                        <th>Partenaire</th>
                        <th>Montant</th>
                        <th>Pourcentage</th>
                    </tr>
                    </thead>
                    <tbody id="table_body_partner">
                    <tr>
                        <td colspan="4" style="text-align: center"><a href="#" id="add_partner"
                                                                      data-toggle="modal" data-target="#m-add-partenaire"> <i class="fa fa-plus"></i>
                                <b>Ajouter partenaire</b> </a>
                        </td>
                    </tr>
                    </tbody>

                    <!-- <tfoot>
                        <tr class="total-col  totalCol">
                            <th></th>
                            <th><strong>TOTAL</strong></th>
                            <th class="total">0</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </tfoot>  -->
                </table>
            </div>
            <button type="button" class="btn btn-secondary delete-row">
                <i class="fa fa-times"></i>
                supprimer partenaire
            </button>
        </div>
    </div>

</section>
<!-- Step 4 -->
<h6>Observations et remarques</h6>
<section>
    <div class="row">
        <div class="col-12">
            <div class="form-group">
                {{Form::textarea('observation','',['id'=>'editor1','placeholder'=>'saisir vos
                obsérvations','rows'=>'10','cols'=>'80'])}}
            </div>
        </div>
    </div>
</section>

{!! Form::close() !!}
