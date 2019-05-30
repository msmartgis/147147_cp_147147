{!! Form::open(['action' => 'SpreadSheetController@demandeSpread_en_cours','method'=>'POST','class'=>'']) !!}
<div class="filters" style="margin-bottom: 4px;margin-top: 6px">

    <div class="row">
        <div class="col-lg-1">
            <label >Communes :</label>
        </div>
        <div class="col-lg-3">
            <div class="form-group">
                <select class="form-control select2" style="width: 100%;" name="communes_en_cours" id="communes_en_cours_filter">
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
                <select class="form-control select2" style="width: 100%;" name="localites_en_cours" id="localites_en_cours_filter">
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
                <select class="form-control select2" style="width: 100%;" name="partenaires_en_cours" id="partenaires_en_cours_filter">
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
            <label >Programme :</label>
        </div>
        <div class="col-lg-3">
            <div class="form-group">
                <select class="form-control select2" style="width: 100%;" name="programmes_en_cours" id="programmes_en_cours_filter">
                    <option value="all" selected>Indifferent</option>
                    @foreach ($programmes as $pr)
                        <option value="{{$pr->id}}">{{$pr->nom_fr}}</option>
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
                <select class="form-control select2" style="width: 100%;" name="interventions_en_cours" id="intervention_en_cours_filter">
                    <option value="all" selected>Indifferent</option>
                    @foreach ($interventions as $intervention)
                        <option value="{{$intervention->id}}">{{$intervention->nom}}</option>
                    @endforeach
                </select>
            </div>
            <!-- /.form-group -->
        </div>
        <div class="col-lg-1">
            <label>MOA :</label>
        </div>
        <div class="col-lg-3">
            <div class="form-group">
                <select class="form-control select2" style="width: 100%;" name="moas_en_cours" id="moas_en_cours_filter">
                    <option value="all" selected>Indifferent</option>
                    @foreach ($moas as $moa)
                        <option value="{{$moa->id}}">{{$moa->nom_fr}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <div class="row" style="margin-top: 4px">
        <div class="col-lg-1">
            <label>Année :</label>
        </div>
        <div class="col-lg-3">
            <div class="form-group">
                <select class="form-control select2" style="width: 100%;" name="annee_en_cours" id="annee_en_cours_filter">
                    <option value="all" selected>Indifferent</option>
                    @for($i = 0; $i < 20 ; $i++)
                        <option value="{{$year_number - $i}}">{{$year_number - $i}}</option>
                    @endfor
                </select>
            </div>
        </div>

    </div>

    <hr style="margin:4px">

    @include('projets.inc.action_button_projet')

    <hr  style="margin:4px">
</div>

{!! Form::close()!!}
