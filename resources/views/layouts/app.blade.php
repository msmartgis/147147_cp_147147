<!DOCTYPE html>
<html lang="en">
 <head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{csrf_token()}}"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="{{asset('images/favicon.ico')}}">

    <title>Fab Admin - Dashboard</title>
    
		@include('inc.css_links')	

  </head>

<body class="hold-transition skin-blue layout-top-nav">
<div class="wrapper">

  <header class="main-header">
	<div class="inside-header">
		<!-- Logo -->
		<a href="index.html" class="logo">
		  <!-- mini logo for sidebar mini 50x50 pixels -->
		  
		  <!-- logo for regular state and mobile devices -->
		  <span class="logo-lg">
			  <img src="{{asset('images/logo.png')}}" alt="logo" class="light-logo">
			  
		  </span>
		</a>
		<!-- Header Navbar -->
		<nav class="navbar navbar-static-top">
		  <!-- Sidebar toggle button-->
		 
		
		  <ul class="navbar-nav mr-auto mt-md-0">		
			
		</ul>	

		  <div class="navbar-custom-menu">
			<ul class="nav navbar-nav">
		
			  <!-- User Account -->
			  <li class="dropdown user user-menu">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">
				  <img src="{{asset('images/avatar.png')}}" class="user-image rounded-circle" alt="User Image">
				</a>
				<ul class="dropdown-menu scale-up">
				  <!-- User image -->
				  <li class="user-header">
					<img src="{{asset('images/avatar.png')}}" class="float-left rounded-circle" alt="User Image">

					<p>
					  Juliya Brus
					  
					  <a href="#" class="btn btn-danger btn-sm btn-rounded">Voir Profile</a>
					</p>
				  </li>
				  <!-- Menu Body -->
				  <li class="user-body">
					<div class="row no-gutters">				 
					  
					  <div class="col-12 text-left">
						<a href="#"><i class="ion ion-settings"></i> Parametres</a>
					  </div>
				
					<div role="separator" class="divider col-12"></div>
					  <div class="col-12 text-left">
						<a href="#"><i class="fa fa-power-off"></i> Logout</a>
					  </div>				
					</div>
					<!-- /.row -->
				  </li>
				</ul>
			  </li>
			 
			</ul>
		  </div>
		</nav>	
	</div>
  </header>
  
  <!-- Main Navbar -->
  <div class="main-nav">  	
	  <nav class="navbar navbar-expand-lg">
		  <div class="collapse navbar-collapse" id="navbarNavDropdown">
			@include('inc.navbar')
		  </div>
		</nav>	  
  </div>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

    <!-- Main content -->
    <section class="content m-content">
			@yield('content')
	        
	</section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="pull-right d-none d-sm-inline-block">
        <ul class="nav nav-primary nav-dotted nav-dot-separated justify-content-center justify-content-md-end">
		 
		</ul>
    </div>
	  &copy; 2018 <a href="smartgis.com"> SmartGIS </a>	
  </footer>

  
  
  <!-- Add the sidebar's background. This div must be placed immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
  
</div>
<!-- ./wrapper -->
  	
	<!-- jQuery 3 -->
	<script src="../assets/vendor_components/jquery-3.3.1/jquery-3.3.1.js"></script>
	
	<!-- jQuery UI 1.11.4 -->
	<script src="../assets/vendor_components/jquery-ui/jquery-ui.js"></script>
	
	<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
	<script>
	  $.widget.bridge('uibutton', $.ui.button);
	</script>	
	@include('inc.scripts')
</body>
</html>
