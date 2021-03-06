@extends('layouts.app')
@section('added_css')
    <!-- Bootstrap time Picker -->
    <link rel="stylesheet" href="{{asset('vendor_plugins/timepicker/bootstrap-timepicker.min.css')}}" />

    <!-- Select2 -->
    <link rel="stylesheet" href="{{asset('vendor_components/select2/dist/css/select2.min.css')}}" />

    <!-- bootstrap datepicker -->
    <link rel="stylesheet" href="{{asset('vendor_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')}}" />

    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="{{asset('vendor_plugins/iCheck/all.css')}}" />


    <!-- toast CSS -->
    <link href="{{asset('vendor_components/jquery-toast-plugin-master/src/jquery.toast.css')}}" rel="stylesheet">

    <!--alerts CSS -->
    <link href="{{asset('vendor_components/sweetalert/sweetalert.css')}}" rel="stylesheet" type="text/css">

    {{--mapping css--}}
    <link rel="stylesheet" href="{{asset('mapping/libs/leaflet.css')}}"/>
    <link rel="stylesheet" href="{{asset('mapping/leaflet.draw.css')}}">
    <link rel="stylesheet" href="{{asset('mapping/libs/easy-button.css')}}">
    <link href="{{asset('mapping/leaflet.fullscreen.css')}}" rel='stylesheet' />
    <link rel="stylesheet" href="{{asset('mapping/m-mapping.css')}}">
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

    </style>
@endsection

@section('content')

    @include('conventions.edit.form_edit')

    {{-- Modals --}}
   @include('conventions.modals')
   @include('conventions.edit.modals_edit')

    {{-- end modals --}}
@endsection

@push('added_scripts')
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



<!-- CK Editor -->
<script src="{{asset('vendor_components/ckeditor/ckeditor.js')}}"></script>
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

</script>


<!-- Sweet-Alert  -->
<script src="{{asset('vendor_components/sweetalert/sweetalert.min.js')}}"></script>
<script src="{{asset('vendor_components/sweetalert/jquery.sweet-alert.custom.js')}}"></script>


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

<script src="{{asset('js/demandes/demande.js')}}"></script>
<script src="{{asset('js/demandes/edit/demande_edit.js')}}"></script>
<script src="{{asset('js/conventions/map_convention_edit.js')}}"></script>



<script>
    $(document).ready(function () {
        $('#activate_edit_btn').on('click',function(){
            modification_active('form_convention_edit','a');
            CKEDITOR.instances.editor1.setReadOnly(false);
        });


        //files managemnt *********
        //add piece
        $('.form-ulpoad-piece').on('submit', function (e) {
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
                        "<tr style='text-align: center'>\
                            <td>" + data.type + "</td>\
                        <td>" + data.nom + "</td>\
                        <td>" + data.path + "</td>\
                        <td style='text-align: center'>\
                            <a href='/files/download/convention/' + data.convention_id + '/' + data.path + '>'\
                                <button type='button'  class='btn btn-secondary-table' >\
                                <i class='fa fa-download'></i>\
                                Télécharger</button>\
                            </a>\
                        </td>\
                        <td style='text-align: center'>\
                            <button type='button' class='btn btn-danger-table delete-piece' data-file_name="+data.path+" data-file_id="+data.id+" data-file_id="+data.id+" data-directory='conventions' data-object_id="+data.convention_id+"><i class='fa fa-close'></i> Supprimer</button>\
                        </td>\
                        </tr>";
                    $(markup).appendTo("#pieces_tbody");
                    $('#add_modal_piece').modal('hide');
                    setTimeout(function() {
                        location.reload();
                    }, 2000);
                }
            });
        });


        //delete piece
        $(".delete-piece").click(function () {
            var object_id;
            var file_name;
            var directory;
            var file_id;
            object_id = $(this).data('object_id');
            file_name = $(this).data('file_name');
            directory = $(this).data('directory');
            file_id = $(this).data('file_id');

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
                        url: '{!! route('delete_piece')!!}',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            object_id: object_id,
                            file_name : file_name,
                            directory : directory,
                            file_id : file_id
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


        //add partenaire
        $('.form-add-partenaire-edit').on('submit', function (e) {
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
                        "<tr style='text-align: center'>\
                            <td>" + data.part.nom_fr + "</td>\
                        <td>" + data.montant + "</td>\
                        <td>" + data.pourcentage + "</td>\
                        <td style='text-align: center'>\
                            <button class='btn btn-secondary edit-partenaire' data-demande'" + data.demande + "' data-partnaire='" + data.id + "' style='visibility : hidden'><i class='fa fa-edit'></i> Editer</button>\
                            <button type='button' class='btn btn-warning delete-partenaire' data-demande'" + data.demande + "' data-partnaire='" + data.id + "'><i class='fa fa-close'></i> Supprimer</button>\
                        </td>\
                        </tr>";
                    $(markup).prependTo("#partenaire_tbody");
                    $('#m-add-partenaire-edit').modal('hide');
                }
            });
        });


        //delete partenaire

        $(".delete-partenaire").click(function () {
            var convention_partenaire = $(this).data('id').split('_');
            var convention_id;
            var partenaire_id;

            convention_id = convention_partenaire[0];
            partenaire_id = convention_partenaire[1];
            message_reussi = "Le partenaire a été supprimer avec succès";
            message_sub_title = "Le partenaire sera supprimé définitivement dans cette demande";

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
                        url: '{!! route("delete_partenaire_convention")!!}',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            convention_id: convention_id,
                            partenaire_id: partenaire_id
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


        //accord definitif
        $('#accord_definitif').click(function(){
            var demande_id =[];
            demande_id.push($(this).data('id'));
            //demande_id = $(this).data('id');
            message_reussi = "Accord définitif avec succès";
            message_sub_title = "Un accord définitif sera affecté a cette demande!!";
            url='{!! route('affecterOrAccord')!!}';
            demande_mngmnt(demande_id,url,message_reussi,message_sub_title);

        });

        //a traiter
        $('#a_traiter').click(function(){
            var demande_id =[];
            demande_id.push($(this).data('id'));
            //demande_id = $(this).data('id');
            message_reussi = "A traiter affecté avec succès";
            message_sub_title = "A traiter sera affecté a cette demande!!";
            url='{!! route('a_traiter')!!}';
            demande_mngmnt(demande_id,url,message_reussi,message_sub_title);
        });

        //restaurer en cours
        $('#restaurer').click(function(){
            var demande_id =[];
            demande_id.push($(this).data('id'));
            message_reussi = "Restauration effectuée avec succès";
            message_sub_title = "Restaurer cette demande!!";
            url='{!! route('restaurer_demande')!!}';
            demande_mngmnt(demande_id,url,message_reussi,message_sub_title);
        });


        //affectation aux convention
        $('#affect_aux_convention_btn').click(function(){
            var demande_id = $(this).data('id');
            var numero_ordre = $(this).data('numero');
            $('#id_demande_modal_affect').val(demande_id);
            $('.modal-title').text('Affectation aux conventions la demande numero : ' + numero_ordre);
            $('#affecter_aux_cnv').modal('show');
        });


        //supprimer demande
        $('#supprimer_convention').click(function(){
            var convention_id = $(this).data('id');
            message_reussi = "Suppression effectuée avec succès";
            message_sub_title = "Voulez vous vraiment supprimer cette convention!!";
            url='{{url("convention")}}'+'/'+convention_id;
            redirect = "/convention";
            delete_function(convention_id,url,message_reussi,message_sub_title,redirect);
        });


        //demande_managemnt
        function demande_mngmnt(id, url, success_message, sub_title_message) {
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
        }

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
