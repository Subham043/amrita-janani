<!--====================  header area ====================-->
<div class="header-area header-area--default">


<!-- Header Bottom Wrap Start -->
<header class="header-area header-sticky">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 d-flex align-items-center">
                <div class="header__logo">
                    <div class="logo">
                        <a href="{{route('index')}}"><img src="{{ asset('main/images/logo/logo.png') }}" alt=""></a>
                    </div>
                </div>
                <div class="header-right">
                    <div class="header__navigation menu-style-three d-none d-lg-block">
                        <nav class="navigation-menu">
                            <ul>
                                <li class="has-children active">
                                    @if(Auth::check())
                                    <a href="{{route('content_dashboard')}}"><span>Home</span></a>
                                    @else
                                    <a href="{{route('index')}}"><span>Home</span></a>
                                    @endif
                                </li>
                                <li class="has-children">
                                    <a href="{{route('about')}}"><span>About</span></a>
                                </li>
                                <li class="has-children">
                                    <a href="{{route('faq')}}"><span>FAQs</span></a>
                                </li>
                                <li class="has-children">
                                    <a href="{{route('contact')}}"><span>Contact</span></a>
                                </li>
                                {{-- @if(Auth::check())
                                <li class="has-children has-children--multilevel-submenu">
                                    <a href="#"><span>Account</span></a>
                                    <ul class="submenu">
                                        <li><a href="{{route('userprofile')}}"><span>User Profile</span></a></li>
                                        <li><a href="{{route('display_profile_password')}}"><span>Change Password</span></a></li>
                                        <li><a href="{{route('search_history')}}"><span>Search History</span></a></li>
                                    </ul>
                                </li>
                                @endif --}}

                            </ul>
                        </nav>

                    </div>

                    @if(Auth::check())
                    @if(Auth::check() && Auth::user()->darkMode==1)
                    <a href="{{route('darkmode')}}"><i id="darkModeToggleBtn" class="fas fa-sun"></i></a>
                    @else
                    <a href="{{route('darkmode')}}"><i id="darkModeToggleBtn" class="fas fa-moon"></i></a>
                    @endif
                    @endif

                    <div class="header-btn text-right d-none d-sm-block ml-lg-4">
                        @if(Auth::check())
                        <a class="btn-circle btn-default btn" href="{{route('signout')}}">Logout</a>
                        @else
                        <a class="btn-circle btn-default btn" href="{{route('signin')}}">Login</a>
                        @endif
                    </div>

                    <!-- mobile menu -->
                    <div class="mobile-navigation-icon d-block d-lg-none" id="mobile-menu-trigger">
                        <i></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- Header Bottom Wrap End -->

</div>
<!--====================  End of header area  ====================-->