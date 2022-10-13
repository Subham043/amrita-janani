@extends('layouts.main.index')

@section('css')
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.1/css/all.css"
    integrity="sha384-vp86vTRFVJgpjF9jiIGPEEqYqlDwgyBgEF109VFjmqGmIY/Y4HV4d3Gp2irVfcrp" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('admin/css/image-previewer.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('main/css/content.css') }}">
    <link rel="stylesheet" href="{{ asset('main/css/plugins/autocomplete.css')}}" type="text/css" />
<style>
    #canvas_container {
        width: 100%;
        height: 550px;
        overflow: auto;
        position: relative;
    }

    #canvas_container {
    background: #333;
    text-align: center;
    border: solid 3px;
    }

    #pdf_controllers{
        width: 100%;
        background: #222;
        display:flex;
        justify-content: space-between;
        align-items: center;
        padding:10px 15px;
    }

    #pdf_controllers button{
        display:grid;
        place-items: center;
        outline: none;
        border: none;
        background:#96171c;
        color:white;
        border-radius:5px;
        padding:5px 10px;
    }

    #navigation_controls, #zoom_controls{
        display:flex;
        align-items:center;
    }
    #navigation_controls button, #zoom_controls button{
        margin:0 10px;
        min-width:30px;
        height:35px;
    }
    #navigation_controls input{
        max-width:30px;
        height:100%;
        margin:0;
        padding:0;
        text-align:center;
        outline:none;
        border:none;
        width: 30px;
        cursor: pointer;
    }
    #navigation_controls label{
        display:flex;
        align-items:center;
        margin:0;
        padding:0;
        height: 40px;
        width: 80px;
        background-color:white;
        outline:none;
        border:1px solid #eee;
        padding:5px;
        position:relative;
        text-align: center;
        color:black;
        border-radius: 5px;
    }
    #totalPageCount{
        /* color:white; */
        margin-left:10px
    }
</style>

@stop

@section('content')

@include('includes.main.sub_menu')


<div class="main-content-wrapper">
    @if($document->contentVisible())
    <div class="main-image-container" id="image-container"
        >

        <div id="my_pdf_viewer" oncontextmenu="return false">
            <div id="pdf_controllers">

                <div id="navigation_controls">
                    <button id="go_previous" title="previous page"><i class="fas fa-angle-double-left"></i></button>
                    <label>
                        <input id="current_page" value="1" type="text" />
                        /<span id="totalPageCount">0</span>
                    </label>
                    <button id="go_next" title="next page"><i class="fas fa-angle-double-right"></i></button>
                </div>

                <div id="zoom_controls">
                    <button id="zoom_in" title="zoom in"><i class="fas fa-search-plus"></i></button>
                    <button id="zoom_out" title="zoom out"><i class="fas fa-search-minus"></i></button>
                </div>
            </div>

            <div id="canvas_container">
                <canvas id="pdf_renderer"></canvas>
            </div>


        </div>

    </div>
    @else
    @include('pages.main.content.common.denied_img', ['text'=>'document'])
    @endif
    <hr />
    <div class="container">
        <div class="row action-button-row">
            <div class="col-sm-12">
                <div class="info-content">
                    <h5>{{$document->title}}</h5>
                </div>
            </div>
            <div class="col-sm-auto">
                <div class="info-content">
                    {{-- <p><span id="view_count">{{$document->views}} views</span> <span
                            id="favourite_count">{{$document->favourites}} favourites</span></p> --}}
                    <p><span id="view_count">{{$document->views}} views</span> </p>
                </div>
            </div>
            <div class="col-lg-5 col-md-6 col-sm-12 action-button-wrapper">
                <a href="{{route('content_document_makeFavourite',$document->uuid)}}"
                    class="action-btn make-favourite-button">
                    @if($document->markedFavorite())
                    <i class="fas fa-heart-broken"></i> 
                    @else
                    <i class="far fa-heart"></i>
                    @endif
                </a>
                <button class="action-btn report-button" data-toggle="modal" data-target="#reportModal"><i
                        class="far fa-flag"></i> </button>
            </div>
        </div>
    </div>
    @if($document->description_unformatted)
    <hr />
    <div class="container info-container info-major-content">
        <h6>Description</h6>
        {!!$document->description!!}
    </div>
    @endif
    <hr />
    <div class="container info-container">
        @if($document->deity)<p>Deity : <b>{{$document->deity}}</b></p>@endif
        @if($document->languages->count()>0)
        <p>Language : 
        @foreach ($document->languages as $languages)
            <b>{{$languages->name}}</b>,
        @endforeach
        </p>
        @endif
        <p>Number of Pages : <b>{{$document->page_number}}</b></p>
        <p>Uploaded : <b>{{$document->time_elapsed()}}</b></p>
        @if(count($document->getTagsArray())>0)
        <p>Tags : 
        @foreach($document->getTagsArray() as $tag)
        <span class="hashtags">#{{$tag}}</span>
        @endforeach
        </p>
        @endif
    </div>
    

    @include('pages.main.content.common.request_access_modal')

    @include('pages.main.content.common.report_modal', ['text'=>'document'])

