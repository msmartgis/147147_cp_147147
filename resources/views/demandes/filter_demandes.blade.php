{!! Form::open(['action' => 'SpreadSheetController@demandeSpread_en_cours','method'=>'POST','class'=>'']) !!}
<div class="filters" style="margin-bottom: 4px;">
    <div class="row">
        <div class="col-md-3">
            <div class="form-group">
                <label>Communes</label>
                <select class="form-control select2" style="width: 100%;" name="communes" id="communes_filter">
                    <option value="all" selected>Indifferent</option>
                    @foreach($communes as $commune)
                    <option value="{{$commune->id}}">{{$commune->nom_fr}}</option>
                    @endforeach
                </select>
            </div>
            <!-- /.form-group -->
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label>Localités</label>                
                <select class="form-control select2" style="width: 100%;" name="localites" id="localites_filter">
                    <option value="all" selected>Indifferent</option>
                    @foreach($localites as $localite)
                    <option value="{{$localite->nom_fr}}">{{$localite->nom_fr}}</option>
                    @endforeach
                </select>
            </div>
            <!-- /.form-group -->
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label>Partenaires : </label>                
                <select class="form-control select2" style="width: 100%;" name="partenaires" id="partenaires_filter">
                    <option value="all" selected>Indifferent</option>
                    @foreach ($partenaires_types as $type_part)
                    <option value="{{$type_part->id}}">{{$type_part->nom_fr}}</option>
                    @endforeach
                </select>
            </div>
            <!-- /.form-group -->
        </div>


        <div class="col-md-3 " style="margin-top: 21px;">
            <a href="/demandes/create" class="btn btn-secondary pull-right"><i class="fa fa-plus" style="margin-right: 6px"></i>Ajouter
                une demande</a>
            <a href="" class="btn btn-secondary pull-right" style="margin-right : 6px"><i class="fa fa-print" style="margin-right: 6px"></i>Imprimer
                la fiche</a>
        </div>


    </div>

    <div class="row" style="margin-top:8px">
        <div class="col-md-3">
            <div class="form-group">
                <label>Session</label>
                <select class="form-control select2" style="width: 100%;" name="session" id="session_filter">
                    <option value="all" selected>Indifferent</option>
                    @foreach ($sessions as $session)
                    <option value="{{$session->id}}">{{$session->nom}}</option>
                    @endforeach
                </select>
            </div>
            <!-- /.form-group -->
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label>Type d'intervention</label>
                <select class="form-control select2" style="width: 100%;" name="interventions" id="intervention_filter">
                    <option value="all" selected>Indifferent</option>
                    @foreach ($interventions as $intervention)
                    <option value="{{$intervention->id}}">{{$intervention->nom}}</option>
                    @endforeach
                </select>
            </div>
            <!-- /.form-group -->
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label>Plage de dates</label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" class="form-control pull-right" name="daterange" id="reservation">
                </div>
            </div>
            <!-- /.form-group -->
        </div>

        <div class="col-md-3" style="margin-top: 21px;">
            <a href="" class="btn btn-success pull-right" ><i class="fa fa-file-pdf-o" style="margin-right: 6px;"></i>Exporter PDF</a>

            <button type="submit" class="btn btn-success pull-right" style="margin-right: 6px;" ><i class="fa fa-file-excel-o" style="margin-right: 6px;"></i>Exporter CSV</button>
        </div>
    </div>


</div>

{!! Form::close()!!}
