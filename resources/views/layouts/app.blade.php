<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

      <title></title>

    <!-- Bootstrap -->
    <link href="{{ url('public/assets/vendors/bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{ url('public/assets/vendors/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">
    <!-- NProgress -->
    <link href="{{ url('public/assets/vendors/nprogress/nprogress.css')}}" rel="stylesheet">
    <!-- Animate.css -->
    <link href="{{ url('public/assets/vendors/animate.css/animate.min.css')}}" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="{{ url('public/assets/build/css/custom.min.css')}}" rel="stylesheet">
    <!-- jQuery -->
    <script src="{{asset('public/assets/vendors/jquery/dist/jquery.min.js')}}"></script>
    <script src="{{ asset('public/assets/js/common.js')}}"></script>

     <style type="text/css">
      .requride_cls{
        color: red;
      }
    </style>
</head>
<body class="login">

     @yield('content')

</body>
</html>
