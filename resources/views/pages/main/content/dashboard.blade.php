@extends('layouts.main.index')

@section('css')
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.1/css/all.css"
        integrity="sha384-vp86vTRFVJgpjF9jiIGPEEqYqlDwgyBgEF109VFjmqGmIY/Y4HV4d3Gp2irVfcrp" crossorigin="anonymous">
        <link rel="stylesheet" href="{{ asset('main/css/content.css') }}">
@stop

@section('content')

@include('includes.main.sub_menu')

@include('includes.main.breadcrumb')

<div class="content-holder">
    <div class="container content-container">
        @if(count($images) > 0)
        <div class="media-container">
            <h3 class="dashboard-header">
                IMAGES
            </h3>
            <div class="row">
                @foreach($images as $images)
                <div class="col-lg-3 col-sm-12">
                    <a class="media-href" title="{{$images->title}}" href="{{route('content_image_view', $images->uuid)}}">
                        <div class="img-holder">
                            <img src="{{asset('main/images/image.png')}}" alt="">
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
        </div>
        @endif
        @if(count($videos) > 0)
        <div class="media-container">
            <h3 class="dashboard-header">
                VIDEOS
            </h3>
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
        </div>
        @endif
        @if(count($audios) > 0)
        <div class="media-container">
            <h3 class="dashboard-header">
                AUDIOS
            </h3>
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
        </div>
        @endif
        @if(count($documents) > 0)
        <div class="media-container">
            <h3 class="dashboard-header">
                DOCUMENTS
            </h3>
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
        </div>
        @endif
    </div>
</div>



@stop