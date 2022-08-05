@extends('layouts.main.index')

@section('css')
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.1/css/all.css"
    integrity="sha384-vp86vTRFVJgpjF9jiIGPEEqYqlDwgyBgEF109VFjmqGmIY/Y4HV4d3Gp2irVfcrp" crossorigin="anonymous">
<style>
.about-tai-content img {
    width: 50%;
    object-fit: contain;
    margin: 0 15px 15px 15px;
}

.about-tai-content p {
    text-align: justify;
}

.float-left {
    float: left;
}

.float-right {
    float: right;
}

@media only screen and (max-width: 767px) {
    .float-left {
        float: none !important;
    }

    .float-right {
        float: none !important;
    }

    .about-tai-content img {
        width: 100%;
        object-fit: contain;
        margin: 0px;
        margin-bottom: 15px;
    }
}

body {
    box-sizing: border-box;
}

.submenu-wrapper {
    background-color: #3e1d1e;
}

.submenu_holder {
    display: flex;
    justify-content: flex-start;
    align-items: center;
    padding: 15px 0;
}

.submenu_holder li a.active {
    background-color: #96171c;
    border-radius: 5px;
    padding: 10px;
}

.submenu_holder li {
    list-style: none;
    margin-right: 20px;
}

.submenu_holder li a:hover {
    color: #ffcc00;
}

.submenu_holder li a {
    color: #fff;
    text-decoration: none;
    font-weight: bold;
}

.right-submenu-holder button {
    margin: 0;
    padding: 0;
    background: transparent;
    border: none;
    outline: none;
    font-size: 25px;
    color: #ffcc00;
}

.right-submenu-holder {
    display: flex;
    justify-content: flex-end;
    align-items: center;
    padding: 15px 0;
}

.right-submenu-holder label {
    display: flex;
    background-color: transparent;
    margin-left: 20px;
    align-items: center;
    border-radius: 10px;
    border: 1px solid #fff;
    padding: 5px 10px;
}

.right-submenu-holder label span {
    color: #fff;
}

.right-submenu-holder label input {
    outline: none;
    border: none;
    background: transparent;
    padding: 0 5px;
    color: #ffcc00;
}

.right-submenu-holder form{
    margin:0;
    padding: 0;
}

.content-holder {
    /* background: #f0f8ff80; */
    background: #fff;
}

.content-holder .content-container {
    padding: 20px 0;
}

.content-holder .content-container .media-container {
    padding: 15px 0;
    text-align: center;
}

.content-holder .content-container .media-container h3 {
    text-align: center;
    font-size: 21px;
    margin-bottom: 0px;
    text-transform: uppercase;
}

.content-holder .content-container .media-container .img-holder {
    
    background-color:#fff;
}

.content-holder .content-container .media-container .media-holder {
    padding: 15px;
    text-align: left;
    background-color:white;
    transition: all 0.3s ease-in-out;
    background-color:#f1f1f1;
    border-top: 1px solid #bababa;
}

.content-holder .content-container .media-container .media-holder p{
    margin:0;
}

.content-holder .content-container .media-container .media-holder h5{
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    text-transform:capitalize;
    font-size: 1.1rem;
    font-weight: 800;
    margin-bottom:5px;
}

.content-holder .content-container .media-container .media-href:hover {
    box-shadow: 3px 4px 4px 3px #bababa;
    transform: scale(1.1);
    z-index: 5;
    position: relative;
    color: #000 !important;
}

.content-holder .content-container .media-container .media-href:hover > .content-holder .content-container .media-container .img-holder img {
    transform: rotateY(360deg);
}

.content-holder .content-container .media-container .media-href:hover > .content-holder .content-container .media-container .media-holder p{
    color: #000 !important;
}

.content-holder .content-container .media-container .img-holder img {
    height: 100px;
    object-fit: contain;
    margin: 20px 0;
    transition: all 0.5s ease-in-out;
}

.content-holder .content-container .media-container .media-href {
    display: block;
    text-decoration: none;
    margin-bottom: 20px;
    padding: 5px 0 0;
    border-radius:5px;
    border:1px solid #bababa;
}

