<!DOCTYPE html>
<html class="no-js" lang="zxx">


<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Stqmv - HTML Template</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('main/images/favicon.ico') }}">

    <!-- CSS
        ============================================ -->

     @yield('css')

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('main/css/vendor/bootstrap.min.css') }}">

    <!-- Flaticon Icon CSS -->
    <link rel="stylesheet" href="{{ asset('main/css/vendor/flaticon.css') }}">

    <!-- Swiper Slider CSS -->
    <link rel="stylesheet" href="{{ asset('main/css/plugins/swiper.min.css') }}">

    <!-- Magnific Popup CSS -->
    <link rel="stylesheet" href="{{ asset('main/css/plugins/magnific-popup.css') }}">


    <!-- Main Style CSS -->
    <link rel="stylesheet" href="{{ asset('main/css/style.css') }}">

</head>

<body>





    @include('includes.main.header')



    <div class="site-wrapper-reveal">
        @yield('content')
    </div>


    @include('includes.main.footer')
    

    

    @include('includes.main.mobile_header')


    <!-- JS
    ============================================ -->

    <!-- Modernizer JS -->
    <script src="{{ asset('main/js/vendor/modernizr-2.8.3.min.js') }}"></script>

    <!-- jquery JS -->
    <script src="{{ asset('main/js/vendor/jquery-3.5.1.min.js') }}"></script>
    <script src="{{ asset('main/js/vendor/jquery-migrate-3.3.0.min.js') }}"></script>

    <!-- Bootstrap JS -->
    <script src="{{ asset('main/js/vendor/bootstrap.min.js') }}"></script>

    <!-- Swiper Slider JS -->
    <script src="{{ asset('main/js/plugins/swiper.min.js') }}"></script>

    <!-- Waypoints JS -->
    <script src="{{ asset('main/js/plugins/waypoints.min.js') }}"></script>

    <!-- Counterup JS -->
    <script src="{{ asset('main/js/plugins/counterup.min.js') }}"></script>

    <!-- Magnific Popup JS -->
    <script src="{{ asset('main/js/plugins/jquery.magnific-popup.min.js') }}"></script>

    <!-- wow JS -->
    <script src="{{ asset('main/js/plugins/wow.min.js') }}"></script>

    <!-- Plugins JS (Please remove the comment from below plugins.min.js for better website load performance and remove plugin js files from avobe) -->

    
    <script src="{{ asset('main/js/plugins/plugins.min.js') }}"></script>
   

    <!-- Main JS -->
    <script src="{{ asset('main/js/main.js') }}"></script>

    @yield('javascript')


</body>


</html>