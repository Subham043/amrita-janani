@extends('layouts.main.index')

@section('css')
<style>
.btn-link {
    font-weight: 400;
    color: #96171c !important;
    text-decoration: none;
}
.btn-link:hover, .btn-link:focus{
    color:#96171c !important;
    text-decoration:none !important;
}
</style>
@stop

@section('content')

@include('includes.main.breadcrumb')

<!-- ======== Church About Area Start ========== -->
<div class="church-about-area section-space--ptb_120">
    <div class="container">
        <div class="row ">
            <div class="col-lg-6">
                <div class="about-tai-content">
                    <div class="accordion" id="accordionExample1">
                        <div class="card">
                            <div class="card-header" id="headingOne">
                                <h2 class="mb-0">
                                    <button class="btn btn-link btn-block text-left" type="button"
                                        data-toggle="collapse" data-target="#collapseOne" aria-expanded="true"
                                        aria-controls="collapseOne">
                                        Why do I need to register to look at the content?
                                    </button>
                                </h2>
                            </div>

                            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne"
                                data-parent="#accordionExample1">
                                <div class="card-body">
                                    The process of registration is only to improve the user experience. Once registered,
                                    the user gets a dashboard where she/he can keeep track of the topic of interest.
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" id="headingTwo">
                                <h2 class="mb-0">
                                    <button class="btn btn-link btn-block text-left collapsed" type="button"
                                        data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false"
                                        aria-controls="collapseTwo">
                                        Why do you need my e-mail ID?
                                    </button>
                                </h2>
                            </div>
                            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo"
                                data-parent="#accordionExample1">
                                <div class="card-body">
                                    This is only to help the Admin to get in touch with you, where required w.r.t your
                                    account.
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" id="headingThree">
                                <h2 class="mb-0">
                                    <button class="btn btn-link btn-block text-left collapsed" type="button"
                                        data-toggle="collapse" data-target="#collapseThree" aria-expanded="false"
                                        aria-controls="collapseThree">
                                        I'm new to the teachings of Guruji. Can I start practicing based on the content
                                        available on this website?
                                    </button>
                                </h2>
                            </div>
                            <div id="collapseThree" class="collapse" aria-labelledby="headingThree"
                                data-parent="#accordionExample1">
                                <div class="card-body">
                                    The purpose of the repository is to make the teachings of Guruji accessible to all
                                    his disciples. It is in your best interest that you get in touch with Devipuram to
                                    undergo the necessary training instead of starting on your own. Contact details are
                                    provided in this website.
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" id="headingFour">
                                <h2 class="mb-0">
                                    <button class="btn btn-link btn-block text-left collapsed" type="button"
                                        data-toggle="collapse" data-target="#collapseFour" aria-expanded="false"
                                        aria-controls="collapseFour">
                                        I have some content which was taught by Guruji Amritananda. How do I share it on
                                        the website?
                                    </button>
                                </h2>
                            </div>
                            <div id="collapseFour" class="collapse" aria-labelledby="headingFour"
                                data-parent="#accordionExample1">
                                <div class="card-body">
                                    Users cannot directly upload any files. This is to make sure that the website
                                    doesn't get spammed with irrelevant content. Write to us and we will be happy to get
                                    in touch with you.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-lg-6">
                <div class="about-tai-content">
                    <div class="accordion" id="accordionExample2">
                        <div class="card">
                            <div class="card-header" id="headingFive">
                                <h2 class="mb-0">
                                    <button class="btn btn-link btn-block text-left" type="button"
                                        data-toggle="collapse" data-target="#collapseFive" aria-expanded="true"
                                        aria-controls="collapseFive">
                                        I have recently shared some content with your team, however I don't see it on
                                        the website. Why?
                                    </button>
                                </h2>
                            </div>

                            <div id="collapseFive" class="collapse show" aria-labelledby="headingFive"
                                data-parent="#accordionExample2">
                                <div class="card-body">
                                    Rest assured that the content is being looked into and processed. Only the relevant
                                    content will be hosted as it is in the interest of all the users. Get in touch with
                                    us in case you have further queries!
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" id="headingSix">
                                <h2 class="mb-0">
                                    <button class="btn btn-link btn-block text-left collapsed" type="button"
                                        data-toggle="collapse" data-target="#collapseSix" aria-expanded="false"
                                        aria-controls="collapseSix">
                                        Can I contribute some money towards Gurujis trust?
                                    </button>
                                </h2>
                            </div>
                            <div id="collapseSix" class="collapse" aria-labelledby="headingSix"
                                data-parent="#accordionExample2">
                                <div class="card-body">
                                    Contact Devipuram for the same.
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" id="headingSeven">
                                <h2 class="mb-0">
                                    <button class="btn btn-link btn-block text-left collapsed" type="button"
                                        data-toggle="collapse" data-target="#collapseSeven" aria-expanded="false"
                                        aria-controls="collapseSeven">
                                        Some features are not working as expected?
                                    </button>
                                </h2>
                            </div>
                            <div id="collapseSeven" class="collapse" aria-labelledby="headingSeven"
                                data-parent="#accordionExample2">
                                <div class="card-body">
                                    Please write to us through the contact page and the information will be passed on to
                                    the relevant team.
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" id="headingEight">
                                <h2 class="mb-0">
                                    <button class="btn btn-link btn-block text-left collapsed" type="button"
                                        data-toggle="collapse" data-target="#collapseEight" aria-expanded="false"
                                        aria-controls="collapseEight">
                                        I have some feedback about this portal?
                                    </button>
                                </h2>
                            </div>
                            <div id="collapseEight" class="collapse" aria-labelledby="headingEight"
                                data-parent="#accordionExample2">
                                <div class="card-body">
                                    Please write us through the contact page and the information will be passed on to
                                    the relevant team.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>
<!-- ======== Church About Area End ========== -->



@stop