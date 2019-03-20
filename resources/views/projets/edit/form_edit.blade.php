{!! Form::open() !!}
<div class="row">
    <div class="col-lg-10">
        <div class="col-12">
            <div class="box" style="border-top: 0;border-bottom: 0;margin-left: 0">
                <!-- /.box-header -->
                <div class="box-body">
                    <!-- Tab panes -->
                    <div class="tab-content">
                        {{--tab informations generales--}}
                        <div class="tab-pane active" id="information_generale_tab" role="tabpanel">
                            <div class="pad">
                                <h5>PORTEUR DE PROJET </h5>
                                <hr style="color:#2d353c;margin:0">
                                <div class="row" style="margin-top: 8px">
                                    <div class="col-lg-6">
                                        <div class="form-group">

                                            <div class="controls">
                                                {{Form::textarea('nom_porteur_fr','',['class'=>'form-control','rows'=>'2','style'=>'height: 52px !important'])}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <div class="controls">
                                                {{Form::textarea('nom_porteur_ar','',['class'=>'form-control','rows'=>'2','style'=>'height: 52px !important'])}}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <h5>OBJET</h5>
                                <hr style="color:#2d353c;margin:0">
                                <div class="row" style="margin-top: 8px">
                                    <div class="col-lg-6">
                                        <div class="form-group">

                                            <div class="controls">
                                                {{Form::textarea('objet_fr','',['class'=>'form-control','rows'=>'2','style'=>'height: 52px !important'])}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <div class="controls">
                                                {{Form::textarea('objet_ar','',['class'=>'form-control','rows'=>'2','style'=>'height: 52px !important'])}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.row -->

                            </div>
                        </div>

                        {{--tab localisation de projet--}}
                        <div class="tab-pane " id="localisation_projet_tab" role="tabpanel">
                            <div class="pad">

                                <div class="row" style="margin-top: 8px">
                                    <div class="col-lg-12">
                                        <div class="form-group">

                                        </div>
                                    </div>
                                </div>




                                <h5>LOCALISATION SUR LA CARTE </h5>
                                <hr style="color:#2d353c;margin:0">
                                <div class="row">
                                    <div class=" col-12">
                                        <div id="map" style="border: solid 1px #666666;box-shadow: 0px 5px 20px rgba(0, 0, 0, 0.05);"></div>

                                        <div class="cmodali active" style=" width: 300px;  height: 100px;left:calc(100% - 320px);top:calc(100% - 72px);z-index:1;">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <img id="satellite_btn" cl class="baselayer_btn active" src="{{asset('images/satellite.png')}}" />
                                                </div>
                                                <div class="col-md-3">
                                                    <img id="hybrid_btn" class="baselayer_btn" src="{{asset('images/hybrid.png')}}" />
                                                </div>
                                                <div class="col-md-3">
                                                    <img id="road_btn" class="baselayer_btn" src="{{asset('images/road.png')}}" />
                                                </div>
                                                <div class="col-md-3">
                                                    <img id="none_btn" class="baselayer_btn" src="{{asset('images/none.png')}}" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        {{--Dossier--}}
                        <div class="tab-pane" id="dossiers_projet_tab" role="tabpanel">
                            <div class="pad">
                                <div class="col-12" style="margin-top : 8px">

                                </div>

                            </div>
                        </div>


                        {{--Gallerie--}}
                        <div class="tab-pane" id="gallerie_projet_tab" role="tabpanel">
                            <div class="pad">
                                <div class="col-12" style="margin-top : 8px">
                                    <div class="container">
                                        <div class="main-img">
                                            <img src="https://preview.ibb.co/gxVppG/img1.jpg" id="current">
                                        </div>

                                        <div class="imgs">
                                            <img src="https://preview.ibb.co/gxVppG/img1.jpg">
                                            <img src="https://preview.ibb.co/iZ3Lww/img2.jpg">
                                            <img src="https://preview.ibb.co/iQsPOb/img3.jpg">
                                            <img src="https://preview.ibb.co/gFFdib/img4.jpg">
                                            <img src="https://preview.ibb.co/hS5ppG/img5.jpg">
                                            <img src="https://preview.ibb.co/goKtGw/img6.jpg">
                                            <img src="https://preview.ibb.co/bSWjOb/img7.jpg">
                                            <img src="https://preview.ibb.co/i2o9pG/img8.jpg">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>



                        {{--tab observation et remarques--}}
                        <div class="tab-pane" id="observation_remarques_tab" role="tabpanel">
                            <div class="pad">

                                <div class="col-12" style="margin-top : 8px">
                                    <div class="form-group">

                                        {{Form::textarea('observation', '', ['id' => 'editor1', 'class' => 'form-control', 'placeholder' => 'Body Text'])}}
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>

    </div>

    <div class="col-lg-2">

    </div>
</div>

{!! Form::close() !!}