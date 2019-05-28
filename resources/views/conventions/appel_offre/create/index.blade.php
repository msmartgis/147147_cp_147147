@extends('layouts.app') @section('added_css')

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

    <style>
        #map {
            height: 75vh;
            margin-top : 8px;
            margin-bottom: 8px;
            z-index: 1;
        }

        .hidden {
            display: none;
        }

        #loading-point-desservi { display: none; }

        .etat-projet{
            display: none;
        }


    </style>

@endsection @section('content')
    <!-- Step wizard -->
    <div class="box box-default">

        <!-- /.box-header -->
        <div class="box-body wizard-content">

            @include('conventions.appel_offre.create.form_appel_offre_add')
        </div>
        <!-- /.box-body -->


        <!-- /.modal -->

        <!-- modals -->
    </div>
    <!-- /.box -->
@endsection
@push('added_scripts')

<script src="{{asset('css/datatable/datatables.min.js')}}"></script>
<!-- steps -->
<script src="{{asset('vendor_components/jquery-steps-master/build/jquery.steps.js')}}"></script>

<!-- wizard -->
<script src="{{asset('js/steps.js')}}"></script>

<!-- Fab Admin for advanced form element -->
<script src="{{asset('js/advanced-form-element.js')}}"></script>

<!-- iCheck 1.0.1 -->
<script src="{{asset('vendor_plugins/iCheck/icheck.min.js')}}"></script>

<!-- bootstrap time picker -->
<script src="{{asset('vendor_plugins/timepicker/bootstrap-timepicker.min.js')}}"></script>

<!-- Select2 -->
<script src="{{asset('vendor_components/select2/dist/js/select2.full.js')}}"></script>


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
<script src="{{asset('js/functions/functions.js')}}"></script>
<script src="{{asset('js/appel_offre/show_appel_offre_conventions.js')}}"></script>

<script>
    ! function (window, document, $) {
        "use strict";
        $("input,select,textarea").not("[type=submit]").jqBootstrapValidation();
    }(window, document, jQuery);


    $('#datepicker').datepicker({
        format: 'dd/mm/yyyy'
    });
    $('#datepicker2').datepicker({
        format: 'dd/mm/yyyy'
    });

    $('#datepicker2').datepicker('setDate', 'today');
    $('#datepicker').datepicker('setDate', 'today');
</script>


<script>
    $(document).ready(function(){
        $(function() {
            $('#etat_selector').change(function(){
                $('.etat-projet').hide();
                $('#' + $(this).val()).show();
            });
        });
    });
</script>



@endpush
