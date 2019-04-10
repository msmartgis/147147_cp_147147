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
            padding: .2em .2em .2em;
        }

        .loading_modal{
            width:100px; /* This value will depend on what size you want for your loading image, let's say it's 50px */
            height: 100px;
            position:absolute;
            left:50%;
            top:50%;
            margin-top: -100px;
            margin-left: -73px;
            z-index: 2;

        }


        .btn-success.disabled, .btn-success:disabled
        {
            color: #6c6969;
        }

        .btn-success.disabled, .btn-success:disabled
        {
            background-color: transparent;
            border-color: transparent;
            opacity: 0.5;

        }




    </style>
@endsection

@section('content')

    @include('conventions.suiviVersement.edit.form_edit')

    @include('conventions.suiviVersement.edit.modals_edit')


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
<script src="{{asset('js/conventions/create.js')}}"></script>
<script src="{{asset('js/functions.js')}}"></script>



<script>
    $(document).ready(function () {
            $(document).ajaxStart(function () {
                $(".loading_modal").show();
                $(".form-add-versement myForm :input").prop("disabled", true);
            }).ajaxStop(function () {
                $(".loading_modal").hide();
                $(".form-add-versement myForm :input").prop("disabled", false);
            });

        //add partenaire
        $('.add-versement').on('click', function () {
            var montant_verse = 0;
            var data_partenaire = $(this).data('id').split('_');
            var partenaire_name = data_partenaire[0];
            var partenaire_id = data_partenaire[1];

            var partenaire_part = data_partenaire[2];
            var convention_id =  $('#hidden_data_versement_modal').find('input[name="convention_id"]').val();
            var _token = $('#hidden_data_versement_modal').find('input[name="_token"]').val();
            $('#partenaire_name_modal').val(partenaire_name);
            $('#part_partenaire').val(partenaire_part);
            $('#partenaire_id_hidden').val(partenaire_id);
            $('#m-add-versement').modal();
            $.ajax({
                'url': '/versement/getVersementData',
                'type': 'POST',
                'data': {
                    '_token' :_token ,
                    'partenaire_id' : partenaire_id,
                    'convention_id' : convention_id,
                },
                success: function (data) {
                    montant_verse = data.montant_verse;
                    $('.form-add-versement').find('input[name="montant_verse"]').val(montant_verse);
                    $('#rest_a_verser').val(partenaire_part-montant_verse);
                    $('#rest_a_verse_hidden').val(partenaire_part-montant_verse);
                   //
                }
            });
        });

        //supprimer versement
        $('.delete-versement').click(function(){
            var versement_id = $(this).data('id');
            swal({
                title: "Vous êtes sûr?",
                text: "Voulez-vous supprimer ce versement",
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
                        url: '/suivi_versement/'+versement_id,
                        type: 'DELETE',
                        data: {
                            "_token": '{{ csrf_token() }}',
                            'id' : versement_id
                        },
                        dataType: 'JSON',
                        success: function (data) {
                            console.log(data);
                            if (data.length == 0) {
                                swal("Réussi!", "Versement supprimer avec succès", "success");
                                setTimeout(location.reload.bind(location), 500);
                            }
                        }
                    });
                } else {
                    swal("L'operation est annulée", "Aucun changement a été éffectué", "error");
                }
            });
        });
    });
</script>

@endpush
