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


</style>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="box">
            <div class="box-header with-border">
                <h4 class="box-title">La liste des demandes</h4>
                <div class="box-controls pull-right">
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">                
                @include('demandes.tabs')                
                <!-- Tab panes -->
                <div class="tab-content">
                    <div class="tab-pane active" id="en_cours" role="tabpanel">
                        <div class="pad">
                            @include('demandes.filter_demandes')
                            <div class="row">
                                <div class="col-md-6"></div>
                                <div class="col-md-6 ">
                                    <a href="/demandes/create" class="btn btn-secondary pull-right"><i class="fa fa-plus"
                                            style="margin-right: 6px"></i>Ajouter
                                        une demande</a>
                                    <a href="" class="btn btn-secondary pull-right" style="margin-right : 6px"><i class="fa fa-print"
                                            style="margin-right: 6px"></i>Imprimer la fiche</a>
                                </div>
                            </div>
                            <div class="row" style="margin-top : 12px">
                                <div class="col-md-6"></div>
                                <div class="col-md-6">
                                    <a href="" class="btn btn-success pull-right" style="margin-right : 6px"><i class="fa fa-file-pdf-o"
                                            style="margin-right: 6px"></i>PDF</a>

                                    <a href="" class="btn btn-success pull-right" style="margin-right : 6px"><i class="fa fa-file-excel-o"
                                            style="margin-right: 6px"></i>CSV</a>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-hover datatables" id="demandes_datatables" style="width:100%">
                                    <thead>
                                        <th>#</th>                                      
                                        <th>N°ordre</th>
                                        <th>D.Réception</th>
                                        <th>Objet</th>
                                        <th>Communes</th>
                                        <th>porteur</th>
                                        <th>Interventions</th>
                                        <th>Partenaire</th>
                                        <th>M.Totol</th>                                        
                                        <th>M.CP</th>                                        
                                        <th>Session</th>                                        
                                       
                                    </thead>

                                </table>
                            </div>
                            <div class="row" style="margin-top : 8px">
                                    <div class="dropdown" style="margin-left : 8px">
                                            <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown">Décision</button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item " href="#" ><div id="modifier"><i class="fa fa-edit"></i> Modifier</div></a>
                                                <a class="dropdown-item" href="#"><div id="accord_definitif"><i class="fa fa-thumbs-up"></i> Accord défintif</div></a>
                                                <a class="dropdown-item" href="#"><div id="a_traiter"><i class="fa fa-clock-o"></i> A traiter</div></a>                                                
                                            </div>
                                    </div>

                                    <button type="button" id="affecter_aux_cnv" class="btn btn-secondary" style="margin-left : 8px;visibility : hidden">Affecter aux conventions</button>
                            </div>
                           
                        </div>
                    </div>

                    {{-- accord_definitif --}}
                    <div class="tab-pane pad" id="accord_definitif" role="tabpanel">2</div>
                    {{-- affectees tab --}}
                    <div class="tab-pane pad" id="affectees" role="tabpanel">
                        <div class="pad">
                            @include('demandes.filter_demandes_affectees')
                            <div class="row">
                                <div class="col-md-6"></div>
                                <div class="col-md-6 ">
                                    <a href="/demandes/create" class="btn btn-secondary pull-right"><i class="fa fa-plus"
                                            style="margin-right: 6px"></i>Ajouter
                                        une demande</a>
                                    <a href="" class="btn btn-secondary pull-right" style="margin-right : 6px"><i class="fa fa-print"
                                            style="margin-right: 6px"></i>Imprimer la fiche</a>
                                </div>
                            </div>
                            <div class="row" style="margin-top : 12px">
                                <div class="col-md-6"></div>
                                <div class="col-md-6">
                                    <a href="" class="btn btn-success pull-right" style="margin-right : 6px"><i class="fa fa-file-pdf-o"
                                            style="margin-right: 6px"></i>PDF</a>

                                    <a href="" class="btn btn-success pull-right" style="margin-right : 6px"><i class="fa fa-file-excel-o"
                                            style="margin-right: 6px"></i>CSV</a>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-hover datatables" id="demandes_datatables_affectees" style="width:100%">
                                    <thead>
                                        <th>#</th>                                      
                                        <th>N°ordre</th>
                                        <th>D.Réception</th>
                                        <th>Objet</th>
                                        <th>Communes</th>
                                        <th>porteur</th>
                                        <th>Interventions</th>
                                        <th>Partenaire</th>
                                        <th>M.Totol</th>                                        
                                        <th>M.CP</th>                                        
                                        <th>Session</th>                                        
                                       
                                    </thead>

                                </table>
                            </div>
                            <div class="row" style="margin-top : 8px">
                                    <div class="dropdown" style="margin-left : 8px">
                                            <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown">Décision</button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item " href="#" ><div  class="modifier"><i class="fa fa-edit"></i> Modifier</div></a>
                                                <a class="dropdown-item" href="#"><div  class="restaurer"><i class="fa fa-thumbs-up"></i>Restaurer</div></a>                                                                                   
                                            </div>
                                    </div>
                            </div>
                           
                        </div>
                    </div>
                    
                    <div class="tab-pane pad" id="realisees_programme" role="tabpanel">3</div>
                    <div class="tab-pane pad" id="a_traiter" role="tabpanel">3</div>
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
<script src="{{asset('validation.js')}}"></script>


