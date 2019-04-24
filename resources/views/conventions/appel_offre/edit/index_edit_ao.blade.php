@extends('layouts.app')
@section('added_css')
    <link rel="stylesheet" href="{{asset('css/datatable/datatables.min.css')}}" />
    <!-- Bootstrap time Picker -->
    <link rel="stylesheet" href="{{asset('vendor_plugins/timepicker/bootstrap-timepicker.min.css')}}" />

    <!-- Select2 -->
    <link rel="stylesheet" href="{{asset('vendor_components/select2/dist/css/select2.min.css')}}" />

    <!-- bootstrap datepicker -->
    <link rel="stylesheet" href="{{asset('vendor_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')}}" />

    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="{{asset('vendor_plugins/iCheck/all.css')}}" />

    {{-- leaflet --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.4/dist/leaflet.css" />

    <!-- toast CSS -->
    <link href="{{asset('vendor_components/jquery-toast-plugin-master/src/jquery.toast.css')}}" rel="stylesheet">

    <!--alerts CSS -->
    <link href="{{asset('vendor_components/sweetalert/sweetalert.css')}}" rel="stylesheet" type="text/css">
    <style>
        #map {
            height: 45vh;
            margin-top : 8px;
            margin-bottom: 8px;
            z-index: 1;
        }
        .col-lg-3 {
            padding: 0 !important;
        }

        .col-lg-9 {
            padding: 0 !important;
        }

        .box{
            margin-bottom: 0 !important;
        }

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
            padding: .1em .1em .1em;
        }

        .form-control[readonly]
        {
            background-color: #fff !important;
        }

        .select2-container--default .select2-selection--multiple
        {
            border: 0;
        }


    </style>
@endsection

@section('content')
    @include('conventions.appel_offre.edit.tabs_ao')

    @include('conventions.appel_offre.edit.form_edit_ao')

    {{-- Modals --}}
    @include('conventions.appel_offre.edit.modals_edit_ao')

    {{-- end modals --}}
@endsection

@push('added_scripts')
<script src="{{asset('css/datatable/datatables.min.js')}}"></script>
<!-- Fab Admin for advanced form element -->
<script src="{{asset('js/advanced-form-element.js')}}"></script>

<!-- iCheck 1.0.1 -->
<script src="{{asset('vendor_plugins/iCheck/icheck.min.js')}}"></script>

<!-- bootstrap time picker -->
<script src="{{asset('vendor_plugins/timepicker/bootstrap-timepicker.min.js')}}"></script>

<!-- Select2 -->
<script src="{{asset('vendor_components/select2/dist/js/select2.full.js')}}"></script>

<!-- InputMask -->
<script src="{{asset('vendor_plugins/input-mask/jquery.inputmask.js')}}"></script>
<script src="{{asset('vendor_plugins/input-mask/jquery.inputmask.date.extensions.js')}}"></script>
<script src="{{asset('vendor_plugins/input-mask/jquery.inputmask.extensions.js')}}"></script>

<!-- date-range-picker -->
<script src="{{asset('vendor_components/moment/min/moment.min.js')}}"></script>
<script src="{{asset('vendor_components/bootstrap-daterangepicker/daterangepicker.js')}}"></script>

<!-- bootstrap datepicker -->
<script src="{{asset('vendor_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>

{{-- leaflet --}}
<script src="https://unpkg.com/leaflet@1.3.4/dist/leaflet.js"></script>

<!-- CK Editor -->
<script src="{{asset('vendor_components/ckeditor/ckeditor.js')}}"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="{{asset('vendor_plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.js')}}"></script>
<!-- Fab Admin for editor -->
<script src="{{asset('js/editor.js')}}"></script>
<!-- Form validator JavaScript -->
<script src="{{asset('js/validation.js')}}"></script>
<!-- toast -->
<script src="{{asset('vendor_components/jquery-toast-plugin-master/src/jquery.toast.js')}}"></script>
<script src="{{asset('js/toastr.js')}}"></script>

<script>
    ! function (window, document, $) {
        "use strict";
        $("input,select,textarea").not("[type=submit]").jqBootstrapValidation();
    }(window, document, jQuery);


    $('#datepicker').datepicker({
        format: 'dd/mm/yyyy'
    });

</script>


<!-- Sweet-Alert  -->
<script src="{{asset('vendor_components/sweetalert/sweetalert.min.js')}}"></script>
<script src="{{asset('vendor_components/sweetalert/jquery.sweet-alert.custom.js')}}"></script>

<script src="{{asset('js/functions.js')}}"></script>



