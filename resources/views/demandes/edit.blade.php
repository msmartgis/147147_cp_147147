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
<style>
    .col-lg-3 {
        padding: 0 !important;
    }

    .col-lg-9 {
        padding: 0 !important;
    }

</style>
@endsection

@section('content')
<div class="box">
    <div class="box-body">
        <div class="row">
            <div class="col-lg-9 col-12">
                <div class="box bg-transparent no-shadow">
                    <div class="box-header with-border">
                        <h3 class="box-title">La demande numero : {{$demande->id}}</h3>

                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="row" style="margin-top: 8px">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <h6>Objet (fr)</h6>
                                    <div class="controls">
                                        {{Form::textarea('objet_fr',$demande->objet_fr,['class'=>'form-control','rows'=>'2'])}}
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <h6>Objet (ar)</h6>
                                    <div class="controls">
                                        {{Form::textarea('objet_ar',$demande->objet_ar,['class'=>'form-control','rows'=>'2'])}}
                                    </div>
                                </div>
                            </div>

                        </div>


                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /. box -->
            </div>
            <!-- /.col -->
            <div class="col-lg-3 col-12">
                <div class="h-p100 p-15 bg-light">
                    <a href="compose.html" class="btn btn-success btn-block btn-shadow margin-bottom">Compose</a>

                    <div class="box bg-transparent no-border no-shadow">
                        <div class="box-header with-border">
                            <h3 class="box-title">Folders</h3>
                        </div>
                        <div class="box-body no-padding mailbox-nav">
                            <ul class="nav nav-pills flex-column">
                                <li class="nav-item"><a class="nav-link active" href="javascript:void(0)"><i class="ion ion-ios-email-outline"></i>
                                        Inbox
                                        <span class="label label-success pull-right">12</span></a></li>
                                <li class="nav-item"><a class="nav-link" href="javascript:void(0)"><i class="ion ion-paper-airplane"></i>
                                        Sent</a></li>
                                <li class="nav-item"><a class="nav-link" href="javascript:void(0)"><i class="ion ion-email-unread"></i>
                                        Drafts</a></li>
                                <li class="nav-item"><a class="nav-link" href="javascript:void(0)"><i class="ion ion-star"></i>
                                        Starred <span class="label label-warning pull-right">14</span></a>
                                </li>
                                <li class="nav-item"><a class="nav-link" href="javascript:void(0)"><i class="ion ion-trash-a"></i>
                                        Trash</a></li>
                            </ul>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /. box -->
                    <div class="box bg-transparent no-border no-shadow">
                        <div class="box-header with-border">
                            <h3 class="box-title">Labels</h3>
                        </div>
                        <div class="box-body no-padding mailbox-nav">
                            <ul class="nav nav-pills flex-column">
                                <li class="nav-item"><a class="nav-link" href="#"><i class="fa fa-circle-o text-red"></i>
                                        Important</a></li>
                                <li class="nav-item"><a class="nav-link" href="#"><i class="fa fa-circle-o text-yellow"></i>
                                        Promotions</a></li>
                                <li class="nav-item"><a class="nav-link" href="#"><i class="fa fa-circle-o text-light-blue"></i>
                                        Social</a></li>
                            </ul>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
</div>
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


<script src="{{asset('js/demande.js')}}"></script>
<script src="{{asset('js/functions.js')}}"></script>
@endpush
