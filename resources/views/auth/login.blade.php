<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="{{asset('images/favicon.ico')}}">

    <title>CP </title>
@include('inc.css_links')

<style>
.form-group {
	margin-bottom: 1rem !important;
}

@font-face {
	font-family: Lato;
	src: url('{{ asset('fonts/Lato/lato-v11-latin-ext_latin-700.ttf') }}');
}


@font-face {
	font-family: Roboto-Condensed;
	src: url('{{ asset('fonts/roboto/RobotoCondensed-Regular.ttf') }}');
}


@font-face {
	font-family: Lato2;
	src: url('{{ asset('fonts/Lato/lato-v11-latin-ext_latin-regular.ttf') }}');
}

.lato-bold
{
	font-family: 'Lato2';
	font-weight: bold;
}

body,
h1,
h2,
h3,
h4,
h5,
h6 {
	font-family: 'Roboto-Condensed','Lato2';

}

label{
	font-family: 'Roboto-Condensed','Lato2';
	font-weight: bold;
}
.nav-tabs
{
	font-family: 'Roboto-Condensed','Lato2' !important;
	font-weight: bold;
}


.table th,
.table thead th {
	font-family: Lato;
	font-weight: 600;
	font-size: 13px;
}

.btn{
	font-family: Lato,'Lato2';
	font-weight: bold;
	font-size: 12px;
}

.form-control{
	height: 35px !important;
}

.btn{
	font-size: 15px;
}

</style>
</head>
<body class="hold-transition login-page">
	
	<div class="container h-p100" style="margin-top:10% !important;border:0 !important;background: none !important;max-width: none !important;">
		<div class="row align-items-center justify-content-md-center h-p100">

			<div class="col-lg-4 col-md-8 col-12">
				<div class="login-box">
				  <div class="login-box-body">
					  <img src="{{asset('images/logo/smart-CP-icon.png')}}" alt="">

					  <br>
					  <h4 class="login-box-msg lato-bold" style="color: #fff !important;">Veuillez saisir vos identifiants pour se connecter </h4>
					  <br>
                      

					<form method="POST" action="{{ route('login') }}">
                        @csrf
					  <div class="form-group has-feedback">                       
                        <input id="username" type="text" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }} rounded" name="username" value="{{ old('username') }}" placeholder="Adresse email" required autofocus>

                        @if ($errors->has('username'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('username') }}</strong>
                            </span>
                        @endif
						<span class="ion ion-email form-control-feedback"></span>
					  </div>
					  <div class="form-group has-feedback">                        
                        <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }} rounded" placeholder="Mot de passe" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
						<span class="ion ion-locked form-control-feedback"></span>
					  </div>
					  <div class="row">
						<!--<div class="col-6">
						  <div class="checkbox">
                              <input class="form-check-input" type="checkbox" id="basic_checkbox_1" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>						
							<label for="basic_checkbox_1">Remember Me</label>
						  </div>
						</div>-->
						<!-- /.col -->
						<!--<div class="col-6">
						 <div class="fog-pwd text-right">
							<a href="javascript:void(0)" class="text-danger"><i class="ion ion-locked"></i> mot de passe oublié?</a><br>
						  </div>
						</div>-->
						<!-- /.col -->
						<div class="col-12 text-center">
						  <button type="submit" class="btn btn-info btn-block margin-top-10 lato-bold">Authentification</button>
						</div>
						<!-- /.col -->
					  </div>
						<div style="text-align: center;margin-top: 20px">
							<img src="{{asset('images/logo/logo_smartgis.png')}}" alt="" height="26" width="115" >
						</div>

					</form>


				  </div>
				  <!-- /.login-box-body -->
				</div>
				<!-- /.login-box -->
			
			</div>
		</div>
	</div>
@include('inc.scripts')

</body>
</html>
