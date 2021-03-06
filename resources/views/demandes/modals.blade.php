<!-- Modal -->
@if($is_mobile == 0)
    <div class="modal center-modal fade " id="accordAndAffectModal" tabindex="-1">
        <div class="modal-dialog m-modal-dim">
            <div class="modal-content">
                <div class="modal-header m-header-style" >
                    <h3 class="m-modal-title" id="modalTitleAccordAndAffect" ></h3>
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {!! Form::open(['action' => 'DemandesController@accordOrAffectation','method'=>'post']) !!}
                    <input type="hidden" name="id" id="id_demande_modal_affect" >
                    <input type="hidden" name="affecter" id="affecterORAccord">
                    <input type="hidden" name="cp_id" id="cp_id">
                    <h4>Informations sur le projet</h4>
                    <hr>
                    <div class="row">
                        <div class="col-md-6 col-lg-6 col-xl-6 col-12">
                            <div class="form-group">
                                <label>Maître d'ouvrage : </label>
                                <select class="form-control select2" name="moas" style="width: 100%;" >
                                    @foreach ($moas as $moa)
                                        <option value="{{$moa->id}}">{{$moa->nom_fr}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <!-- /.form-group -->
                        </div>
                    </div>

                    <h4>Financement de projet</h4>
                    <hr>
                    <div class="row">
                        <div class="col-md-6 col-lg-6 col-xl-6 col-12">
                            <div class="form-group">
                                <label>Montant Total TTC:</label>
                                <input type="text" class="form-control " name="montant_global" id="montant_g">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Montant CP :</label>
                                <input type="text" class="form-control" name="montant_cp" id="montant_cp">
                            </div>
                        </div>
                    </div>

                    <h5>SOURCE DE FINANCEMENT (CP) </h5>
                    <hr>
                    <div class="row" style="margin-top:8px">
                        <div class="col-12">
                            <table class="table table-hover">
                                <tr>
                                    <th>#</th>
                                    <th>Source</th>
                                    <th>Reference</th>
                                    <th>Montant Total</th>
                                </tr>
                                <tbody id="table_body_source">
                                <tr>

                                </tr>

                                </tbody>
                            </table>
                            <div class="col-12" style="text-align: center">
                                <a href="#" id="add_source" data-toggle="modal" data-target="#m-add-source-financement">
                                    <i class="fa fa-plus"></i>
                                    <b>Ajouter Source</b>
                                </a>
                            </div>

                            <button type="button" class="btn btn-danger-table " id="delete_source_financement">
                                <i class="fa fa-times"></i>
                                supprimer
                            </button>
                        </div>
                    </div>

                    <h5>Montage financier définitif</h5>
                    <hr>
                    <div class="row" style="margin-top:8px">
                        <div class="col-12">
                            <table class="table table-hover">
                                <tr>
                                    <th>#</th>
                                    <th>Partenaire</th>
                                    <th>Montant</th>
                                    <th>Pourcentage</th>
                                </tr>
                                <tbody id="table_body_partner">
                                <tr>

                                </tr>

                                </tbody>
                            </table>
                            <div class="col-12" style="text-align: center">
                                <a href="#" id="add_partner" data-toggle="modal" data-target="#m-add-partenaire"> <i class="fa fa-plus"></i>
                                    <b>Ajouter partenaire</b>
                                </a>
                            </div>
                            <button type="button" class="btn btn-danger-table " id="delete_partenaire">
                                <i class="fa fa-times"></i>
                                supprimer
                            </button>
                        </div>
                    </div>

                </div>
                <hr>
                <div class="modal-footer modal-footer-uniform">
                    <button type="button" class="btn btn-bold btn-pure btn-warning m-btn-cancel-modal" data-dismiss="modal" ><i class="fa fa-close" style="margin-right: 8px"></i>Annuler</button>
                    <button type="submit" class="btn btn-bold btn-pure btn-success float-right m-btn-submit-modal" > <i class="fa fa-check" style="margin-right: 8px"></i>Affecter</button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

@else


    <div class="modal fade" id="accordAndAffectModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="" id="modalTitleAccordAndAffect"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    {!! Form::open(['action' => 'DemandesController@accordOrAffectation','method'=>'post']) !!}
                        <input type="hidden" name="id" id="id_demande_modal_affect" >
                        <input type="hidden" name="affecter" id="affecterORAccord">
                        <input type="hidden" name="cp_id" id="cp_id">
                        <h5>Informations sur le projet</h5>
                        <hr>

                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xm-12">
                                <div class="form-group">
                                    <label>Maître d'ouvrage : </label>
                                    <select class="form-control select2" name="moas" style="width: 100%;" >
                                        @foreach ($moas as $moa)
                                            <option value="{{$moa->id}}">{{$moa->nom_fr}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <!-- /.form-group -->
                            </div>
                        </div>

                        <h5>Financement de projet</h5>
                        <hr>

                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Montant Total TTC:</label>
                                    <input type="text" class="form-control " name="montant_global" id="montant_g">
                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Montant CP :</label>
                                    <input type="text" class="form-control" name="montant_cp" id="montant_cp">
                                </div>
                            </div>
                        </div>


                        <h5>SOURCE DE FINANCEMENT (CP) </h5>
                        <hr>
                        <div class="row" style="margin-top:8px">
                            <div class="col-12">
                                <table class="table table-hover">
                                    <tr>
                                        <th>#</th>
                                        <th>Source</th>
                                        <th>Reference</th>
                                        <th>Montant Total</th>
                                    </tr>
                                    <tbody id="table_body_source">
                                    <tr>

                                    </tr>

                                    </tbody>
                                </table>
                                <div class="col-12" style="text-align: center">
                                    <a href="#" id="add_source" data-toggle="modal" data-target="#m-add-source-financement">
                                        <i class="fa fa-plus"></i>
                                        <b>Ajouter Source</b>
                                    </a>
                                </div>

                                <button type="button" class="btn btn-warning " id="delete_source_financement">
                                    <i class="fa fa-times"></i>
                                    supprimer source de financement
                                </button>
                            </div>
                        </div>


                        <h5>Montage financier définitif</h5>
                        <hr>
                        <div class="row" style="margin-top:8px">
                            <div class="col-12">
                                <table class="table table-hover">
                                    <tr>
                                        <th>#</th>
                                        <th>Partenaire</th>
                                        <th>Montant</th>
                                        <th>Pourcentage</th>
                                    </tr>
                                    <tbody id="table_body_partner">
                                    <tr>

                                    </tr>

                                    </tbody>
                                </table>
                                <div class="col-12" style="text-align: center">
                                    <a href="#" id="add_partner" data-toggle="modal" data-target="#m-add-partenaire"> <i class="fa fa-plus"></i>
                                        <b>Ajouter partenaire</b>
                                    </a>
                                </div>
                                <button type="button" class="btn btn-warning " id="delete_partenaire">
                                    <i class="fa fa-times"></i>
                                    supprimer partenaire
                                </button>
                            </div>
                        </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-bold btn-pure btn-warning" data-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-bold btn-pure btn-success float-right">Affecter</button>
                </div>
                {!! Form::close() !!}
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

@endif

    <div class="modal fade" id="m-add-partenaire">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title">Nouveau partenaire</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Partenaire</label>
                                <select class="form-control select2" style="width: 100%;" name="partnenaire_type_id" id="partenaire_type">
                                    @foreach ($partenaires_types as $type)
                                    <option value="{{$type->id}}">{{$type->nom_fr}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="example_input_full_name">Montant:</label>
                                <input type="text"  class="form-control currency-input" id="montant_partnenaire">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                    <button type="button" class="btn btn-success float-right" id="add_partner_to_list">Ajouter à la
                        liste</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->


<!-- add source financement-->
<div class="modal fade" id="m-add-source-financement">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">Ajouter Source de Financement</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Source de Financement</label>
                            <select class="form-control select2" style="width: 100%;" name="sourceFinancementId" id="sourceFinancement">
                                @foreach ($sourceFincancement as $sf)
                                    <option value="{{$sf->id}}">{{$sf->source }} : {{ $sf->reference }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="example_input_full_name">Montant:</label>
                            <input type="text" class="form-control currency-input" id="montant_sourceFinancement">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-success float-right" id="add_source_to_list">Ajouter à la
                    liste</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

    <!-- end modals -->