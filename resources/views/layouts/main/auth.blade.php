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
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('main/images/fav/android-icon-192x192.png')}}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('main/images/fav/favicon-16x16.png')}}">

    <!-- CSS
        ============================================ -->

    @yield('css')

    <link rel="stylesheet" type="text/css" href="{{ asset('auth/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('auth/css/fontawesome-all.min.css ') }}">
    <link rel="stylesheet" href="{{ asset('main/css/plugins/iziToast.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('auth/css/iofrm-style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('auth/css/iofrm-theme2.css') }}">

</head>

<body>

    <div class="form-body">
        <div class="website-logo">
            <a href="{{route('index')}}">
                <div class="logo">
                    <img class="" src="{{ asset('main/images/logo/logo.png') }}" alt="">
                </div>
            </a>
        </div>
        <div class="row">
            <div class="img-holder">
                <div class="bg" style="background-size: cover;background-position: left bottom;background-image: linear-gradient(45deg, #000000bd, #000000ba), url({{asset('main/images/hero/banner3.jpg')}});"></div>
                <div class="info-holder">

                </div>
            </div>
            <div class="form-holder">
                <div class="form-content">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('auth/js/jquery.min.js') }}"></script>
    <script src="{{ asset('auth/js/popper.min.js') }}"></script>
    <script src="{{ asset('auth/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('main/js/plugins/iziToast.min.js') }}"></script>
    <script src="{{ asset('admin/js/pages/just-validate.production.min.js') }}"></script>

    <script type="text/javascript">
    @if(session('success_status'))
    iziToast.success({
        title: 'Success',
        message: '{{ Session::get('success_status') }}',
        position: 'topRight',
        timeout: 6000
    });
    @endif
    @if(session('error_status'))
    iziToast.error({
        title: 'Error',
        message: '{{ Session::get('error_status') }}',
        position: 'topRight',
        timeout: 6000
    });
    @endif
    </script>

    @yield('javascript')


</body>


</html>