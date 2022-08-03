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
}

.content-holder {
    background: #f0f8ff;
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

.content-holder .content-container .media-container .media-holder {
    padding: 15px;
    text-align: center;
    background-color: white;
    border-radius: 15px;
    box-shadow: 3px 4px 4px 3px #bababa;
}

.content-holder .content-container .media-container .media-holder img {
    height: 100px;
    object-fit: contain;
    margin-bottom: 20px;
}

.content-holder .content-container .media-container .media-href {
    display: block;
    text-decoration: none;
    margin-bottom: 20px;
}

.content-holder .content-container .media-container .view-more-href {
    padding: 10px 15px;
    background-color: #96171c;
    color: #fff;
    margin: 35px 0;
    border-radius: 5px;
}

.sort-row {
    justify-content: flex-end;
}

.sort-row select {
    height: 45px;
    background: white;
    border-color: #fff;
}

.sort-row select:focus {
    background: white;
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
                    <li><a href="">Dashboard</a></li>
                    <li><a class="active" href="">Images</a></li>
                    <li><a href="">Videos</a></li>
                    <li><a href="">Audios</a></li>
                    <li><a href="">Documents</a></li>
                </ul>
            </div>
            <div class="col-lg-5 col-sm-12">
                <div class="right-submenu-holder">
                    <button><i class="fas fa-sun"></i></button>
                    <label for="search">
                        <span><i class="fas fa-search"></i></span>
                        <input type="search" id="search" />
                    </label>
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
                            <select>
                                <option value="">Newest</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3">

                    <div class="filter-holder">
                        <hr>
                        <button class="accordion active">Language</button>
                        <div class="panel" style="max-height: 100%;height:auto;">
                            <ul>
                                <li>
                                    <label for="">
                                        <input type="checkbox" name="" id="">
                                        English
                                    </label>
                                </li>
                                <li>
                                    <label for="">
                                        <input type="checkbox" name="" id="">
                                        Hindi
                                    </label>
                                </li>
                                <li>
                                    <label for="">
                                        <input type="checkbox" name="" id="">
                                        Telegu
                                    </label>
                                </li>
                            </ul>
                        </div>
                        <hr>

                        <button class="accordion active">Language</button>
                        <div class="panel" style="max-height: 100%;height:auto;">
                            <ul>
                                <li>
                                    <label for="">
                                        <input type="checkbox" name="" id="">
                                        English
                                    </label>
                                </li>
                                <li>
                                    <label for="">
                                        <input type="checkbox" name="" id="">
                                        Hindi
                                    </label>
                                </li>
                                <li>
                                    <label for="">
                                        <input type="checkbox" name="" id="">
                                        Telegu
                                    </label>
                                </li>
                            </ul>
                        </div>
                        <hr>


                    </div>

                </div>

                <div class="col-lg-9">
                    
                    <div class="row">
                        <div class="col-lg-4 col-sm-12">
                            <a class="media-href" href="">
                                <div class="media-holder">
                                    <img src="{{asset('main/images/image.png')}}" alt="">
                                    <h5>File Name</h5>
                                    <p>3 days ago</p>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-4 col-sm-12">
                            <a class="media-href" href="">
                                <div class="media-holder">
                                    <img src="{{asset('main/images/image.png')}}" alt="">
                                    <h5>File Name</h5>
                                    <p>3 days ago</p>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-4 col-sm-12">
                            <a class="media-href" href="">
                                <div class="media-holder">
                                    <img src="{{asset('main/images/image.png')}}" alt="">
                                    <h5>File Name</h5>
                                    <p>3 days ago</p>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-4 col-sm-12">
                            <a class="media-href" href="">
                                <div class="media-holder">
                                    <img src="{{asset('main/images/image.png')}}" alt="">
                                    <h5>File Name</h5>
                                    <p>3 days ago</p>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-4 col-sm-12">
                            <a class="media-href" href="">
                                <div class="media-holder">
                                    <img src="{{asset('main/images/image.png')}}" alt="">
                                    <h5>File Name</h5>
                                    <p>3 days ago</p>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-4 col-sm-12">
                            <a class="media-href" href="">
                                <div class="media-holder">
                                    <img src="{{asset('main/images/image.png')}}" alt="">
                                    <h5>File Name</h5>
                                    <p>3 days ago</p>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-4 col-sm-12">
                            <a class="media-href" href="">
                                <div class="media-holder">
                                    <img src="{{asset('main/images/image.png')}}" alt="">
                                    <h5>File Name</h5>
                                    <p>3 days ago</p>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-4 col-sm-12">
                            <a class="media-href" href="">
                                <div class="media-holder">
                                    <img src="{{asset('main/images/image.png')}}" alt="">
                                    <h5>File Name</h5>
                                    <p>3 days ago</p>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-4 col-sm-12">
                            <a class="media-href" href="">
                                <div class="media-holder">
                                    <img src="{{asset('main/images/image.png')}}" alt="">
                                    <h5>File Name</h5>
                                    <p>3 days ago</p>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3"></div>
                <div class="col-lg-9 my-4 nav-flex-direction-end">
                    <p>Showing 1 to 10 of entries</p>
                    <nav aria-label="Page navigation example">
                        <ul class="pagination">
                            <li class="page-item">
                                <a class="page-link" href="#" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                    <span class="sr-only">Previous</span>
                                </a>
                            </li>
                            <li class="page-item"><a class="page-link" href="#">1</a></li>
                            <li class="page-item active"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item">
                                <a class="page-link" href="#" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
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

@stop