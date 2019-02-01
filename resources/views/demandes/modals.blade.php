<!-- Modal -->
    <div class="modal center-modal fade" id="affecter_aux_cnv" tabindex="-1">
        <div class="modal-dialog m-modal-dim">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title"></h3>
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {!! Form::open(['action' => 'DemandesController@affecterAuxConventions','method'=>'post']) !!}
                    <input type="hidden" name="id" id="id_demande">
                    <h4>Informations sur le projet</h4>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Maître d'ouvrage : </label>
                                <select class="form-control select2" name="moas[]" style="width: 100%;" multiple="multiple">
                                    @foreach ($moas as $moa)
                                    <option value="{{$moa->id}}">{{$moa->nom_fr}}</option>
                                    @endforeach

                                </select>
                            </div>
                            <!-- /.form-group -->
                        </div>
                    </div>

                    <h4>Financement de projet</h4>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Montant Global TTC:</label>
                                <input type="text" class="form-control" name="montant_global" id="montant_g">
                            </div>
                        </div>
                    </div>

                    <h5>Montage financier définitif</h5>
                    <div class="row">
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
                                        <td colspan="4" style="text-align: center"><a href="#" id="add_partner"
                                                data-toggle="modal" data-target="#m-add-partenaire"> <i class="fa fa-plus"></i>
                                                <b>Ajouter partenaire</b> </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <button type="button" class="btn btn-warning delete-row">
                                <i class="fa fa-times"></i>
                                supprimer partenaire
                            </button>
                        </div>
                    </div>

                </div>

                <div class="modal-footer modal-footer-uniform">
                    <button type="button" class="btn btn-bold btn-pure btn-warning" data-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-bold btn-pure btn-success float-right">Affecter</button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    <!-- /.modal -->

    <div class="modal fade" id="m-add-partenaire">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Nouveau partenaire</h4>
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
                                <input type="text" class="form-control" id="montant_partnenaire">
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

   
    <!-- /.modal -->





    <!-- end modals -->