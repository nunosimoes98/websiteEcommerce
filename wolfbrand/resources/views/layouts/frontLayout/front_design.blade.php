<!DOCTYPE html>
<html lang="en">
  <head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
   <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="icon" href="{{ asset('images/frontend_images/logo.png') }}" type="image/png">
  <title>WOLFWORK</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="{{ asset('css/frontend_css/bootstrap.css') }}">
  <link rel="stylesheet" href="{{ asset('vendors/linericon/style.css') }}">
  <link rel="stylesheet" href="{{ asset('css/frontend_css/font-awesome.min.css') }}">
  <link rel="stylesheet" href="{{ asset('vendors/owl-carousel/owl.carousel.min.css') }}">
  <link rel="stylesheet" href="{{ asset('vendors/lightbox/simpleLightbox.css') }}">
  <link rel="stylesheet" href="{{ asset('vendors/nice-select/css/nice-select.css') }}">
  <link rel="stylesheet" href="{{ asset('vendors/animate-css/animate.css') }}">
  <link rel="stylesheet" href="{{ asset('vendors/jquery-ui/jquery-ui.css') }}">
  <link rel="stylesheet" href="{{ asset('css/frontend_css/easyzoom.css') }}">
  <link rel="stylesheet" href="{{ asset('css/frontend_css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('css/frontend_css/responsive.css') }}">
  <link rel="stylesheet" href="{{ asset('css/frontend_css/passtrength.css') }}">
</head>
  
  <body>
    
  	@include('layouts.frontLayout.front_header')

    @yield('content')

    @include('layouts.frontLayout.front_footer')


  <script src="{{ asset('js/frontend_js/jquery-3.2.1.min.js') }}"></script>
  <script src="{{ asset('js/frontend_js/popper.js') }}"></script>
  <script src="{{ asset('js/frontend_js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('js/frontend_js/stellar.js') }}"></script>
  <script src="{{ asset('vendors/lightbox/simpleLightbox.min.js') }}"></script>
  <script src="{{ asset('vendors/nice-select/js/jquery.nice-select.min.js') }}"></script>
  <script src="{{ asset('vendors/isotope/imagesloaded.pkgd.min.js') }}"></script>
  <script src="{{ asset('vendors/isotope/isotope-min.js') }}"></script>
  <script src="{{ asset('vendors/owl-carousel/owl.carousel.min.js') }}"></script>
  <script src="{{ asset('js/frontend_js/jquery.ajaxchimp.min.js') }}"></script>
  <script src="{{ asset('vendors/counter-up/jquery.waypoints.min.js') }}"></script>
  <script src="{{ asset('vendors/flipclock/timer.js') }}"></script>
  <script src="{{ asset('vendors/counter-up/jquery.counterup.js') }}"></script>
  <script src="{{ asset('js/frontend_js/mail-script.js') }}"></script>
  <script src="{{ asset('js/frontend_js/theme.js') }}"></script>
  <script src="{{ asset('js/frontend_js/easyzoom.js') }}"></script>
  <script src="{{ asset('js/frontend_js/main.js') }}"></script>
  <script src="{{ asset('js/frontend_js/jquery.validate.js') }}"></script>
  <script src="{{ asset('js/frontend_js/passtrength.js') }}"></script>
  <script src="{{ asset('js/frontend_js/custom.js') }}"></script>
  <script src="{{ asset('js/frontend_js/contact.js') }}"></script>
  <script src="{{ asset('js/frontend_js/gmaps.min.js') }}"></script>
  <script src="{{ asset('js/frontend_js/matrix.form_validation.js') }}"></script>


  
 <script type="text/javascript" src="https://platform-api.sharethis.com/js/sharethis.js#property=5ea06a9981693d0012e588bf&product=inline-share-buttons" async="async"></script>

  
    
    
  </body>
</html>