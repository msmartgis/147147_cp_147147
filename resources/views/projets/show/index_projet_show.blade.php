@extends('layouts.app')
@section('added_css')
    <link rel="stylesheet" href="{{asset('css/datatable/datatables.min.css')}}" />
    <!-- Select2 -->
    <link rel="stylesheet" href="{{asset('vendor_components/select2/dist/css/select2.min.css')}}" />
    <!-- bootstrap datepicker -->
    <link rel="stylesheet" href="{{asset('vendor_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')}}" />

    <!--alerts CSS -->
    <link href="{{asset('vendor_components/sweetalert/sweetalert.css')}}" rel="stylesheet" type="text/css">


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


        [type=checkbox]+label:before,
        [type=checkbox]:not(.filled-in)+label:after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 12px;
            height: 12px;
            z-index: 0;
            border: 1.5px solid #ff8740;
            border-radius: 1px;
            margin-top: 0px;
            -webkit-transition: .2s;
            -o-transition: .2s;
            transition: .2s;
        }


        [type=checkbox]+label {
            font-weight: 0;
            position: relative;
            padding-left: 0px;
            cursor: pointer;
            display: inline-block;
            height: 16px;
            line-height: 25px;
            -webkit-user-select: none;
            -moz-user-select: none;
            -khtml-user-select: none;
            -ms-user-select: none;
        }

        [type=checkbox]:checked.chk-col-green+label:before {
            border-right: 2px solid #2fbc26;
            border-bottom: 2px solid #2fbc26;
        }


        [type=checkbox]:checked+label:before {
            top: -4px;
            left: 0px;
            width: 9px;
            height: 18px;
            border-top: 2px solid transparent;
            border-left: 2px solid transparent;
            border-right: 2px solid #398bf7;
            border-bottom: 2px solid #398bf7;
            -webkit-transform: rotate(40deg);
            -ms-transform: rotate(40deg);
            transform: rotate(40deg);
            -webkit-backface-visibility: hidden;
            backface-visibility: hidden;
            -webkit-transform-origin: 100% 100%;
            -ms-transform-origin: 100% 100%;
            transform-origin: 100% 100%
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="box">

                <!-- /.box-header -->
                <div class="box-body">
                @include('projets.show.tabs')
                <!-- Tab panes -->
                    <div class="tab-content" style="margin-top: 15px">
                        @include('projets.show.tab_programmes')

                        @include('projets.show.tab_appel_offre')
                        {{--@include('projets.show.tab_en_cours_execution')
                        @include('projets.show.tab_realise')--}}
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
    </div>
@endsection

@push('added_scripts')
<script src="{{asset('css/datatable/datatables.min.js')}}"></script>

<!-- iCheck 1.0.1 -->
<script src="{{asset('vendor_plugins/iCheck/icheck.min.js')}}"></script>

<!-- bootstrap time picker -->
<script src="{{asset('vendor_plugins/timepicker/bootstrap-timepicker.min.js')}}"></script>
<!-- InputMask -->
<script src="{{asset('vendor_plugins/input-mask/jquery.inputmask.js')}}"></script>
<script src="{{asset('vendor_plugins/input-mask/jquery.inputmask.date.extensions.js')}}"></script>
<script src="{{asset('vendor_plugins/input-mask/jquery.inputmask.extensions.js')}}"></script>

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

@endpush
