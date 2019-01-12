@extends('layouts.app') @section('added_css')
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
        margin-bottom: 8px
    }

    .hidden {
        display: none;
    }
</style>

@endsection @section('content')

<!-- Step wizard -->
<div class="box box-default">
    <div class="box-header with-border">
        <h4 class="box-title">Creation d'une nouvelle demande</h4>
    </div>
    <!-- /.box-header -->
    <div class="box-body wizard-content">

        @include('demandes.form_demande_add')
    </div>
    <!-- /.box-body -->

    <!-- modals -->
    @include('inc._modal_add_partner')


    <!-- modals -->
</div>
<!-- /.box -->
@endsection 
@push('added_scripts')
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


<!-- functions js -->
<script src="{{asset('js/functions.js')}}"></script>
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
<script>

//add point
// let result= [];
// function load_point_desservi(type) {
    
//         $.ajax({
//             url: '/loadPoint',
//             type: 'POST',
//             data: {
//                 _token: '{{ csrf_token() }}',
//                 type: type
//             },

//             dataType: 'JSON',
//             success: function (data) {                
//                result.push(data);
//             }
//         });
//         return result;
//     }
$(document).ready(function () {
    var switch_markup;

     //point desservi management *********************
    $('.table-points tbody').on('change', '.type_point', function () {
        console.log('hello');
        var currow = $(this).closest('tr');
        var point_type = currow.find('td .type_point').val();
        //var col1 = currow.find('td:eq(1)').text();
        currow.find('td .point-desservis').html('');
        switch_markup ='';
        //send ajax data
        $.ajax({
            url: '/loadPoint',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                type: point_type
            },
            dataType: 'JSON',
            success: function (data) {
                console.log(data);

                for(propName in data)
            {
                switch_markup +="<option value="+data[propName].id+">"+data[propName].nom_fr+"</option>";                                                   
            } 
            currow.find('td .point-desservis').append(switch_markup);
            }
        });

    });



    $('#add_point').click(function () {
        var type_point = "localite";
        $.ajax({
            url: '/loadPoint',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                type: type_point
            },    
         
            dataType: 'JSON',
            success: function (data) {
                var propName;
                var markup2       
                //console.log(data[0].nom_fr);
                     
                
                        var markup1 = '<tr>\
                                    <td style=\"width: 40%\">\
                                        <div class=\"form-group\">\
                                            <select class=\"form-control type_point\" name="type_point[]" >\
                                                <option value=\"localite\" selected=\"selected\">Localité</option>\
                                                <option value=\"etablissement_scol\">Etablissement Scolaire</option>\
                                                <option value=\"etablissemnt_sante\"><i class=\"fa fa-dollar\"></i>Etablissement de santé</option>\
                                                <option value=\"autre\"><i class=\"fa fa-dollar\"></i>Autre</option>\
                                            </select>\
                                        </div>\
                                    </td>\
                                    <td style=\"width: 60%\">\
                                        <div class=\"form-group\">\
                                            <select class=\"form-control point-desservis select2 \" name="points[]" style=\"width: 100%;\">';
                                          
                                                for(propName in data)
                                                {
                                                    markup2 +="<option value="+data[propName].id+">"+data[propName].nom_fr+"</option>";                                                   
                                                }  
                                                
                        var markup3 = "</select></div></td></tr>";
                           
                                                

            $(".table-points tr:last").after(markup1+markup2+markup3);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
            }
        });
    });
});
</script>

<script src="{{asset('js/demande.js')}}"></script>
<script src="{{asset('js/function_helpers.js')}}"></script>
@endpush
