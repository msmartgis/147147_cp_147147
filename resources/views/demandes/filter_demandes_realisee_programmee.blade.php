<div class="filters" style="margin-bottom: 24px;margin-top: 8px">
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label>Communes</label>
                <select class="form-control select2" style="width: 100%;" name="communes_realisee_programmee" id="communes_filter_realisee_programmee">
                    <option value="all" selected>Indifferent</option>
                    @foreach($communes as $commune)
                    <option value="{{$commune->id}}">{{$commune->nom_fr}}</option>
                    @endforeach
                </select>
            </div>
            <!-- /.form-group -->
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label>Localités</label>
                <select class="form-control select2" style="width: 100%;" name="localites_realisee_programmee" id="localites_filter_realisee_programmee">
                    <option value="all" selected>Indifferent</option>
                    @foreach($localites as $localite)
                    <option value="{{$localite->nom_fr}}">{{$localite->nom_fr}}</option>
                    @endforeach
                </select>
            </div>
            <!-- /.form-group -->
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label>Partenaires : </label>
                <select class="form-control select2" style="width: 100%;" name="partenaires_realisee_programmee" id="partenaires_filter_realisee_programmee">
                    <option value="all" selected>Indifferent</option>
                    @foreach ($partenaires_types as $type_part)
                    <option value="{{$type_part->id}}">{{$type_part->nom_fr}}</option>
                    @endforeach
                </select>
            </div>
            <!-- /.form-group -->
        </div>
    </div>

    <div class="row" style="margin-top:8px">
        <div class="col-md-4">
            <div class="form-group">
                <label>Session</label>
                <select class="form-control select2" style="width: 100%;" name="session_realisee_programmee" id="session_filter_realisee_programmee">
                    <option value="all" selected>Indifferent</option>
                    @foreach ($sessions as $session)
                    <option value="{{$session->id}}">{{$session->nom}}</option>
                    @endforeach

                </select>
            </div>
            <!-- /.form-group -->
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label>Type d'intervention</label>
                <select class="form-control select2" style="width: 100%;" name="interventions_realisee_programmee" id="intervention_filter_realisee_programmee">
                    <option value="all" selected>Indifferent</option>
                    @foreach ($interventions as $intervention)
                    <option value="{{$intervention->id}}">{{$intervention->nom}}</option>
                    @endforeach
                </select>
            </div>
            <!-- /.form-group -->
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label>Plage de dates</label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" class="form-control pull-right" name="daterange_realisee_programmee" id="reservation_realisee_programmee">
                </div>
            </div>
            <!-- /.form-group -->
        </div>
    </div>
</div>
