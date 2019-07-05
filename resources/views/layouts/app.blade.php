<!DOCTYPE html>
<html lang="en">
 <head>
    <meta charset="utf-8">
    <meta name="_token" content="{{csrf_token()}}"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
     <meta name="author" content="">
    <link rel="icon" href="{{asset('images/favicon.svg')}}">

	<title>{{config('app.name')}}</title>
     @include('inc.css_links')

    {{-- TODO i put style here because i don't why it's not working in master-style.css or sommCss.css --}}
     <style>
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


         .no-js #loader { display: none;  }
         .js #loader { display: block; position: absolute; left: 100px; top: 0; }
         .se-pre-con {
             position: fixed;
             left: 0px;
             top: 0px;
             width: 100%;
             height: 100%;
             z-index: 9999;
             background: url(/images/loader/square-load.gif) center no-repeat #fff;
             /*background-size: 350px 300px;*/
         }

         .mobile-nav
         {
             margin-top: 15px !important;
         }

         .mobile-nav > li
         {
             border-bottom: 1px solid !important;
         }
     </style>
</head>

<body class="hold-transition skin-blue layout-top-nav has-drawer">
<div class="se-pre-con"></div>

<div class="wrapper">

  <header class="main-header">
	<div class="inside-header">
        <!-- Logo -->
        <a href="{{ route('home') }}" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <b class="logo-mini">
                <span class="light-logo"><img src="{{asset('images/logo/logo_mini_.png')}}" alt="logo" width="48px"></span>
            </b>
            <!-- logo for regular state and mobile devices -->
            <!--
            <span class="logo-lg">
			  <img src="{{asset('images/logo/logo_lg_.png')}}" alt="logo" class="light-logo">
		  </span>-->
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
                            <img src="{{asset('images/svg/manager.svg')}}" class="user-image rounded-circle" style="border: #fff solid 1.5px;" alt="User Image">
                        </a>
                        <ul class="dropdown-menu scale-up">
                            <!-- User image -->
                            <li class="user-header">
                                <img src="{{asset('images/svg/manager.svg')}}" class="float-left rounded-circle" alt="User Image" style="width : 50px;height : 50px">

                                <p>
                                    {{ Auth::user()->username }}
                                    <small class="mb-5">{{ Auth::user()->email }}</small>
                                    <a href="/profile" class="btn btn-danger btn-sm btn-rounded" style="border-radius: 60px !important;padding: 5px;width: 100%;"> <i class="fa fa-user"></i> Mon profil</a>
                                </p>
                            </li>
                            <!-- Menu Body -->
                            <li class="user-body">
                                <div class="row no-gutters">

                                    <div role="separator" class="divider col-12"></div>
                                    <div class="col-12 text-left">
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                           onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                          <i class="fa fa-sign-out"></i>  {{ __('Déconnexion') }}
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
    <section class="content m-content ">
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
