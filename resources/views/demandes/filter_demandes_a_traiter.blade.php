{!! Form::open(['action' => 'SpreadSheetController@demandeSpread_a_traiter','method'=>'POST','class'=>'']) !!}
<div class="filters" style="margin-bottom: 4px;">
    @if($is_mobile == 1)
        <h4 style="text-align: center;text-decoration: underline"> A TRAITER</h4>
    @endif
    <div class="row">
        <div class="col-lg-1">
            <label >Communes :</label>
        </div>
        <div class="col-lg-3">
            <div class="form-group">
                <select class="form-control select2" style="width: 100%;" name="communes_a_traiter" id="communes_filter_a_traiter">
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
                <select class="form-control select2" style="width: 100%;" name="localites_a_traiter" id="localites_filter_a_traiter">
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
                <select class="form-control select2" style="width: 100%;" name="partenaires_a_traiter" id="partenaires_filter_a_traiter">
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
                <select class="form-control select2" style="width: 100%;" name="session_id" id="session_filter_a_traiter">
                    <option value="all" selected>Indifferent</option>
                    @foreach($sessions as $session)
                        <option value="{{$session->id}}">{{$session->mois}} | {{$session->type}}</option>
                    @endforeach
                </select>
            </div>
            <!-- /.form-group -->
        </div>
        <div class="col-lg-1">
            <label>Intervention :</label>
        </div>
        <div class="col-lg-3">
            <div class="form-group">
                <select class="form-control select2" style="width: 100%;" name="interventions_a_traiter" id="intervention_filter_a_traiter">
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
                    <input type="text" class="form-control pull-right" name="daterange_a_traiter" id="reservation_a_traiter" style="font-size: 0.94rem;">
                </div>
            </div>
            <!-- /.form-group -->
        </div>
    </div>

    <hr style="margin:4px">

    @include('demandes.inc.action_button_a_traiter')

    <hr  style="margin:4px">
</div>

{!! Form::close()!!}
