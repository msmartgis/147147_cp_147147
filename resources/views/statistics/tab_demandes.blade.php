<div class="tab-pane active " id="demandes_tab" role="tabpanel">
    <div class="pad">
        {{--@include('demandes.filter_demandes_a_traiter')--}}


        <div class="vtabs customvtab col-lg-12" style="padding: 0;" id="tabs_demande_lg">
            <ul class="nav nav-tabs tabs-vertical" role="tablist" id="tab_list_demande">
                <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#home3" role="tab" aria-expanded="true"><span class="hidden-sm-up"><i class="ion-home"></i></span> <span class="hidden-xs-down">Nombre</span> </a> </li>
                <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#profile3" role="tab" aria-expanded="false"><span class="hidden-sm-up"><i class="ion-person"></i></span> <span class="hidden-xs-down">Longueur</span></a> </li>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content" style="margin : 0 !important;margin-top: 0 !important;">
                <div class="tab-pane active" id="home3" role="tabpanel" aria-expanded="true" >
                    <div class="pad col-lg-12" style="display:table;">
                        <div class="row " id="nombre_div"  style="margin-top: 8px;" >
                            <div class="col-lg-5" style="display:table-cell;">
                                <div class="row">
                                    <div class="col-lg-2">
                                        <label style="font-size: 12px;">Intervention :</label>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <select class="form-control select2" style="width: 100%;" name="intervention_demande" id="interventions_demande_filter">
                                                <option value="all" selected>Indifferent</option>
                                                @foreach($interventions as $intervention)
                                                    <option value="{{$intervention->id}}">{{$intervention->nom}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <!-- /.form-group -->
                                    </div>

                                    <div class="col-lg-2">
                                        <label style="font-size: 12px;">Année :</label>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <select class="form-control select2" style="width: 100%;" name="annee_demande" id="annee_demande_filter">
                                                <option value="all" selected>Indifferent</option>
                                                @for($i = 0; $i < 20 ; $i++)
                                                    <option value="{{$year_number - $i}}">{{$year_number - $i}}</option>
                                                @endfor
                                            </select>
                                        </div>
                                        <!-- /.form-group -->
                                    </div>
                                </div>

                                <h5> NOMBRE  DES DEMANDES</h5>
                                <hr>
                                <div class="row">
                                    <div class="table-responsive" style="margin-left: 13px;margin-top: 8px">
                                        <table class="table table-hover table-striped datatables" id="demandes_statistcs_datatables" style="width:100% ;">
                                            <thead>
                                            <th>Communes</th>
                                            <th>En cours</th>
                                            <th>Accord Definitif</th>
                                            <th>Total</th>
                                            <th>Taux</th>
                                            </thead>
                                            <tbody id="demandes_statistcs_datatables_tbody">

                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <h5> TAUX DES DEMANDES</h5>
                                <hr>
                                <div class="row">
                                    <div class="col-lg-12" style="text-align: center">

                                        <h6>Intervention</h6>
                                    </div>

                                    <canvas id="demande_chart" ></canvas>
                                </div>

                            </div>
                            <div class="col-lg-7" style="display:table-cell;">
                                <div id="map_nombre" style="width : 100%;border: solid 1px #666666;box-shadow: 0px 5px 20px rgba(0, 0, 0, 0.05);"></div>

                                <div class="cmodali active" style=" width: 300px;  height: 100px;left:calc(100% - 320px);top:calc(100% - 72px);z-index:99998;">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <img id="satellite_btn_demande"  class="baselayer_btn_demande active" src="{{asset('images/satellite.png')}}" />
                                        </div>
                                        <div class="col-md-3">
                                            <img id="hybrid_btn_demande" class="baselayer_btn_demande" src="{{asset('images/hybrid.png')}}" />
                                        </div>
                                        <div class="col-md-3">
                                            <img id="road_btn_demande" class="baselayer_btn_demande" src="{{asset('images/road.png')}}" />
                                        </div>
                                        <div class="col-md-3">
                                            <img id="none_btn_demande" class="baselayer_btn_demande" src="{{asset('images/none.png')}}" />
                                        </div>
                                    </div>
                                </div>


                            </div>

                        </div>

                    </div>
                </div>
                <div class="tab-pane pad" id="profile3" role="tabpanel" aria-expanded="false">
                    {{-- another div for longueur filter --}}
                    <div class="row filter-demande-lg" id="longeur_div"  style="margin-top: 8px;">
                        <div class="col-lg-5">
                            <div class="row">
                                <div class="col-lg-2">
                                    <label style="font-size: 12px;">Intervention :</label>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <select class="form-control select2" style="width: 100%;" name="intervention_demande_lg" id="interventions_demande_lg_filter">
                                            <option value="all" selected>Indifferent</option>
                                            @foreach($interventions as $intervention)
                                                <option value="{{$intervention->id}}">{{$intervention->nom}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <!-- /.form-group -->
                                </div>

                                <div class="col-lg-2">
                                    <label style="font-size: 12px;">Année :</label>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <select class="form-control select2" style="width: 100%;" name="annee_demande_lg" id="annee_demande_lg_filter">
                                            <option value="all" selected>Indifferent</option>
                                            @for($i = 0; $i < 20 ; $i++)
                                                <option value="{{$year_number - $i}}">{{$year_number - $i}}</option>
                                            @endfor
                                        </select>
                                    </div>
                                    <!-- /.form-group -->
                                </div>
                            </div>

                            <h5> LONGUEUR  DES INTERVENTIONS</h5>
                            <hr>
                            <div class="row">
                                <div class="table-responsive" style="margin-left: 13px;margin-top: 8px">
                                    <table class="table table-hover table-striped datatables" id="demandes_longueur_statistcs_datatables" style="width:100% ;">
                                        <thead>
                                        <th>Communes</th>
                                        <th>En cours</th>
                                        <th>Accord Definitif</th>
                                        <th>Total</th>
                                        <th>Taux</th>
                                        </thead>
                                        <tbody id="demandes_statistcs_datatables_lg_tbody">

                                        </tbody>


                                    </table>
                                </div>
                            </div>
                            <h5> TAUX LONGUEURS DES INTERVENTIONS POUR LES DEMANDES : </h5>
                            <hr>
                            <div class="row">
                                <div class="col-lg-12" style="text-align: center">
                                    <h6>Intervention</h6>
                                </div>

                                <canvas id="demande_longueur_chart" ></canvas>
                            </div>
                        </div>
                        <div class="col-lg-7" id="map_longueur_demande_div">
                            <div id="map_container_demande_longueur">
                                <div id="map_demande_lg" style="width : 100%;border: solid 1px #666666;box-shadow: 0px 5px 20px rgba(0, 0, 0, 0.05);"></div>
                            </div>


                            <div class="cmodali active" style=" width: 300px;  height: 100px;left:calc(100% - 320px);top:calc(100% - 72px);z-index:99998;">
                                <div class="row">
                                    <div class="col-md-3">
                                        <img id="satellite_btn_demande_lg"  class="baselayer_btn_demande_lg active" src="{{asset('images/satellite.png')}}" />
                                    </div>
                                    <div class="col-md-3">
                                        <img id="hybrid_btn_demande_lg" class="baselayer_btn_demande_lg" src="{{asset('images/hybrid.png')}}" />
                                    </div>
                                    <div class="col-md-3">
                                        <img id="road_btn_demande_lg" class="baselayer_btn_demande_lg" src="{{asset('images/road.png')}}" />
                                    </div>
                                    <div class="col-md-3">
                                        <img id="none_btn_demande_lg" class="baselayer_btn_demande_lg" src="{{asset('images/none.png')}}" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>






    </div>
</div>