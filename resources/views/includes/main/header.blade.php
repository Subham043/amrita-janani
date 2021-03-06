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
                                    <a href="{{route('index')}}"><span>Home</span></a>
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

                            </ul>
                        </nav>

                    </div>

                    <div class="header-btn text-right d-none d-sm-block ml-lg-4">
                        <a class="btn-circle btn-default btn" href="{{route('signin')}}">Login</a>
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