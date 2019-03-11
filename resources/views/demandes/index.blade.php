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
                <div class="tab-content">
                    @include('demandes.show.tab_en_cours') 
                    {{-- affectees tab --}}
                    @include('demandes.show.tab_affectees')
                    {{-- accord_definitif --}} 
                    @include('demandes.show.tab_accord_definitif') 
                    {{-- realisee programme --}}
                     @include('demandes.show.tab_realisees_programme') 
                     {{-- a traiter --}}
                     @include('demandes.show.tab_a_traiter')   
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
<script src="{{asset('js/functions.js')}}"></script>
<script src="{{asset('js/demandes/index_en_cours.js')}}"></script>
<script src="{{asset('js/demandes/index_affectees.js')}}"></script>
<script src="{{asset('js/demandes/index_accord_definitif.js')}}"></script>
<script src="{{asset('js/demandes/index_realisee_programmee.js')}}"></script>
<script src="{{asset('js/demandes/index_a_traiter.js')}}"></script>

{{-- libraries for datatables exoprting --}}
{{-- <script src="{{asset('js/vfs_fonts.js')}}"></script>
<script src="{{asset('js/buttons.html5.min.js')}}"></script>
<script src="{{asset('js/buttons.print.min.js')}}"></script>
<script src="{{asset('js/buttons.flash.min.js')}}"></script>
<script src="{{asset('js/jszip.min.js')}}"></script>
<script src="{{asset('js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('js/jquery.dataTables.min.js')}}"></script> --}}

<!-- Sweet-Alert  -->
<script src="{{asset('vendor_components/sweetalert/sweetalert.min.js')}}"></script>
<script src="{{asset('vendor_components/sweetalert/jquery.sweet-alert.custom.js')}}"></script>

<script>
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
</script>

@endpush
