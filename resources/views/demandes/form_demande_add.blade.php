{{--TODO add remove option when adding partner or document--}}

{!! Form::model($demande,['action' => 'DemandesController@store','method'=>'POST','class'=>'tab-wizard
        wizard-circle form-create','enctype' => 'multipart/form-data']) !!}
        <!-- Step 1 -->
        <h6>Information Général</h6>
        <section>
            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                    <div class="form-group">
                        {{Form::label('','N° d\'ordre :')}}
                        {{Form::text('num_ordre',$current_numero_ordre,['class'=>'form-control','required'=>'required'  ])}}
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                    <div class="form-group">
                        {{Form::label('','Date de récéption:')}}
                        <div class="input-group date">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            {{Form::text('date_reception','',['class'=>'form-control pull-right','id'=>'datepicker'])}}
                        </div>
                        <!-- /.input group -->
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
                        {{Form::label('','Etat du projet :')}}
                        {{Form::select('etat_projet',
                         [
                             'sans' => 'sans',
                              'realisee' => 'Réalisée dans d\'autre programme',
                              'programmee' =>'Programmée dans d\'autre programme'
                        ], 
                        'sans',
                         [
                            'data-placeholder' => 'Etat du projet',
                            'class'=>'form-control',
                            'name'=>'etat'
                        ])}}
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <input type="hidden" id="piste_id_input" name="piste_id" value="{{$piste_id}}">
                    <input type="hidden" id="geometry_input" class="form-control" name="geometry" value="" required>
                    <div class="form-group">

                        {{Form::label('','Longueur :')}}
                        {{Form::text('longueur','',['class'=>'form-control','id'=>'longueur_input','required'=>'required'])}}
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label>Session : </label>
                        <select placeholder="Session" class="form-control select2" style="width: 100%;" name="session_id">

                            @foreach($sessions as $session)
                                <option value="{{$session->id}}">{{$session->mois}} | {{$session->type}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-lg-12 col-md-4 col-sm-12 col-xs-12">
                    <div id="map" style="border: solid 1px #666666;box-shadow: 0px 5px 20px rgba(0, 0, 0, 0.05);"></div>
                    <div class="cmodali active" style=" width: 300px;  height: 100px;left:calc(100% - 320px);top:calc(100% - 72px);z-index:99998;">
                        <div class="row">
                            <div class="col-md-3">
                                <img id="satellite_btn"  class="baselayer_btn active" src="{{asset('images/satellite.png')}}" />
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
                        <label>Porteur de projet</label>
                        <select placeholder="Porteur de projet" class="form-control select2" style="width: 100%;" name="porteur_projet">

                            @foreach($porteur_projet as $porteur)
                                <option value="{{$porteur->id}}">{{$porteur->nom_porteur_fr}}</option>
                            @endforeach
                        </select>
                        <a href="" class="btn btn-secondary" style="margin-right : 6px"><i class="fa fa-plus" style="margin-right: 6px"></i>Ajouter Porteur de projet  </a>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">

                </div>
            </div>
        </section>
        <!-- Step 2 -->
        <h6>Informations techniques</h6>
        <section>
            {{--<h5>LES POINTS DESSERVIS</h5>
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
                                            <option value="{{ $categorie_point->id}}">{{ ucwords($categorie_point->nom_fr)}}</option>
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
            </div>--}}

                <h5>LES PIECES TECHNIQUES</h5>
                <hr>
            <div class="row" style="margin: 0 !important;">
                <div class="table-responsive" style="margin-top: 12px">
                    <table class="table table-piece">
                        <tr style="text-align: center;">
                            <th></th>
                            <th>Nom</th>
                            <th>Etat</th>
                            <th>Upload</th>
                        </tr>
                        <tbody id="piece_demande_tbody">
                        <tr>
                            <td>
                                <div class="form-group">
                                    <div class="checkbox">
                                        <input type="checkbox" id="row_piece_0" name="record">
                                        <label for="row_piece_0"></label>
                                    </div>
                                </div>
                            </td>
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
                                <div class="form-group" style="margin-left: 18px">
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
                    <button type="button" class="btn delete-row btn-danger-table" id="delete_elemtent_row_demande_btn"> <i class="fa fa-close"></i> Supprimer Document</button>
                </div>
            </div>

            <h5>TYPES D'INTERVENTIONS</h5>
            <hr>
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
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
                        'class'=>'form-control currency-input' ,
                        'id'=>'montant_g'
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
                                <td colspan="4" style="text-align: center"><a href="#" id="add_partner_demande"
                                                                              > <i class="fa fa-plus"></i>
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
                    <button type="button" class="btn btn-danger-table delete-row">
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
