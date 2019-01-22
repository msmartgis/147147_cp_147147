@extends('layouts.app')
@section('added_css')
<link rel="stylesheet" href="{{asset('css/datatable/datatables.min.css')}}" />
<!-- Select2 -->
<link rel="stylesheet" href="{{asset('vendor_components/select2/dist/css/select2.min.css')}}" />
<!-- bootstrap datepicker -->
<link rel="stylesheet" href="{{asset('vendor_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')}}" />


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
         !important;
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
                @include('demandes.filter_demandes')

                <div class="row">
                    <div class="col-md-6"></div>
                    <div class="col-md-6 ">
                        <a href="/demandes/create" class="btn btn-secondary pull-right"><i class="fa fa-plus" style="margin-right: 6px"></i>Ajouter
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
                    <table class="table table-hover" id="demandes_datatables">
                        <thead>
                            <th>Numero ordre</th>
                            <th>Date Réception</th>
                            <th>Objet</th>
                            <th>Communes</th>
                            <th>porteur</th>
                            <th>Interventions</th>
                            <th>M.Totol</th>
                            <th>Décision</th>
                            <th>Action</th>
                        </thead>

                    </table>
                </div>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
    <!-- modals -->
    <!-- Modal -->
    <div class="modal center-modal fade" id="affecter_aux_cnv" tabindex="-1">
        <div class="modal-dialog m-modal-dim">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title"></h3>
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {!! Form::open(['action' => 'DemandesController@affecterAuxConventions','method'=>'post']) !!}  
                    <input type="hidden" name="id" id="id_demande">
                    <h4>Informations sur le projet</h4>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Maître d'ouvrage : </label>
                                <select class="form-control select2" name="moas[]" style="width: 100%;" multiple="multiple">
                                    @foreach ($moas as $moa)
                                    <option value="{{$moa->id}}">{{$moa->nom_fr}}</option>
                                    @endforeach

                                </select>
                            </div>
                            <!-- /.form-group -->
                        </div>
                    </div>

                    <h4>Financement de projet</h4>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Montant Global TTC:</label>
                                <input type="text" class="form-control" name="montant_global" id="montant_g">
                            </div>
                        </div>
                    </div>

                    <h5>Montage financier définitif</h5>
                    <div class="row">
                        <div class="col-12">
                            <table class="table table-hover">
                                <tr>
                                    <th>#</th>
                                    <th>Partenaire</th>
                                    <th>Montant</th>
                                    <th>Pourcentage</th>
                                </tr>
                                <tbody id="table_body_partner">
                                    <tr>
                                        <td colspan="4" style="text-align: center"><a href="#" id="add_partner"
                                            data-toggle="modal" data-target="#m-add-partenaire"> <i class="fa fa-plus"></i>
                                            <b>Ajouter partenaire</b> </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <button type="button" class="btn btn-warning delete-row">
                                <i class="fa fa-times"></i>
                                supprimer partenaire
                            </button>
                        </div>                        
                    </div>
                   
                </div>

                <div class="modal-footer modal-footer-uniform">
                    <button type="button" class="btn btn-bold btn-pure btn-warning" data-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-bold btn-pure btn-success float-right">Affecter</button>
                </div>
                 {!! Form::close() !!}
            </div>
        </div>
    </div>
    <!-- /.modal -->

    <div class="modal fade" id="m-add-partenaire">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Nouveau partenaire</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Partenaire</label>
                                <select class="form-control select2" style="width: 100%;" name="partnenaire_type_id" id="partenaire_type">
                                    @foreach ($partenaires_types as $type)
                                    <option value="{{$type->id}}">{{$type->nom_fr}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="example_input_full_name">Montant:</label>
                                <input type="text" class="form-control" id="montant_partnenaire">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                    <button type="button" class="btn btn-success float-right" id="add_partner_to_list">Ajouter à la
                        liste</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
    <!-- end modals -->
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
                }

            },
            columns: [{
                    data: 'num_ordre',
                    name: 'demandes.num_ordre'
                },
                {
                    data: 'date_reception',
                    name: 'demandes.date_reception'
                },
                {
                    data: 'objet_fr',
                    name: 'demandes.objet_fr'
                },
                {
                    data: 'communes',
                    name: 'communes.nom_fr'
                },
                {
                    data: 'porteur',
                    name: 'porteur.nom_porteur_fr'
                },
                {
                    data: 'interventions',
                    name: 'interventions.nom'
                },
                {
                    data: 'montant_global',
                    name: 'montant_global'
                },
                {
                    data: 'decision',
                    name: 'decision'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
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



        $('#communes_filter,#session_filter,#intervention_filter').on('change', function (e) {

            oTable.draw();
            e.preventDefault();
        });

        $(document).on('click', '.affect-modal-btn', function () {
            var numero_ordre = $(this).data('numero');
            var id_demande = $(this).data('id');
            $('.modal-title').text('Affectation aux conventions la demande numero : ' + numero_ordre);
            $('#id_demande').val(id_demande);

            $('#affecter_aux_cnv').modal('show');
        });

    });

</script>

@endpush