.content-holder .content-container .media-container .view-more-href, .filter_button {
    padding: 10px 15px;
    background-color: #96171c;
    color: #fff;
    margin: 35px 0;
    border-radius: 5px;
    outline: none;
    border:none;
}

.filter_button {
    padding: 5px 8px;
    margin: 20px 0;
}

.sort-row {
    justify-content: flex-end;
}

.sort-row select {
    height: 45px;
    background: white;
    border-color: #ccc;
}

.sort-row select:focus {
    background: white !important;
}

.filter-holder .accordion {
    background-color: transparent;
    color: #868484;
    cursor: pointer;
    padding: 18px;
    width: 100%;
    text-align: left;
    border: none;
    outline: none;
    transition: 0.4s;
    font-weight: bold;
    font-size: 18px;
}

/* Add a background color to the button if it is clicked on (add the .active class with JS), and when you move the mouse over it (hover) */
.filter-holder .active,
.filter-holder .accordion:hover {
    background-color: transparent;
}

/* Style the accordion panel. Note: hidden by default */
.filter-holder .panel {
    padding: 0 18px;
    background-color: transparent;
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.2s ease-out;
    text-align: left;
}

.filter-holder .accordion:after {
    content: '\003E';
    /* Unicode character for "plus" sign (+) */
    font-size: 13px;
    color: #777;
    float: right;
    margin-left: 5px;
}

.filter-holder .active:after {
    content: "\02C5";
    /* Unicode character for "minus" sign (-) */
}

hr {
    margin: 0 !important;
}

.nav-flex-direction-end{
    display:flex;
    justify-content: space-between;
    align-items: center;
}

.nav-flex-direction-end p{
    color: #868484;
    font-weight: bold;
}
</style>
@stop

@section('content')

<div class="submenu-wrapper">
    <div class="container">
        <div class="row submenu-row">
            <div class="col-lg-7 col-sm-12">
                <ul class="submenu_holder">
                    <li><a href="{{route('content_dashboard')}}">Dashboard</a></li>
                    <li><a class="active" href="{{route('content_image')}}">Images</a></li>
                    <li><a href="{{route('content_video')}}">Videos</a></li>
                    <li><a href="{{route('content_audio')}}">Audios</a></li>
                    <li><a href="{{route('content_document')}}">Documents</a></li>
                </ul>
            </div>
            <div class="col-lg-5 col-sm-12">
                <div class="right-submenu-holder">
                    <button><i class="fas fa-sun"></i></button>
                    <form  method="get" action="{{route('content_image')}}" class="col-sm-auto" onsubmit="return callSearchHandler()">
                        <label for="search">
                            <span><i class="fas fa-search"></i></span>
                            <input type="search" id="search" value="@if(app('request')->has('search') && !empty(app('request')->has('search'))){{app('request')->input('search')}}@endif" />
                        </label>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@include('includes.main.breadcrumb')

<div class="content-holder">
    <div class="container content-container" style="padding-bottom:0">
        <div class="media-container">
            <h3>
                IMAGES
            </h3>

        </div>

    </div>
