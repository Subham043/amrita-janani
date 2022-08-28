@extends('layouts.main.index')

@section('css')
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.1/css/all.css"
    integrity="sha384-vp86vTRFVJgpjF9jiIGPEEqYqlDwgyBgEF109VFjmqGmIY/Y4HV4d3Gp2irVfcrp" crossorigin="anonymous">
<link rel="stylesheet" href="{{ asset('main/css/content.css') }}">
@stop

@section('content')

@include('includes.main.sub_menu')

@include('includes.main.breadcrumb')

<div class="contact-page-wrapper">

    <div class="contact-form-area section-space--ptb_90">
        <div class="container">
            <div class="contact-form-wrap ml-lg-5">
                <h3 class="title mb-40">Search History</h3>
            </div>

            <table class="table table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Search Query</th>
                        <th scope="col">DateTime</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if($search_history->count() > 0)
                    @foreach($search_history->items() as $key=>$value)
                    <tr>
                        <th scope="row">{{$key+1}}</th>
                        <td>{{$value->search}}</td>
                        <td>{{$value->created_at}}</td>
                        @if($value->screen==1)
                        <td><a target="_blank" href="{{route('content_dashboard')}}?search={{$value->search}}" class="btn btn-warning">View Search Results</a></td>
                        @elseif($value->screen==2)
                        <td><a target="_blank" href="{{route('content_audio')}}?search={{$value->search}}" class="btn btn-warning">View Search Results</a></td>
                        @elseif($value->screen==3)
                        <td><a target="_blank" href="{{route('content_document')}}?search={{$value->search}}" class="btn btn-warning">View Search Results</a></td>
                        @elseif($value->screen==4)
                        <td><a target="_blank" href="{{route('content_image')}}?search={{$value->search}}" class="btn btn-warning">View Search Results</a></td>
                        @else
                        <td><a target="_blank" href="{{route('content_video')}}?search={{$value->search}}" class="btn btn-warning">View Search Results</a></td>
                        @endif
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
            <div style="display:flex;justify-content:center;">
                {{ $search_history->links('pagination::bootstrap-4') }}
            </div>

        </div>
    </div>
</div>

@stop

@section('javascript')
<script src="{{ asset('main/js/plugins/axios.min.js') }}"></script>
@include('pages.main.content.common.search_js', ['search_url'=>route('content_search_query')])
@include('pages.main.content.common.dashboard_search_handler', ['search_url'=>route('content_dashboard')])
@stop
