@extends('layouts.app')

@section('added_css')
    <link rel="stylesheet" href="{{asset('css/datatable/datatables.min.css')}}" />
    <!-- Select2 -->
    <link rel="stylesheet" href="{{asset('vendor_components/select2/dist/css/select2.min.css')}}" />
    <!-- bootstrap datepicker -->
    <link rel="stylesheet" href="{{asset('vendor_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')}}" />

    <!--alerts CSS -->
    <link href="{{asset('vendor_components/sweetalert/sweetalert.css')}}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="{{asset('chart.js/dist/Chart.min.css')}}">

    {{--mapping css--}}
    <link rel="stylesheet" href="{{asset('mapping/libs/leaflet.css')}}"/>
    <link rel="stylesheet" href="{{asset('mapping/leaflet.draw.css')}}">
    <link rel="stylesheet" href="{{asset('mapping/libs/easy-button.css')}}">
    <link href="{{asset('mapping/leaflet.fullscreen.css')}}" rel='stylesheet' />
    <link rel="stylesheet" href="{{asset('mapping/m-mapping.css')}}">


    <link rel="stylesheet" href="{{asset('mapping/MarkerCluster.css')}}">
    <link rel="stylesheet" href="{{asset('mapping/MarkerCluster.Default.css')}}">

    <link rel="stylesheet" href="{{asset('bootstrap-drawer/dist/css/bootstrap-drawer.min.css')}}">




    <style>
        #map {
            height: 85vh;
            z-index: 1;
        }


        .baselayer_btn {
            border-radius: 50%;

            border: 3px solid #ffda44;
            filter: grayscale(100%);
        }

        .baselayer_btn.active {
            border-radius: 50%;

            border: 3px solid #b2ff59;
            filter: grayscale(0%);
        }

        .baselayer_btn {
            border-radius: 50%;

            border: 3px solid #ffda44;
            filter: grayscale(100%);
        }


        .m-toolTip
        {
            background: none;
            border: none;
            display: inline-block;
            box-shadow: none;
            font-family: Lato;

        }
        .tooltip-arrow{
            background: none;
            border: none;
        }

        .map-toggle
        {
            background-color: #ececec;
            border-color: #ececec;
            color: #000;
        }

        .btn-primary:focus, .btn-primary.focus
        {
            color: #000;
        }
        .btn-primary:hover
        {
            background-color: #B4B4B4;
            border-color: #B4B4B4;
        }

        .visible
        {
            visibility: visible;
            opacity: 1;
            transition: opacity 2s linear;
        }

        .hidden-class
        {
            visibility: hidden;
            opacity: 0;
            transition: visibility 0s 2s, opacity 2s linear;
        }
        .dw-md-4
        {
            /*
            width: 21.333333%;*/
        }
        #drawer_btn
        {
            /*
            margin-left: 200px;*/
        }
        .dw-md-4 {
            /*
            width: 22.333333%;*/
        }
        .fold.dw-md-4 {
            /*
            margin-left: -22.333333%;*/
        }

        body {
            overflow:hidden;
        }

        .label-cbx
        {
            margin-left: 24px;
        }

        .couche-title
        {
            margin-left: 12px;
        }

        [type=checkbox].filled-in:checked+label:before
        {
            width: 6px;
            height: 11px;
        }

        [type=checkbox].filled-in:checked+label:after
        {
            width: 16px;
            height: 16px;
        }

        [type=checkbox].filled-in:not(:checked)+label:after
        {
            height: 16px;
            width: 16px;
        }
    </style>
@endsection

@section('content')

    @include('cartographie.drawer')


    <div class="row ">
        <div class="col-12">
                <div class="box ">
                    <!-- /.box-header -->
                    <div class="box-body" style="padding : 0">
                        @include('cartographie.map_carto')
                    </div>
                    <!-- /.box-body -->
                </div>

            <!-- /.box -->
        </div>
    </div>
@endsection



@push('added_scripts')

