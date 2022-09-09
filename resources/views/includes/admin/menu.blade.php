
            <!-- ========== App Menu ========== -->
            <div class="app-menu navbar-menu">
                <!-- LOGO -->
                <div class="navbar-brand-box">
                    <!-- Dark Logo-->
                    <a href="{{route('dashboard')}}" class="logo logo-dark">
                        <span class="logo-sm">
                            <img src="{{ asset('main/images/fav/android-icon-192x192.png')}}" alt="" height="22">
                        </span>
                        <span class="logo-lg">
                            <img src="{{ asset('admin/images/logo.png') }}" alt="" height="17">
                        </span>
                    </a>
                    <!-- Light Logo-->
                    <a href="{{route('dashboard')}}" class="logo logo-light">
                        <span class="logo-sm">
                            <img src="{{ asset('main/images/fav/android-icon-192x192.png')}}" alt="" height="30">
                        </span>
                        <span class="logo-lg">
                            <img src="{{ asset('admin/images/logo.png') }}" alt="" height="30">
                        </span>
                    </a>
                    <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
                        <i class="ri-record-circle-line"></i>
                    </button>
                </div>

                <div id="scrollbar">
                    <div class="container-fluid">
            
                        <div id="two-column-menu">
                        </div>
                        <ul class="navbar-nav" id="navbar-nav">
                            <li class="menu-title"><span data-key="t-menu">Menu</span></li>
                            <li class="nav-item">
                                <a class="nav-link menu-link {{strpos(url()->current(),'enquiry') !== false ? 'active' : ''}}" href="{{route('enquiry_view')}}">
                                    <i class="ri-message-fill"></i> <span data-key="t-widgets">Enquiries</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link menu-link {{strpos(url()->current(),'user') !== false ? 'active' : ''}}" href="{{route('subadmin_view')}}">
                                    <i class="ri-admin-fill"></i> <span data-key="t-widgets">Users</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link menu-link {{strpos(url()->current(),'language') !== false ? 'active' : ''}}" href="{{route('language_view')}}">
                                    <i class="bx bx-text"></i> <span data-key="t-widgets">Languages</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link menu-link {{strpos(url()->current(),'admin/image') !== false || strpos(url()->current(),'admin/audio') !== false || strpos(url()->current(),'admin/video') !== false || strpos(url()->current(),'admin/document') !== false ? 'active' : ''}}" href="#sidebarDashboards6" data-bs-toggle="collapse" role="button"
                                    aria-expanded="{{strpos(url()->current(),'admin/image') !== false || strpos(url()->current(),'admin/audio') !== false || strpos(url()->current(),'admin/video') !== false || strpos(url()->current(),'admin/document') !== false ? 'true' : 'false'}}" aria-controls="sidebarDashboards6">
                                    <i class="ri-image-fill"></i> <span data-key="t-dashboards">Media Content</span>
                                </a>
                                <div class="collapse menu-dropdown {{strpos(url()->current(),'admin/image') !== false || strpos(url()->current(),'admin/audio') !== false || strpos(url()->current(),'admin/video') !== false || strpos(url()->current(),'admin/document') !== false ? 'show' : ''}}" id="sidebarDashboards6">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="{{route('image_view')}}" class="nav-link {{strpos(url()->current(),'admin/image') !== false ? 'active' : ''}}" data-key="t-analytics"> Image </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{route('audio_view')}}" class="nav-link {{strpos(url()->current(),'admin/audio') !== false ? 'active' : ''}}" data-key="t-analytics"> Audio </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{route('video_view')}}" class="nav-link {{strpos(url()->current(),'admin/video') !== false ? 'active' : ''}}" data-key="t-analytics"> Video </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{route('document_view')}}" class="nav-link {{strpos(url()->current(),'admin/document') !== false ? 'active' : ''}}" data-key="t-analytics"> Document </a>
                                        </li>
                                    </ul>
                                </div>
                            </li> <!-- end Dashboard Menu -->
                            <li class="nav-item">
                                <a class="nav-link menu-link {{strpos(url()->current(),'access-request/image') !== false || strpos(url()->current(),'access-request/audio') !== false || strpos(url()->current(),'access-request/video') !== false || strpos(url()->current(),'access-request/document') !== false ? 'active' : ''}}" href="#sidebarDashboards8" data-bs-toggle="collapse" role="button"
                                    aria-expanded="{{strpos(url()->current(),'access-request/image') !== false || strpos(url()->current(),'access-request/audio') !== false || strpos(url()->current(),'access-request/video') !== false || strpos(url()->current(),'access-request/document') !== false ? 'true' : 'false'}}" aria-controls="sidebarDashboards8">
                                    <i class="ri-wheelchair-line"></i> <span data-key="t-dashboards">Access Control</span>
                                </a>
                                <div class="collapse menu-dropdown {{strpos(url()->current(),'access-request/image') !== false || strpos(url()->current(),'access-request/audio') !== false || strpos(url()->current(),'access-request/video') !== false || strpos(url()->current(),'access-request/document') !== false ? 'show' : ''}}" id="sidebarDashboards8">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="{{route('image_view_access')}}" class="nav-link {{strpos(url()->current(),'access-request/image') !== false ? 'active' : ''}}" data-key="t-analytics"> Image </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{route('audio_view_access')}}" class="nav-link {{strpos(url()->current(),'access-request/audio') !== false ? 'active' : ''}}" data-key="t-analytics"> Audio </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{route('video_view_access')}}" class="nav-link {{strpos(url()->current(),'access-request/video') !== false ? 'active' : ''}}" data-key="t-analytics"> Video </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{route('document_view_access')}}" class="nav-link {{strpos(url()->current(),'access-request/document') !== false ? 'active' : ''}}" data-key="t-analytics"> Document </a>
                                        </li>
                                    </ul>
                                </div>
                            </li> <!-- end Dashboard Menu -->
                            <li class="nav-item">
                                <a class="nav-link menu-link {{strpos(url()->current(),'report/image') !== false || strpos(url()->current(),'report/audio') !== false || strpos(url()->current(),'report/video') !== false || strpos(url()->current(),'report/document') !== false ? 'active' : ''}}" href="#sidebarDashboards9" data-bs-toggle="collapse" role="button"
                                    aria-expanded="{{strpos(url()->current(),'report/image') !== false || strpos(url()->current(),'report/audio') !== false || strpos(url()->current(),'report/video') !== false || strpos(url()->current(),'report/document') !== false ? 'true' : 'false'}}" aria-controls="sidebarDashboards9">
                                    <i class="ri-file-chart-line"></i> <span data-key="t-dashboards">Flagged Content</span>
                                </a>
                                <div class="collapse menu-dropdown {{strpos(url()->current(),'report/image') !== false || strpos(url()->current(),'report/audio') !== false || strpos(url()->current(),'report/video') !== false || strpos(url()->current(),'report/document') !== false ? 'show' : ''}}" id="sidebarDashboards9">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="{{route('image_view_report')}}" class="nav-link {{strpos(url()->current(),'report/image') !== false ? 'active' : ''}}" data-key="t-analytics"> Image </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{route('audio_view_report')}}" class="nav-link {{strpos(url()->current(),'report/audio') !== false ? 'active' : ''}}" data-key="t-analytics"> Audio </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{route('video_view_report')}}" class="nav-link {{strpos(url()->current(),'report/video') !== false ? 'active' : ''}}" data-key="t-analytics"> Video </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{route('document_view_report')}}" class="nav-link {{strpos(url()->current(),'report/document') !== false ? 'active' : ''}}" data-key="t-analytics"> Document </a>
                                        </li>
                                    </ul>
                                </div>
                            </li> <!-- end Dashboard Menu -->
                            <li class="nav-item">
                                <a class="nav-link menu-link {{strpos(url()->current(),'page/home') !== false || strpos(url()->current(),'page/about') !== false || strpos(url()->current(),'page/dynamic') !== false || strpos(url()->current(),'faq') !== false || strpos(url()->current(),'banner') !== false || strpos(url()->current(),'quote') !== false ? 'active' : ''}}" href="#sidebarDashboards10" data-bs-toggle="collapse" role="button"
                                    aria-expanded="{{strpos(url()->current(),'page/home') !== false || strpos(url()->current(),'page/about') !== false || strpos(url()->current(),'page/dynamic') !== false || strpos(url()->current(),'faq') !== false || strpos(url()->current(),'banner') !== false || strpos(url()->current(),'quote') !== false ? 'true' : 'false'}}" aria-controls="sidebarDashboards10">
                                    <i class="ri-pages-line"></i> <span data-key="t-dashboards">Website Content</span>
                                </a>
                                <div class="collapse menu-dropdown {{strpos(url()->current(),'page/home') !== false || strpos(url()->current(),'page/about') !== false || strpos(url()->current(),'page/dynamic') !== false || strpos(url()->current(),'faq') !== false || strpos(url()->current(),'banner') !== false || strpos(url()->current(),'quote') !== false ? 'show' : ''}}" id="sidebarDashboards10">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="{{route('home_page')}}" class="nav-link {{strpos(url()->current(),'page/home') !== false ? 'active' : ''}}" data-key="t-analytics"> Home Page </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{route('about_page')}}" class="nav-link {{strpos(url()->current(),'page/about') !== false ? 'active' : ''}}" data-key="t-analytics"> About Page </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{route('dynamic_page_list')}}" class="nav-link {{strpos(url()->current(),'page/dynamic') !== false ? 'active' : ''}}" data-key="t-analytics"> Dynamic Web Pages </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{route('faq_view')}}" class="nav-link {{strpos(url()->current(),'faq') !== false ? 'active' : ''}}" data-key="t-analytics"> FAQ </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{route('banner_view')}}" class="nav-link {{strpos(url()->current(),'banner') !== false ? 'active' : ''}}" data-key="t-analytics"> Banner Images </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{route('banner_quote_view')}}" class="nav-link {{strpos(url()->current(),'quote') !== false ? 'active' : ''}}" data-key="t-analytics"> Banner Quotes </a>
                                        </li>
                                    </ul>
                                </div>
                            </li> <!-- end Dashboard Menu -->
                        </ul>
                    </div>
                    <!-- Sidebar -->
                </div>
            </div>
            <!-- Left Sidebar End -->
            <!-- Vertical Overlay-->
            <div class="vertical-overlay"></div>