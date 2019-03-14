{!! Form::open(['action' => 'SpreadSheetController@projetsSpreadSheet','method'=>'POST','class'=>'']) !!}
<div class="filters" style="margin-bottom: 4px;">
    <div class="row">
        <div class="col-lg-1">
            <label >Communes :</label>
        </div>
        <div class="col-lg-2">
            <div class="form-group">
                <select class="form-control select2" style="width: 100%;" name="communes" id="communes_filter">
                    <option value="all" selected>Indifferent</option>
                    @foreach($communes as $commune)
                        <option value="{{$commune->id}}">{{$commune->nom_fr}}</option>
                    @endforeach
                </select>
            </div>
            <!-- /.form-group -->
        </div>
        <div class="col-lg-1">
            <label >Localités :</label>
        </div>
        <div class="col-lg-2">
            <div class="form-group">
                <select class="form-control select2" style="width: 100%;" name="localites" id="localites_filter">
                    <option value="all" selected>Indifferent</option>
                    @foreach($localites as $localite)
                        <option value="{{$localite->nom_fr}}">{{$localite->nom_fr}}</option>
                    @endforeach
                </select>
            </div>
            <!-- /.form-group -->
        </div>

        <div class="col-lg-1">
            <label>Partenaires : </label>
        </div>
        <div class="col-lg-2">
            <div class="form-group">
                <select class="form-control select2" style="width: 100%;" name="partenaires" id="partenaires_filter">
                    <option value="all" selected>Indifferent</option>
                    @foreach ($partenaires_types as $type_part)
                        <option value="{{$type_part->id}}">{{$type_part->nom_fr}}</option>
                    @endforeach
                </select>
            </div>
            <!-- /.form-group -->
        </div>


        <div class="col-lg-1">
            <label>M.O.A : </label>
        </div>
        <div class="col-lg-2">
            <div class="form-group">
                <select class="form-control select2" style="width: 100%;" name="partenaires" id="partenaires_filter">
                    <option value="all" selected>Indifferent</option>
                    @foreach ($moas as $moa)
                        <option value="{{$moa->id}}">{{$moa->nom_fr}}</option>
                    @endforeach
                </select>
            </div>
            <!-- /.form-group -->
        </div>


    </div>

    <div class="row" style="margin-top: 4px">
        <div class="col-lg-1">
            <label >Session :</label>
        </div>
        <div class="col-lg-2">
            <div class="form-group">
                <select class="form-control select2" style="width: 100%;" name="session" id="session_filter">
                    <option value="all" selected>Indifferent</option>
                    @foreach ($sessions as $session)
                        <option value="{{$session->id}}">{{$session->nom}}</option>
                    @endforeach
                </select>
            </div>
            <!-- /.form-group -->
        </div>
        <div class="col-lg-1">
            <label>Type d'intervention :</label>
        </div>
        <div class="col-lg-2">
            <div class="form-group">
                <select class="form-control select2" style="width: 100%;" name="interventions" id="intervention_filter">
                    <option value="all" selected>Indifferent</option>
                    @foreach ($interventions as $intervention)
                        <option value="{{$intervention->id}}">{{$intervention->nom}}</option>
                    @endforeach
                </select>
            </div>
            <!-- /.form-group -->
        </div>

        <div class="col-lg-1">
            <label>Programme :</label>
        </div>
        <div class="col-lg-2">
            <div class="form-group">
                <select class="form-control select2" style="width: 100%;" name="programmes" id="programmes_filter">
                    <option value="all" selected>Indifferent</option>
                    @foreach ($programmes as $programme)
                        <option value="{{$programme->id}}">{{$programme->nom_fr}}</option>
                    @endforeach
                </select>
            </div>
            <!-- /.form-group -->
        </div>


        <div class="col-lg-1">
            <label>Avancement :</label>
        </div>
        <div class="col-lg-2">
            <div class="form-group">
                <select class="form-control select2" style="width: 100%;" name="avancement" id="avancement_filter">
                    <option value="all" selected>Indifferent</option>
                    @foreach ($avancement as $av)
                        <option value="{{$av->id}}">{{$av->pourcentage}}%</option>
                    @endforeach
                </select>
            </div>
            <!-- /.form-group -->
        </div>


    </div>

    <div class="row" style="margin-top : 4px">

        <div class="col-lg-1">
            <label>Plage de dates :</label>
        </div>
        <div class="col-lg-2">
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" class="form-control pull-right" name="daterange" id="reservation" style="font-size: 0.94rem;">
                </div>
            </div>
            <!-- /.form-group -->
        </div>

        <div class="col-lg-6">

        </div>

        <div class="col-lg-3">
                <a href="" class="btn btn-success pull-right" ><i class="fa fa-file-pdf-o" style="margin-right: 6px;"></i>Exporter PDF</a>
                <button type="submit" class="btn btn-success pull-right" style="margin-right: 6px;" ><i class="fa fa-file-excel-o" style="margin-right: 6px;"></i>Exporter CSV</button>
        </div>

    </div>

</div>

{!! Form::close()!!}
