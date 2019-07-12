<div>
    <div id="map" style="border: solid 1px #666666;box-shadow: 0px 5px 20px rgba(0, 0, 0, 0.05);"></div>

    <div  class="cmodali active" style=" width: 300px;  height: 100px;left:calc(100% - 320px);top:calc(100% - 72px);z-index:99998;">
            <div class="row">
                <div class="col-md-3">
                    <img id="satellite_btn"  class="baselayer_btn active" src="{{asset('images/satellite.png')}}" />
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
