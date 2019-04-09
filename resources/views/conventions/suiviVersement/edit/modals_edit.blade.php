{{-- add partenaire  --}}
<div class="modal center-modal fade versement-modal" id="m-add-versement">
    <div class="modal-dialog m-modal-dim" role="document">
        <form action="{{ action('SuiviVersementController@addVersement') }}" method="POST" class="form-add-versement" enctype="multipart/form-data">
            <div id="hidden_data_versement_modal">
                <input type="hidden" name="convention_id" value="{{$convention->id}}">
                <input type="hidden" name="partenaire_id" id="partenaire_id_hidden" value="">
                <input type="hidden" name="montant_partenaire" value="">
                <input type="hidden" name="rest_a_verse_hidden" id="rest_a_verse_hidden" value="">
                <input name="_token" type="hidden" value="{{ csrf_token() }}" />
            </div>

            <div class="modal-content">
                <div class="modal-header" style="margin-top: 8px">
                    <h4 class="modal-title" >AJOUTER UN VERSEMENT : </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                </div>
                <div class="loading_modal">
                    <img src="{{asset('images/loader/Preloader_2.gif')}}" alt="">
                </div>
                <div class="modal-body" style="z-index: 1;">
                    <div class="row">
                        <div class="col-lg-2">
                            <label >Partenaire:</label>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <input type="text" name="partenaire" id="partenaire_name_modal" class="form-control" readonly >
                            </div>
                        </div>

                        <div class="col-lg-2">
                            <label >Montant global TTC:</label>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <input type="text" name="montant_global" value="{{number_format($convention->montant_global,2)}} DH" class="form-control" readonly >
                            </div>
                        </div>
                    </div>

                    <div class="row" style="margin-top: 8px">
                        <div class="col-lg-2">
                            <label >Part Partenaire:</label>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <input type="text" name="part_partenaire" id="part_partenaire" class="form-control" readonly >
                            </div>
                        </div>

                        <div class="col-lg-2">
                            <label >Mantant versé:</label>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group ">
                                <input type="text" name="montant_verse" class="form-control" readonly >
                            </div>
                        </div>
                    </div>

                    <div class="row" style="margin-top: 8px">
                        <div class="col-lg-2">
                            <label >Reste à verser:</label>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group ">
                                <input type="text" id="rest_a_verser" name="rest_a_verser"  class="form-control" readonly >
                            </div>
                        </div>
                    </div>
                    <br>

                    <h4>NOUVEAU VERSEMENT</h4>
                    <hr>

                    <div class="row" style="margin-top: 8px">
                        <div class="col-lg-2">
                            <label >Date d'entrée:</label>
                        </div>
                        <div class="col-lg-3">
                            <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" name="date_versement" class="form-control pull-righ" id="datepicker">
                            </div>
                        </div>

                        <div class="col-lg-2">
                            <label >Montant de versement:</label>
                        </div>
                        <div class="col-lg-3">
                                <input type="text" name="montant_de_versement" class="form-control">
                        </div>
                    </div>
                    <br>

                    <h4>DOCUMENT</h4>
                    <hr>
                    <br>

                    <div class="row" style="padding:8px">
                        <div class="table-responsive">
                            <table class="table table-piece">
                                <tr style="text-align: center;">
                                    <th>Nom de document</th>
                                    <th>Pris en charge</th>
                                    <th>Charge le fichier</th>
                                </tr>
                                <tbody id="document_versement_tbody">
                                    <tr>
                                        <td>
                                            <input type="text" name="nom_document" class="form-control">
                                        </td>
                                        <td>
                                            <select class="form-control select2" name="pris_en_charge" style="width: 100%;" >
                                                    <option value="1">OUI</option>
                                                <option value="0">NON</option>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="file" name="versement_file" class="form-control">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-success float-right" id="add_partenaire_to_list_edit">Ajouter un versement</button>
                </div>
            </div>
        </form>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->