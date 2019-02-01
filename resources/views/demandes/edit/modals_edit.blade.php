{{-- add piece --}}
<div class="modal fade " id="add_modal_piece">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Ajouter pièce</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form action="{{ action('PieceController@addPiece') }}" method="POST" enctype="multipart/form-data"
                    class="form-ulpoad-piece">
                    <input type="hidden" name="demande_id" value="{{$demande->id}}">
                    <input name="_token" type="hidden" value="{{ csrf_token() }}" />
                    <div class="table-responsive">
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
                                            <select name="piece_type" class="document">
                                                <option value="etude">Etude</option>
                                                <option value="fiche_technique">Fiche technique</option>
                                            </select>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <select name="piece_nom" class="etat">
                                                <option value="approuve">Approuvée</option>
                                                <option value="disponible">Disponible</option>
                                                <option value="en_cours_approbation">En cours d'approbation</option>
                                            </select>
                                        </div>
                                    </td>

                                    <td>
                                        <div class="form-group">
                                            <input name="piece_upload" id="#file" type="file" />
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                <button type="submit" class="btn btn-success float-right" id="add_piece_to_list">Ajouter</button>
            </div>
        </div>
            </form>
        
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>



{{-- add partenaire  --}}

 <div class="modal fade" id="m-add-partenaire">
        <div class="modal-dialog" role="document">            
            <form action="{{ action('PartenaireTypeController@addPartenaire') }}" method="POST" class="form-add-partenaire">
                    <input type="hidden" name="demande_id" value="{{$demande->id}}">
                    <input type="hidden" name="montant_global" value="{{$demande->montant_global}}">
                    <input name="_token" type="hidden" value="{{ csrf_token() }}" />
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
                                <input type="text" name="montant" class="form-control" id="montant_partnenaire">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-success float-right" >Ajouter à la
                        liste</button>
                </div>
            </div>
        </form>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->


    {{-- edite partenaire --}}

    <div class="modal fade" id="m-edite-partenaire">
        <div class="modal-dialog" role="document">            
            <form action="{{ action('PartenaireTypeController@addPartenaire') }}" method="POST" class="form-add-partenaire">
                    <input type="hidden" name="demande_id" value="{{$demande->id}}">
                    <input type="hidden" name="montant_global" value="{{$demande->montant_global}}">
                    <input name="_token" type="hidden" value="{{ csrf_token() }}" />
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Modifier le partenaire</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Partenaire</label>
                                <select class="form-control select2" style="width: 100%;" name="partnenaire_type_id" id="partenaire_type_edit">
                                    @foreach ($partenaires_types as $type)
                                    <option value="{{$type->id}}">{{$type->nom_fr}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="example_input_full_name">Montant:</label>
                            <input type="text" name="montant"  class="form-control" id="montant_partnenaire">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-success float-right" >Ajouter à la
                        liste</button>
                </div>
            </div>
        </form>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->