</div>
<div class="content-holder">
    <div class="container content-container" style="padding-top:0">
        <div class="media-container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row sort-row">
                        <div class="col-lg-2 col-md-12 mb-3">
                            <select name="sort" id="sort"  oninput="return callSearchHandler()">
                                <option value="newest" @if(app('request')->has('sort') && app('request')->input('sort')=="newest") selected @endif>Sort by Newest</option>
                                <option value="oldest" @if(app('request')->has('sort') && app('request')->input('sort')=='oldest') selected @endif>Sort by Oldest</option>
                                <option value="a-z" @if(app('request')->has('sort') && app('request')->input('sort')=="a-z") selected @endif>Sort by A-Z</option>
                                <option value="z-a" @if(app('request')->has('sort') && app('request')->input('sort')=="z-a") selected @endif>Sort by Z-A</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3">

                    <div class="filter-holder">
                        <hr>
                        @if(count($languages) > 0)
                        <button class="accordion active">Language</button>
                        <div class="panel" style="max-height: 100%;height:auto;">
                            <ul>

                                @foreach($languages as $languages)
                                <li>
                                    <label for="language{{$languages->id}}">
                                        <input type="checkbox" name="language" id="language{{$languages->id}}" value="{{$languages->id}}" @if(app('request')->has('language') && in_array($languages->id, explode(',', app('request')->input('language'))) ) checked @endif>
                                        {{$languages->name}}
                                    </label>
                                </li>
                                @endforeach

                            </ul>
                        </div>
                        <hr>
                        @endif

                        <button class="accordion active">Other Filter</button>
                        <div class="panel" style="max-height: 100%;height:auto;">
                            <ul>
                                <li>
                                    <label for="filter_check">
                                        <input type="checkbox" id="filter_check" name="filter" value="favourite">
                                        My Favourite Images
                                    </label>
                                </li>
                            </ul>
                        </div>
                        <hr>


                    </div>
                    <div style="text-align: left">
                        <button onclick="callSearchHandler()" class="filter_button"> Apply Filters</button>
                        <a href="{{route('content_image')}}" class="filter_button"> Clear Filters</a>
                    </div>

                </div>

                <div class="col-lg-9">
                    
                    <div class="row">

                        @if($images->count() > 0)

                        @foreach($images->items() as $image)
                        <div class="col-lg-4 col-sm-12">
                            <a class="media-href" title="{{$image->title}}" href="">
                                <div class="img-holder">
                                    <img src="{{asset('main/images/image.png')}}" alt="">
                                </div>
                                <div class="media-holder">
                                    <h5>{{$image->title}}</h5>
                                    <p>Format : {{$image->file_format()}}</p>
                                    <p>Uploaded : {{$image->time_elapsed()}}</p>
                                </div>
                            </a>
                        </div>
                        @endforeach

                        @else
                        <div class="col-lg-12 col-sm-12" style="text-align:center;">
                            <h6>No items are available.</h6>
                        </div>

                        @endif
                        
                    </div>
                </div>
                <div class="col-lg-3"></div>
                <div class="col-lg-9 my-4 nav-flex-direction-end">
                    @if($images->previousPageUrl()==null)
                    <p>Showing {{(($images->perPage() * $images->currentPage()) - $images->perPage() + 1)}} to {{($images->currentPage() * $images->perPage())}} of {{$images->total()}} entries</p>
                    @else
                    <p>Showing {{(($images->perPage() * $images->currentPage()) - $images->perPage() + 1)}} to {{($images->total())}} of {{$images->total()}} entries</p>
                    @endif

                    {{ $images->links('pagination::bootstrap-4') }}
                    
                </div>
            </div>

        </div>

    </div>
</div>



@stop

@section('javascript')

<script>
var acc = document.getElementsByClassName("accordion");
var i;

for (i = 0; i < acc.length; i++) {
    acc[i].addEventListener("click", function() {
        this.classList.toggle("active");
        var panel = this.nextElementSibling;
        if (panel.style.maxHeight) {
            panel.style.maxHeight = null;
        } else {
            panel.style.maxHeight = panel.scrollHeight + "px";
        }
    });
}
</script>

<script>
    const errorToast = (message) =>{
        iziToast.error({
            title: 'Error',
            message: message,
            position: 'bottomCenter',
            timeout:7000
        });
    }
    const successToast = (message) =>{
        iziToast.success({
            title: 'Success',
            message: message,
            position: 'bottomCenter',
            timeout:6000
        });
    }

    function callSearchHandler(){
        var str= "";
        var arr = [];

        if(document.getElementById('search').value){
            arr.push("search="+document.getElementById('search').value)
        }

        if(document.getElementById('sort').value){
            arr.push("sort="+document.getElementById('sort').value)
        }

        var inputElems = document.getElementsByName("language");
        var languageArr = [];
        for (var i=0; i<inputElems.length; i++) {
            if (inputElems[i].type === "checkbox" && inputElems[i].checked === true){
                languageArr.push(inputElems[i].value);
            }
        }
        if(languageArr.length > 0){
            languageStr = languageArr.join(';');
            arr.push("language="+languageStr)
        }


        str = arr.join('&');
        console.log(str);
        window.location.replace('{{route('content_image')}}?'+str)
        return false;
    }
</script>

@stop