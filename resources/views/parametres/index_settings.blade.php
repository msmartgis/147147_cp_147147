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

    <style>
        /* width */
        ::-webkit-scrollbar {
            width: 10px;
        }

        /* Track */
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        /* Handle */
        ::-webkit-scrollbar-thumb {
            background: #888;
        }

        /* Handle on hover */
        ::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

        .close{
            background: #000;
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


        /* An ugly trick to use a filter icon */
        .ui-icon-volume-off.ui-icon-filter {
            -ms-transform: rotate(270deg);
            -webkit-transform: rotate(270deg);
            transform: rotate(270deg);
        }


        .vtabs .tabs-vertical
        {
            width: 200px;
        }

    </style>
@endsection

@section('content')

    <div class="row ">
        <div class="col-12">
            <div class="box ">
                <!-- /.box-header -->
                <div class="box-body" style="padding : 10px">
                    <div class="vtabs col-12">
                        <ul class="nav nav-tabs tabs-vertical" role="tablist">
                            <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#home9" role="tab"><span><i class="fa fa-calendar" style="margin-right: 8px"></i>SESSIONS</span></a> </li>
                            <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#profile9" role="tab"><span><i class="fa fa-calendar" style="margin-right: 8px"></i>PORTEUR DE PROJET</span></a> </li>
                            <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#messages9" role="tab"><span><i class="fa fa-calendar" style="margin-right: 8px"></i>POINTS DESSERVIS</span></a> </li>
                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div class="tab-pane active" id="home9" role="tabpanel">
                                <div class="pad">
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <tr>
                                                <th></th>
                                                <th>N°</th>
                                                <th>Mois</th>
                                                <th>Date</th>
                                                <th>Type</th>
                                                <th>Status</th>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <input type="checkbox" id="md_checkbox_15" class="chk-col-orange" checked />
                                                    <label for="md_checkbox_15"></label>
                                                </td>
                                                <td>Lorem Ipsum</td>
                                                <td><span class="text-muted"><i class="fa fa-clock-o"></i> Oct 16, 2017</span> </td>
                                                <td>$158.00</td>
                                                <td><span class="label label-danger">Pending</span></td>
                                                <td><span class="label label-danger">Pending</span></td>

                                            </tr>
                                            <tr>
                                                <td>
                                                    <input type="checkbox" id="md_checkbox_15" class="chk-col-orange" checked />
                                                    <label for="md_checkbox_15"></label>
                                                </td>
                                                <td>Lorem Ipsum</td>
                                                <td><span class="text-muted"><i class="fa fa-clock-o"></i> Oct 16, 2017</span> </td>
                                                <td>$55.00</td>
                                                <td><span class="label label-warning">Shipped</span></td>
                                                <td><span class="label label-warning">Shipped</span></td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <input type="checkbox" id="md_checkbox_15" class="chk-col-orange" checked />
                                                    <label for="md_checkbox_15"></label>
                                                </td>
                                                <td>Lorem Ipsum</td>
                                                <td><span class="text-muted"><i class="fa fa-clock-o"></i> Oct 16, 2017</span> </td>
                                                <td>$845.00</td>
                                                <td><span class="label label-danger">Prossing</span></td>
                                                <td><span class="label label-danger">Prossing</span></td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td>Lorem Ipsum</td>
                                                <td><span class="text-muted"><i class="fa fa-clock-o"></i> Oct 16, 2017</span> </td>
                                                <td>$145.00</td>
                                                <td><span class="label label-success">Paid</span></td>
                                                <td><span class="label label-success">Paid</span></td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td>Lorem Ipsum</td>
                                                <td><span class="text-muted"><i class="fa fa-clock-o"></i> Oct 16, 2017</span> </td>
                                                <td>$450.00</td>
                                                <td><span class="label label-warning">Shipped</span></td>
                                                <td><span class="label label-warning">Shipped</span></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane pad" id="profile9" role="tabpanel">2</div>
                            <div class="tab-pane pad" id="messages9" role="tabpanel">3</div>
                        </div>
                    </div>

                </div>
                <!-- /.box-body -->
            </div>

            <!-- /.box -->
        </div>
    </div>

    <!-- modals -->

@endsection



@push('added_scripts')

<script src="{{asset('css/datatable/datatables.min.js')}}"></script>

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

<!-- Sweet-Alert  -->
<script src="{{asset('vendor_components/sweetalert/sweetalert.min.js')}}"></script>
<script src="{{asset('vendor_components/sweetalert/jquery.sweet-alert.custom.js')}}"></script>



@endpush
