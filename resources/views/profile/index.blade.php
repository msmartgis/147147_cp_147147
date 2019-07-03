@extends('layouts.app')

@section('added_css')
    <link rel="stylesheet" href="{{asset('css/datatable/datatables.min.css')}}" />


@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="box card-inverse bg-img" style="background-image: url(/images/logo/smart-CP-icon.png); padding-top: 200px;background-repeat: no-repeat;
    background-position: center;background-color: rgba(0,0,0,0.05);">
                <div class="flexbox align-items-center px-20" data-overlay="4">
                    <div class="flexbox align-items-center mr-auto">
                        <a href="#">
                            <img class="avatar avatar-xl avatar-bordered" src="{{asset('images/svg/manager.svg')}}" alt="">
                        </a>
                        <div class="pl-10 d-none d-md-block">
                            <h5 class="mb-0"><a class="hover-primary text-white" href="#">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</a></h5>
                            <span>
                                @if(Auth::user()->role == 'admin')
                                    Administrateur
                                @endif
                            </span>
                        </div>
                    </div>

                    <ul class="flexbox flex-justified text-center py-20">
                        <li class="px-10">
                            <span class="opacity-60"> Comptes</span><br>
                            <span class="font-size-20">3</span>
                        </li>
                        <li class="px-10">
                            <span class="opacity-60">Departements</span><br>
                            <span class="font-size-20">2</span>
                        </li>
                    </ul>
                </div>
            </div>


            <!-- Profile Image -->
            <div class="box">
                <div class="box-body box-profile">
                    <div class="row">
                        <div class="col-md-4 col-12">
                            <div class="profile-user-info">
                                <p>Email :<span class="text-gray pl-10">{{ Auth::user()->email }}</span> </p>
                                <p>Organisme :<span class="text-gray pl-10">
                                        @if(Auth::user()->organisation_id == 1)
                                            Conseil Provincial
                                        @endif
                                    </span></p>
                                <p>Responsabilité :<span class="text-gray pl-10">{{ Auth::user()->responsablite }}</span></p>
                            </div>
                        </div>
                        <div class="col-md-3 col-12">

                        </div>
                        <div class="col-md-5 col-12">
                            <div class="profile-user-info">

                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-lg-12 col-12">
            <div class="nav-tabs-custom box-profile">
                <ul class="nav nav-tabs">

                    <li><a class="active" href="#user_management_tab" data-toggle="tab">Gestion des utilisateurs</a></li>
                    <li><a href="#tracabilte_tab" data-toggle="tab">Tracabiltés</a></li>
                    <li><a href="#settings" data-toggle="tab">Parametres de compte personnol</a></li>
                </ul>

                <div class="tab-content">

                    @include('profile.tab_user_mngmt')


                    <!-- /.tab-pane -->

                    <div class="tab-pane" id="tracabilte_tab">

                        <div class="box p-15">
                            <!-- Post -->

                            <!-- /.post -->

                            <!-- /.post -->
                        </div>

                    </div>
                    <!-- /.tab-pane -->

                    <div class="tab-pane" id="settings">

                        <div class="box p-15">
                            <form class="form-horizontal form-element col-12">
                                <div class="form-group row">
                                    <label for="inputName" class="col-sm-2 control-label">Name</label>

                                    <div class="col-sm-10">
                                        <input type="email" class="form-control" id="inputName" placeholder="">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail" class="col-sm-2 control-label">Email</label>

                                    <div class="col-sm-10">
                                        <input type="email" class="form-control" id="inputEmail" placeholder="">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputPhone" class="col-sm-2 control-label">Phone</label>

                                    <div class="col-sm-10">
                                        <input type="tel" class="form-control" id="inputPhone" placeholder="">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputExperience" class="col-sm-2 control-label">Experience</label>

                                    <div class="col-sm-10">
                                        <textarea class="form-control" id="inputExperience" placeholder=""></textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputSkills" class="col-sm-2 control-label">Skills</label>

                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="inputSkills" placeholder="">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="ml-auto col-sm-10">
                                        <div class="checkbox">
                                            <input type="checkbox" id="basic_checkbox_1" checked="">
                                            <label for="basic_checkbox_1"> I agree to the</label>
                                            &nbsp;&nbsp;&nbsp;&nbsp;<a href="#">Terms and Conditions</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="ml-auto col-sm-10">
                                        <button type="submit" class="btn btn-success">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
            </div>
            <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->


    </div>

    <!--- modals -->
    @include('profile.modals_profile')

@endsection

@push('added_scripts')
<script src="{{asset('css/datatable/datatables.min.js')}}"></script>
<script src="{{asset('js/user_management/user_table.js')}}"></script>
<script src="{{asset('js/sum().js')}}"></script>


<script>



</script>
@endpush