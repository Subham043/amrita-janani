@extends('layouts.main.index')

@section('css')
<style>
.about-tai-content img{
    height:235px;
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
        height:auto;
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
<div class="church-about-area  section-space--pt_120  section-space--pb_90">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="about-tai-content">
                    <img src="{{ asset('main/images/hero/banner7.jpg')}}" class="img-fluid float-left" alt="About Images">
                    <div class="section-title-wrap" style="display:inline">
                        <h3 class="section-title--two  left-style mb-30">What is Amrita Janani?</h3>
                        <p>Amrita Janani is an online digital knowledge repository containing the teachings of Guruji Sri Amritananda Natha Saraswati of Devipuram, Vizag, India. The teachings are in the form of lectures, practice manuals, guided meditations, etc.</p>
                        <a href="{{route('about')}}" class="submit-btn">Learn More</a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="church-about-area  section-space--pb_90">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="about-tai-content">
                    <div class="section-title-wrap" style="display:inline">
                        <h3 class="section-title--two  left-style mb-30">How To Access Amrita Janani contents?</h3>
                        <p>To acces the contents, create a new account by clicking the Login/Signup button and entering your details along with a unique password in the "Register" section.</p>
                        <p>Click the Register button. An OTP will be sent to the registered email ID. Enter the OTP in the Verify Email page to activate the account.</p>
                        <p>Access Amrita Janani contents by logging in with the registered email ID and password in the "Login" section.</p>
                    </div>
                </div>

            </div>
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
                    <div class="video-content-wrap text-center">
                        <div class="icon">
                            <a href="https://www.youtube.com/watch?v=5UWwNpilnz0" class="video-link popup-youtube"><img src="{{ asset('main/images/icons/play-circle.png')}}" alt="Video Icon"></a>
                        </div>
                        <div class="content section-space--mt_80">
                            <h3 class="text-white mb-10">Who is Guruji Sri Amritananda Natha Saraswati</h3>
                            <p class="text-white">Learn more about Guruji Sri Amritananda Natha Saraswati from a part of the documentary on Guruji by renowned documentary filmmaker Raja Choudhury.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ========  Hindu Video Area End ========== -->

@stop