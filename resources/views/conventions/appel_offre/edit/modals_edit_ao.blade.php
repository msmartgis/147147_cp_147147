{{-- add piece --}}
<div class="modal fade" id="modal_add_piece">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Ajouter pièce</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form action="" id="add_piece_forme" method="POST" enctype="multipart/form-data"
                    class="form-ulpoad-piece">
                    <input type="hidden" name="appelOffre_id" value="{{$appelOffre->id}}">
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
