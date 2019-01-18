@extends('layouts.app')
@section('added_css')
<link rel="stylesheet" href="{{asset('css/datatable/datatables.min.css')}}" />
	<!-- Select2 -->
<link rel="stylesheet" href="{{asset('vendor_components/select2/dist/css/select2.min.css')}}" />
<!-- bootstrap datepicker -->
<link rel="stylesheet" href="{{asset('vendor_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')}}" />


<style>
th{
    text-align: center;
    background-color: #ffffff;
    color: #2d353c;
    border: 1px solid #dbe1e6;
}
td {
    border: 0.5px solid #dbe1e6;
}


.center-data-blue
{
    text-align : center;
    background-color: #dbe1e6 !important;
}

.center-data
{
    text-align : center;
   
}
tbody{
    font-size: 13px;
    color: #2d353c;
}

.btn
{
    margin-top : 0 !important;
    padding : .2em .6em .3em; !important;
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
                <div class="table-responsive">
                    <table class="table table-hover" id="demandes_datatables">
                        <thead>
                            <th >Numero ordre</th>
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


<script>
$(document).ready( function () {
    var oTable = $('#demandes_datatables').DataTable({
         processing: true,
        serverSide: true,
        language: {
            url: "{{ URL::asset('js/french-datatables.json') }}",
        },
        ajax: {
            url :'{!! route('get.demandes') !!}',
            type : 'GET',
            data: function (d) {                      
                d.communes = $('select[name=communes]').val();              
                d.session = $('select[name=session]').val();              
                d.interventions = $('select[name=interventions]').val();              
            }
          
        },
        columns: [
            {data: 'num_ordre', name: 'demandes.num_ordre'},
            {data: 'date_reception', name: 'demandes.date_reception'},
            {data: 'objet_fr', name: 'demandes.objet_fr'},
            {data: 'communes', name: 'communes.nom_fr'},
            {data: 'porteur', name: 'porteur.nom_porteur_fr'},
            {data: 'interventions', name: 'interventions.nom'},          
            {data: 'montant_global', name: 'montant_global'},
            {data: 'decision', name: 'decision'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
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


});
</script>

@endpush
