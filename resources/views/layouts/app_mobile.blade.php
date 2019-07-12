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
        <!-- Main content -->
            @include('inc.messages')
            @yield('content')

        <!-- /.content -->

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
