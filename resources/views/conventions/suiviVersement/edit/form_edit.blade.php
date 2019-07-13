
<div class="row">
    <div class="col-lg-10">
        <div class="row">
            <div class="col-12">
                <div class="box" style="border-top: 0;border-bottom: 0">
                    <!-- /.box-header -->
                    <div class="box-body">
                        @if($is_mobile == 1)
                            @include('inc.go_back_btn_mobile')
                        @endif
                        <h5>OBJET</h5>
                        <hr style="color:#2d353c;margin:0">
                        @if($is_mobile == 1)
                            <div class="row">
                                <div class="col-lg-6 col-xl-6 col-md-6 col-12">
                                    <div class="form-group">

                                        <div class="controls">
                                            {{Form::textarea('objet_fr',$convention->objet_fr,['class'=>'form-control','rows'=>'2','style'=>'height: 52px !important' ,'disabled' => 'disabled'])}}
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="row" style="margin-top: 8px !important;">
                                <div class="col-lg-6 col-xl-6 col-md-6 col-12">
                                    <div class="form-group">
                                        <div class="controls">
                                            {{Form::textarea('objet_ar',$convention->objet_ar,['class'=>'form-control','rows'=>'2','style'=>'height: 52px !important','disabled' => 'disabled'])}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="row" style="margin-top: 8px">
                                <div class="col-lg-6">
                                    <div class="form-group">

                                        <div class="controls">
                                            {{Form::textarea('objet_fr',$convention->objet_fr,['class'=>'form-control','rows'=>'2','style'=>'height: 52px !important','disabled' => 'disabled'])}}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <div class="controls">
                                            {{Form::textarea('objet_ar',$convention->objet_ar,['class'=>'form-control','rows'=>'2','style'=>'height: 52px !important','disabled' => 'disabled'])}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                    @endif
                        <!-- /.row -->
                        <h5>INTERVENTIONS </h5>
                        <hr style="color:#2d353c;margin:0">
                        <div class="row">
                            <div class="col-12" style="margin-top : 8px">
                                <div class="form-group">
                                    {{Form::select('interventions', $interventions, $convention->interventions->pluck('id'),
                                    [
                                    'data-placeholder' => 'Selectionner commune(s)',
                                    'class'=>'form-control select2',
                                    'multiple'=>'multiple',
                                    'name'=>'interventions[]',
                                    'disabled' => 'disabled'
                                    ]
                                    )}}
                                </div>
                            </div>
                    </div>

                        <div class="row">
                            <div class="col-12" style="margin-top : 8px">
                                <h5>MONTAGE FINANCIER DEFINITIF</h5>
                                <hr style="color:#2d353c;margin-top:0px;margin-bottom: 4px">
                                <div class="table-responsive">
                                    <table class="table table-piece">
                                        <tr style="text-align: center;">
                                            <th>Nom partenaire</th>
                                            <th>Montant(DH)</th>
                                            <th>Pourcentage(%)</th>
                                            @if($is_mobile == 0)
                                                <th></th>
                                            @endif
                                        </tr>
                                        <tbody id="partenaire_tbody">
                                        @foreach ($convention->partenaires as $item)
                                            @php
                                                $montant_verse = 0;
                                            @endphp

                                            @foreach($convention->versements as $versement)
                                                @if($versement->partenaire_id == $item->id)
                                                    @php
                                                        $montant_verse +=  $versement->montant;
                                                    @endphp
                                                @endif
                                            @endforeach
                                            <tr>
                                                <td style="text-align: center">
                                                    {{$item->nom_fr}}
                                                </td>
                                                <td style="text-align: center">
                                                    {{number_format($item->pivot->montant,2)}}

                                                </td>
                                                <td style="text-align: center">
                                                    {{number_format($item->pivot->montant/($convention->montant_global)*100,2)}}
                                                </td>
                                                @if($is_mobile == 0)
                                                    <td style="text-align: center">
                                                        <button type="button" class="btn btn-success-table add-versement"  data-id="{{$item->nom_fr}}_{{$item->id}}_{{$item->pivot->montant}}"
                                                        @if($montant_verse/($item->pivot->montant)*100 == 100)
                                                            disabled
                                                        @endif
                                                        style="display: none">
                                                            <i class="fa fa-plus-circle"></i>
                                                            Ajouter versement</button>
                                                    </td>
                                                @endif
                                            </tr>
                                        @endforeach
                                        <tr>

                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-12" style="margin-top : 8px">
                                <h5>ETAT DES VERSEMENTS</h5>
                                <hr style="color:#2d353c;margin-top:0px;margin-bottom: 4px">
                                <div class="table-responsive">
                                    <table class="table table-piece">
                                        <tr style="text-align: center;">
                                            <th>Partenaire</th>
                                            <th>Montant Versé</th>
                                            <th>Reste</th>
                                            <th>%</th>
                                        </tr>
                                        <tbody id="versement_tbody">
                                            @foreach ($convention->partenaires as $item)
                                                @php
                                                    $montant_verse = 0;
                                                @endphp

                                                @foreach($convention->versements as $versement)
                                                    @if($versement->partenaire_id == $item->id)
                                                        @php
                                                            $montant_verse +=  $versement->montant;
                                                        @endphp
                                                    @endif
                                                @endforeach


                                                <tr>
                                                    <td style="text-align: center">
                                                        {{$item->nom_fr}}
                                                    </td>
                                                    <td style="text-align: center">
                                                        @php
                                                            echo($montant_verse);
                                                        @endphp

                                                    </td>

                                                    <td style="text-align: center">
                                                        @php
                                                            echo($item->pivot->montant-$montant_verse);
                                                        @endphp

                                                    </td>
                                                    <td style="text-align: center">
                                                        @php
                                                            echo(number_format($montant_verse/($item->pivot->montant)*100));
                                                        @endphp
                                                    </td>
                                                </tr>
                                            @endforeach
                                        <tr>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-12" style="margin-top : 8px">
                                <h5>DETAILS DES VERSEMENTS</h5>
                                <hr style="color:#2d353c;margin-top:0px;margin-bottom: 4px">
                                <div class="table-responsive">
                                    <table class="table table-versement-details">
                                        <tr style="text-align: center;">
                                            <th>N°</th>
                                            <th>Partenaire</th>
                                            <th>Date</th>
                                            <th>Montant Versé</th>
                                            <th>Nom document</th>
                                            <th>Pris en charge</th>
                                            <th></th>
                                            @if($is_mobile == 0)
                                                <th></th>
                                            @endif
                                        </tr>
                                        <tbody id="versement_log_tbody">
                                        @php
                                            $i = 1;
                                        @endphp
                                        @foreach($versements as $versement)
                                            <tr>
                                                <td style="text-align: center;">
                                                    @php
                                                       echo($i++);
                                                    @endphp
                                                </td>

                                                <td style="text-align: center;">
                                                    {{$versement->partenaire->nom_fr}}
                                                </td>

                                                <td style="text-align: center;">
                                                    {{$versement->date_versement}}
                                                </td>

                                                <td style="text-align: center;">
                                                    {{$versement->montant}}
                                                </td>

                                                <td style="text-align: center;">
                                                    {{$versement->document}}
                                                </td>
                                                <td style="text-align: center">
                                                    @if($versement->prise_en_charge == 1)
                                                        OUI
                                                    @endif

                                                        @if($versement->prise_en_charge == 0)
                                                            NON
                                                        @endif
                                                </td>
                                                @if($versement->path != "")
                                                <form action="{{route('versement.download')}}" method="get">
                                                    <input type="hidden" name="id" value="{{$versement->id}}">
                                                    <td style="text-align: center;">
                                                            <button type="submit" class="btn btn-secondary-table ">
                                                                <i class="fa fa-download"></i>
                                                                Télécharger</button>
                                                    </td>
                                                </form>
                                                @elseif($versement->path == "")
                                                    <td></td>
                                                @endif
                                                @if($is_mobile == 0)
                                                    <td style="text-align: center; width : 15%">
                                                        <button type="button" class="btn btn-danger-table delete-versement"  data-id="{{$versement->id}}" style="display: none">
                                                            <i class="fa fa-times-circle"></i>
                                                            Supprimer versement</button>
                                                    </td>
                                                @endif
                                            </tr>
                                        @endforeach
                                        <tr>
                                        </tr>
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </div>
    </div>
    <!-- /.col -->
    <div class="col-lg-2" style="padding-left: 0px !important;">
        <div class="h-p100  bg-light bg-secondary-gradient" style="padding-right: 5px">
            <div class="box bg-transparent no-border no-shadow">
                <div class="box-body no-padding mailbox-nav">
                    @if($is_mobile == 0)
                        @include('inc.go_back_btn')
                    @endif


                    <div class="row row-edit">
                        <div class="col-lg-3">
                            {{Form::label('','Programme:',['style'=> 'font-size : 11px'])}}
                        </div>
                        <div class="col-lg-9">
                            <div class="form-group form-group-edit">

                                {{Form::text('programme',$convention->programme->nom_fr,['class'=>'form-control','disabled'])}}
                            </div>
                        </div>
                    </div>


                    <div class="row row-edit">
                        <div class="col-lg-3">
                            {{Form::label('','M.O.A:',['style'=> 'font-size : 11px'])}}
                        </div>
                        <div class="col-lg-9">
                            <div class="form-group form-group-edit">

                                {{Form::text('moa',$convention->moas->nom_fr,['class'=>'form-control','disabled'])}}
                            </div>
                        </div>
                    </div>


                    <div class="row row-edit">
                        <div class="col-lg-3">
                            {{Form::label('','M.Total(DHS):',['style'=> 'font-size : 11px'])}}
                        </div>
                        <div class="col-lg-9">
                            <div class="form-group form-group-edit">
                                {{Form::text('montant_global',$convention->montant_global,['class'=>'form-control','disabled'])}}
                            </div>
                        </div>
                    </div>


                    <div class="row row-edit">
                        <div class="col-lg-3">
                            {{Form::label('','Longueur(KM):',['style'=> 'font-size : 11px'])}}
                        </div>
                        <div class="col-lg-9">
                            <div class="form-group form-group-edit">
                                {{Form::hidden('id_pist',$convention->piste->id)}}
                                {{Form::text('longueur',$convention->piste->longueur,['class'=>'form-control','disabled'])}}
                            </div>
                        </div>
                    </div>
                    @if($is_mobile == 0)
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        @endif
                    <br>
                        @if($is_mobile == 0)
                            <h5>Edition : </h5>
                            <hr>
                            <button type="button" id="activate_edit_btn" class="btn  btn-secondary-edit" style="color : #1118c5" ><i class="fa fa-edit" style="margin-right: 8px;"></i>Activer la modification</button>
                        @endif
                    <div  style="margin-right: 8px !important;">
                        <a href="/convention/{{$convention->id}}/edit">
                            <button type="button" class="btn btn-secondary-edit col-12"   style="margin-top: 8px !important"><i class="fa fa-file" style="margin-right: 4px"></i> Accéder aux détails du projet</button>
                        </a>
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /. box -->
        </div>
    </div>
    <!-- /.col -->
</div>
<!-- /.row -->