@extends('layouts.main.index')

@section('css')
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.1/css/all.css"
    integrity="sha384-vp86vTRFVJgpjF9jiIGPEEqYqlDwgyBgEF109VFjmqGmIY/Y4HV4d3Gp2irVfcrp" crossorigin="anonymous">
<link rel="stylesheet" href="{{ asset('admin/css/image-previewer.css')}}" type="text/css" />
<link rel="stylesheet" href="{{ asset('main/css/content.css') }}">

<style>
    .main-content-wrapper{
        width: 100%;
        max-width: 100%;
    }

    .main-content-wrapper .main-image-container{
        /* Add the blur effect */
        /* filter: blur(8px);
        -webkit-filter: blur(8px); */
        /* Full height */
        min-height: 75vh;
        /* Center and scale the image nicely */
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
        position: relative;
    }

    .main-content-wrapper .main-image-container .blur-bg{
        width:100%;
        height:100%;
        background-color: rgba(255, 255, 255, 0.4);
        -webkit-backdrop-filter: blur(15px);
        backdrop-filter: blur(15px);
        padding:20px;
        display:grid;
        place-items:center;
        position:absolute;
        top:0;
        left:0;
        z-index: 3;
    }

    .main-content-wrapper .main-image-container img{
        max-width:100%;
        object-fit:contain;
        height:400px;
        box-shadow: 0px 5px 11px 4px #222;
    }
</style>
@stop

@section('content')

@include('includes.main.sub_menu')


<div class="main-content-wrapper">
    <div class="main-image-container" id="image-container" style="background-image:url({{asset('storage/upload/images/'.$image->image)}})">
        <div class="blur-bg">
            <img src="{{asset('storage/upload/images/'.$image->image)}}" />
        </div>
    </div>
    <hr/>
    <div class="container">
    </div>
</div>

@stop

@section('javascript')
<script src="{{ asset('admin/js/pages/img-previewer.min.js') }}"></script>
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
@stop