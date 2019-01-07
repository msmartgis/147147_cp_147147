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
            
            {!! Form::open(['action' => 'DemandesController@store','method'=>'POST','class'=>'tab-wizard
            wizard-circle create-demande','enctype' => 'multipart/form-data']) !!}  
             
        <!-- Step 1 -->
        <h6>Information Général</h6>
        <section>
            <div class="row">               
                <div class="col-3">
                    <div class="form-group">
                    {{Form::label('','N° d\'ordre :')}}
                    {{Form::text('num_ordre',$current_numero_ordre,['class'=>'form-control'])}}
                </div>
                </div>
                <div class="col-3">
                    <div class="form-group">
                    {{Form::label('','Date de récéption:')}}
                    <div class="input-group date">
                        <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </div>
                        {{Form::text('date_reception','',['class'=>'form-control pull-right','id'=>'datepicker'])}}
                    </div>
                    <!-- /.input group -->
                </div>
                </div>

                <div class="col-6">
                    <div class="form-group">                        
                        {{Form::label('','Commune:')}}                        
                            {{Form::select('communes', $communes, null,
                             [
                                 'data-placeholder' => 'Selectionner commune(s)',
                                 'class'=>'form-control select2',
                                 'multiple'=>'multiple',
                                 'name'=>'communes[]'
                            ]
                            )}}
                        
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                       
                        {{Form::label('','Etat du projet :')}}  
                        {{Form::select('etat_projet', ['realise' => 'Réalisée dans d\'autre programme', 'programme' => 'Programmée dans d\'autre programme'], null, ['data-placeholder' => 'Etat du projet','class'=>'form-control'])}}
                     
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">                       
                        {{Form::label('','Longueur :')}}
                        {{Form::text('longueur','',['class'=>'form-control'])}}                        
                    </div>
                </div>
                <div class="col-12">
                    <div id="map" style="border: solid 1px #666666;box-shadow: 0px 5px 20px rgba(0, 0, 0, 0.05);"></div>

                    <div class="cmodali active" style=" width: 300px;  height: 100px;left:calc(100% - 320px);top:calc(100% - 72px);z-index:99998;">
                        <div class="row">
                            <div class="col-md-3">
                                <img id="satellite_btn" cl class="baselayer_btn active" src="{{asset('images/satellite.png')}}" />
                            </div>
                            <div class="col-md-3">
                                <img id="hybrid_btn" class="baselayer_btn" src="{{asset('images/hybrid.png')}}" />
                            </div>
                            <div class="col-md-3">
                                <img id="road_btn" class="baselayer_btn" src="{{asset('images/road.png')}}" />
                            </div>
                            <div class="col-md-3">
                                <img id="none_btn" class="baselayer_btn" src="{{asset('images/none.png')}}" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <h6>Objet (fr)</h6>
                        <div class="controls">
                            {{Form::textarea('objet_fr','',['class'=>'form-control','placeholder'=>'saisir l\'objet en francais','rows'=>'2'])}}                           
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <h6>Objet (ar)</h6>
                        <div class="controls">
                            {{Form::textarea('objet_ar','',['class'=>'form-control','placeholder'=>'saisir l\'objet en arabe','rows'=>'2'])}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        {{Form::label('','Porteur de projet(fr) :')}}
                        {{Form::text('nom_porteur_fr','',['class'=>'form-control'])}}     
                        
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">                  
                        {{Form::label('','Porteur de projet(ar) :')}}
                        {{Form::text('nom_porteur_ar','',['class'=>'form-control'])}}   
                    </div>
                </div>
            </div>
        </section>
        <!-- Step 2 -->
        <h6>Informations techniques</h6>
        <section>
            <div class="row">

                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="box">
                        <div class="box-header with-border" style="background-color: #cedce3;">
                            <div class="row">
                                <div class="col-6 ">
                                    <h4 class="box-title pull-left">Points désservis</h4>
                                </div>
                                <div class="col-6">
                                    <button type="button" class="btn btn-success pull-right" id="add_point" style="padding: 0.4rem 1rem;">
                                        <i class="fa fa-plus"></i> Ajouter point
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- /.box-header -->
                        <div class="box-body no-padding">
                            <div class="table-responsive">
                                <table class="table table-points">
                                    <tr style="text-align: center;">
                                        <th>Type</th>
                                        <th>Nom</th>
                                    </tr>
                                    <tbody>
                                        <tr>
                                            <td style="width: 40%">
                                                <div class="form-group">
                                                    {{Form::select('type_point_desservis',
                                                                     [
                                                                         'localite' => 'Localité',
                                                                          'etablissement_scol' => 'Etablissement Scolaire',
                                                                          'etablissemnt_sante' => 'Etablissement de santé ',
                                                                          'autre' => 'Autre'
                                                                     ], 
                                                                     'localite', 
                                                                     [
                                                                         'data-placeholder' => 'Etat du projet',
                                                                         'class'=>'form-control type_point'
                                                                     ]
                                                                )
                                                    }}                                                    
                                                </div>
                                            </td>
                                            <td style="width: 60%">
                                                <div class="form-group ">
                                                    <select class="form-control select2 point-desservis" name="localites" style="width : 100%">
                                                        @foreach($localites as $localite)
                                                        <option value="{{ $localite->id}}">{{ $localite->nom_fr}}</option>
                                                        @endforeach
                                                    
                                                    </select>
                                           
                                                  
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>


                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="box">
                        <div class="box-header with-border" style="background-color: #cedce3;">
                            <div class="row">
                                <div class="col-6 ">
                                    <h4 class="box-title pull-left">Pièces </h4>
                                </div>
                                <div class="col-6">
                                    <button type="button" class="btn btn-success pull-right" id="add_piece" style="padding: 0.4rem 1rem;">
                                        <i class="fa fa-plus"></i> Ajouter pièce
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- /.box-header -->
                        <div class="box-body no-padding">
                            <div class="table-responsive">
                                <table class="table table-piece">
                                    <tr style="text-align: center;">
                                        <th>Type</th>
                                        <th>Nom</th>
                                        <th>Upload</th>
                                    </tr>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="form-group">                                                 

                                                    {{Form::select('piece_type',
                                                                     [
                                                                          'etude' => 'Etude',
                                                                          'fiche_technique' => 'Fiche technique'
                                                                     ], 
                                                                     'etude', 
                                                                     [
                                                                         'data-placeholder' => 'Document',
                                                                         'class'=>'form-control  document',
                                                                         'style'=>'width : 100%'
                                                                     ]
                                                                )
                                                    }} 
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group ">
                                                   
                                                     {{Form::select('piece_nom',
                                                                     [
                                                                          'approuve' => 'Approuvée',
                                                                          'disponible' => 'Disponible',
                                                                          'en_cours_approbation' => 'En cours d\'approbation'
                                                                     ], 
                                                                     'approuve', 
                                                                     [
                                                                         'data-placeholder' => 'Document',
                                                                         'class'=>'form-control  etat',
                                                                         'style'=>'width : 100%',
                                                                       
                                                                     ]
                                                                )
                                                    }} 
                                                </div>

                                            </td>

                                            <td>
                                                <div class="form-group">
                                                    {{Form::file('piece_upload')}}
                                                </div>
                                            </td>

                                        </tr>
                                    </tbody>

                                </table>
                            </div>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>


            </div>
        </section>
        <!-- Step 3 -->
        <h6>Information sur le financement du projet</h6>
        <section>
            <div class="row">
                <div class="col-2">
                    <div class="form-group">
                        
                        {{Form::label('','Montant global TTC (DH) :')}}

                            {{Form::text(
                                'montant_global',
                                '',
                                [
                                'class'=>'form-control',
                                'id'=>'montant_g',
                                'data-validation-containsnumber-regex'=>'(\d)+',
                                'data-validation-containsnumber-message'=>'Veuillez saisir des numeros seulement'
                                ]
                                )}} 
                    </div>

                    <button type="button" class="btn btn-secondary " id="add_partenaire">
                        <i class="fa fa-plus"></i>
                        ajouter partenaire
                    </button>
                </div>
                <div class="col-10">
                    <div class="box">
                        <div class="box-header">
                            <h4 class="box-title"><strong>Montage Financier proposé</strong></h4>
                        </div>
                        <div class="box-body">
                            <div class="table-responsive">
                                <table id="table" class="table editable-table table-bordered mb-0">
                                    <thead style="text-align: center">
                                        <tr>
                                            <th>#</th>
                                            <th>Partenaire</th>
                                            <th>Montant</th>
                                            <th>Pourcentage</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tableBody">
                                        <tr>  
                                            <td>1</td>                                          
                                            <td></td>
                                            <td>0</td>
                                            <td>0</td>
                                        </tr>
                                    </tbody>
                                    <!--
                                            we can add tfoot when fix the problem of calculation
                                            <tfoot>
                                            <tr class="total-col  totalCol">
                                                <th><strong>TOTAL</strong></th>
                                                <th class="total">0</th>
                                                <th></th>
                                            </tr>
                                        </tfoot> -->
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
        </section>
        <!-- Step 4 -->
        <h6>Observations et remarques</h6>
        <section>
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        {{Form::textarea('observation','',['id'=>'editor1','placeholder'=>'saisir vos obsérvations','rows'=>'10','cols'=>'80'])}}                     
                    </div>
                </div>
            </div>
        </section>

        {!! Form::close() !!}
    </div>
    <!-- /.box-body -->
</div>
<!-- /.box -->
@endsection @section('added_scripts')
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

<!-- map -->
<script src="{{asset('js/demande.js')}}"></script>


<script src="{{asset('js/jquery.tabledit.js')}}"></script>

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

	

@endsection
