<!DOCTYPE html>
<html class="no-js" lang="zxx">


<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Amrita Janani - {{$breadcrumb}}</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Favicon -->

    <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('main/images/fav/apple-icon-57x57.png')}}">
    <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('main/images/fav/apple-icon-60x60.png')}}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('main/images/fav/apple-icon-72x72.png')}}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('main/images/fav/apple-icon-76x76.png')}}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('main/images/fav/apple-icon-114x114.png')}}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('main/images/fav/apple-icon-120x120.png')}}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('main/images/fav/apple-icon-144x144.png')}}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('main/images/fav/apple-icon-152x152.png')}}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('main/images/fav/apple-icon-180x180.png')}}">
    <link rel="icon" type="image/png" sizes="192x192"  href="{{ asset('main/images/fav/android-icon-192x192.png')}}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('main/images/fav/favicon-16x16.png')}}">

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

    <link rel="stylesheet" href="{{ asset('main/css/plugins/iziToast.min.css') }}">


    <!-- Main Style CSS -->
    <link rel="stylesheet" href="{{ asset('main/css/style.css') }}">
    
    @if(Auth::check() && Auth::user()->darkMode==1)
    <link rel="stylesheet" href="{{ asset('main/css/dark.css') }}">
    @endif

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

    <script src="{{ asset('main/js/plugins/iziToast.min.js') }}"></script>

    <!-- Plugins JS (Please remove the comment from below plugins.min.js for better website load performance and remove plugin js files from avobe) -->

    
    <!-- <script src="{{ asset('main/js/plugins/plugins.min.js') }}"></script> -->
   

    <!-- Main JS -->
    <script src="{{ asset('main/js/main.js') }}"></script>

    <script type="text/javascript">
        @if (session('success_status'))
            iziToast.success({
                title: 'Success',
                message: '{{ Session::get('success_status') }}',
                position: 'topRight',
                timeout:6000
            });
        @endif
        @if (session('error_status'))
            iziToast.error({
                title: 'Error',
                message: '{{ Session::get('error_status') }}',
                position: 'topRight',
                timeout:6000
            });
        @endif
    </script>

    @yield('javascript')

    <script>
         
         function toggleDarkMode(){

             try{
                document.getElementById('dark_mode_css').remove()
                document.getElementById('darkModeToggleBtn').className = "fas fa-moon"
             }catch(error){
                // Get HTML head element
                var head = document.getElementsByTagName('HEAD')[0];
                    
                    // Create new link Element
                    var link = document.createElement('link');

                    // set the attributes for link element
                    link.rel = 'stylesheet';
                
                    link.type = 'text/css';

                    link.id = 'dark_mode_css';
                
                    link.href = "{{ asset('main/css/dark.css') }}";

                    // Append link element to HTML head
                    head.appendChild(link);
                    document.getElementById('darkModeToggleBtn').className = "fas fa-sun"
             }
         }
    </script>


</body>


</html>