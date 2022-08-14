@extends('layouts.main.index')

@section('css')
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.1/css/all.css"
    integrity="sha384-vp86vTRFVJgpjF9jiIGPEEqYqlDwgyBgEF109VFjmqGmIY/Y4HV4d3Gp2irVfcrp" crossorigin="anonymous">
<link rel="stylesheet" href="{{ asset('admin/css/image-previewer.css')}}" type="text/css" />
<link rel="stylesheet" href="{{ asset('main/css/content.css') }}">
<link rel="stylesheet" href="{{ asset('main/css/plugins/autocomplete.css')}}" type="text/css" />

@stop

@section('content')

@include('includes.main.sub_menu')


<div class="main-content-wrapper">
    @if($image->restricted==0 || Auth::user()->userType!=2)
    <div class="main-image-container" id="image-container" style="background-image:url({{asset('storage/upload/images/'.$image->image)}})">
        <div class="blur-bg">
            <img src="{{asset('storage/upload/images/'.$image->image)}}" />
        </div>
    </div>
    @else
    @if(empty($imageAccess) || $imageAccess->status==0)
        @include('pages.main.content.common.denied_img', ['text'=>'image'])
    @else
    <div class="main-image-container" id="image-container" style="background-image:url({{asset('storage/upload/images/'.$image->image)}})">
        <div class="blur-bg">
            <img src="{{asset('storage/upload/images/'.$image->image)}}" />
        </div>
    </div>
    @endif
    @endif
    <hr/>
    <div class="container">
        <div class="row action-button-row">
            <div class="col-sm-12">
                <div class="info-content">
                    <h5>{{$image->title}}</h5>
                </div>
            </div>
            <div class="col-sm-auto">
                <div class="info-content">
                    <p><span id="view_count">{{$image->views}} views</span> <span id="favourite_count">{{$image->favourites}} favourites</span></p>
                </div>
            </div>
            <div class="col-lg-5 col-md-6 col-sm-12 action-button-wrapper">
                <a href="{{route('content_image_makeFavourite',$image->uuid)}}" class="action-btn make-favourite-button">
                    @if($imageFav)
                    @if($imageFav->status == 1)
                    <i class="fas fa-heart-broken"></i> Unmark Favourite
                    @else
                    <i class="far fa-heart"></i> Mark Favourite
                    @endif
                    @else
                    <i class="far fa-heart"></i> Make Favourite
                    @endif
                </a>
                <button class="action-btn report-button" data-toggle="modal" data-target="#reportModal"><i class="far fa-flag"></i> Report</button>
            </div>
        </div>
    </div>
    <hr/>
    <div class="container info-container">
    <p>ID : <b>{{$image->uuid}}</b></p>
    <p>Format : <b>{{$image->file_format()}}</b></p>
    <p>Language : <b>{{$image->LanguageModel->name}}</b></p>
    <p>Visibility : <b>{{$image->restricted==0 ? 'Public' : 'Private'}}</b></p>
    <p>Uploaded By : <b>{{$image->User->name}}</b></p>
    <p>Uploaded At : <b>{{$image->time_elapsed()}}</b></p>
    </div>
    @if($image->description_unformatted)
    <hr/>
    <div class="container info-container info-major-content">
        <h6>Description</h6>
        {!!$image->description!!}
    </div>
    @endif

    @include('pages.main.content.common.request_access_modal')
    
    @include('pages.main.content.common.report_modal', ['text'=>'image'])

</div>

@stop

@section('javascript')
<script src="{{ asset('admin/js/pages/img-previewer.min.js') }}"></script>
<script src="{{ asset('main/js/plugins/just-validate.production.min.js') }}"></script>
<script src="{{ asset('main/js/plugins/axios.min.js') }}"></script> 

@include('pages.main.content.common.search_js', ['search_url'=>route('content_search_query')])

<script>
    const myViewer = new ImgPreviewer('#image-container',{
      // aspect ratio of image
        fillRatio: 0.9,
        // attribute that holds the image
        dataUrlKey: 'src',
        // additional styles
        style: {
            modalOpacity: 0.6,
            headerOpacity: 0,
            zIndex: 99
        },
        // zoom options
        imageZoom: { 
            min: 0.1,
            max: 5,
            step: 0.1
        },
        // detect whether the parent element of the image is hidden by the css style
        bubblingLevel: 0,
        
    });
</script>

<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>

@include('pages.main.content.common.request_access_form_js', ['url'=>route('content_image_requestAccess', $image->uuid)])
@include('pages.main.content.common.report_form_js', ['url'=>route('content_image_report', $image->uuid)])


@include('pages.main.content.common.reload_captcha_js')

@include('pages.main.content.common.dashboard_search_handler', ['search_url'=>route('content_dashboard')])


@stop