@extends('layouts.main.index')

@section('css')
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.1/css/all.css"
    integrity="sha384-vp86vTRFVJgpjF9jiIGPEEqYqlDwgyBgEF109VFjmqGmIY/Y4HV4d3Gp2irVfcrp" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('main/css/content.css') }}">
    <link rel="stylesheet" href="{{ asset('main/css/plugins/easy-autocomplete.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('main/css/plugins/easy-autocomplete.themes.css')}}" type="text/css" />
@stop

@section('content')

@include('includes.main.sub_menu')

@include('includes.main.breadcrumb')

<div class="content-holder">
    <div class="container content-container" style="padding-bottom:0">
        <div class="media-container">
            <h3>
                AUDIOS
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
                                        My Favourite Audios
                                    </label>
                                </li>
                            </ul>
                        </div>
                        <hr>


                    </div>
                    <div style="text-align: left">
                        <button onclick="callSearchHandler()" class="filter_button"> Apply Filters</button>
                        <a href="{{route('content_audio')}}" class="filter_button"> Clear Filters</a>
                    </div>

                </div>

                <div class="col-lg-9">
                    
                    <div class="row">

                        @if($audios->count() > 0)

                        @foreach($audios->items() as $audio)
                        <div class="col-lg-4 col-sm-12">
                            <a class="media-href" title="{{$audio->title}}" href="{{route('content_audio_view', $audio->uuid)}}">
                                <div class="img-holder">
                                    <img src="{{asset('main/images/audio-book.png')}}" alt="">
                                </div>
                                <div class="media-holder">
                                    <h5>{{$audio->title}}</h5>
                                    <p>Format : {{$audio->file_format()}}</p>
                                    <p>Duration : {{$audio->duration}}</p>
                                    <p>Uploaded : {{$audio->time_elapsed()}}</p>
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
                    @if($audios->previousPageUrl()==null)
                    <p>Showing {{(($audios->perPage() * $audios->currentPage()) - $audios->perPage() + 1)}} to {{($audios->currentPage() * $audios->perPage())}} of {{$audios->total()}} entries</p>
                    @else
                    <p>Showing {{(($audios->perPage() * $audios->currentPage()) - $audios->perPage() + 1)}} to {{($audios->total())}} of {{$audios->total()}} entries</p>
                    @endif

                    {{ $audios->links('pagination::bootstrap-4') }}
                    
                </div>
            </div>

        </div>

    </div>
</div>



@stop

@section('javascript')
<script src="{{ asset('main/js/plugins/jquery.easy-autocomplete.js') }}"></script>
<script>
    var options = {
    url: function(phrase) {
        return "{{route('content_audio_search_query')}}";
    },
    ajaxSettings: {
        dataType: "json",
        method: "POST",
        data: {
            dataType: "json"
        }
    },
    preparePostData: function(data) {
        data.phrase = $("#search").val();
        data._token= "{{ csrf_token() }}";
        return data;
    },
    getValue: function(element) {
        return element.name;
    },


    list: {
    match: {
      enabled: true
    }
  },
};

$("#search").easyAutocomplete(options);
</script>

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
        window.location.replace('{{route('content_audio')}}?'+str)
        return false;
    }
</script>

@stop