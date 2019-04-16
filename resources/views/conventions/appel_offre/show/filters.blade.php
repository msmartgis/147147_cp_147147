{!! Form::open(['action' => 'SpreadSheetController@demandeSpread_en_cours','method'=>'POST','class'=>'']) !!}
<div class="filters" style="margin-bottom: 4px;margin-top: 6px">
    <div class="row">
        <div class="col-lg-1">
            <label >MOA :</label>
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
            <label>Etat :</label>
        </div>
        <div class="col-lg-3">
            <div class="form-group">
                <select class="form-control select2" style="width: 100%;" name="etat" id="etat_filter">
                    <option value="all" selected>Indifferent</option>
                    <option value="publie" >Publié</option>
                    <option value="en_preparation" >En préparation</option>
                </select>
            </div>
        </div>
    </div>

    <div class="row" style="margin-top: 4px">

        <div class="col-lg-1">
            <label>Date Publication :</label>
        </div>
        <div class="col-lg-3">
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" class="form-control pull-right" name="daterange_publication" id="reservation" style="font-size: 0.94rem;">
                </div>
            </div>
            <!-- /.form-group -->
        </div>


        <div class="col-lg-1">
            <label style="font-size: 12px;">Date Ouverture plis :</label>
        </div>
        <div class="col-lg-3">
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" class="form-control pull-right" name="daterange_ouverture_plis" id="ouverture_plis" style="font-size: 0.94rem;">
                </div>
            </div>
            <!-- /.form-group -->
        </div>
    </div>

    <hr style="margin:4px">

    @include('conventions.appel_offre.show.action_btn_appel_offre')

    <hr  style="margin:4px">
</div>

{!! Form::close()!!}
