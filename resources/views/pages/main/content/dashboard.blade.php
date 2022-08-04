@extends('layouts.main.index')

@section('css')
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.1/css/all.css"
        integrity="sha384-vp86vTRFVJgpjF9jiIGPEEqYqlDwgyBgEF109VFjmqGmIY/Y4HV4d3Gp2irVfcrp" crossorigin="anonymous">
<style>
.about-tai-content img{
    width: 50%;
    object-fit: contain;
    margin: 0 15px 15px 15px;
}
.about-tai-content p{
    text-align: justify;
}

.float-left{ float: left; }
.float-right{ float: right; }

@media only screen and (max-width: 767px) {
    .float-left{ float: none !important; }
    .float-right{ float: none !important; }
    .about-tai-content img{
        width: 100%;
        object-fit: contain;
        margin: 0px;
        margin-bottom: 15px;
    }
}

body{
    box-sizing: border-box;
}

.submenu-wrapper{
    background-color: #3e1d1e;
}

.submenu_holder{
    display:flex;
    justify-content:flex-start;
    align-items: center;
    padding: 15px 0;
}

.submenu_holder li a.active{
    background-color: #96171c;
    border-radius: 5px;
    padding:10px;
}

.submenu_holder li{
    list-style: none;
    margin-right:20px;
}

.submenu_holder li a:hover{
    color: #ffcc00;
}

.submenu_holder li a{
    color: #fff;
    text-decoration: none;
    font-weight: bold;
}

.right-submenu-holder button{
    margin: 0;
    padding: 0;
    background: transparent;
    border: none;
    outline: none;
    font-size: 25px;
    color:#ffcc00;
}

.right-submenu-holder{
    display:flex;
    justify-content:flex-end;
    align-items: center;
    padding: 15px 0;
}

.right-submenu-holder label{
    display:flex;
    background-color: transparent;
    margin-left:20px;
    align-items: center;
    border-radius:10px;
    border: 1px solid #fff;
    padding: 5px 10px;
}

.right-submenu-holder form{
    margin:0;
    padding: 0;
}
.right-submenu-holder label span{
    color: #fff;
}

.right-submenu-holder label input{
    outline: none;
    border: none;
    background: transparent;
    padding: 0 5px;
    color: #ffcc00;
}

.content-holder{
    background:#fff;
}

.content-holder .content-container{
    padding:20px 0;
}

.content-holder .content-container .media-container{
    padding:15px 0;
    text-align:center;
}

.content-holder .content-container .media-container h3{
    text-align:center;
    font-size: 21px;
    margin-bottom:30px;
    text-transform:uppercase;
}

.content-holder .content-container .media-container .media-holder{
    padding: 15px;
    text-align: center;
    background-color:white;
    border-radius:5px;
    border:1px solid #bababa;
    transition: all 0.3s ease-in-out;
    padding: 15px 5px;
}

.content-holder .content-container .media-container .media-holder:hover {
    box-shadow: 3px 4px 4px 3px #bababa;
    transform: scale(1.1);
    z-index: 5;
    position: relative;
}

.content-holder .content-container .media-container .media-holder:hover > img {
    transform: rotateY(360deg);
}

.content-holder .content-container .media-container .media-holder h5{
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    text-transform:capitalize;
    padding: 0 5px;
}

.content-holder .content-container .media-container .media-holder img{
    height:80px;
    object-fit: contain;
    margin-bottom:20px;
    transition: all 0.5s ease-in-out;
}

.content-holder .content-container .media-container .media-href{
    display: block;
    text-decoration:none;
    margin-bottom:20px;
}

.content-holder .content-container .media-container .view-more-href{
    padding:10px 15px;
    background-color:#96171c;
    color:#fff;
    margin:35px 0;
    border-radius:5px;
}

</style>
@stop

@section('content')

<div class="submenu-wrapper">
    <div class="container">
        <div class="row submenu-row">
            <div class="col-lg-7 col-sm-12">
                <ul class="submenu_holder">
                    <li><a class="active" href="">Dashboard</a></li>
                    <li><a href="">Images</a></li>
                    <li><a href="">Videos</a></li>
                    <li><a href="">Audios</a></li>
                    <li><a href="">Documents</a></li>
                </ul>
            </div>
            <div class="col-lg-5 col-sm-12">
                <div class="right-submenu-holder">
                    <button><i class="fas fa-sun"></i></button>
                    <form  method="get" action="{{route('content_image')}}" class="col-sm-auto" onsubmit="return callSearchHandler()">
                        <label for="search">
                            <span><i class="fas fa-search"></i></span>
                            <input type="search" id="search" />
                        </label>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@include('includes.main.breadcrumb')

<div class="content-holder">
    <div class="container content-container">
        @if(count($images) > 0)
        <div class="media-container">
            <h3>
                IMAGES
            </h3>
            <div class="row">
                @foreach($images as $images)
                <div class="col-lg-3 col-sm-12">
                    <a class="media-href" title="{{$images->title}}" href="">
                        <div class="media-holder">
                            <img src="{{asset('main/images/image.png')}}" alt="">
                            <h5>{{$images->title}}</h5>
                            <p>3 days ago</p>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
            <a href="" class="view-more-href">View More Images</a>
        </div>
        @endif
        @if(count($videos) > 0)
        <div class="media-container">
            <h3>
                VIDEOS
            </h3>
            <div class="row">
                @foreach($videos as $videos)
                <div class="col-lg-3 col-sm-12">
                    <a class="media-href" title="{{$videos->title}}" href="">
                        <div class="media-holder">
                            <img src="{{asset('main/images/video.png')}}" alt="">
                            <h5>{{$videos->title}}</h5>
                            <p>3 days ago</p>
                        </div>
                    </a>
                </div>
                @endforeach
                
            </div>
            <a href="" class="view-more-href">View More Videos</a>
        </div>
        @endif
        @if(count($audios) > 0)
        <div class="media-container">
            <h3>
                AUDIOS
            </h3>
            <div class="row">
                @foreach($audios as $audios)
                <div class="col-lg-3 col-sm-12">
                    <a class="media-href" title="{{$audios->title}}" href="">
                        <div class="media-holder">
                            <img src="{{asset('main/images/audio-book.png')}}" alt="">
                            <h5>{{$audios->title}}</h5>
                            <p>3 days ago</p>
                        </div>
                    </a>
                </div>
                @endforeach
                
            </div>
            <a href="" class="view-more-href">View More Audios</a>
        </div>
        @endif
        @if(count($documents) > 0)
        <div class="media-container">
            <h3>
                DOCUMENTS
            </h3>
            <div class="row">
                @foreach($documents as $documents)
                <div class="col-lg-3 col-sm-12">
                    <a class="media-href" title="{{$documents->title}}" href="">
                        <div class="media-holder">
                            <img src="{{asset('main/images/pdf.png')}}" alt="">
                            <h5>{{$documents->title}}</h5>
                            <p>3 days ago</p>
                        </div>
                    </a>
                </div>
                @endforeach
                
            </div>
            <a href="" class="view-more-href">View More Documents</a>
        </div>
        @endif
    </div>
</div>



@stop