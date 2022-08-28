<div class="submenu-wrapper">
    <div class="container">
        <div class="row submenu-row">
            <div class="col-lg-9 col-sm-12 sub-menu-col">
                <ul class="submenu_holder">
                    {{-- <li><a class="{{strpos(url()->current(),'content/') === false ? 'active' : ''}}" href="{{route('content_dashboard')}}">Dashboard</a></li> --}}
                    <li><a class="{{strpos(url()->current(),'image') !== false ? 'active' : ''}}" href="{{route('content_image')}}">Images</a></li>
                    <li><a class="{{strpos(url()->current(),'video') !== false ? 'active' : ''}}" href="{{route('content_video')}}">Videos</a></li>
                    <li><a class="{{strpos(url()->current(),'audio') !== false ? 'active' : ''}}" href="{{route('content_audio')}}">Audio</a></li>
                    <li><a class="{{strpos(url()->current(),'document') !== false ? 'active' : ''}}" href="{{route('content_document')}}">Documents</a></li>
                    <li><a class="{{strpos(url()->current(),'user-profile') !== false ? 'active' : ''}}" href="{{route('userprofile')}}">User Profile</a></li>
                    <li><a class="{{strpos(url()->current(),'user-password') !== false ? 'active' : ''}}" href="{{route('display_profile_password')}}">Change Password</a></li>
                    <li><a class="{{strpos(url()->current(),'search-history') !== false ? 'active' : ''}}" href="{{route('search_history')}}">Search History</a></li>
                </ul>
            </div>
            <div class="col-lg-3 col-md-12 col-sm-12 search-col">
                <div class="right-submenu-holder">
                    {{-- @if(Auth::check() && Auth::user()->darkMode==1)
                    <a href="{{route('darkmode')}}"><i id="darkModeToggleBtn" class="fas fa-sun"></i></a>
                    @else
                    <a href="{{route('darkmode')}}"><i id="darkModeToggleBtn" class="fas fa-moon"></i></a>
                    @endif --}}
                    <form  method="get" class="col-sm-auto" onsubmit="return callSearchHandler()">
                        <label for="search">
                            {{-- <span><i class="fas fa-search"></i></span> --}}
                            <input type="search" id="search"  autocomplete="off" value="@if(app('request')->has('search') && !empty(app('request')->has('search'))){{app('request')->input('search')}}@endif" />
                        </label>
                        <button><i class="fas fa-search"></i></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>