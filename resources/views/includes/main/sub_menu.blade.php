<div class="submenu-wrapper">
    <div class="container">
        <div class="row submenu-row">
            <div class="col-lg-7 col-sm-12 sub-menu-col">
                <ul class="submenu_holder">
                    <li><a class="{{strpos(url()->current(),'content/') === false ? 'active' : ''}}" href="{{route('content_dashboard')}}">Dashboard</a></li>
                    <li><a class="{{strpos(url()->current(),'image') !== false ? 'active' : ''}}" href="{{route('content_image')}}">Images</a></li>
                    <li><a class="{{strpos(url()->current(),'video') !== false ? 'active' : ''}}" href="{{route('content_video')}}">Videos</a></li>
                    <li><a class="{{strpos(url()->current(),'audio') !== false ? 'active' : ''}}" href="{{route('content_audio')}}">Audios</a></li>
                    <li><a class="{{strpos(url()->current(),'document') !== false ? 'active' : ''}}" href="{{route('content_document')}}">Documents</a></li>
                </ul>
            </div>
            <div class="col-lg-5 col-md-12 col-sm-12 search-col">
                <div class="right-submenu-holder">
                    @if(Auth::check() && Auth::user()->darkMode==1)
                    <a href="{{route('darkmode')}}"><i id="darkModeToggleBtn" class="fas fa-sun"></i></a>
                    @else
                    <a href="{{route('darkmode')}}"><i id="darkModeToggleBtn" class="fas fa-moon"></i></a>
                    @endif
                    <form  method="get" class="col-sm-auto" onsubmit="return callSearchHandler()">
                        <label for="search">
                            <span><i class="fas fa-search"></i></span>
                            <input type="search" id="search"  autocomplete="off" value="@if(app('request')->has('search') && !empty(app('request')->has('search'))){{app('request')->input('search')}}@endif" />
                        </label>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>