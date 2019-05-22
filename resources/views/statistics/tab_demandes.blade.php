<div class="tab-pane active " id="demandes_tab" role="tabpanel">
    <div class="pad">
        {{--@include('demandes.filter_demandes_a_traiter')--}}
        <div class="row">
            <div class="col-lg-5">

                <div style="margin-left: 15px;margin-bottom: 8px">
                    <div class="form-group col-lg-6 " >
                        <input name="type_filter_demande_radio" type="radio" id="nombre_demande_radio" class="with-gap radio-col-orange" checked/>
                        <label for="nombre_demande_radio">Nombre</label>
                    </div>


                    <div class="form-group col-lg-6 " >
                        <input name="type_filter_demande_radio" type="radio" id="longueur_demande_radio" class="with-gap radio-col-orange" />
                        <label for="longueur_demande_radio">Longueur des interventions</label>
                    </div>
                </div>


                <div class="row">
                    <div class="col-lg-2">
                        <label >Intervention :</label>
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
                        <label >Année :</label>
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
            <div class="col-lg-7">
                <div id="map" style="width : 100%;border: solid 1px #666666;box-shadow: 0px 5px 20px rgba(0, 0, 0, 0.05);"></div>

                <div class="cmodali active" style=" width: 300px;  height: 100px;left:calc(100% - 320px);top:calc(100% - 72px);z-index:99998;">
                    <div class="row">
                        <div class="col-md-3">
                            <img id="satellite_demande_btn" cl class="baselayer_btn active" src="{{asset('images/satellite.png')}}" />
                        </div>
                        <div class="col-md-3">
                            <img id="hybrid_demande_btn" class="baselayer_btn" src="{{asset('images/hybrid.png')}}" />
                        </div>
                        <div class="col-md-3">
                            <img id="road_demande_btn" class="baselayer_btn" src="{{asset('images/road.png')}}" />
                        </div>
                        <div class="col-md-3">
                            <img id="none_demande_btn" class="baselayer_btn" src="{{asset('images/none.png')}}" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>