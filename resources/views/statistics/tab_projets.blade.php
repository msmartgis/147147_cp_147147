<div class="tab-pane " id="projets_tab" role="tabpanel">
    <div class="pad">

        <div class="vtabs customvtab col-lg-12" style="padding: 0;" id="tabs_projet_lg">
            <ul class="nav nav-tabs tabs-vertical" role="tablist" id="tab_list_projet">
                <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#nombre_projet" role="tab" aria-expanded="true"><span class="hidden-sm-up"><i class="ion-home"></i></span> <span class="hidden-xs-down">Nombre</span> </a> </li>
                <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#longueur_projet" role="tab" aria-expanded="false"><span class="hidden-sm-up"><i class="ion-person"></i></span> <span class="hidden-xs-down">Longueur</span></a> </li>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content" style="margin : 0 !important;margin-top: 0 !important;">
                <div class="tab-pane active" id="nombre_projet" role="tabpanel" aria-expanded="true" >
                    <div class="pad col-lg-12" style="display:table;">
                        <div class="row "   style="margin-top: 8px;" >
                            <div class="col-lg-5" style="display:table-cell;">
                                <div class="row">
                                    <div class="col-lg-2">
                                        <label style="font-size: 12px;">Intervention :</label>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <select class="form-control select2" style="width: 100%;" name="intervention_projet" id="interventions_projet_filter">
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
                                            <select class="form-control select2" style="width: 100%;" name="annee_projet" id="annee_projet_filter">
                                                <option value="all" selected>Indifferent</option>
                                                @for($i = 0; $i < 20 ; $i++)
                                                    <option value="{{$year_number - $i}}">{{$year_number - $i}}</option>
                                                @endfor
                                            </select>
                                        </div>
                                        <!-- /.form-group -->
                                    </div>
                                </div>


                                <div class="row" style="margin-top: 8px">
                                    <div class="col-lg-2">
                                        <label style="font-size: 12px;">M.O :</label>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <select class="form-control select2" style="width: 100%;" name="intervention_projet" id="moa_projet_filter">
                                                <option value="all" selected>Indifferent</option>
                                                @foreach($interventions as $intervention)
                                                    <option value="{{$intervention->id}}">{{$intervention->nom}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <!-- /.form-group -->
                                    </div>

                                    <div class="col-lg-2">
                                        <label style="font-size: 12px;">Programme :</label>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <select class="form-control select2" style="width: 100%;" name="annee_projet" id="programme_projet_filter">
                                                <option value="all" selected>Indifferent</option>
                                                @foreach($programmes as $prgrm)
                                                    <option value="{{$prgrm->id}}">{{$prgrm->nom_fr}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <!-- /.form-group -->
                                    </div>
                                </div>

                                <h5> NOMBRE  DES PROJETS</h5>
                                <hr>
                                <div class="row">
                                    <div class="table-responsive" style="margin-left: 13px;margin-top: 8px">
                                        <table class="table table-hover table-striped datatables" id="projets_statistcs_datatables" style="width:100% ;">
                                            <thead>
                                            <th>Communes</th>
                                            <th>Programmés</th>
                                            <th>A.O</th>
                                            <th>En cours</th>
                                            <th>Realisés</th>
                                            <th>Total</th>
                                            <th>Taux</th>
                                            </thead>
                                            <tbody id="projets_statistcs_datatables_tbody">
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <h5> TAUX DES PROJETS</h5>
                                <hr>
                                <div class="row">
                                    <div class="col-lg-12" style="text-align: center">

                                        <h6>Intervention</h6>
                                    </div>

                                    <canvas id="projet_chart" ></canvas>
                                </div>

                            </div>
                            <div class="col-lg-7" style="display:table-cell;">
                                <div id="map_projet_nombre" style="width : 100%;border: solid 1px #666666;box-shadow: 0px 5px 20px rgba(0, 0, 0, 0.05);"></div>

                                <div class="cmodali active" style=" width: 300px;  height: 100px;left:calc(100% - 320px);top:calc(100% - 72px);z-index:99998;">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <img id="satellite_btn_projet"  class="baselayer_btn_projet active" src="{{asset('images/satellite.png')}}" />
                                        </div>
                                        <div class="col-md-3">
                                            <img id="hybrid_btn_projet" class="baselayer_btn_projet" src="{{asset('images/hybrid.png')}}" />
                                        </div>
                                        <div class="col-md-3">
                                            <img id="road_btn_projet" class="baselayer_btn_projet" src="{{asset('images/road.png')}}" />
                                        </div>
                                        <div class="col-md-3">
                                            <img id="none_btn_projet" class="baselayer_btn_projet" src="{{asset('images/none.png')}}" />
                                        </div>
                                    </div>
                                </div>


                            </div>

                        </div>

                    </div>
                </div>
                <div class="tab-pane" id="longueur_projet" role="tabpanel" aria-expanded="true" >
                    <div class="pad col-lg-12" style="display:table;">
                        <div class="row"   style="margin-top: 8px;" >
                            <div class="col-lg-5" style="display:table-cell;">
                                <div class="row">
                                    <div class="col-lg-2">
                                        <label style="font-size: 12px;">Intervention :</label>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <select class="form-control select2" style="width: 100%;" name="intervention_projet_lg" id="interventions_projet_lg_filter">
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
                                            <select class="form-control select2" style="width: 100%;" name="annee_projet_lg" id="annee_projet_lg_filter">
                                                <option value="all" selected>Indifferent</option>
                                                @for($i = 0; $i < 20 ; $i++)
                                                    <option value="{{$year_number - $i}}">{{$year_number - $i}}</option>
                                                @endfor
                                            </select>
                                        </div>
                                        <!-- /.form-group -->
                                    </div>
                                </div>

                                <h5>  LONGUEUR DES INTERVENTIONS</h5>
                                <hr>
                                <div class="row">
                                    <div class="table-responsive" style="margin-left: 13px;margin-top: 8px">
                                        <table class="table table-hover table-striped datatables" id="projets_lg_statistcs_datatables" style="width:100% ;">
                                            <thead>
                                            <th>Communes</th>
                                            <th>Programmés</th>
                                            <th>A.O</th>
                                            <th>En cours</th>
                                            <th>Realisés</th>
                                            <th>Total</th>
                                            <th>Taux</th>
                                            </thead>
                                            <tbody id="projets_lg_statistcs_datatables_tbody">

                                            </tbody>
                                        </table>
                                    </div>
                                </div>



                            </div>
                            <div class="col-lg-7" style="display:table-cell;">
                                <div id="map_projet_lg" style="width : 100%;border: solid 1px #666666;box-shadow: 0px 5px 20px rgba(0, 0, 0, 0.05);"></div>

                                <div class="cmodali active" style=" width: 300px;  height: 100px;left:calc(100% - 320px);top:calc(100% - 72px);z-index:99998;">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <img id="satellite_btn_projet_lg"  class="baselayer_btn_projet_lg active" src="{{asset('images/satellite.png')}}" />
                                        </div>
                                        <div class="col-md-3">
                                            <img id="hybrid_btn_projet_lg" class="baselayer_btn_projet_lg" src="{{asset('images/hybrid.png')}}" />
                                        </div>
                                        <div class="col-md-3">
                                            <img id="road_btn_projet_lg" class="baselayer_btn_projet_lg" src="{{asset('images/road.png')}}" />
                                        </div>
                                        <div class="col-md-3">
                                            <img id="none_btn_projet_lg" class="baselayer_btn_projet_lg" src="{{asset('images/none.png')}}" />
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
</div>