<!-- Formatter -->
<script src="{{asset('vendor_components/formatter/formatter.js')}}"></script>
<script src="{{asset('vendor_components/formatter/jquery.formatter.js')}}"></script>

<script src="{{asset('js/formatter.js')}}"></script>
<script src="{{asset('js/functions.js')}}"></script>

<!-- Sweet-Alert  -->
<script src="{{asset('vendor_components/sweetalert/sweetalert.min.js')}}"></script>
<script src="{{asset('vendor_components/sweetalert/jquery.sweet-alert.custom.js')}}"></script>

<script>
    $(document).ready(function () {
        var oTable = $('#demandes_datatables').DataTable({
            processing: true,
            serverSide: true,
            language: {
                url: "{{ URL::asset('js/french-datatables.json') }}",
                processing: "<img src='{{asset('images/loader.gif')}}'>",
            },
            ajax: {
                url: '{!! route('get.demandes') !!}',
                type: 'GET',
                data: function (d) {
                    d.communes = $('select[name=communes]').val();
                    d.session = $('select[name=session]').val();
                    d.interventions = $('select[name=interventions]').val();
                    d.partenaires = $('select[name=partenaires]').val();
                    d.localites = $('select[name=localites]').val();
                    d.daterange = $('input[name=daterange]').val();
                }

            },
            columnDefs: [
           
            { width: 20, targets: 1 },
            { width: 30, targets: 2 },
             { width: 300, targets: 3 }
            ],
            columns: [
                {
                    data: 'checkbox',
                    name: 'checkbox',
                    orderable: false,
                    searchable: false
                },               
                
                {
                    data: 'num_ordre',
                    name: 'demandes.num_ordre',
                     orderable: true,
                    searchable: true
                },
                {
                    data: 'date_reception',
                    name: 'demandes.date_reception',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'objet_fr',
                    name: 'demandes.objet_fr',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'communes',
                    name: 'communes.nom_fr',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'porteur',
                    name: 'porteur.nom_porteur_fr',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'interventions',
                    name: 'interventions.nom',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'partenaires',
                    name: 'partenaires.nom_fr',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'montant_global',
                    name: 'montant_global',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'montantCP',
                    name: 'montantCP',
                    orderable: true,
                    searchable: true
                },


                {
                    data: 'session',
                    name: 'session.nom',
                    orderable: true,
                    searchable: true
                }             
            ],            
            initComplete: function () {
                this.api().columns().every(function () {
                    var column = this;
                    var input = document.createElement("input");
                    $(input).appendTo($(column.footer()).empty())
                        .on('change', function () {
                            column.search($(this).val(), false, false, true).draw();
                        });
                });
            }
        });


        $('#communes_filter,#session_filter,#intervention_filter,#partenaires_filter,#localites_filter,#reservation').on('change paste keyup', function (e) {
            oTable.draw();
            e.preventDefault();
        });


        

        //select item from datatable
        //edite
        $("#modifier").click(function () {
            var id;           
            $("#demandes_datatables > tbody").find('input[name="checkbox"]').each(function () {
                if ($(this).is(":checked")) {
                    id = $('input[name=checkbox]').val();
                    window.location.href = "demandes/"+id+"/edit";                   
                    return false;
                }else{
                    swal("Veuillez selectionner une demande");
                    return false;
                }
            });
        });

        //effecter 
        $("#accord_definitif").click(function () {
            url = "demandes/accord_definitif";
            datatble_id = "demandes_datatables";
            name_chechbox = "checkbox";
            method = "POST";
            decision_function(datatble_id,name_chechbox,url,method);            
        });

        //a traiter 
        $("#a_traiter").click(function () {
            url = "demandes/a_traiter";
            datatble_id = "demandes_datatables";
            name_chechbox = "checkbox";
            method = "POST";
            decision_function(datatble_id,name_chechbox,url,method);    
        });


        //function for decision 
function decision_function(datatble_id, name_chechbox, url,method) {
    //alert(datatble_id + ' ' + name_chechbox + ' ' + url);
    var message_sub_title = '';
    var message_reussi = ''; 
    if(url == "demandes/accord_definitif")
    {
        message_sub_title = "Ajouter a la liste des demandes avec accord définitif!";
        message_reussi = "Accord définitif réussi.";
    }
    if(url == "demandes/a_traiter")
    {
        message_sub_title = "Ajouter a la liste des demandes à traiter!";
        message_reussi = "A traiter réussi.";
    }
    var demande_ids = [];
    var numero_ordres = [];
    $("#" + datatble_id + " > tbody ").find("input[name=" + name_chechbox + " ]").each(function () {
        if ($(this).is(":checked")) {
            demande_ids.push($(this).val());
            numero_ordres.push($(this).data('numero'));
            // id_demande = $('input[name=checkbox]').val();
            // var numero_ordre = $('input[name=checkbox]').data('numero');
            // $('.modal-title').text('Affectation aux conventions la demande numero : ' + numero_ordre);
            // $('#id_demande').val(id_demande);
            // $('#affecter_aux_cnv').modal('show');                                    

        } else {
            swal("Veuillez selectionner une demande");
            return false;
        }

    });

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
                    dataType: 'text',
                    success: function (data) {
                        if (data == "ok") {
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


//affectees 
var oTable_affectees = $('#demandes_datatables_affectees').DataTable({
            processing: true,
            serverSide: true,
            language: {
                url: "{{ URL::asset('js/french-datatables.json') }}",
                processing: "<img src='{{asset('images/loader.gif')}}'>",
            },
            ajax: {
                url: '{!! route('get.demandes.affectees') !!}',
                type: 'GET',
                data: function (d) {
                    d.communes = $('select[name=communes]').val();
                    d.session = $('select[name=session]').val();
                    d.interventions = $('select[name=interventions]').val();
                    d.partenaires = $('select[name=partenaires]').val();
                    d.localites = $('select[name=localites]').val();
                    //d.daterange = $('input[name=daterange]').val();
                }

            },
            columnDefs: [
           
            { width: 20, targets: 1 },
            { width: 30, targets: 2 },
             { width: 300, targets: 3 }
            ],
            columns: [
                {
                    data: 'checkbox',
                    name: 'checkbox',
                    orderable: false,
                    searchable: false
                },               
                
                {
                    data: 'num_ordre',
                    name: 'demandes.num_ordre',
                     orderable: true,
                    searchable: true
                },
                {
                    data: 'date_reception',
                    name: 'demandes.date_reception',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'objet_fr',
                    name: 'demandes.objet_fr',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'communes',
                    name: 'communes.nom_fr',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'porteur',
                    name: 'porteur.nom_porteur_fr',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'interventions',
                    name: 'interventions.nom',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'partenaires',
                    name: 'partenaires.nom_fr',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'montant_global',
                    name: 'montant_global',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'montantCP',
                    name: 'montantCP',
                    orderable: true,
                    searchable: true
                },


                {
                    data: 'session',
                    name: 'session.nom',
                    orderable: true,
                    searchable: true
                }             
            ],            
            initComplete: function () {
                this.api().columns().every(function () {
                    var column = this;
                    var input = document.createElement("input");
                    $(input).appendTo($(column.footer()).empty())
                        .on('change', function () {
                            column.search($(this).val(), false, false, true).draw();
                        });
                });
            }
        });


        $('#communes_filter_affectees,#session_filter_affectees,#intervention_filter_affectees,#partenaires_filter_affectees,#localites_filter_affectees').on('change paste keyup', function (e) {
            oTable_affectees.draw();
            e.preventDefault();
        });

    });

</script>

@endpush
