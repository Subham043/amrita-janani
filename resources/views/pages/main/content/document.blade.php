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
                DOCUMENTS
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
                                <option value="a-z" @if(app('request')->has('sort') && app('request')->input('sort')=="a-z") selected @endif>Sort by A-Z</option>
                                <option value="z-a" @if(app('request')->has('sort') && app('request')->input('sort')=="z-a") selected @endif>Sort by Z-A</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3">

                    <div class="filter-holder">
                        <hr>
                        
                        <button class="accordion active">Other Filter</button>
                        <div class="panel" style="max-height: 100%;height:auto;">
                            <ul>
                                <li>
                                    <label for="filter_check">
                                    <input type="checkbox" id="filter_check" name="filter" value="favourite" @if(app('request')->has('filter') && app('request')->input('filter')=="favourite") checked @endif>
                                        My Favourite Documents
                                    </label>
                                </li>
                            </ul>
                        </div>
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


                    </div>
                    <div style="text-align: left">
                        <button onclick="callSearchHandler()" class="filter_button"> Apply </button>
                        <a href="{{route('content_document')}}" class="filter_button"> Clear </a>
                    </div>

                </div>

                <div class="col-lg-9">
                    
                    <div class="row">

                        @if($documents->count() > 0)

                        @foreach($documents->items() as $document)
                        <div class="col-lg-4 col-sm-12">
                            <a class="media-href" title="{{$document->title}}" href="{{route('content_document_view', $document->uuid)}}">
                                <div class="img-holder">
                                    <img class="icon-img" src="{{asset('main/images/pdf.png')}}" alt="">
                                </div>
                                <div class="media-holder">
                                    <h5>{{$document->title}}</h5>
                                    <p class="desc">{{$document->description_unformatted}}</p>
                                    {{-- <p>Format : {{$document->file_format()}}</p> --}}
                                    @if($document->languages->count()>0)
                                    <p>Language : 
                                    @foreach ($document->languages as $languages)
                                        {{$languages->name}},
                                    @endforeach
                                    </p>
                                    @endif
                                    <p>Pages : {{$document->page_number}}</p>
                                    <p>Uploaded : {{$document->time_elapsed()}}</p>
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
                    {{-- @if($documents->previousPageUrl()==null)
                    <p>Showing {{(($documents->perPage() * $documents->currentPage()) - $documents->perPage() + 1)}} to {{($documents->currentPage() * $documents->perPage())}} of {{$documents->total()}} entries</p>
                    @else
                    <p>Showing {{(($documents->perPage() * $documents->currentPage()) - $documents->perPage() + 1)}} to {{($documents->total())}} of {{$documents->total()}} entries</p>
                    @endif --}}

                    {{ $documents->links('pagination::bootstrap-4') }}
                    
                </div>
            </div>

        </div>

    </div>
</div>



@stop

@section('javascript')
<script src="{{ asset('main/js/plugins/axios.min.js') }}"></script>

@include('pages.main.content.common.search_js', ['search_url'=>route('content_document_search_query')])

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

@include('pages.main.content.common.multimedia_search_handler', ['search_url'=>route('content_document')])

@stop