<script src="{{asset('mapping/libs/leaflet-src.js')}}"></script>
<script src="{{asset('mapping/libs/easy-button.js')}}"></script>
<script src="{{asset('mapping/Leaflet.draw.js')}}"></script>
<script src="{{asset('mapping/Leaflet.Draw.Event.js')}}"></script>
<script src="{{asset('mapping/edit/handler/Edit.Poly.js')}}"></script>
<script src="{{asset('mapping/edit/handler/Edit.SimpleShape.js')}}"></script>
<script src="{{asset('mapping/edit/handler/Edit.Rectangle.js')}}"></script>
<script src="{{asset('mapping/edit/handler/Edit.Marker.js')}}"></script>
<script src="{{asset('mapping/edit/handler/Edit.CircleMarker.js')}}"></script>
<script src="{{asset('mapping/edit/handler/Edit.Circle.js')}}"></script>
<script src="{{asset('mapping/draw/handler/Draw.Feature.js')}}"></script>
<script src="{{asset('mapping/draw/handler/Draw.Polyline.js')}}"></script>
<script src="{{asset('mapping/draw/handler/Draw.Polygon.js')}}"></script>
<script src="{{asset('mapping/draw/handler/Draw.SimpleShape.js')}}"></script>
<script src="{{asset('mapping/draw/handler/Draw.Rectangle.js')}}"></script>
<script src="{{asset('mapping/draw/handler/Draw.Circle.js')}}"></script>
<script src="{{asset('mapping/draw/handler/Draw.Marker.js')}}"></script>
<script src="{{asset('mapping/draw/handler/Draw.CircleMarker.js')}}"></script>
<script src="{{asset('mapping/ext/TouchEvents.js')}}"></script>
<script src="{{asset('mapping/ext/LatLngUtil.js')}}"></script>
<script src="{{asset('mapping/ext/GeometryUtil.js')}}"></script>
<script src="{{asset('mapping/ext/LineUtil.Intersect.js')}}"></script>
<script src="{{asset('mapping/ext/Polyline.Intersect.js')}}"></script>
<script src="{{asset('mapping/ext/Polygon.Intersect.js')}}"></script>
<script src="{{asset('mapping/Control.Draw.js')}}"></script>
<script src="{{asset('mapping/Tooltip.js')}}"></script>
<script src="{{asset('mapping/Toolbar.js')}}"></script>
<script src="{{asset('mapping/draw/DrawToolbar.js')}}"></script>
<script src="{{asset('mapping/edit/EditToolbar.js')}}"></script>
<script src="{{asset('mapping/edit/handler/EditToolbar.Edit.js')}}"></script>
<script src="{{asset('mapping/edit/handler/EditToolbar.Delete.js')}}"></script>
<script src='{{asset('mapping/Leaflet.fullscreen.min.js')}}'></script>
<script src="{{asset('mapping/leaflet.ajax.js')}}"></script>
<script src="{{asset('css/datatable/datatables.min.js')}}"></script>


<script src="{{asset('mapping/leaflet.markercluster-src.js')}}"></script>

<!-- iCheck 1.0.1 -->
<script src="{{asset('vendor_plugins/iCheck/icheck.min.js')}}"></script>


<script src="{{asset('bootstrap-drawer/dist/js/drawer.js')}}"></script>

<!-- bootstrap time picker -->
<script src="{{asset('vendor_plugins/timepicker/bootstrap-timepicker.min.js')}}"></script>


<!-- date-range-picker -->
<script src="{{asset('vendor_components/moment/min/moment.min.js')}}"></script>
<script src="{{asset('vendor_components/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
<!-- bootstrap datepicker -->
<script src="{{asset('vendor_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>
<!-- Form validator JavaScript -->
<script src="{{asset('js/validation.js')}}"></script>
<!-- Formatter -->
<script src="{{asset('vendor_components/formatter/formatter.js')}}"></script>
<script src="{{asset('vendor_components/formatter/jquery.formatter.js')}}"></script>
<script src="{{asset('js/formatter.js')}}"></script>

<!-- Sweet-Alert  -->
<script src="{{asset('vendor_components/sweetalert/sweetalert.min.js')}}"></script>
<script src="{{asset('vendor_components/sweetalert/jquery.sweet-alert.custom.js')}}"></script>
<script src="{{asset('js/carto/carto.js')}}"></script>

<script>
    $("#Layers-List-Toggle").click(function()
    {
        if($("#Layers-List-Toggle").hasClass("showing"))
        {
            $("#Layers-List-Container").css("opacity",'0');
            $("#Layers-List-Container").css("display",'none');
            $("#Layers-List-Toggle").removeClass("showing").addClass("hidding");
            $("#Layers-List-Toggle-i").html("keyboard_arrow_down");
        }
        else{
            $("#Layers-List-Container").css("opacity",'1');
            $("#Layers-List-Container").css("display",'');
            $("#Layers-List-Toggle").removeClass("showing").addClass("showing");
            $("#Layers-List-Toggle-i").html("keyboard_arrow_up");
        }

    });


    $('#drawer_btn').click(function() {
        var content_btn = $('#drawer_btn').text();

        if(content_btn.includes('Etendre'))
        {
            $('#drawer_btn').text('Réduire') ;
        }else{
            $('#drawer_btn').text('Etendre');
        }

    });

</script>
@endpush
