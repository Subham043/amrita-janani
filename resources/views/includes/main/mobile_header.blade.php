<!--====================  mobile menu overlay ====================-->
<div class="mobile-menu-overlay" id="mobile-menu-overlay">
        <div class="mobile-menu-overlay__inner">
            <div class="mobile-menu-overlay__header">
                <div class="container-fluid">
                    <div class="row align-items-center">
                        <div class="col-md-6 col-8">
                            <!-- logo -->
                            <div class="logo">
                                <a href="{{route('index')}}">
                                    <img src="{{ asset('main/images/logo/logo.png') }}" class="img-fluid" alt="">
                                </a>
                            </div>
                        </div>
                        <div class="col-md-6 col-4">
                            <!-- mobile menu content -->
                            <div class="mobile-menu-content text-right">
                                <span class="mobile-navigation-close-icon" id="mobile-menu-close-trigger"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mobile-menu-overlay__body">
                <nav class="offcanvas-navigation">
                    <ul>
                        <li class="has-children">
                            <a href="{{route('index')}}">Home</a>
                        </li>
                        <li class="has-children">
                            <a href="{{route('about')}}">About</a>
                        </li>
                        <li class="has-children">
                            <a href="{{route('faq')}}">FAQs</a>
                        </li>
                        <li class="has-children">
                            <a href="{{route('contact')}}">Contact</a>
                        </li>
                        @if(Auth::check())
                        <li class="has-children">
                            <a href="#">Content</a>
                            <ul class="sub-menu">
                                <li><a href="{{route('content_dashboard')}}"><span>Dashboard</span></a></li>
                                <li><a href="{{route('content_image')}}"><span>Images</span></a></li>
                                <li><a href="{{route('content_video')}}"><span>Videos</span></a></li>
                                <li><a href="{{route('content_audio')}}"><span>Audio</span></a></li>
                                <li><a href="{{route('content_document')}}"><span>Documents</span></a></li>
                            </ul>
                        </li>
                        <li class="has-children">
                            <a href="#">Account</a>
                            <ul class="sub-menu">
                                <li><a href="{{route('userprofile')}}"><span>User Profile</span></a></li>
                                <li><a href="{{route('display_profile_password')}}"><span>Change Password</span></a></li>
                                <li><a href="{{route('search_history')}}"><span>Search History</span></a></li>
                            </ul>
                        </li>
                        @endif
                        <li class="has-children">
                            @if(Auth::check())
                            <a href="{{route('signout')}}">Logout</a>
                            @else
                            <a href="{{route('signin')}}">Login</a>
                            @endif
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
    <!--====================  End of mobile menu overlay  ====================-->