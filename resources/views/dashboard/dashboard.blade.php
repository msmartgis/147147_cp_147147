@extends('layouts.app')

@section('added_css')
    <link rel="stylesheet" href="{{asset('css/datatable/datatables.min.css')}}" />

    <style>
        .m-footer
        {
            color: #000;
            background-color: rgba(255, 56, 32, 0.44) !important;
            font-weight: 600;
        }
    </style>
@endsection

@section('content')
    <div class="statitics" style="padding-top: 1px;padding-left: 10px;padding-right: 10px;">
        <div class="row" style="margin-top: 8px">
            <div class="col-xl-2 col-md-6 col-6" style="flex: 0 0 20%;max-width: 20%;">
                <!-- small box -->
                <div class="small-box bg-info">
                    <div class="inner" style="background-color: #f1f1f1;">
                        <h3 style="color: #1a74c3;">{{$nombre_projet}}</h3>

                        <p style="color: #1a74c3;">Nombre de projets</p>
                    </div>
                    <div class="icon" >
                        <i class="fa fa-tasks " style="color: #1a74c3;"></i>
                    </div>
                    <a href="/projet" class="small-box-footer" style="z-index: 0;"><b>Voir les details </b> <i class="fa fa-arrow-right" ></i></a>
                </div>
            </div>


            <div class="col-xl-2 col-md-6 col-6" style="flex: 0 0 20%;max-width: 20%;">
                <!-- small box -->
                <div class="small-box bg-success" style="background-color: #9fd037 !important;">
                    <div class="inner" style="background-color: #f1f1f1;">
                        <h3 style="color: #9fd037;">{{$nbr_projet_realise}}</h3>

                        <p style="color: #9fd037;">Réalisés  </p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-thumbs-up " style="color: #9fd037;"></i>
                    </div>
                    <a href="/projet" class="small-box-footer" style="z-index: 0;"><b>Voir les details </b> <i class="fa fa-arrow-right"></i></a>
                </div>
            </div>


            <div class="col-xl-2 col-md-6 col-6" style="flex: 0 0 20%;max-width: 20%;">
                <!-- small box -->
                <div class="small-box bg-danger">
                    <div class="inner" style="background-color: #f1f1f1;">
                        <h3 style="color: #d6405c;">{{$nbr_projet_en_cours}}</h3>

                        <p style="color: #d6405c;">En cours de réalisation  </p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-clock-o  " style="color: #d6405c;"></i>
                    </div>
                    <a href="/projet" class="small-box-footer" style="z-index: 0;"><b>Voir les details </b> <i class="fa fa-arrow-right"></i></a>
                </div>
            </div>

            <div class="col-xl-2 col-md-6 col-6" style="flex: 0 0 20%;max-width: 20%;">
                <!-- small box -->
                <div class="small-box bg-primary" style="background-color: #ad13ef !important;">
                    <div class="inner" style="background-color: #f1f1f1;">
                        <h3 style="color: #ad13ef;">{{$nbr_projet_programmes}}</h3>

                        <p style="color: #ad13ef;">Programmés </p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-calendar" style="color: #ad13ef;"></i>
                    </div>
                    <a href="/projet" class="small-box-footer" style="z-index: 0;"><b>Voir les details </b> <i class="fa fa-arrow-right"></i></a>
                </div>
            </div>

            <div class="col-xl-2 col-md-6 col-6" style="flex: 0 0 20%;max-width: 20%;">
                <!-- small box -->
                <div class="small-box bg-primary" style="background-color: #000 !important;">
                    <div class="inner" style="background-color: #f1f1f1;">
                        <h3 style="color: #000;">{{ $cout_total_projets }} </h3>

                        <p style="color: #000;">Coût Total (MDH) </p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-money" style="color: #000;"></i>
                    </div>
                    <a href="/projet" class="small-box-footer" style="z-index: 0;"><b>Voir les details </b> <i class="fa fa-arrow-right"></i></a>
                </div>
            </div>

        </div>


        <h5>NOMBRE DES PROJETS</h5>
        <hr>


        <div class="row" style="margin-top: 8px">
            <div class="col-12">
                        <div class="table-responsive" style="margin-top: 8px">
                            <table class="table table-hover table-striped datatables" id="nombre_projet_datatables" style="width:100% ;">
                                <thead>
                                    <th>Programme</th>
                                    <th>Nombre de projets</th>
                                    <th>Coût (MDH)</th>
                                    <th>Réalisés(KM) </th>
                                    <th>En cours (KM)</th>
                                    <th>Programmés (KM)</th>
                                    <th>Total (KM)</th>
                                </thead>

                                <tfoot>
                                <tr class="m-footer">
                                    <td >Total:</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                </tfoot>

                            </table>
                        </div>
                    <!-- /.box-body -->

                <!-- /.box -->
            </div>
        </div>


        <h5>NATURE DES INTERVENTIONS</h5>
        <hr>
        <div class="row" style="margin-top: 8px">
            <div class="col-12">

                        <div class="table-responsive" style="margin-top: 8px">
                            <table class="table table-hover table-striped datatables" id="intervention_projet_datatables" style="width:100% ;">
                                <thead>
                                <th>Programme</th>
                                <th>Terrassement</th>
                                <th>Revetement</th>
                                <th>Dallage </th>
                                <th>Pavé</th>
                                <th>Recallibrage</th>
                                <th>Elargissement</th>
                                <th>Renforcement</th>
                                <th>Ouvrages d'art</th>
                                <th>Entretien</th>
                                <th>Etude</th>
                                </thead>
                                <tfoot>
                                    <tr class="m-footer">
                                        <td >Total:</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </tfoot>


                            </table>
                        </div>

                    <!-- /.box-body -->

                <!-- /.box -->
            </div>
        </div>
    </div>

@endsection

@push('added_scripts')
<script src="{{asset('css/datatable/datatables.min.js')}}"></script>
<script src="{{asset('js/TBD/datatables_nombre_projet.js')}}"></script>
<script src="{{asset('js/TBD/datatables_intervention_projet.js')}}"></script>
<script src="{{asset('js/sum().js')}}"></script>
@endpush