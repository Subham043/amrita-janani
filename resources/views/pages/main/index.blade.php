@extends('layouts.main.index')

@section('css')
<style>
.about-tai-content img{
    width: 40%;
    object-fit: contain;
    margin: 0 15px 15px 15px;
}
.about-tai-content p{
    text-align: justify;
}

.float-left{ float: left; }
.float-right{ float: right; }

@media only screen and (max-width: 767px) {
    .float-left{ float: none !important; }
    .float-right{ float: none !important; }
    .about-tai-content img{
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
<div class="hero-area hero-style-02 christian-hero-bg-two bg-overlay-black">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="hero-content text-center">
                    <h1 class="text-white">Mere Ganpati Guru <br>
                    Ganesh Ji Tusi Aa Jao.</h1>

                        <!-- <div class="ht-btn-area section-space--mt_60"><a href="#" class="hero-btn">Explore</a></div> -->

                </div>
            </div>
        </div>
    </div>
</div>
<!-- ======== Hero Area End ========== -->

<!-- ======== Church About Area Start ========== -->
<div class="church-about-area  section-space--pt_120">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="about-tai-content">
                    <img src="{{ asset('main/images/hero/banner7.jpg')}}" class="img-fluid float-left" alt="About Images">
                    <div class="section-title-wrap" style="display:inline">
                        <h3 class="section-title--two  left-style mb-30">What is Amrita Janani?</h3>
                        <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the middle of text.</p>
                        <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised</p>
                        <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised</p>
                        <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the middle of text.</p>
                        <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised</p>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<!-- ======== Church About Area End ========== -->

<!-- ======== Hindu Video Area Start ========== -->
<div class="hindu-video-area  section-space--ptb_120">
    <div class="container-fluid container-fluid--cp-100">
        <div class="hindu-video-bg hindu-video-section-pb bg-overlay-black border-radius-5">
            <div class="row">
                <div class="col-lg-8 ml-auto mr-auto">
                    <div class="video-content-wrap text-center">
                        <div class="icon">
                            <a href="https://www.youtube.com/watch?v=d7jAiAYusUg" class="video-link popup-youtube"><img src="{{ asset('main/images/icons/play-circle.png')}}" alt="Video Icon"></a>
                        </div>
                        <div class="content section-space--mt_80">
                            <h3 class="text-white mb-10">Best speech on religious life</h3>
                            <p class="text-white">On the other hand, we denounce with righteous indignation and dislike men who are so
                                beguiled and demoralized by the charms of pleasure of the moment</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ========  Hindu Video Area End ========== -->

@stop