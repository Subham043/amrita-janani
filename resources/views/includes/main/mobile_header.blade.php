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
                        <!-- <li class="has-children">
                            <a href="index.html">Home</a>
                            <ul class="sub-menu">
                                <li><a href="index.html"><span>Home 1</span></a></li>
                                <li><a href="index-2.html"><span>Home 2</span></a></li>
                                <li><a href="index-3.html"><span>Home 3</span></a></li>
                                <li><a href="index-4.html"><span>Home 4</span></a></li>
                            </ul>
                        </li> -->
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
                    </ul>
                </nav>
            </div>
        </div>
    </div>
    <!--====================  End of mobile menu overlay  ====================-->