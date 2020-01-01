<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
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
      }
      .permissionHeader{
        color:black;
        border-style: outset;
        font-weight: bold;
        background-color:#bbe7ff;
    }
    .selectalltitle{
        color:#3e1ad0;
        margin-right:10px;
        cursor:pointer;
    }
    .deselectalltitle{
        color:#e8182b;
        margin-right:10px;
        cursor:pointer;
    }
    .permissionOption{
        color: black;
        font-size: 13px;
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
