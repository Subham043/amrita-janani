
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
                                <a class="nav-link menu-link {{strpos(url()->current(),'enquiry') !== false ? 'active' : ''}}" href="#sidebarDashboards4" data-bs-toggle="collapse" role="button"
                                    aria-expanded="{{strpos(url()->current(),'enquiry') !== false ? 'true' : 'false'}}" aria-controls="sidebarDashboards4">
                                    <i class="ri-message-fill"></i> <span data-key="t-dashboards">Enquiry Management</span>
                                </a>
                                <div class="collapse menu-dropdown {{strpos(url()->current(),'enquiry') !== false  ? 'show' : ''}}" id="sidebarDashboards4">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="{{route('enquiry_view')}}" class="nav-link {{strpos(url()->current(),'enquiry') !== false ? 'active' : ''}}" data-key="t-analytics"> Enquiries </a>
                                        </li>
                                    </ul>
                                </div>
                            </li> <!-- end Dashboard Menu -->
                            <li class="nav-item">
                                <a class="nav-link menu-link {{strpos(url()->current(),'user') !== false ? 'active' : ''}}" href="#sidebarDashboards5" data-bs-toggle="collapse" role="button"
                                    aria-expanded="{{strpos(url()->current(),'user') !== false ? 'true' : 'false'}}" aria-controls="sidebarDashboards5">
                                    <i class="ri-admin-fill"></i> <span data-key="t-dashboards">User Management</span>
                                </a>
                                <div class="collapse menu-dropdown {{strpos(url()->current(),'user') !== false ? 'show' : ''}}" id="sidebarDashboards5">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="{{route('subadmin_view')}}" class="nav-link {{strpos(url()->current(),'user') !== false ? 'active' : ''}}" data-key="t-analytics"> User </a>
                                        </li>
                                    </ul>
                                </div>
                            </li> <!-- end Dashboard Menu -->
                            <li class="nav-item">
                                <a class="nav-link menu-link {{strpos(url()->current(),'language') !== false ? 'active' : ''}}" href="#sidebarDashboards7" data-bs-toggle="collapse" role="button"
                                    aria-expanded="{{strpos(url()->current(),'language') !== false ? 'true' : 'false'}}" aria-controls="sidebarDashboards7">
                                    <i class="bx bx-text"></i> <span data-key="t-dashboards">Language Management</span>
                                </a>
                                <div class="collapse menu-dropdown {{strpos(url()->current(),'language') !== false ? 'show' : ''}}" id="sidebarDashboards7">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="{{route('language_view')}}" class="nav-link {{strpos(url()->current(),'language') !== false ? 'active' : ''}}" data-key="t-analytics"> Language </a>
                                        </li>
                                    </ul>
                                </div>
                            </li> <!-- end Dashboard Menu -->
                            <li class="nav-item">
                                <a class="nav-link menu-link {{strpos(url()->current(),'image') !== false || strpos(url()->current(),'audio') !== false || strpos(url()->current(),'video') !== false || strpos(url()->current(),'document') !== false ? 'active' : ''}}" href="#sidebarDashboards6" data-bs-toggle="collapse" role="button"
                                    aria-expanded="{{strpos(url()->current(),'image') !== false || strpos(url()->current(),'audio') !== false || strpos(url()->current(),'video') !== false || strpos(url()->current(),'document') !== false ? 'true' : 'false'}}" aria-controls="sidebarDashboards6">
                                    <i class="ri-image-fill"></i> <span data-key="t-dashboards">Multimedia Management</span>
                                </a>
                                <div class="collapse menu-dropdown {{strpos(url()->current(),'image') !== false || strpos(url()->current(),'audio') !== false || strpos(url()->current(),'video') !== false || strpos(url()->current(),'document') !== false ? 'show' : ''}}" id="sidebarDashboards6">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="{{route('image_view')}}" class="nav-link {{strpos(url()->current(),'image') !== false ? 'active' : ''}}" data-key="t-analytics"> Image </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{route('audio_view')}}" class="nav-link {{strpos(url()->current(),'audio') !== false ? 'active' : ''}}" data-key="t-analytics"> Audio </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{route('video_view')}}" class="nav-link {{strpos(url()->current(),'video') !== false ? 'active' : ''}}" data-key="t-analytics"> Video </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{route('document_view')}}" class="nav-link {{strpos(url()->current(),'document') !== false ? 'active' : ''}}" data-key="t-analytics"> Document </a>
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