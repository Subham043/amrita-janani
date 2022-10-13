@extends('layouts.main.index')

@section('css')
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.1/css/all.css"
    integrity="sha384-vp86vTRFVJgpjF9jiIGPEEqYqlDwgyBgEF109VFjmqGmIY/Y4HV4d3Gp2irVfcrp" crossorigin="anonymous">
<link rel="stylesheet" href="{{ asset('main/css/content.css') }}">
<link rel="stylesheet" href="{{ asset('main/css/plugins/autocomplete.css')}}" type="text/css" />
@stop

@section('content')

@include('includes.main.sub_menu')

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
                        <div class="col-lg-2 col-md-12 mb-3 sort-div">
                            <i class="fas fa-sort-amount-down"></i>
                            <select name="sort" id="sort"  oninput="return callSearchHandler()">
                                <option value="newest" @if(app('request')->has('sort') && app('request')->input('sort')=="newest") selected @endif>Sort by Newest</option>
                                <option value="oldest" @if(app('request')->has('sort') && app('request')->input('sort')=='oldest') selected @endif>Sort by Oldest</option>
                                <option value="a-z" @if(app('request')->has('sort') && app('request')->input('sort')=="a-z") selected @endif> Sort by A-Z</option>
                                <option value="z-a" @if(app('request')->has('sort') && app('request')->input('sort')=="z-a") selected @endif>Sort by Z-A</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-12">

                    <div class="filter-holder">
                        <hr>
                        

                        <button class="accordion active">Filter</button>
                        <div class="panel" style="max-height: 100%;height:auto;">
                            <ul>
                                <li>
                                    <label for="filter_check">
                                        <input type="checkbox" id="filter_check" name="filter" value="favourite" @if(app('request')->has('filter') && app('request')->input('filter')=="favourite") checked @endif>
                                        My Favourite Images
                                    </label>
                                </li>
                            </ul>
                        </div>
                        <hr>


                    </div>
                    <div style="text-align: left">
                        <button onclick="callSearchHandler()" class="filter_button"> Apply </button>
                        <a href="{{route('content_image')}}" class="filter_button"> Clear </a>
                    </div>

                </div>

                <div class="col-lg-9 col-md-12">
                    
                    <div class="row">

                        @if($images->count() > 0)

                        @foreach($images->items() as $image)
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <a class="media-href" title="{{$image->title}}" href="{{route('content_image_view', $image->uuid)}}">
                                <div class="img-holder">
                                    <img src="{{route('content_image_thumbnail',$image->uuid)}}" alt="">
                                </div>
                                <div class="media-holder">
                                    <h5>{{$image->title}}</h5>
                                    <p class="desc">{{$image->description_unformatted}}</p>
                                    {{-- <p>Format : <b>{{$image->file_format()}}</b></p> --}}
                                    <p>Uploaded : <b>{{$image->time_elapsed()}}</b></p>
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
                    {{-- @if($images->previousPageUrl()==null)
                    <p>Showing {{(($images->perPage() * $images->currentPage()) - $images->perPage() + 1)}} to {{($images->currentPage() * $images->perPage())}} of {{$images->total()}} entries</p>
                    @else
                    <p>Showing {{(($images->perPage() * $images->currentPage()) - $images->perPage() + 1)}} to {{($images->total())}} of {{$images->total()}} entries</p>
                    @endif --}}

                    {{ $images->links('pagination::bootstrap-4') }}
                    
                </div>
            </div>

        </div>

    </div>
</div>



@stop

@section('javascript')
<script src="{{ asset('main/js/plugins/axios.min.js') }}"></script>

@include('pages.main.content.common.search_js', ['search_url'=>route('content_image_search_query')])


@include('pages.main.content.common.accordian_js')

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

</script>

<script>
    function callSearchHandler(){
        var str= "";
        var arr = [];

        if(document.getElementById('search').value){
            arr.push("search="+document.getElementById('search').value)
        }

        if(document.getElementById('sort').value){
            arr.push("sort="+document.getElementById('sort').value)
        }

        var filter_check = document.getElementById("filter_check");
        if (filter_check.type === "checkbox" && filter_check.checked === true){
            arr.push("filter="+document.getElementById('filter_check').value)
        }


        str = arr.join('&');
        window.location.replace('{{route('content_image')}}?'+str)
        return false;
    }
</script>


@stop