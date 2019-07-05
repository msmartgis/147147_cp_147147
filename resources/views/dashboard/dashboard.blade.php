@extends('layouts.app')

@section('added_css')
    <link rel="stylesheet" href="{{asset('css/datatable/datatables.min.css')}}" />

    <style>
        .m-footer
        {
            color: #ff1308 !important;
            font-weight: 600;
        }

        .small-box>.inner {
            padding: 0.75rem;
        }
        .small-box
        {
            margin-bottom: 10px;
        }
        h5
        {
            font-weight: 600;
        }



        .text-styling
        {
            font-size: 14px;
            color: #000;

        }

        .text-center
        {
            font-size: 14px;
            color: #000;
        }


        .table th, .table  td
        {
            border-right: 1px solid #f4f4f4;
        }


        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(0,0,0,.05) !important;
        }
        th{
            background-color: unset !important;
        }


        .m-thead
        {
            font-family: Lato;
            font-weight: 700 !important;
            font-size: 15px !important;
        }


        .m-thead-mobile
        {
            font-family: Lato;
            font-weight: 600 !important;
            font-size: 13px !important;

        }



    </style>
@endsection

@section('content')
    <div class="statitics " style="padding-top: 10px;padding-left: 10px;padding-right: 10px;">

        {{--verify the user gaent if is mobile--}}
            @if($is_mobile == 0)
                <div class="row">
                    <div class="col-xl-3 col-lg-3 col-md-6 col-12" >
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

                    <div class="col-xl-3 col-lg-3 col-md-6 col-12" >
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

                    <div class="col-xl-3 col-lg-3 col-md-6 col-12" >
                        <!-- small box -->
                        <div class="small-box bg-primary" style="background-color: #22ef49 !important;">
                            <div class="inner" style="background-color: #f1f1f1;">
                                <h3 style="color: #ad13ef;">{{$appel_offre}}</h3>

                                <p style="color: #ad13ef;">Appel d'offre </p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-newspaper-o" style="color: #22ef49;"></i>
                            </div>
                            <a href="/projet" class="small-box-footer" style="z-index: 0;"><b>Voir les details </b> <i class="fa fa-arrow-right"></i></a>
                        </div>
                    </div>


                    <div class="col-xl-3 col-lg-3 col-md-6 col-12" >
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
                </div>


                <div class="row">

                    <div class="col-xl-3 col-lg-3 col-md-6 col-12" >
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


                    <div class="col-xl-3 col-lg-3 col-md-6 col-12" >
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
            @else
                <div class="col-xl-3 col-lg-3 col-md-6 col-12" >
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

                <div class="col-xl-3 col-lg-3 col-md-6 col-12" >
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

                <div class="col-xl-3 col-lg-3 col-md-6 col-12" >
                    <!-- small box -->
                    <div class="small-box bg-primary" style="background-color: #22ef49 !important;">
                        <div class="inner" style="background-color: #f1f1f1;">
                            <h3 style="color: #ad13ef;">{{$appel_offre}}</h3>

                            <p style="color: #ad13ef;">Appel d'offre </p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-newspaper-o" style="color: #22ef49;"></i>
                        </div>
                        <a href="/projet" class="small-box-footer" style="z-index: 0;"><b>Voir les details </b> <i class="fa fa-arrow-right"></i></a>
                    </div>
                </div>


                <div class="col-xl-3 col-lg-3 col-md-6 col-12" >
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





                <div class="col-xl-3 col-lg-3 col-md-6 col-12" >
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


                <div class="col-xl-3 col-lg-3 col-md-6 col-12" >
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
            @endif




        <h5 style="color: #f14343 !important;">NOMBRE DES PROJETS</h5>
        <hr>


        <div class="row" style="">
            <div class="col-12">
                        <div class="table-responsive" style="margin-top: 8px">
                            <table class="table table-hover table-striped datatables" id="nombre_projet_datatables" style="width:100% ;">
                                <thead >
                                    <th class=" @if($is_mobile == 0)m-thead @else m-thead-mobile @endif" >Programme</th>
                                    <th class="@if($is_mobile == 0)m-thead @else m-thead-mobile @endif">Nombre de projets</th>
                                    <th class="@if($is_mobile == 0)m-thead @else m-thead-mobile @endif">Coût (MDH)</th>
                                    <th class="@if($is_mobile == 0)m-thead @else m-thead-mobile @endif">Réalisés(KM) </th>
                                    <th class="@if($is_mobile == 0)m-thead @else m-thead-mobile @endif">En cours (KM)</th>
                                    <th class="@if($is_mobile == 0)m-thead @else m-thead-mobile @endif">Programmés (KM)</th>
                                    <th class="@if($is_mobile == 0)m-thead @else m-thead-mobile @endif">Total (KM)</th>
                                </thead>

                                <tfoot>
                                <tr class="m-footer" style=" color: #ff1308 !important;">
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


        <h5 style="color: #f14343 !important; margin-top: 12px !important;">NATURE DES INTERVENTIONS</h5>
        <hr>
        <div class="row" >
            <div class="col-12">
                        <div class="table-responsive" style="margin-top: 8px">
                            <table class="table table-hover table-striped datatables" id="intervention_projet_datatables" style="width:100% ;">
                                <thead>
                                    <th class="@if($is_mobile == 0)m-thead @else m-thead-mobile @endif">Programme</th>
                                    <th class="@if($is_mobile == 0)m-thead @else m-thead-mobile @endif">Terrassement</th>
                                    <th class="@if($is_mobile == 0)m-thead @else m-thead-mobile @endif">Revetement</th>
                                    <th class="@if($is_mobile == 0)m-thead @else m-thead-mobile @endif">Dallage </th>
                                    <th class="@if($is_mobile == 0)m-thead @else m-thead-mobile @endif">Pavé</th>
                                    <th class="@if($is_mobile == 0)m-thead @else m-thead-mobile @endif">Recallibrage</th>
                                    <th class="@if($is_mobile == 0)m-thead @else m-thead-mobile @endif">Elargissement</th>
                                    <th class="@if($is_mobile == 0)m-thead @else m-thead-mobile @endif">Renforcement</th>
                                    <th class="@if($is_mobile == 0)m-thead @else m-thead-mobile @endif">Ouvrages d'art</th>
                                    <th class="@if($is_mobile == 0)m-thead @else m-thead-mobile @endif">Entretien</th>
                                    <th class="@if($is_mobile == 0)m-thead @else m-thead-mobile @endif">Etude</th>
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