<!DOCTYPE html>
<html lang="en">
  <head>
  <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
       <link rel="shortcut icon" href="{{ asset('public/images/'.Helper::setting()->favicon) }}" >
       <title>@yield('title')</title>
       @include('layouts.partials.header')
    <style>
      .error {
        color:red;
        font-size: 11px !important;
      }
    </style>
  </head>

<body class="nav-md">
  <div class="container body">
    <div class="main_container">
      <div class="col-md-3 left_col">
      @include('layouts.partials.sidebar')
      </div>

       @include('layouts.partials.topnavigation')
        <!-- page content -->
            @yield('content')
        <!-- /page content -->
        @include('layouts.partials.footer')
      </div>
    </div>
    @include('layouts.partials.footerscript')
    @yield('script')

  </body>
</html>
