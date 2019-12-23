
<!doctype html>
<html class="no-js" lang="">
<head>
  <meta charset="utf-8">
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Unauthorized: Access is denied</title>

  <link rel="stylesheet" href="{{ asset('public/unauthorized/styles/vendor.css') }}">
  <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,400,300,600,700' rel='stylesheet' type='text/css'>
  <link rel="stylesheet" href="{{ asset('public/unauthorized/styles/main.css') }}">

  <script src="{{ asset('public/unauthorized/scripts/vendor/modernizr.js') }}"></script>
</head>
<body>
      <div class="page_overlay unauthorized">
        <div class="loader-inner ball-pulse">
          <div></div>
          <div></div>
          <div></div>
        </div>
      </div>
      <div class="cloudWrapper">
        <div class="cloud cloud-1"><img src="{{ asset('public/unauthorized/images/cloud-1.png') }}" alt=""></div>
        <div class="cloud cloud-2"><img src="{{ asset('public/unauthorized/images/cloud-2.png') }}" alt=""></div>
        <div class="cloud cloud-3"><img src="{{ asset('public/unauthorized/images/cloud-3.png') }}" alt=""></div>
        <div class="cloud cloud-4"><img src="{{ asset('public/unauthorized/images/cloud-4.png') }}" alt=""></div>
      </div>

      <div class="unauthorized-wrap">
        <div class="scene-unauth"></div>
        <div class="row-flex">
          <div class="messge-unathorized">
            <h1><span>Stop</span> <br>
              Unauthorized</h1>
            </div>
          </div>
          <div class="charecter-6">
           <img src="{{ asset('public/unauthorized/images/charecter-6.png') }}" alt="">
           <span class="eye-6"><img src="{{ asset('public/theme/unauthorized/images/eye-6.gif') }}" alt=""></span>
           <span class="hand-6">
             <img src="{{ asset('public/unauthorized/images/hand-6.png') }}" alt="">
           </span>
         </div>
       </div>

       <!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
       <script>
        (function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
          function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
        e=o.createElement(i);r=o.getElementsByTagName(i)[0];
        e.src='//www.google-analytics.com/analytics.js';
        r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
        ga('create','UA-XXXXX-X');ga('send','pageview');
      </script>

      <script src="{{ asset('public/unauthorized/scripts/vendor.js') }}"></script>
      <script src="{{ asset('public/unauthorized/scripts/plugins.js') }}"></script>
      <script src="{{ asset('public/unauthorized/scripts/main.js') }}"></script>
    </body>
    </html>
