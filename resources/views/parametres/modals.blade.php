<!-- setting edit -->
<div class="modal fade center-modal settingModal">
    <div class="modal-dialog" role="document" >
        <div class="modal-content" style="width : 650px">
            <div class="modal-header m-header-style">
                <h6 class="modal-title m-modal-title" id="modal_title_setting"></h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body setting-modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default m-btn-cancel-modal" data-dismiss="modal"><i class="fa fa-close" style="margin-right: 8px"></i>Annuler</button>
                <button type="button" id="modal_submit" class="btn btn-success float-right m-btn-submit-modal" ><i class="fa fa-check" style="margin-right: 8px"></i>Enregistrer</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


<!-- setting Add assoc-->
<div class="modal fade center-modal settings-add-assoc">
    <div class="modal-dialog" role="document" >
        <div class="modal-content" style="width : 650px">
            <div class="modal-header m-header-style">
                <h6 class="modal-title m-modal-title" >Ajouter une Association</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body ">
                {!! Form::open(['action' => 'PorteurController@store','method'=>'POST','class'=>'form-create']) !!}
                <div class="row" >
                    <div class="row col-12">
                        <div class="col-lg-2 col-md-2">
                            {{Form::label('','Raison fr :')}}
                        </div>
                        <div class="col-lg-3 col-md-3">
                            {{Form::text('nom_porteur_fr','',['class'=>'form-control','required'=>'required'])}}
                        </div>


                        <div class="col-lg-2 col-md-2">
                            {{Form::label('','Raison ar :')}}
                        </div>
                        <div class="col-lg-3 col-md-3">
                            {{Form::text('nom_porteur_ar','',['class'=>'form-control','required'=>'required'])}}
                        </div>

                    </div>


                    <div class="row col-12" style="margin-top: 8px">
                        <div class="col-lg-2 col-md-2">
                            {{Form::label('','Adresse :')}}
                        </div>
                        <div class="col-lg-3 col-md-3">
                            {{Form::text('adresse','',['class'=>'form-control','required'=>'required'])}}
                        </div>
                    </div>

                </div>




            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default m-btn-cancel-modal" data-dismiss="modal"><i class="fa fa-close" style="margin-right: 8px"></i>Annuler</button>
                <button type="submit"  class="btn btn-success float-right m-btn-submit-modal" ><i class="fa fa-check" style="margin-right: 8px"></i>Ajouter</button>
            </div>
            {!! Form::close() !!}
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>



<!-- setting Add src-->
<div class="modal fade center-modal settings-add-src">
    <div class="modal-dialog" role="document" >
        <div class="modal-content" style="width : 650px">
            <div class="modal-header m-header-style">
                <h6 class="modal-title m-modal-title" >Ajouter une source de financement</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body ">
                {!! Form::open(['action' => 'SourceFinancementController@store','method'=>'POST','class'=>'form-create']) !!}
                <div class="row" >
                    <div class="row col-12">
                        <div class="col-lg-2 col-md-2">
                            {{Form::label('','Source :')}}
                        </div>
                        <div class="col-lg-3 col-md-3">
                            {{Form::text('source','',['class'=>'form-control','required'=>'required'])}}
                        </div>


                        <div class="col-lg-2 col-md-2">
                            {{Form::label('','Code :')}}
                        </div>
                        <div class="col-lg-3 col-md-3">
                            {{Form::text('reference','',['class'=>'form-control','required'=>'required'])}}
                        </div>

                    </div>


                    <div class="row col-12" style="margin-top: 8px">
                        <div class="col-lg-2 col-md-2">
                            {{Form::label('','Montant de crédit :')}}
                        </div>
                        <div class="col-lg-3 col-md-3">
                            {{Form::text('montant_credit','',['class'=>'form-control','required'=>'required'])}}
                        </div>
                    </div>
                </div>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default m-btn-cancel-modal" data-dismiss="modal"><i class="fa fa-close" style="margin-right: 8px"></i>Annuler</button>
                <button type="submit"  class="btn btn-success float-right m-btn-submit-modal" ><i class="fa fa-check" style="margin-right: 8px"></i>Ajouter</button>
            </div>
            {!! Form::close() !!}
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>




<!-- setting Add Session-->
<div class="modal fade center-modal settings-add-session">
    <div class="modal-dialog" role="document" >
        <div class="modal-content" style="width : 650px">
            <div class="modal-header m-header-style">
                <h6 class="modal-title m-modal-title" >Ajouter une session</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body ">
                {!! Form::open(['action' => 'SessionController@store','method'=>'POST','class'=>'form-create']) !!}
                <div class="row" >
                    <div class="row col-12">
                        <div class="col-lg-2 col-md-2">
                            {{Form::label('','N° session :')}}
                        </div>
                        <div class="col-lg-3 col-md-3">
                            {{Form::text('mois','',['class'=>'form-control','required'=>'required'])}}
                        </div>


                        <div class="col-lg-2 col-md-2">
                            {{Form::label('','Date :')}}
                        </div>
                        <div class="col-lg-3 col-md-3">
                            {{Form::text('date','',['class'=>'form-control','required'=>'required','id' => 'datepicker'])}}
                        </div>

                    </div>


                    <div class="row col-12" style="margin-top: 8px">
                        <div class="col-lg-2 col-md-2">
                            {{Form::label('','Type :')}}
                        </div>
                        <div class="col-lg-3 col-md-3">
                            <div class="form-group">
                                <select  class="form-control select2" style="width: 100%;" name="type">
                                    <option value="ordinaire">Ordinaire</option>
                                    <option value="extraordinaire">Extraordinaire</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default m-btn-cancel-modal" data-dismiss="modal"><i class="fa fa-close" style="margin-right: 8px"></i>Annuler</button>
                <button type="submit"  class="btn btn-success float-right m-btn-submit-modal" ><i class="fa fa-check" style="margin-right: 8px"></i>Ajouter</button>
            </div>
            {!! Form::close() !!}
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>