<script>
    $(document).ready(function () {

        $('.add-piece').on('click',function(){
            $('#add_piece_forme').attr('action', $(this).data('route'));

            $('#modal_add_piece').modal('show');
        });


        $(function() {
            $('#etat_selector').change(function(){
                $('.etat-projet').hide();
                $('#' + $(this).val()).show();
            });
        });


        //files managemnt *********
        //add piece
        $('.form-ulpoad-piece').on('submit', function (e) {
            $('#modal_add_piece').modal('hide');
            $form = $(this);
            e.preventDefault();
            var markup = '';
            url = $form.attr('action');
            type = $form.attr('method');
            $.ajax({
                'type': type,
                'url': url,
                'data': new FormData(this),
                // Tell jQuery not to process data or worry about content-type
                // You *must* include these options!
                cache: false,
                contentType: false,
                processData: false,
                success: function (data) {
                    console.log(data);
                    markup =
                        '<tr style="text-align: center">'+
                            '<td>' + data.piece.document + '</td>'+
                            '<td>' + data.piece.file_name + '</td>'+
                            '<td style="text-align: center">'+
                            '<a href="/files/download/appel_offres/'+data.piece.appel_offre_id+'/'+data.file_name+'">'+
                                '<button class="btn btn-secondary-table delete-piece" ><i class="fa fa-download"></i> Telecharger</button>'+
                            '</td>'+

                            '<td style="text-align: center">'+
                                '<button class="btn btn-danger-table delete-piece" data-id=' + data.piece.id + '><i class="fa fa-close"></i> Supprimer</button>'+
                            '</td>'+
                        '</tr>';

                    if(data.type_piece == "dossier_adjiducataire")
                    {
                        $(markup).prependTo("#pieces_tbody_adjiducataire");
                    }

                    if(data.type_piece == "dce")
                    {
                        $(markup).prependTo("#pieces_tbody_dce");
                    }


                    $('#add_modal_piece').modal('hide');
                }
            });
        });


        //delete piece
        $(".delete-piece").click(function () {
            var piece_id;
            var directory;
            var file_name;
            var route;
            route = $(this).data('route');
            piece_id = $(this).data('id');
            directory = $(this).data('directory');
            file_name = $(this).data('file');
            message_reussi = "La piéce a été supprimer avec succès";
            message_sub_title = "Le document sera supprimé définitivement";

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
                        url: route,
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            piece_id: piece_id,
                            directory: directory,
                            file_name: file_name
                        },
                        dataType: 'JSON',
                        success: function (data) {

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
        });

        //attribuer appel offre
        $('#attribuer_appel_offre_btn').click(function(){
            var appelOffre_id = $(this).data('id');
            var state = "attribue";

            changeAppelOffrState(appelOffre_id,state);
        });


        //reporter appel offre
        $('#reporter_appel_offre_btn').click(function(){
            var appelOffre_id = $(this).data('id');
            var state = "reporte";
            var data = $('#ouverture_plis_input').val();

            changeAppelOffrState(appelOffre_id,state,data);
        });

        //anuller appel offre
        $('#annuler_appel_offre_btn').click(function(){
            var appelOffre_id = $(this).data('id');
            var state = "annule";
            changeAppelOffrState(appelOffre_id,state);
        });

        function changeAppelOffrState(idAO,state,data)
        {
            swal({
                title: "Vous êtes sûr?",
                text: "Cette action va changer l'etat de l'appel d'offre",
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
                        url: '{!! route('apppelOffre.changeState')!!}',
                        type: 'POST',
                        data: {
                            "_token": '{{ csrf_token() }}',
                            "id": idAO,
                            "state" : state,
                            "data" : data
                        },
                        dataType: 'JSON',
                        success: function (data) {
                            if (data.length == 0) {
                                swal("Réussi!", "Opération réusssite", "success");
                                setTimeout(window.location.replace('/appelOffre/'+idAO+'/edit'), 500);
                            }
                        }
                    });
                } else {
                    swal("L'operation est annulée", "Aucun changement a été éffectué", "error");
                }
            });

        }


        //supprimer appel offre
        $('#supprimer_ao').click(function(){
            var appelOffre_id = $(this).data('id');
            message_reussi = "Suppression effectuée avec succès";
            message_sub_title = "Voulez vous vraiment supprimer cet Appel d'offre!!";
            url='{{url("appelOffre")}}'+'/'+appelOffre_id;
            redirect = "/appelOffre";
            delete_function(appelOffre_id,url,message_reussi,message_sub_title,redirect);
        });

        //delete function
        function delete_function(id, url, success_message, sub_title_message,redirect) {
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
                        type: 'DELETE',
                        data: {
                            "_token": '{{ csrf_token() }}',
                            "_method": 'DELETE',
                            "id": id,
                        },
                        dataType: 'JSON',
                        success: function (data) {
                            console.log(data);
                            if (data.length == 0) {
                                swal("Réussi!", success_message, "success");
                                setTimeout(window.location.replace(redirect), 500);
                            }
                        }
                    });
                } else {
                    swal("L'operation est annulée", "Aucun changement a été éffectué", "error");
                }
            });
        }

    });

</script>

@endpush
