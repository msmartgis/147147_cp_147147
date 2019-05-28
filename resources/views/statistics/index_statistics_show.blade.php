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

    <style>
        th {
            text-align: center;
            background-color: #ffffff;
            color: #2d353c;
            border: 1px solid #dbe1e6;
        }

        td {
            border: 0.5px solid #dbe1e6;
        }


        .center-data-blue {
            text-align: center;
            background-color: #dbe1e6 !important;
        }

        .center-data {
            text-align: center;

        }

        tbody {
            font-size: 13px;
            color: #2d353c;
        }

        .btn {
            margin-top: 0 !important;
            padding: .2em .6em .3em;

        }

        .nav-tabs
        {
            border-bottom: 1px solid #9fd037;
        }

        label {
            margin-top: 0.2rem;
        }


        #map_nombre {
            height: 100vh;
            margin-bottom: 8px;
            z-index: 1;
        }



        #map_demande_lg {
            height: 100vh;
            margin-bottom: 8px;
            z-index: 1;
        }

        ul#switch_item li {
            display:inline;
        }

        .baselayer_btn_demande {
            border-radius: 50%;

            border: 3px solid #ffda44;
            filter: grayscale(100%);
        }

        .baselayer_btn_demande.active {
            border-radius: 50%;

            border: 3px solid #b2ff59;
            filter: grayscale(0%);
        }

        .baselayer_btn_projet {
            border-radius: 50%;

            border: 3px solid #ffda44;
            filter: grayscale(100%);
        }

        .baselayer_btn_projet.active {
            border-radius: 50%;

            border: 3px solid #b2ff59;
            filter: grayscale(0%);
        }


        .baselayer_btn_projet_lg {
            border-radius: 50%;

            border: 3px solid #ffda44;
            filter: grayscale(100%);
        }

        .baselayer_btn_projet_lg.active {
            border-radius: 50%;

            border: 3px solid #b2ff59;
            filter: grayscale(0%);
        }

        .baselayer_btn_demande_lg {
            border-radius: 50%;

            border: 3px solid #ffda44;
            filter: grayscale(100%);
        }

        .baselayer_btn_demande_lg.active {
            border-radius: 50%;

            border: 3px solid #b2ff59;
            filter: grayscale(0%);
        }
        .box-body ul li
        {
            line-height: 13px !important;
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

    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="box">

                <!-- /.box-header -->
                <div class="box-body">
                @include('statistics.tabs')
                <!-- Tab panes -->
                    <div class="tab-content" style="margin-top: 15px">
                        @include('statistics.tab_projets')
                        {{-- a traiter --}}
                        @include('statistics.tab_demandes')
                    </div>
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
<script src="{{asset('js/sum().js')}}"></script>

<!-- iCheck 1.0.1 -->
<script src="{{asset('vendor_plugins/iCheck/icheck.min.js')}}"></script>

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
<script src="{{asset('js/projets/show_projet.js')}}"></script>
<!-- Sweet-Alert  -->
<script src="{{asset('vendor_components/sweetalert/sweetalert.min.js')}}"></script>
<script src="{{asset('vendor_components/sweetalert/jquery.sweet-alert.custom.js')}}"></script>
<script src="{{asset('js/functions/functions.js')}}"></script>
<script src="{{asset('chart.js/dist/Chart.js')}}"></script>


<script src="{{asset('js/statistics/demande_statistics_map.js')}}"></script>
<script src="{{asset('js/statistics/datatable_statistics_demandes.js')}}"></script>
<script src="{{asset('js/statistics/chart_data_demandes.js')}}"></script>

<script src="{{asset('js/statistics/datatable_statistics_projets.js')}}"></script>

<script type="text/javascript">
    jQuery("body").prepend('<div id="preloader">Loading...</div>');
    jQuery(document).ready(function() {
        jQuery("#preloader").remove();
    });
</script>

@endpush
