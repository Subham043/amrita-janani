<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="sm-hover">

    
<head>
        
        <meta charset="utf-8" />
        <title>Amrita Janani - Login</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
        <meta content="Themesbrand" name="author" />
        <!-- App favicon -->
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

        <!-- Layout config Js -->
        <script src="{{ asset('admin/js/layout.js') }}"></script>
        <!-- Bootstrap Css -->
        <link href="{{ asset('admin/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="{{ asset('admin/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="{{ asset('admin/css/app.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- custom Css-->
        <link href="{{ asset('admin/css/custom.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('admin/css/iziToast.min.css') }}" rel="stylesheet" type="text/css" />

        <style>
            .invalid-message{
                color:red;
            }
        </style>
    </head>

    <body>

        <div class="auth-page-wrapper pt-5">
            <!-- auth page bg -->
            <div class="auth-one-bg-position auth-one-bg"  id="auth-particles">
                <div class="bg-overlay"></div>
                
                <div class="shape">
                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 1440 120">
                        <path d="M 0,36 C 144,53.6 432,123.2 720,124 C 1008,124.8 1296,56.8 1440,40L1440 140L0 140z"></path>
                    </svg>
                </div>
            </div>

            <!-- auth page content -->
            <div class="auth-page-content">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="text-center mt-sm-5 mb-4 text-white-50">
                                <div>
                                    <a href="index.html" class="d-inline-block auth-logo">
                                        <img src="{{ asset('admin/images/logo.png') }}" alt="">
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end row -->
                        @yield('content')

                    <!-- end row -->
                </div>
                <!-- end container -->
            </div>
            <!-- end auth page content -->

            
        </div>
        <!-- end auth-page-wrapper -->

        <!-- JAVASCRIPT -->
        <script src="{{ asset('admin/js/pages/Jquery.min.js') }}"></script>
        <script src="{{ asset('admin/js/pages/just-validate.production.min.js') }}"></script>
        <script src="{{ asset('admin/js/pages/iziToast.min.js') }}"></script>
        <script src="{{ asset('admin/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('admin/libs/simplebar/simplebar.min.js') }}"></script>
        <script src="{{ asset('admin/libs/node-waves/waves.min.js') }}"></script>
        <script src="{{ asset('admin/libs/feather-icons/feather.min.js') }}"></script>
        <script src="{{ asset('admin/js/pages/plugins/lord-icon-2.1.0.js') }}"></script>
        <!-- <script src="{{ asset('admin/js/plugins.js') }}"></script> -->

        <!-- particles js -->
        <script src="{{ asset('admin/libs/particles.js/particles.js') }}"></script>
        <!-- particles app js -->
        <script src="{{ asset('admin/js/pages/particles.app.js') }}"></script>

        <script type="text/javascript">
            @if (session('success_status'))

                iziToast.success({
                    title: 'Success',
                    message: '{{ session('success_status') }}',
                    position: 'topRight',
                    timeout:6000
                });

            @endif
            @if (session('error_status'))

                iziToast.error({
                    title: 'Error',
                    message: '{{ session('error_status') }}',
                    position: 'topRight',
                    timeout:6000
                });

            @endif

        </script>
        
        @yield('javascript')
    </body>


<!-- Mirrored from themesbrand.com/velzon/html/modern/auth-signin-basic.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 13 Apr 2022 07:00:42 GMT -->
</html>