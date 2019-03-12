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

	<title>{{config('app.name')}}</title>    
			@include('inc.css_links')	
</head>

<body class="hold-transition skin-blue layout-top-nav">
<div class="wrapper">

  <header class="main-header">
	<div class="inside-header">
        <!-- Logo -->
        <a href="{{ route('home') }}" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <b class="logo-mini">
                <span class="light-logo"><img src="{{asset('images/logo.png')}}" alt="logo"></span>
                <span class="dark-logo"><img src="{{asset('images/logo.png')}}" alt="logo"></span>
            </b>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg">
			  <img src="{{asset('images/logo.png')}}" alt="logo" class="light-logo">
			  <img src="{{asset('images/logo.png')}}" alt="logo" class="dark-logo">
		  </span>
        </a>



        <!-- Header Navbar -->
        <nav class="navbar navbar-static-top">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle d-block d-lg-none" data-toggle="push-menu" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>

            <ul class="navbar-nav mr-auto mt-md-0">
                <!-- .Megamenu -->

                <!-- /.Megamenu -->
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
                                    <small class="mb-5">jb@gmail.com</small>
                                    <a href="#" class="btn btn-danger btn-sm btn-rounded">View Profile</a>
                                </p>
                            </li>
                            <!-- Menu Body -->
                            <li class="user-body">
                                <div class="row no-gutters">
                                    <div class="col-12 text-left">
                                        <a href="#"><i class="ion ion-person"></i> My Profile</a>
                                    </div>

                                    <div role="separator" class="divider col-12"></div>
                                    <div class="col-12 text-left">
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                           onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            {{ __('Logout') }}
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            @csrf
                                        </form>
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
			@include('inc.messages')
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
  	


	<script>
	  $.widget.bridge('uibutton', $.ui.button);
	</script>	
	@include('inc.scripts')
</body>
</html>
