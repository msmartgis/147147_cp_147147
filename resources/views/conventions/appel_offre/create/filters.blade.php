
<div class="filters" style="margin-bottom: 4px;margin-top: 6px">
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

        <div class="col-lg-1">
            <label>MOA :</label>
        </div>
        <div class="col-lg-3">
            <div class="form-group">
                <select class="form-control select2" style="width: 100%;" name="moas" id="moas_filter">
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
            <label >Programme :</label>
        </div>
        <div class="col-lg-3">
            <div class="form-group">
                <select class="form-control select2" style="width: 100%;" name="programmes" id="programmes_filter">
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
            <label style="font-size: 12px;">Etat de versement :</label>
        </div>


        <div class="form-group col-lg-1">

            <select class="form-control select2" style="width: 100%;" name="etat_versement_from" id="etat_versement_from">
                <option value="all" selected>Indifferent</option>
                <option value="0" >0%</option>
                <option value="10" >10%</option>
                <option value="20" >20%</option>
                <option value="30" >30%</option>
                <option value="40" >40%</option>
                <option value="50" >50%</option>
                <option value="60" >60%</option>
                <option value="70" >70%</option>
                <option value="80" >80%</option>
                <option value="90" >90%</option>
                <option value="100" >100%</option>
            </select>
        </div>

        <div class="col-lg-1" style="max-width: 0.333333%;">
            A:
        </div>

        <div class="form-group col-lg-1 ">

            <select class="form-control select2" style="width: 100%;" name="etat_versement_to" id="etat_versement_to">
                <option value="all" selected>Indifferent</option>
                <option value="0" >0%</option>
                <option value="10" >10%</option>
                <option value="20" >20%</option>
                <option value="30" >30%</option>
                <option value="40" >40%</option>
                <option value="50" >50%</option>
                <option value="60" >60%</option>
                <option value="70" >70%</option>
                <option value="80" >80%</option>
                <option value="90" >90%</option>
                <option value="100" >100%</option>
            </select>
        </div>

    </div>

    <hr style="margin:4px">

</div>


