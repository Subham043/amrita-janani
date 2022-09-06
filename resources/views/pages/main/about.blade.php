@extends('layouts.main.index')

@section('css')
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.1/css/all.css"
        integrity="sha384-vp86vTRFVJgpjF9jiIGPEEqYqlDwgyBgEF109VFjmqGmIY/Y4HV4d3Gp2irVfcrp" crossorigin="anonymous">
<style>
.about-tai-content img{
    width: 50%;
    object-fit: contain;
    margin: 0 15px 15px 15px;
}
.about-tai-content p{
    font-size: 17px;
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

@include('includes.main.breadcrumb')

<!-- ======== Church About Area Start ========== -->
<div class="church-about-area section-space--ptb_120">
    <div class="container">
        <div class="row ">
            @if($about->PageContentModel->count()>0)
            @foreach ($about->PageContentModel as $item)    
            <div class="col-lg-12 mb-5">
                <div class="about-tai-content">
                    <div class="section-title-wrap">
                        <h3 class="section-title--two  left-style mb-30">{{$item->heading}}</h3>
                    </div>
                    <div>
                        @if($item->image)
                        <img src="{{asset('storage/upload/pages/'.$item->image)}}" class="{{$item->image_position==1?'img-fluid float-left':'img-fluid float-right'}}" alt="About Images">
                        @endif
                        <div class="section-title-wrap" style="display:inline">
                            {!!$item->description!!}
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

{{-- <!-- ======== Church About Area Start ========== -->
<div class="church-about-area   section-space--pt_60">
    <div class="container">
        <div class="row ">
            <div class="col-lg-12">
                <div class="about-tai-content">
                    <div class="section-title-wrap">
                        <h3 class="section-title--two  left-style mb-30">GURUJI</h3>
                    </div>
                    <div>
                        <img src="{{ asset('main/images/hero/banner7.jpg')}}" class="img-fluid float-right" alt="About Images">
                        <div class="section-title-wrap" style="display:inline">
                            <p>Dr. N. Prahlada Sastry (Sri Amritananda Natha Saraswati) was born in Vishakapatnam (in Andhra Pradesh) to Sri Narasimha Rao and Smt. Lakshminarasamma. His disciples affectionately refer to him as Guruji. Guruji started his spiritual quest at a very young age when he was blessed with many divine experiences early in his childhood; His young mind was teeming with questions in search of the truth. The stage was set at a very tender age for his spiritual exploration that was to intensify later in his life.</p>
                            <p>He got his master’s degree (MSc.) in Nuclear Physics from Andhra University and obtained his doctorate in physics from the Bombay University. Guruji worked for 20+ as a scientist with the Tata Institute of Fundamental Research (TIFR) in Bombay. In 1977, while struggling to justify his association with a defence project, he had an intense spiritual experience at a Balaji temple in Hyderabad (Birla Temple, Hyderabad). This felt like his first initiation from the almighty Herself. It reminded him of his many spiritual visions as a child and his mind was pondering in search of the truth within himself. Around this time, he moved to Zambia as a professor on a two-year contract. After Guruji returned back to India in 1981, he decided to leave his lucrative job at TIFR to come back to his hometown (Visakhapatnam) for rediscovering his spiritual roots. He received the Sri Vidya Poorna Deeksha from Sri Swaprakashananda Natha Thirtha Avadhuta of Anakapalli.</p>
                            <p>Subsequently, he started receiving direct experiential tutelage from the Goddess Saraswathi and Bala Tripurasundari. The Divine Mother prompted Guruji to embark on building the first ever Sri Chakra Meru Temple in Devipuram (near Anakapalle, Andhra Pradesh). In this temple complex, one can see life size Khadgamala Goddesses, the Kamakhya Peetham and a Siva temple. Devipuram is one of the important Shakti Peethams.</p>
                            <p>Guruji had visions of the Devi as a sixteen-year-old girl. With Her blessings, he built the Kamakhya Peetam on the hillock and a Siva temple on the peak, in 1984. The construction of the Sri Meru Nilayam in Devipuram was started in 1985. Built covering an area of 108 feet wide, the temple has 3 levels and stands 54 feet tall. The temple has the idols of all the Devis described in the Devi Khadgamala Stotram. The temple construction was completed in 1994 and the Kumbhabhishekam was performed with great pomp and piety. This temple is unique in allowing the devotees to perform puja to the Devi themselves, without any distinction.</p>
                            <p>Guruji made the teaching of Sri Vidya an essential part of his mission and strongly believed that everyone regardless of caste, creed, religion, nationality or gender should have access to this Vidya. Guruji left no stone unturned in demystifying the complex rituals, creating easy formats for everyone to understand and practice. Guruji also started many social empowerment programs to help the society at large.</p>
                            <p>With numerous loving disciples all over the world, Guruji and his wife, Srimati Annapurnamba (lovingly known as Guruji Amma) have dedicated their lives to the service of the people.</p>
                            <p>Guruji was an accomplished researcher, an evolved spiritual master and a successful social worker. He always had the agility and spontaneity of a child in all his endeavours.</p>
                            <p>In October 2015, Guruji merged with the Divine Mother leaving behind a great legacy.</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<!-- ======== Church About Area End ========== -->

<!-- ======== Church About Area Start ========== -->
<div class="church-about-area  section-space--pt_60 section-space--pb_120">
    <div class="container">
        <div class="row ">
            <div class="col-lg-12">
                <div class="about-tai-content">
                    <div class="section-title-wrap">
                        <h3 class="section-title--two  left-style mb-30">DEVIPURAM</h3>
                    </div>
                    <div>
                        <img src="{{ asset('main/images/hero/banner8.jpg')}}" class="img-fluid float-left" alt="About Images" >
                        <div class="section-title-wrap" style="display:inline">
                            <p>Like a jewel resting in the bosom of the green hills all around, Devipuram is nestled amidst the folds of the Eastern Ghats, near Visakhapatnam, Andhra Pradesh. Devipuram has developed into a global center for Sri Vidya and Mother worship, centered on the Sri Meru temple, which – at 108 feet wide and 54 feet high – remains the largest Maha Meru in the world. Sri Meru nilayam is a unique three-dimensional projection of the sacred yantra known as Sri Chakra, which is central to Sri Vidya Upasana (an ancient and intricate form of Tantric Shakta worship).</p>
                            <p>The temple is the divine abode of 108 life-sized icons of the Goddesses of the Khadgamala Stotram, presided over by the thousand-eyed Lalita Devi called Sahasrakshi Rajarajeshwari Devi. For the first time, you can physically see the Khadgamala deities, actually sit inside the Sri Chakra and meditate, do archana, and perform abhishekam to any Goddess, whose blessings you desire.</p>
                            <p>1983, when he received the place where the temple stands today. After coming here, he saw the Goddess of Creativity, Kamakhya Devi, in a triangular pit formation in a rock boulder nearby (now designated as the Kamakhya Peetham). She showed him all the various deity forms who receive puja in Sri Chakra, and gave him many experiences of the Kula pujas of yore, which she enjoys. He recorded these visions of yoginis and deities through the visual medium of sculpture. She guided him at every step in the building of the present temple. Guruji struggled for 11 years in this wilderness to bring this Sri Meru Nilayam temple into reality.</p>
                            <p>At Devipuram, one can also see the Panchabhootalingeshwara temple housing 1365 Sivalingas at Dakshavati, the Ananda Bhairava Linga at the Rajarajeswara (Siva) temple and the Karya Siddhi Ganapati temple.</p>
                            <p>The temple is unique in allowing devotees to perform puja to the Devi themselves, without distinction of caste or creed. Everyone is welcome to experience the wonders of the 1000 lingams, Womb of the Cosmos, Sri Chakra temple, Nature spirits and invite their divine energies into them.</p>
                        </div>
                    </div>
                </div>

            </div>
            
        </div>
    </div>
</div>
<!-- ======== Church About Area End ========== --> --}}

@stop