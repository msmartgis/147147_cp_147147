@extends('layouts.app') @section('added_css')
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

    {{--mapping css--}}
    <link rel="stylesheet" href="{{asset('mapping/libs/leaflet.css')}}"/>
    <link rel="stylesheet" href="{{asset('mapping/leaflet.draw.css')}}">
    <link rel="stylesheet" href="{{asset('mapping/libs/easy-button.css')}}">
    <link href="{{asset('mapping/leaflet.fullscreen.css')}}" rel='stylesheet' />
    <link rel="stylesheet" href="{{asset('mapping/m-mapping.css')}}">

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
    </style>

@endsection @section('content')
    <!-- Step wizard -->
    <div class="box box-default">

        <!-- /.box-header -->
        <div class="box-body wizard-content">

            @include('projets.create.form_projet_add')
        </div>
        <!-- /.box-body -->

        <!-- modals -->
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
                                        @foreach ($partenaire_types as $type)
                                            <option value="{{$type->id}}">{{$type->nom_fr}}</option>
                                        @endforeach

                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example_input_full_name">Montant:</label>
                                    <input type="text" class="form-control currency-input" id="montant_partnenaire">
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

<script src="{{asset('js/projets/create.js')}}"></script>
<script src="{{asset('js/projets/map_projet.js')}}"></script>
<script src="{{asset('js/functions/functions.js')}}"></script>

<script>
    ! function (window, document, $) {
        "use strict";
        $("input,select,textarea").not("[type=submit]").jqBootstrapValidation();
    }(window, document, jQuery);


    $('#datepicker').datepicker({
        format: 'dd/mm/yyyy'
    });
    $('#datepicker2').datepicker('setDate', 'today');

    $('#datepicker').datepicker('setDate', 'today');


</script>
<script>

    $(document).ready(function () {
        var switchMarkup;
        loading_image('loading-point-desservi','response-div-point-desservi');
        //point desservi management *********************
        $('.table-points tbody').on('change', '.type_point', function () {
            //$('.show-point-desservi').hide();
            var currow = $(this).closest('tr');
            var pointType = currow.find('td .type_point').val();
            //alert(pointType+'test');
            //var col1 = currow.find('td:eq(1)').text();
            currow.find('td .point-desservis').html('');
            switchMarkup ='';
            //send ajax data
            $.ajax({
                url: '/pointDesservi/loadPoint',
                type: 'post',
                data: {
                    _token: '{{ csrf_token() }}',
                    type: pointType
                },
                dataType: 'JSON',
                success: function (data) {
                    console.log(data);
                    for(var propName in data.points)
                    {
                        switchMarkup +='<option value='+data.points[propName].id+'>'+data.points[propName].nom_fr+'</option>';
                    }
                    currow.find('td .point-desservis').append(switchMarkup);
                }
            });
        });


        $('#add_point').click(function () {
            var item = 1;
            var type_point = 1;
            $.ajax({
                url: '/pointDesservi/loadPoint',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    type: type_point
                },

                dataType: 'JSON',
                success: function (data) {
                    // console.log(data.categories);
                    var propName;
                    var markup2;
                    var markup_categ;
                    var markup_points;
                    //console.log(data[0].nom_fr);
                    for(propName in data.categories)
                    {
                        //console.log(data.categories[propName].nom_fr);
                        markup_categ +="<option value="+data.categories[propName].id+">"+data.categories[propName].nom_fr+"</option>";
                    }

                    for(propName in data.points)
                    {
                        //console.log(data.points[propName].nom_fr);
                        markup_points +="<option value="+data.points[propName].id+">"+data.points[propName].nom_fr+"</option>";
                    }

                    var markup1 = "<tr><td style='width: 40%'><div class='form-group'><select class='form-control type_point select2' name='type_point[]'>";
                    var markup2="</select></div></td>";
                    var markup3="<td style='width: 60%'><div class='form-group'><select class='form-control point-desservis select2' name='points[]' style='width: 100%;'>";

                    var markup4 = "</select></div></td></tr>";
                    $(".table-points tr:last").after(markup1+markup_categ+markup2+markup3+markup_points+markup4);


                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
                }
            });
        });

        //add piece
        var item_document = 1;
        $('#add_piece_projet_btn').click(function(){
            var markup = '<tr>' +
                '<td>' +
                '<div class="form-group">'+
                '<div class="checkbox">'+
                '<input type="checkbox" id="row_' + item_document + '" name="record">'+
                '<label for="row_' + item_document + '"></label>'+
                '</div>'+
                '</div>'+
                '</td>' +

                '<td>' +
                '<select class="form-control select2" style="width: 100%;" name="pieces_types[]" id="etat_selector">' +
                '<option value="cps" selected>CPS</option>' +
                '<option value="rc" >RC</option>' +
                '<option value="cps+rc" >CPS+RC</option>' +
                '<option value="bordereau_prix" >BORDEREAU DES PRIX</option>' +
                '<option value="avis_publication_fr" >AVIS DE PUBLICATION FR</option>' +
                '<option value="avis_publication_ar" >AVIS DE PUBLICATION AR</option>' +
                '<option value="en_preparation" >En péparation</option>' +
                ' </select>' +
                '</td>' +

                '<td>' +
                '<div class="form-group" style="text-align: center">' +
                '<input type="file" name="pieces_uploads[]">' +
                '</div>'+
                '</td>' +
                '';
            $('.table-piece tr:last').after(markup);
            item_document++;
        });


        $(".delete-row").click(function () {
            removeRowFromTable('table_body_partner');
        });
    });
</script>


@endpush