</div>

@stop

@section('javascript')
<script src="http://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.0.943/pdf.min.js"></script>
<script src="{{ asset('main/js/plugins/just-validate.production.min.js') }}"></script>
<script src="{{ asset('main/js/plugins/axios.min.js') }}"></script>

@include('pages.main.content.common.search_js', ['search_url'=>route('content_search_query')])

@include('pages.main.content.common.img_preview_js', ['obj'=>$documentAccess])

<script>
$(function() {
    $('[data-toggle="tooltip"]').tooltip()
})
</script>

@include('pages.main.content.common.request_access_form_js', ['url'=>route('content_document_requestAccess', $document->uuid)])
@include('pages.main.content.common.report_form_js', ['url'=>route('content_document_report', $document->uuid)])


@include('pages.main.content.common.reload_captcha_js')

@if($document->contentVisible())
<script>

    
    var myState = {
        pdf: null,
        currentPage: 1,
        zoom: 1
    }
    
    pdfjsLib.getDocument('{{route('content_document_file',$document->uuid)}}').then((pdf) => {
    
        myState.pdf = pdf;
        document.getElementById("totalPageCount").innerHTML = myState.pdf._pdfInfo.numPages;
        render();

    });

    function render() {
        myState.pdf.getPage(myState.currentPage).then((page) => {
        
            var canvas = document.getElementById("pdf_renderer");
            var ctx = canvas.getContext('2d');
    
            var viewport = page.getViewport(myState.zoom);

            canvas.width = viewport.width;
            canvas.height = viewport.height;
        
            page.render({
                canvasContext: ctx,
                viewport: viewport
            });
        });
    }

    

    document.getElementById('go_previous').addEventListener('click', (e) => {
        if(myState.pdf == null || myState.currentPage == 1) return false;
        myState.currentPage -= 1;
        document.getElementById("current_page").value = myState.currentPage;
        render();
    });

    document.getElementById('go_next').addEventListener('click', (e) => {
        if(myState.pdf == null || myState.currentPage >= myState.pdf._pdfInfo.numPages) return false;
        myState.currentPage += 1;
        document.getElementById("current_page").value = myState.currentPage;
        render();
    });

    document.getElementById('current_page').addEventListener('keypress', (e) => {
        if(myState.pdf == null) return;
        
        // Get key code
        var code = (e.keyCode ? e.keyCode : e.which);
        
        // If key code matches that of the Enter key
        if(code == 13) {
            var desiredPage = 
            document.getElementById('current_page').valueAsNumber;
                                
            if(desiredPage >= 1 && desiredPage <= myState.pdf._pdfInfo.numPages) {
                myState.currentPage = desiredPage;
                document.getElementById("current_page").value = desiredPage;
                render();
            }
        }
    });

    document.getElementById('zoom_in').addEventListener('click', (e) => {
        if(myState.pdf == null) return;
        myState.zoom += 0.1;
        render();
    });

    document.getElementById('zoom_out').addEventListener('click', (e) => {
        if(myState.pdf == null) return;
        myState.zoom -= 0.1;
        render();
    });

</script>

@endif

@include('pages.main.content.common.dashboard_search_handler', ['search_url'=>route('content_dashboard')])


@stop