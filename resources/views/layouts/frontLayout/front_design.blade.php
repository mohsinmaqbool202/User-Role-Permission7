<!DOCTYPE html>
<html lang="en">
<head>       
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset( 'css/frontend_css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset( 'css/frontend_css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset( 'css/frontend_css/prettyPhoto.css') }}" rel="stylesheet">
    <link href="{{ asset( 'css/frontend_css/price-range.css') }}" rel="stylesheet">
    <link href="{{ asset( 'css/frontend_css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset( 'css/frontend_css/main.css') }}" rel="stylesheet">
    <link href="{{ asset( 'css/frontend_css/responsive.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="{{ asset( 'css/frontend_css/jquery.exzoom.css') }}" rel="stylesheet">

    @yield('style')
<body>

	@include('layouts.frontLayout.front_header')
	@yield('content')
	@include('layouts.frontLayout.front_footer')

   <script src="{{ asset( 'js/frontend_js/jquery.js ') }}"></script>
	<script src="{{ asset( 'js/frontend_js/bootstrap.min.js ') }}"></script>
	<script src="{{ asset( 'js/frontend_js/jquery.scrollUp.min.js ') }}"></script>
	<script src="{{ asset( 'js/frontend_js/price-range.js ') }}"></script>
   <script src="{{ asset( 'js/frontend_js/jquery.prettyPhoto.js ') }}"></script>
   <script src="{{ asset( 'js/frontend_js/main.js ') }}"></script>
   <script src="{{ asset( 'js/frontend_js/jquery.exzoom.js') }}"></script>
   <script>
     $(function(){
        $("#exzoom").exzoom({
          // thumbnail nav options
          "navWidth": 60,
          "navHeight": 60,
          "autoPlay":false,

        });

      });
   </script>
   
</body>
</html>