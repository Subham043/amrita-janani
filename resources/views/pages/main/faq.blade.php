@extends('layouts.main.index')

@section('css')
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.1/css/all.css"
        integrity="sha384-vp86vTRFVJgpjF9jiIGPEEqYqlDwgyBgEF109VFjmqGmIY/Y4HV4d3Gp2irVfcrp" crossorigin="anonymous">
<style>
h5.section-title-normal{
    color:#96171c;
}
</style>
@stop

@section('content')

@include('includes.main.breadcrumb')

<!--=========== Causes Details Area Start ==========-->
<div class="causes-details-area section-space--pb_120 section-space--pt_70">
    <div class="container">
        <div class="row">
            @foreach ($faq as $key=>$value)    
            <div class="col-lg-12 mt-5">
                <div class="mission-wrap mr-lg-5">
                    <div class="section-title-wrap text-left">
                        <h5 class="section-title-normal mb-30">{{$key+1}}. {{$value->question}}</h5>
                    </div>

                    <div class="target-content">
                        <p>{{$value->answer}}</p>
                    </div>

                </div>
            </div>
            @endforeach
            
        </div>
    </div>
</div>
<!--=========== Causes Details Area End ==========-->




@stop