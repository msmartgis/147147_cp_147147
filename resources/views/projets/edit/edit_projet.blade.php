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


        /* IMAGE GALLERY*/
        :root {
            /* Set fade in duration */
            --fade-time: 0.5s;
        }

        .main-img
        {display:inline-block;position:relative;}

        .main-img-download {
            position:absolute;
            top:2px;
            right:2px;
        }

        .main-img-delete {
            position:absolute;
            top:70px;
            right:2px;
        }


        .container {
            max-width: 1080px;
            margin: auto;
            border: #000 solid 0px;
            background: #fff;
        }

        .main-img img,
        .imgs img {
            width: 100%;
        }



        .imgs img {
            cursor: pointer;
        }

        /* Fade in animation */
        @keyframes fadeIn {
            to {
                opacity: 1;
            }
        }

        .fade-in {
            opacity: 0;
            animation: fadeIn var(--fade-time) ease-in 1 forwards;
        }

        /* Media Queries */
        @media(max-width: 600px) {
            .imgs {
                grid-template-columns: repeat(2, 1fr);
            }
        }


        /* Style the button and place it in the middle of the container/image */

    </style>
@endsection

@section('content')

    @include('projets.edit.form_edit_projet')

    {{-- Modals --}}
   @include('projets.edit.modals_edit_projet')


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

</script>


<!-- Sweet-Alert  -->
<script src="{{asset('vendor_components/sweetalert/sweetalert.min.js')}}"></script>
<script src="{{asset('vendor_components/sweetalert/jquery.sweet-alert.custom.js')}}"></script>

<script src="{{asset('js/demandes/demande.js')}}"></script>
<script src="{{asset('js/demandes/functions.js')}}"></script>
<script src="{{asset('js/demandes/edit/demande_edit.js')}}"></script>
<script src="{{asset('js/functions.js')}}"></script>
<script src="{{asset('js/projets/projets.js')}}"></script>


<script>
    $(document).ready(function () {
        //files managemnt *********
        //delete image gallery
        $(".main-img-delete").click(function () {
            var filenam = $('#current').attr('src').split('/');

            var path = filenam[filenam.length - 1];
            var id_convention = filenam[filenam.length - 2];

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
                        url: '{!! route('delete_gallery_image')!!}',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            path: path,
                            id_convention : id_convention
                        },
                        dataType: 'JSON',
                        success: function (data) {

                            if (data.length == 0) {
                                swal("Réussi!", message_reussi, "success");
                                location.reload(true);
                            }
                        }
                    });
                } else {
                    swal("L'operation est annulée", "Aucun changement a été éffectué", "error");
                }
            });
        });

        //delete piece
        $(".delete-piece").click(function () {
            var piece_id;
            piece_id = $(this).data('id').split('_').pop();
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
                            piece_id: piece_id
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


        $(".delete-etat").click(function () {
            var etat_id;
            etat_id = $(this).data('id').split('_').pop();
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
                        url: '{!! route('delete_etat')!!}',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            etat_id: etat_id
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

        //supprimer demande
        $('#supprimer_demande').click(function(){
            var demande_id = $(this).data('id');
            message_reussi = "Suppression effectuée avec succès";
            message_sub_title = "Voulez vous vraiment supprimer cette demande!!";
            url='{{url("demandes")}}'+'/'+demande_id;
            redirect = "/demandes";
            delete_function(demande_id,url,message_reussi,message_sub_title,redirect);
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
