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

<style>
    #map {
        height: 75vh;
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
        <form action="#" class="tab-wizard wizard-circle">
            <!-- Step 1 -->
            <h6>Information Général</h6>
            <section>
                <div class="row">
                    <div class="col-3">
                        <div class="form-group">
                            <label for="firstName5">N° d'ordre :</label>
                            <input type="text" class="form-control" id="firstName5" />
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label>Date de récéption:</label>

                            <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" class="form-control pull-right" id="datepicker" />
                            </div>
                            <!-- /.input group -->
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="form-group">
                            <label for="location3">Commune :</label>
                            <select class="form-control select2" multiple="multiple" data-placeholder="Select a State"
                                style="width: 100%;">
                                <option>Alabama</option>
                                <option>Alaska</option>
                                <option>California</option>
                                <option>Delaware</option>
                                <option>Tennessee</option>
                                <option>Texas</option>
                                <option>Washington</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="location3">Etat du projet :</label>
                            <select class="form-control " data-placeholder="Etat du projet" style="width: 100%;">
                                <option>Réalisée dans d'autre programme</option>
                                <option>Programmée dans d'autre programme</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="firstName5">Longueur :</label>
                            <input type="text" class="form-control" id="firstName5" />
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
                                <textarea name="textarea" id="textarea" class="form-control" required placeholder="Textarea text"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <h6>Objet (ar)</h6>
                            <div class="controls">
                                <textarea name="textarea" id="textarea" class="form-control" required placeholder="Textarea text"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="addressline2">Porteur de projet(fr) :</label>
                            <input type="text" class="form-control" id="addressline2" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="addressline2">Porteur de projet(ar) :</label>
                            <input type="text" class="form-control" id="addressline2" />
                        </div>
                    </div>
                </div>
            </section>
            <!-- Step 2 -->
            <h6>Informations techniques</h6>
            <section>
                <div class="row">

                    <div class="col-12">
                        <div class="box">
                            <div class="box-header with-border" style="background-color: #cedce3;">
                                <div class="row">
                                    <div class="col-6 ">
                                        <h4 class="box-title pull-left">Points désservis</h4>
                                    </div>
                                    <div class="col-6">
                                        <button type="button" class="btn btn-success pull-right" style="padding: 0.4rem 1rem;">
                                            <i class="fa fa-plus"></i> Ajouter point
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- /.box-header -->
                            <div class="box-body no-padding">
                                <div class="table-responsive">
                                    <table class="table ">
                                        <tr style="text-align: center;">
                                            <th>Type</th>
                                            <th>Nom</th>
                                        </tr>

                                        <tr>
                                            <td style="width: 40%">
                                                <div class="form-group">
                                                    <select class="form-control " id="type_point">
                                                        <option value="localite" selected="selected">Localité</option>
                                                        <option value="etablissement_scol">Etablissement Scolaire</option>
                                                        <option value="etablissemnt_sante"><i class="fa fa-dollar"></i>Etablissement
                                                            de santé </option>
                                                        <option value="autre"><i class="fa fa-dollar"></i>Autre</option>
                                                    </select>
                                                </div>
                                            </td>
                                            <td style="width: 60%">
                                                <div class="form-group point-desservis" id="localite">
                                                    <select class="form-control select2" style="width: 100%;">
                                                        <option selected="selected">Douar 1</option>
                                                        <option>Douar 2</option>
                                                        <option>Douar 3</option>
                                                    </select>
                                                </div>
                                                <div class="form-group hidden point-desservis" id="etablissement_scol">
                                                    <select class="form-control " style="width: 100%;">
                                                        <option selected="selected">Etablissement Scol 1</option>
                                                        <option>Etablissement Scol 2</option>
                                                        <option>Etablissement Scol 3</option>
                                                        <option>Etablissement Scol 4</option>
                                                        <option>Etablissement Scol 5</option>
                                                    </select>
                                                </div>
                                                <div class="form-group hidden point-desservis" id="etablissemnt_sante">
                                                    <select class="form-control " style="width: 100%;">
                                                        <option selected="selected">Etablissement Sante 1</option>
                                                        <option>Etablissement Sante 2</option>
                                                        <option>Etablissement Sante 3</option>
                                                        <option>Etablissement Sante 4</option>
                                                        <option>Etablissement Sante 5</option>
                                                    </select>
                                                </div>
                                            </td>

                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <!-- /.box-body -->
                        </div>
                        <!-- /.box -->
                    </div>


                    <div class="col-12">
                        <div class="box">
                            <div class="box-header with-border" style="background-color: #cedce3;">
                                <div class="row">
                                    <div class="col-6 ">
                                        <h4 class="box-title pull-left">Pièces </h4>
                                    </div>
                                    <div class="col-6">
                                        <button type="button" class="btn btn-success pull-right" style="padding: 0.4rem 1rem;">
                                            <i class="fa fa-plus"></i> Ajouter pièce
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- /.box-header -->
                            <div class="box-body no-padding">
                                <div class="table-responsive">
                                    <table class="table ">
                                        <tr style="text-align: center;">
                                            <th>Type</th>
                                            <th>Nom</th>
                                            <th>Upload</th>
                                        </tr>

                                        <tr>
                                            <td>
                                                <div class="form-group">
                                                    <select class="form-control " style="width: 100%;" id="document">
                                                        <option value="etude" selected="selected">Etude </option>
                                                        <option value="fiche_technique"> Fiche technique</option>

                                                    </select>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group etat" id="etude">
                                                    <select class="form-control " style="width: 100%;">
                                                        <option selected="selected">Approuvée </option>
                                                        <option>Disponible</option>
                                                        <option>En cours d'approbation</option>
                                                    </select>
                                                </div>
                                                <div class="form-group hidden etat" id="fiche_technique">
                                                    <select class="form-control " style="width: 100%;">
                                                        <option selected="selected">Sce concérné</option>
                                                        <option>DE Province</option>
                                                        <option>Sce technique.com</option>
                                                        <option>BET</option>
                                                    </select>
                                                </div>

                                            </td>

                                            <td>
                                                <button type="button" class="btn btn-secondary ">
                                                    <i class="fa fa-plus"></i> Choisir document
                                                </button>
                                            </td>

                                        </tr>
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
                            <label for="firstName5">Montant global TTC (DH) :</label>
                            <input type="text" class="form-control" id="montant_g" data-validation-containsnumber-regex="(\d)+"
                                data-validation-containsnumber-message="Veuillez saisir des numeros seulement" />
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
                                                <td>p1</td>
                                                <td>m1</td>
                                                <td>pourcent1</td>
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
                            <textarea id="editor1" name="editor1" rows="10" cols="80">

                            </textarea>
                        </div>


                    </div>
                </div>
            </section>
        </form>
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


<!-- CK Editor -->
<script src="{{asset('vendor_components/ckeditor/ckeditor.js')}}"></script>

<!-- Bootstrap WYSIHTML5 -->
<script src="{{asset('vendor_plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.js')}}"></script>

<!-- Fab Admin for editor -->
<script src="{{asset('js/editor.js')}}"></script>


<!-- Form validator JavaScript -->
<script src="{{asset('js/validation.js')}}"></script>
<script>
    ! function (window, document, $) {
        "use strict";
        $("input,select,textarea").not("[type=submit]").jqBootstrapValidation();
    }(window, document, jQuery);

</script>

@endsection
