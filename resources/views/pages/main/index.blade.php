@extends('layouts.main.index')

@section('css')
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.1/css/all.css"
        integrity="sha384-vp86vTRFVJgpjF9jiIGPEEqYqlDwgyBgEF109VFjmqGmIY/Y4HV4d3Gp2irVfcrp" crossorigin="anonymous">
    <style>
        .about-tai-content img {
            height: 235px;
            object-fit: contain;
            margin: 0 15px 15px 15px;
        }

        .about-tai-content p {
            font-size: 17px;
            text-align: justify;
        }

        .float-left {
            float: left;
        }

        .float-right {
            float: right;
        }

        .section-space--pb_50 {
            padding-bottom: 50px;
        }

        @media only screen and (max-width: 767px) {
            .float-left {
                float: none !important;
            }

            .float-right {
                float: none !important;
            }

            .about-tai-content img {
                height: auto;
                width: 100%;
                object-fit: contain;
                margin: 0px;
                margin-bottom: 15px;
            }
        }
    </style>
@stop

@section('content')

    <!-- ======== Hero Area Start ========== -->
    <div class="hero-area hero-style-02 christian-hero-bg-two bg-overlay-black" style="background:url({{asset('storage/upload/banners/'.$bannerImage->image)}})">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="hero-content text-center">
                        <h1 class="text-white"><i>{{$bannerQuote->quote}}</i>
                        <br/><span style="font-size: 20px;"> - Guruji Amritananda Natha Saraswati</span></h1>

                        <!-- <div class="ht-btn-area section-space--mt_60"><a href="#" class="hero-btn">Explore</a></div> -->

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ======== Hero Area End ========== -->

    <!-- ======== Church About Area Start ========== -->
    <div class="church-about-area  section-space--pt_120  section-space--pb_50">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="about-tai-content">
                        <img src="{{ asset('main/images/hero/banner7.jpg') }}" class="img-fluid float-left"
                            alt="About Images">
                        <div class="section-title-wrap" style="display:inline">
                            <h3 class="section-title--two  left-style mb-30">What is Amrita Janani?</h3>
                            <p>Amrita Janani is an online digital knowledge repository containing the teachings of Guruji
                                Sri Amritananda Natha Saraswati of Devipuram, Vizag, India. The teachings are in the form of
                                lectures, practice manuals, guided meditations, etc.</p>
                            <div class="text-center">
                                <a href="{{ route('about') }}" class="submit-btn">Learn More</a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="church-about-area">
        <div class="container">
            <div class="row">
                @if ($home->PageContentModel->count() > 0)
                    @foreach ($home->PageContentModel as $item)
                        <div class="col-lg-12 mb-5">
                            <div class="about-tai-content">
                                <div class="section-title-wrap">
                                    <h3 class="section-title--two  left-style mb-30">{{ $item->heading }}</h3>
                                </div>
                                <div>
                                    @if ($item->image)
                                        <img src="{{ asset('storage/upload/pages/' . $item->image) }}"
                                            class="{{ $item->image_position == 1 ? 'img-fluid float-left' : 'img-fluid float-right' }}"
                                            alt="About Images">
                                    @endif
                                    <div class="section-title-wrap" style="display:inline">
                                        {!! $item->description !!}
                                    </div>
                                </div>
                            </div>

                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
    <!-- ======== Church About Area End ========== -->

    <!-- ======== Hindu Video Area Start ========== -->
    <div class="hindu-video-area  section-space--pb_120">
        <div class="container">
            <div class="hindu-video-bg hindu-video-section-pb bg-overlay-black border-radius-5">
                <div class="row">
                    <div class="col-lg-8 ml-auto mr-auto">
                        <a href="https://www.youtube.com/watch?v=5UWwNpilnz0" class="video-link popup-youtube">
                            <div class="video-content-wrap text-center">
                                <div class="icon">
                                    <img src="{{ asset('main/images/icons/play-circle.png') }}" alt="Video Icon">
                                </div>
                                <div class="content section-space--mt_80">
                                    <h3 class="text-white mb-10">Who is Guruji Sri Amritananda Natha Saraswati</h3>
                                    <p class="text-white">Learn more about Guruji Sri Amritananda Natha Saraswati from a
                                        part of the documentary on Guruji by renowned documentary filmmaker Raja Choudhury.
                                    </p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ========  Hindu Video Area End ========== -->

@stop
