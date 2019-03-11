@extends('layouts.app')



@section('content')
    <div class="statitics">
        <div class="row">
            <div class="col-xl-2 col-md-6 col-6" style="flex: 0 0 20%;max-width: 20%;">
                <!-- small box -->
                <div class="small-box bg-info">
                    <div class="inner" style="background-color: #f1f1f1;">
                        <h3 style="color: #1a74c3;">72</h3>

                        <p style="color: #1a74c3;">Nombre de projets</p>
                    </div>
                    <div class="icon" >
                        <i class="fa fa-tasks " style="color: #1a74c3;"></i>
                    </div>
                    <a href="#" class="small-box-footer"><b>Voir les details </b> <i class="fa fa-arrow-right" ></i></a>
                </div>
            </div>


            <div class="col-xl-2 col-md-6 col-6" style="flex: 0 0 20%;max-width: 20%;">
                <!-- small box -->
                <div class="small-box bg-success" style="background-color: #9fd037 !important;">
                    <div class="inner" style="background-color: #f1f1f1;">
                        <h3 style="color: #9fd037;">13</h3>

                        <p style="color: #9fd037;">Réalisés  </p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-thumbs-up " style="color: #9fd037;"></i>
                    </div>
                    <a href="#" class="small-box-footer"><b>Voir les details </b> <i class="fa fa-arrow-right"></i></a>
                </div>
            </div>


            <div class="col-xl-2 col-md-6 col-6" style="flex: 0 0 20%;max-width: 20%;">
                <!-- small box -->
                <div class="small-box bg-danger">
                    <div class="inner" style="background-color: #f1f1f1;">
                        <h3 style="color: #d6405c;">20</h3>

                        <p style="color: #d6405c;">En cours de réalisation  </p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-clock-o  " style="color: #d6405c;"></i>
                    </div>
                    <a href="#" class="small-box-footer"><b>Voir les details </b> <i class="fa fa-arrow-right"></i></a>
                </div>
            </div>

            <div class="col-xl-2 col-md-6 col-6" style="flex: 0 0 20%;max-width: 20%;">
                <!-- small box -->
                <div class="small-box bg-primary" style="background-color: #ad13ef !important;">
                    <div class="inner" style="background-color: #f1f1f1;">
                        <h3 style="color: #ad13ef;">39</h3>

                        <p style="color: #ad13ef;">Programmés </p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-calendar" style="color: #ad13ef;"></i>
                    </div>
                    <a href="#" class="small-box-footer"><b>Voir les details </b> <i class="fa fa-arrow-right"></i></a>
                </div>
            </div>

            <div class="col-xl-2 col-md-6 col-6" style="flex: 0 0 20%;max-width: 20%;">
                <!-- small box -->
                <div class="small-box bg-primary" style="background-color: #000 !important;">
                    <div class="inner" style="background-color: #f1f1f1;">
                        <h3 style="color: #000;">902.4 </h3>

                        <p style="color: #000;">Coût Total (MDH) </p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-money" style="color: #000;"></i>
                    </div>
                    <a href="#" class="small-box-footer"><b>Voir les details </b> <i class="fa fa-arrow-right"></i></a>
                </div>
            </div>

        </div>


        <div class="row">
            <div class="col-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h4 class="box-title">Tableau de Bord par intervenant</h4>

                    </div>
                    <div class="box-body no-padding">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <tr style="background-color: #979499;color: #fff;">
                                    <th>Intervenant</th>
                                    <th>Nombre de projets</th>
                                    <th>Coût (MDH)</th>
                                    <th>Réalisés(KM) </th>
                                    <th>En cours (KM)</th>
                                    <th>Programmés (KM)</th>
                                    <th>Total (KM)</th>
                                </tr>
                                <tr>
                                    <td><a href="javascript:void(0)">Partenariats C.P</a></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td><a href="javascript:void(0)">Convention METL</a></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td><a href="javascript:void(0)">Gouverneur FDR</a></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td><a href="javascript:void(0)">INDH</a></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td><a href="javascript:void(0)">Ministère de l'agriculture</a></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>

                                <tr>
                                    <td><a href="javascript:void(0)">Programme  de lutte contre la disparités territoriales</a></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td><a href="javascript:void(0)">Région</a></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>


                                <tr style="background-color: #fc4b6c !important;color: #fff;">
                                    <td><b>Total</b></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>

                            </table>
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </div>



        <div class="row">
            <div class="col-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h4 class="box-title">Tableau de Bord par intervention</h4>
                    </div>
                    <div class="box-body no-padding">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <tr style="background-color: #979499;color: #fff;">
                                    <th>Nature des intérventions</th>
                                    <th> Terrassement+ ouvrages </th>
                                    <th>Revêtement</th>
                                    <th>Dallage </th>
                                    <th>Pavé</th>
                                    <th>Recalibrage</th>
                                    <th>Elargissement</th>
                                    <th>Renforcement</th>
                                    <th>Ouvrages d'art</th>
                                    <th>Entretien</th>
                                </tr>
                                <tr>
                                    <td><a href="javascript:void(0)">Partenariats C.P</a></td>
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
                                <tr>
                                    <td><a href="javascript:void(0)">Convention METL</a></td>
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
                                <tr>
                                    <td><a href="javascript:void(0)">Gouverneur FDR</a></td>
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
                                <tr>
                                    <td><a href="javascript:void(0)">INDH</a></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td><a href="javascript:void(0)">Ministère de l'agriculture</a></td>
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

                                <tr>
                                    <td><a href="javascript:void(0)">Programme  de lutte contre la disparités territoriales</a></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td><a href="javascript:void(0)">Région</a></td>
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


                                <tr style="background-color: #fc4b6c !important;color: #fff;">
                                    <td><b>Total</b></td>
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

                            </table>
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </div>


    </div>
@endsection