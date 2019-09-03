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

        .title-setting
        {
            color: #ff540a !important;
        }

    </style>
@endsection

@section('content')

    <div class="row ">
        <div class="col-12">
            <div class="box ">
                <!-- /.box-header -->
                <div class="box-body" style="padding : 10px">

                    <div class="row">
                        <div class="col-lg-10">
                            <div class="row">
                                <div class="col-12">
                                    <div class="box" style="border-top: 0;border-bottom: 0">
                                        <!-- /.box-header -->
                                        <div class="box-body">
                                            @include('parametres.users')
                                            @include('parametres.associations')
                                            @include('parametres.source_financement')
                                            @include('parametres.sessions')
                                            @include('parametres.modals')
                                        </div>
                                        <!-- /.box-body -->
                                    </div>
                                    <!-- /.box -->
                                </div>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-lg-2"
                             @if($is_mobile == 0) style="padding-left: 0px  !important;"  @else  @endif>
                            <div class="h-p100  bg-light bg-secondary-gradient" style="padding-right: 5px">
                                <div class="box bg-transparent no-border no-shadow ">
                                    <div class="box-body no-padding mailbox-nav ">
                                        <h5>Décisions : </h5>
                                        <hr>
                                    </div>
                                    <!-- /.box-body -->
                                </div>
                                <!-- /. box -->
                            </div>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->


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

<script src="{{asset('js/functions/functions.js')}}"></script>
<script src="{{asset('js/settings/settings.js')}}"></script>


<!-- Sweet-Alert  -->
<script src="{{asset('vendor_components/sweetalert/sweetalert.min.js')}}"></script>
<script src="{{asset('vendor_components/sweetalert/jquery.sweet-alert.custom.js')}}"></script>


<script>




    //get data element
    function getElementData(route,model,modalTitle)
    {
        //send an ajax request to the server update decision column
        $.ajax({
            url: route,
            type: 'GET',
            data: {
                _token: '{{ csrf_token() }}',
                model : model
            },
            dataType: 'HTML',
            success: function (data) {
                $('#modal_title_setting').text(modalTitle);
                $('.setting-modal-body').html(data);
                $('.settingModal').modal('show');

                $('#modal_submit').click(function(){
                    $('.'+model+'-form').submit();
                });
            }
        });

    }

    //delete data
    function deleteElement(route,id)
    {
        swal({
            title: "Vous êtes sûr?",
            text: "Cet élement va être supprimé définitivement",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Oui, je confirme!",
            cancelButtonText: "Non, annuler!",
            closeOnConfirm: false,
            closeOnCancel: false
        }, function (isConfirm) {
            if (isConfirm) {
                //send an ajax request to the server update decision column
                $.ajax({
                    url: route,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: id
                    },
                    dataType: 'JSON',
                    success: function (data) {
                         if (data.length == 0) {
                         swal("Réussi!", "Suppression a été éfectuer avec succès", "success");
                         setTimeout(location.reload.bind(location), 500);
                         }
                    }
                });
            } else {
                swal("L'operation est annulée", "Aucun changement a été éffectué", "error");
            }
        });

    }

</script>
@endpush
