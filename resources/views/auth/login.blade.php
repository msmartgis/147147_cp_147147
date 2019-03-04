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
</style>
</head>
<body class="hold-transition login-page">
	
	<div class="container h-p100" style="margin-top: 80px;">
		<div class="row align-items-center justify-content-md-center h-p100">
			<div class="col-lg-3 col-md-8 col-12 d-none d-lg-block">
				<div class="box mb-0 b-0 bg-transparent">
					<div class="box-body login-slider p-0">
						<div id="carousel-example-generic-captions" class="carousel slide" data-ride="carousel">
						<!-- Indicators -->
						  <ol class="carousel-indicators">
							<li data-target="#carousel-example-generic-captions" data-slide-to="0" class="active"></li>
							<li data-target="#carousel-example-generic-captions" data-slide-to="1"></li>
							<li data-target="#carousel-example-generic-captions" data-slide-to="2"></li>
						  </ol>                      
						  <!-- Wrapper for slides -->
						  <div class="carousel-inner" role="listbox">
							<div class="carousel-item active">
							  <img src="{{asset('images/slider/documents.jpeg')}}" class="img-fluid" alt="slide-1">
							  <div class="carousel-caption">
								<h3>Gestion des demandes</h3>								
							  </div>
							</div>
							<div class="carousel-item">
							  <img src="{{asset('images/slider/statistics.jpeg')}}" class="img-fluid" alt="slide-2">
							  <div class="carousel-caption">					  
								<h3>Statistiques</h3>							
							  </div>
							</div>
							<div class="carousel-item">
							  <img src="{{asset('images/slider/map_2.jpeg')}}" class="img-fluid" alt="slide-3">
							  <div class="carousel-caption">					  
								<h3>Cartographie</h3>								
							  </div>
							</div>
						  </div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-4 col-md-8 col-12">
				<div class="login-box">
				  <div class="login-box-body">
					<h3 class="text-center">Bienvenue sur la plateforme CP</h3>
					<p class="login-box-msg">Espace de gestion </p>

					<form method="POST" action="{{ route('login') }}">
                        @csrf
					  <div class="form-group has-feedback">                       
                        <input id="username" type="username" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }} rounded" name="username" value="{{ old('username') }}" placeholder="Adresse email" required autofocus>

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
						<div class="col-6">
						  <div class="checkbox">
                              <input class="form-check-input" type="checkbox" id="basic_checkbox_1" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>						
							<label for="basic_checkbox_1">Remember Me</label>
						  </div>
						</div>
						<!-- /.col -->
						<div class="col-6">
						 <div class="fog-pwd text-right">
							<a href="javascript:void(0)" class="text-danger"><i class="ion ion-locked"></i> mot de passe oublié?</a><br>
						  </div>
						</div>
						<!-- /.col -->
						<div class="col-12 text-center">
						  <button type="submit" class="btn btn-info btn-block margin-top-10">Connexion</button>
						</div>
						<!-- /.col -->
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
