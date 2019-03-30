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
                @include('demandes.show.tabs')                
                <!-- Tab panes -->
                <div class="tab-content" style="margin-top: 15px">
                    @include('demandes.show.tab_en_cours')
                    {{-- a traiter --}}
                    @include('demandes.show.tab_a_traiter')
                    {{-- accord_definitif --}}
                    @include('demandes.show.tab_accord_definitif')
                    {{-- affectees tab --}}
                    @include('demandes.show.tab_affectees')
                    {{--  programme --}}
                     @include('demandes.show.tab_programmee')
                    {{-- realisee  --}}
                    @include('demandes.show.tab_realisee')

                </div>  
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
    <!-- modals -->
    @include('demandes.modals')
</div>
@endsection

@push('added_scripts')
<script src="css/datatable/datatables.min.js"></script>

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
<script src="{{asset('js/demandes/index_en_cours.js')}}"></script>
<script src="{{asset('js/demandes/index_a_traiter.js')}}"></script>
<script src="{{asset('js/demandes/index_accord_definitif.js')}}"></script>
{{--
<script src="{{asset('js/demandes/index_affectees.js')}}"></script>

<script src="{{asset('js/demandes/index_programmee.js')}}"></script>
<script src="{{asset('js/demandes/index_realisee.js')}}"></script>

--}}

<!-- Sweet-Alert  -->
<script src="{{asset('vendor_components/sweetalert/sweetalert.min.js')}}"></script>
<script src="{{asset('vendor_components/sweetalert/jquery.sweet-alert.custom.js')}}"></script>


<script src="{{asset('js/functions/functions.js')}}"></script>


<script>

    //function for decision
    function decision_function(datatble_id, name_chechbox, url, method) {
        var checked = false;
        var message_sub_title = '';
        var message_reussi = '';
        if (url == "demandes/accord_definitif") {
            message_sub_title = "Ajouter a la liste des demandes avec accord définitif!";
            message_reussi = "Accord définitif réussi.";
        }
        if (url == "demandes/a_traiter") {
            message_sub_title = "Ajouter a la liste des demandes à traiter!";
            message_reussi = "A traiter réussi.";
        }
        var demande_ids = [];
        var numero_ordres = [];
        $("#" + datatble_id + " > tbody ").find("input[name=" + name_chechbox + " ]").each(function () {
            if ($(this).is(":checked")) {
                demande_ids.push($(this).val());
                numero_ordres.push($(this).data('numero'));
                checked = true;
            }
        });

        if (!checked) {
            swal("Veuillez selectionner une demande");
            return false;
        }

        if (demande_ids.length > 0) {
            swal({
                title: "Vous êtes sûr?",
                text: message_sub_title,
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
                        url: url,
                        type: method,
                        data: {
                            _token: '{{ csrf_token() }}',
                            demande_ids: demande_ids
                        },
                        dataType: 'JSON',
                        success: function (data) {
                            //console.log(data);
                            if (data.length == 0) {
                                swal("Réussi!", message_reussi, "success");
                                setTimeout(location.reload.bind(location), 500);
                            }
                        }
                    });
                } else {
                    swal("L'operation est annulée", "Aucun changement a été éffectué", "error");
                }
            });
        }
    }


    //affectation and accord defintitf
    function accordAndAffectation_modal_data(modalTitle,datatable,nameCheckbox)
    {
        $("#"+datatable+" > tbody").find("input[name=" + nameCheckbox + " ]").each(function () {
            if ($(this).prop("checked") == true) {
                id= $(this).attr('id');

                $.ajax({
                    url: 'demandes/getDemandeData',
                    type: 'GET',
                    data: {
                        _token: '{{ csrf_token() }}',
                        id : id
                    },
                    dataType: 'JSON',
                    success: function (data) {
                        var montant_cp =data.pivot[0].pivot.montant;
                        var montant_global = data.montantGlobal.montant_global;
                        $('#modalTitleAccordAndAffect').text(modalTitle);
                        $('#montant_g').val(montant_global);
                        $('#affecterORAccord').val('0');
                        $('#montant_cp').val(montant_cp);
                        $("#accordAndAffectModal").modal();


                        if(data.pivot_all.length > 0)
                        {

                            for( i = 0 ; i < data.pivot_all.length ; i++)
                            {
                                $('#table_body_partner').append('<tr style="text-align: center"><td><input type="checkbox" name="record" id="row_'+data.pivot_all[i].id+'"><label for="row_'+data.pivot_all[i].id+'"></label></td><td>'+data.pivot_all[i].nom_fr+'</td><td>'+data.pivot_all[i].pivot.montant+'</td><td>'+(data.pivot_all[i].pivot.montant)/montant_global*100+'</td></tr>');
                            }
                        }

                    }
                });

            } else {
                swal("Veuillez selectionner une demande");
                return false;
            }
        });
    }


    //button accord defintif
    $("#accord_defintif").click(function () {
        $("#demandes_datatables_affectees > tbody").find('input[name="checkbox_affectees"]').each(function () {
            if ($(this).prop("checked") == true) {
               alert('accord defintif clicekd');
            } else {
                swal("Veuillez selectionner une demande");
                return false;
            }
        });
    });


//restaurer en cours affecter
$("#restaurer_affectees").click(function () {
        $("#demandes_datatables_affectees > tbody").find('input[name="checkbox_affectees"]').each(function () {
            if ($(this).prop("checked") == true) {
                var demande_id = [];
                demande_id.push($('input[name=checkbox_affectees]').val());     
                message_reussi = "Restauration effectuée avec succès";
                message_sub_title = "Restaurer cette demande!!";
                url='{!! route('restaurer_demande_from_affectation')!!}';
                demande_mngmnt(demande_id,url,message_reussi,message_sub_title);
            } else {
                swal("Veuillez selectionner une demande");
                return false;
            }
        });
    });


    //restaurer accord definitif   
    $("#restaurer_accord_definitif").click(function () {
            $("#demandes_datatables_accord_definitif > tbody").find('input[name="checkbox_accord_definitif"]').each(function () {
                if ($(this).prop("checked") == true) {
                    var demande_id = [];
                    demande_id.push($('input[name=checkbox_accord_definitif]').val());     
                    message_reussi = "Restauration effectuée avec succès";
                    message_sub_title = "Restaurer cette demande!!";
                    url='{!! route('restaurer_demande')!!}';
                    demande_mngmnt(demande_id,url,message_reussi,message_sub_title);
                } else {
                    swal("Veuillez selectionner une demande");
                    return false;
                }
            });
        });


//demande_managemnt
/*function demande_mngmnt(id, url, success_message, sub_title_message) {
    swal({
        title: "Vous êtes sûr?",
        text: sub_title_message,
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
                url: url,
                type: 'POST',
                data: {
                    "_token": '{{ csrf_token() }}',
                    "demande_ids": id,
                },
                dataType: 'JSON',
                success: function (data) {
                    console.log(data);
                    if (data.length == 0) {
                        swal("Réussi!", success_message, "success");
                        setTimeout(location.reload.bind(location), 500);
                    }
                }
            });
        } else {
            swal("L'operation est annulée", "Aucun changement a été éffectué", "error");
        }
    });
}*/
</script>

@endpush
