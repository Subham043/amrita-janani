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
    <div class="container content-container">
        <div class="media-container">
            <h3 class="dashboard-header">
                IMAGES
            </h3>
            @if(count($images) > 0)
            <div class="row">
                @foreach($images as $images)
                <div class="col-lg-3 col-sm-12">
                    <a class="media-href" title="{{$images->title}}" href="{{route('content_image_view', $images->uuid)}}">
                        <div class="img-holder">
                            <img src="{{asset('storage/upload/images/compressed-'.$images->image)}}" alt="">
                        </div>
                        <div class="media-holder">
                            <h5>{{$images->title}}</h5>
                            <p>Format : <b>{{$images->file_format()}}</b></p>
                            <p>Uploaded : <b>{{$images->time_elapsed()}}</b></p>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
            <a href="{{route('content_image')}}" class="view-more-href">View More Images</a>
            @else
            <p style="text-align:center">No images available.</p>
            <a href="{{route('content_image')}}" class="view-more-href">View Other Images</a>
            @endif
        </div>
        <div class="media-container">
            <h3 class="dashboard-header">
                VIDEOS
            </h3>
            @if(count($videos) > 0)
            <div class="row">
                @foreach($videos as $videos)
                <div class="col-lg-3 col-sm-12">
                    <a class="media-href" title="{{$videos->title}}" href="{{route('content_video_view', $videos->uuid)}}">
                        <div class="img-holder">
                            <img src="{{asset('main/images/video.png')}}" alt="">
                        </div>
                        <div class="media-holder">
                            <h5>{{$videos->title}}</h5>
                            <p>Uploaded : {{$videos->time_elapsed()}}</p>
                        </div>
                    </a>
                </div>
                @endforeach
                
            </div>
            <a href="{{route('content_video')}}" class="view-more-href">View More Videos</a>
            @else
            <p style="text-align:center">No videos available.</p>
            <a href="{{route('content_video')}}" class="view-more-href">View Other Videos</a>
            @endif
        </div>
        <div class="media-container">
            <h3 class="dashboard-header">
                AUDIOS
            </h3>
            @if(count($audios) > 0)
            <div class="row">
                @foreach($audios as $audios)
                <div class="col-lg-3 col-sm-12">
                    <a class="media-href" title="{{$audios->title}}" href="{{route('content_audio_view', $audios->uuid)}}">
                        <div class="img-holder">
                            <img src="{{asset('main/images/audio-book.png')}}" alt="">
                        </div>
                        <div class="media-holder">
                            <h5>{{$audios->title}}</h5>
                            <p>Format : <b>{{$audios->file_format()}}</b></p>
                            <p>Duration : {{$audios->duration}}</p>
                            <p>Uploaded : <b>{{$audios->time_elapsed()}}</b></p>
                        </div>
                    </a>
                </div>
                @endforeach
                
            </div>
            <a href="{{route('content_audio')}}" class="view-more-href">View More Audios</a>
            @else
            <p style="text-align:center">No audios available.</p>
            <a href="{{route('content_audio')}}" class="view-more-href">View Other Audios</a>
            @endif
            
        </div>
        <div class="media-container">
            <h3 class="dashboard-header">
                DOCUMENTS
            </h3>
            @if(count($documents) > 0)
            <div class="row">
                @foreach($documents as $documents)
                <div class="col-lg-3 col-sm-12">
                    <a class="media-href" title="{{$documents->title}}" href="{{route('content_document_view', $documents->uuid)}}">
                        <div class="img-holder">
                            <img src="{{asset('main/images/pdf.png')}}" alt="">
                        </div>
                        <div class="media-holder">
                            <h5>{{$documents->title}}</h5>
                            <p>Format : <b>{{$documents->file_format()}}</b></p>
                            <p>Number of Pages : {{$documents->page_number}}</p>
                            <p>Uploaded : <b>{{$documents->time_elapsed()}}</b></p>
                        </div>
                    </a>
                </div>
                @endforeach
                
            </div>
            <a href="{{route('content_document')}}" class="view-more-href">View More Documents</a>
            @else
            <p style="text-align:center">No documents available.</p>
            <a href="{{route('content_document')}}" class="view-more-href">View Other Documents</a>
            @endif
        </div>
    </div>
</div>



@stop

@section('javascript')
<script src="{{ asset('main/js/plugins/axios.min.js') }}"></script>
@include('pages.main.content.common.search_js', ['search_url'=>route('content_search_query')])
@include('pages.main.content.common.dashboard_search_handler', ['search_url'=>route('content_dashboard')])



@stop