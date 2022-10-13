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

@php
$documents = $documents;
$audios=$audios;
$images = $images;
$videos = $videos;    
@endphp

<div class="content-holder">
    <div class="container content-container">
        @if(count($images) > 0)
        <div class="media-container">
            <h3 class="dashboard-header">
                IMAGES
            </h3>
            <div class="row">
                @foreach($images as $image)
                <div class="col-lg-3 col-sm-12">
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
            </div>
            <a href="{{route('content_image')}}" class="view-more-href">View More Images</a>
            {{-- @else
            <p style="text-align:center">No images available.</p>
            <a href="{{route('content_image')}}" class="view-more-href">View Other Images</a> --}}
        </div>
        @endif
        @if(count($videos) > 0)
        <div class="media-container">
            <h3 class="dashboard-header">
                VIDEOS
            </h3>
            <div class="row">
                @foreach($videos as $video)
                <div class="col-lg-3 col-sm-12">
                    <a class="media-href" title="{{$video->title}}" href="{{route('content_video_view', $video->uuid)}}">
                        <div class="img-holder">
                            @if(strpos($video->video,'vimeo') !== false)
                            <img src="https://vumbnail.com/{{$video->getVideoId()}}.jpg" alt="">
                            @else
                            <img src="https://i3.ytimg.com/vi/{{$video->getVideoId()}}/maxresdefault.jpg" alt="">
                            @endif
                        </div>
                        <div class="media-holder">
                            <h5>{{$video->title}}</h5>
                            <p class="desc">{{$video->description_unformatted}}</p>
                            @if($video->languages->count()>0)
                            <p>Language : 
                            @foreach ($video->languages as $languages)
                                {{$languages->name}},
                            @endforeach
                            </p>
                            @endif
                            <p>Uploaded : {{$video->time_elapsed()}}</p>
                        </div>
                    </a>
                </div>
                @endforeach
                
            </div>
            <a href="{{route('content_video')}}" class="view-more-href">View More Videos</a>
            {{-- @else
            <p style="text-align:center">No videos available.</p>
            <a href="{{route('content_video')}}" class="view-more-href">View Other Videos</a> --}}
        </div>
        @endif
        @if(count($audios) > 0)
        <div class="media-container">
            <h3 class="dashboard-header">
                AUDIO
            </h3>
            <div class="row">
                @foreach($audios as $audio)
                <div class="col-lg-3 col-sm-12">
                    <a class="media-href" title="{{$audio->title}}" href="{{route('content_audio_view', $audio->uuid)}}">
                        <div class="img-holder">
                            <img class="icon-img" src="{{asset('main/images/audio-book.png')}}" alt="">
                        </div>
                        <div class="media-holder">
                            <h5>{{$audio->title}}</h5>
                            <p class="desc">{{$audio->description_unformatted}}</p>
                            {{-- <p>Format : <b>{{$audio->file_format()}}</b></p> --}}
                            @if($audio->languages->count()>0)
                            <p>Language : 
                            @foreach ($audio->languages as $languages)
                                {{$languages->name}},
                            @endforeach
                            </p>
                            @endif
                            <p>Duration : {{$audio->duration}}</p>
                            <p>Uploaded : <b>{{$audio->time_elapsed()}}</b></p>
                        </div>
                    </a>
                </div>
                @endforeach
                
            </div>
            <a href="{{route('content_audio')}}" class="view-more-href">View More Audio</a>
            {{-- @else
            <p style="text-align:center">No audio available.</p>
            <a href="{{route('content_audio')}}" class="view-more-href">View Other Audio</a> --}}
            
        </div>
        @endif
        @if(count($documents) > 0)
        <div class="media-container">
            <h3 class="dashboard-header">
                DOCUMENTS
            </h3>
            <div class="row">
                @foreach($documents as $document)
                <div class="col-lg-3 col-sm-12">
                    <a class="media-href" title="{{$document->title}}" href="{{route('content_document_view', $document->uuid)}}">
                        <div class="img-holder">
                            <img class="icon-img" src="{{asset('main/images/pdf.png')}}" alt="">
                        </div>
                        <div class="media-holder">
                            <h5>{{$document->title}}</h5>
                            <p class="desc">{{$document->description_unformatted}}</p>
                            {{-- <p>Format : <b>{{$document->file_format()}}</b></p> --}}
                            @if($document->languages->count()>0)
                            <p>Language : 
                            @foreach ($document->languages as $languages)
                                {{$languages->name}},
                            @endforeach
                            </p>
                            @endif
                            <p>Pages : {{$document->page_number}}</p>
                            <p>Uploaded : <b>{{$document->time_elapsed()}}</b></p>
                        </div>
                    </a>
                </div>
                @endforeach
                
            </div>
            <a href="{{route('content_document')}}" class="view-more-href">View More Documents</a>
            {{-- @else
            <p style="text-align:center">No documents available.</p>
            <a href="{{route('content_document')}}" class="view-more-href">View Other Documents</a> --}}
        </div>
        @endif
        @if(!(count($documents) > 0) && !(count($audios) > 0) && !(count($images) > 0) && !(count($videos) > 0))
        <div class="media-container">
            <p class="no_data" style="text-align:center">No data available.</p>
            {{-- <a href="{{route('content_document')}}" class="view-more-href">View Other Documents</a> --}}
        </div>
        @endif
    </div>
</div>



@stop

@section('javascript')
<script src="{{ asset('main/js/plugins/axios.min.js') }}"></script>
@include('pages.main.content.common.search_js', ['search_url'=>route('content_search_query')])
@include('pages.main.content.common.dashboard_search_handler', ['search_url'=>route('content_dashboard')])



@stop