<form action=""  method="post" class="en-cours-demande-form">
    <input type="hidden" name="_token" value="{{csrf_token()}}">
    <div class="filters" style="margin-bottom: 4px;">
        @if($is_mobile == 1)
            <h4 style="text-align: center;text-decoration: underline">EN COURS</h4>
        @endif

        <div class="row">
            <div class="col-lg-1">
                <label >Communes :</label>
            </div>
            <div class="col-lg-3">
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
            <div class="col-lg-3">
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
            <div class="col-lg-3">
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
        </div>

        <div class="row" style="margin-top: 4px">
            <div class="col-lg-1">
                <label >Session :</label>
            </div>
            <div class="col-lg-3">
                <div class="form-group">
                    <select class="form-control select2" style="width: 100%;" name="session_id" id="session_filter">
                        <option value="all" selected>Indifferent</option>
                        @foreach($sessions as $session)
                            <option value="{{$session->id}}">{{$session->mois}} | {{$session->type}}</option>
                        @endforeach
                    </select>
                </div>
                <!-- /.form-x -->
            </div>
            <div class="col-lg-1">
                <label>Intervention :</label>
            </div>
            <div class="col-lg-3">
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
                <label>Plage de dates :</label>
            </div>
            <div class="col-lg-3">
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
        </div>

    </div>
</form>
<hr style="margin:4px">
@include('demandes.inc.action_button_en_cours')
<hr  style="margin:4px">
