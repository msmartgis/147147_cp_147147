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
                    <input type="hidden" name="convention_id" value="{{$convention->id}}">
                    <input name="_token" type="hidden" value="{{ csrf_token() }}" />
                    <div class="table-responsive">
                        <table class="table table-piece">
                            <tr style="text-align: center;">
                                <th>Document</th>
                                <th>Upload</th>
                            </tr>
                            <tbody>
                            <tr>
                                <td>
                                    <div class="form-group">
                                        <select name="piece_type">
                                            <option value="etude">Etude</option>
                                            <option value="rc">RC</option>
                                            <option value="Levé topographique">Levé topographique</option>
                                            <option value="CPS">CPS</option>
                                            <option value="CPS+RC">CPS+RC</option>
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
<div class="modal fade" id="m-add-partenaire-edit">
    <div class="modal-dialog" role="document">
        <form action="{{ action('PartenaireTypeController@addPartenaire') }}" method="POST" class="form-add-partenaire-edit">
            <input type="hidden" name="convention_id" value="{{$convention->id}}">
            <input type="hidden" name="montant_global" value="{{$convention->montant_global}}">
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
                                <input type="text" name="montant" class="form-control" id="montant_partenaire">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-success float-right" id="add_partenaire_to_list_edit">Ajouter à la
                        liste</button>
                </div>
            </div>
        </form>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->


{{--Add Etat projet--}}
<div class="modal fade" id="add_modal_etat">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Ajouter Etat</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form action="{{ action('EtatController@addEtat') }}" method="POST"
                      class="form-add-etat">
                    <input type="hidden" name="convention_id" value="{{$convention->id}}">
                    <input name="_token" type="hidden" value="{{ csrf_token() }}" />
                    <div class="table-responsive">
                        <table class="table table-etat">
                            <tr style="text-align: center;">
                                <th>Etat</th>
                                <th>Date</th>
                            </tr>
                            <tbody>
                            <tr>
                                <td>
                                    <div class="form-group ">
                                        <select name="etat" style="width : 100%">
                                            <option value="programme">Programmé</option>
                                            <option value="en_cours_execution">En cours d'execution</option>
                                            <option value="a.o_pulie">A.O Publié</option>
                                            <option value="plis_ouvert">Plis ouvert</option>
                                            <option value="a.o_attribue">A.O Attribué</option>
                                            <option value="a.o_reporte">A.O Reporté</option>
                                            <option value="a.o_annule">A.O Annule</option>
                                            <option value="en_retard">En retard</option>
                                            <option value="en_etat_arret">En état d\'arrêt</option>
                                            <option value="realise">Réalisé</option>
                                        </select>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <input name="date"  type="text" id="datepicker" style="width : 100%"/>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                <button type="submit" class="btn btn-success float-right" id="add_etat_to_list">Ajouter</button>
            </div>
        </div>
        </form>

        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


{{--ADD piece to DCE--}}
{{-- add piece --}}
<div class="modal fade" id="modal_add_piece_projet">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Ajouter pièce</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form action="" id="add_piece_forme" method="POST" enctype="multipart/form-data"
                      class="form-ulpoad-piece-projet">
                    <input type="hidden" name="appelOffre_id" value="{{$convention->appelOffres->id}}">
                    <input name="_token" type="hidden" value="{{ csrf_token() }}" />
                    <div class="table-responsive">
                        <table class="table table-piece">
                            <tr style="text-align: center;">
                                <th>Type</th>
                                <th>Upload</th>
                            </tr>
                            <tbody>
                            <tr>
                                <td>
                                    <div class="form-group">
                                        <select name="piece_type" class="document">
                                            <option value="cps">CPS</option>
                                            <option value="rc">RC</option>
                                            <option value="cps+rc">CPS+RC</option>
                                            <option value="bordereau des prix">BORDEREAU DES PRIX</option>
                                            <option value="avis de publication fr">AVIS DE PUBLICATION FR</option>
                                            <option value="avis publication ar">AVIS DE PUBLICATION AR</option>
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

