
<div class="row">
    <div class="col-lg-10">
        <div class="row">
            <div class="col-12">
                <div class="box" style="border-top: 0;border-bottom: 0">
                    <!-- /.box-header -->
                    <div class="box-body">
                        <h5>OBJET</h5>
                        <hr style="color:#2d353c;margin:0">
                        <div class="row" style="margin-top: 8px">
                            <div class="col-lg-6">
                                <div class="form-group">

                                    <div class="controls">
                                        {{Form::textarea('objet_fr',$convention->objet_fr,['class'=>'form-control','rows'=>'2','style'=>'height: 52px !important'])}}
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <div class="controls">
                                        {{Form::textarea('objet_ar',$convention->objet_ar,['class'=>'form-control','rows'=>'2','style'=>'height: 52px !important'])}}
                                    </div>
                                </div>
                            </div>
                        </div>
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
                                    'name'=>'interventions[]'
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
                                            <th></th>
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

                                                <td style="text-align: center">
                                                    <button type="button" class="btn btn-success-table add-versement"  data-id="{{$item->nom_fr}}_{{$item->id}}_{{$item->pivot->montant}}"
                                                    @if($montant_verse/($item->pivot->montant)*100 == 100)
                                                        disabled
                                                    @endif
                                                    >
                                                        <i class="fa fa-plus-circle"></i>
                                                        Ajouter versement</button>
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
                                            <th></th>
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

                                                <td style="text-align: center; width : 15%">
                                                    <button type="button" class="btn btn-danger-table delete-versement"  data-id="{{$versement->id}}" >
                                                        <i class="fa fa-times-circle"></i>
                                                        Supprimer versement</button>
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

                    <div class="form-group">
                        {{Form::label('','Programme:')}}
                        {{Form::text('programme',$convention->programme->nom_fr,['class'=>'form-control'])}}
                    </div>
                    <div class="form-group">
                        {{Form::label('','MOA:')}}
                        {{Form::text('moa',$convention->moas->nom_fr,['class'=>'form-control'])}}
                    </div>

                    <div class="form-group">
                        {{Form::label('','Montant global DH:')}}
                        {{Form::text('montant_global',$convention->montant_global,['class'=>'form-control'])}}
                    </div>

                    <div class="form-group">
                        {{Form::hidden('id_pist',$convention->piste->id)}}
                        {{Form::label('','Longueur:')}}
                        {{Form::text('longueur',$convention->piste->longueur,['class'=>'form-control'])}}
                    </div>
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
                    <br>

                    <a href="/convention/{{$convention->id}}/edit">
                        <button type="button" class="btn btn-secondary col-12"   style="margin-top: 8px !important"><i class="fa fa-file" style="margin-right: 4px"></i> Accéder aux détails du projet</button>
                    </a>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /. box -->
        </div>
    </div>
    <!-- /.col -->
</div>
<!-- /.row -->