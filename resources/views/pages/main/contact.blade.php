@extends('layouts.main.index')

@section('css')
<style>
    .contact-form__one .contact-input .contact-inner textarea {
        border-radius: 25px;
        border: 1px solid #ddd;
        padding: 10px 20px;
        width: 100%;
        font-style: italic;
    }
</style>
@stop

@section('content')

@include('includes.main.breadcrumb')

<div class="contact-page-wrapper section-space--pt_120">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="single-contact-info">
                            <div class="contact-icon">
                                <i class="flaticon-placeholder"></i>
                            </div>
                            <div class="contact-info">
                                <h4>Address</h4>
                                <p>Demo address 72/3 Dome <br>
                                city. USA</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="single-contact-info">
                            <div class="contact-icon">
                                <i class="flaticon-call"></i>
                            </div>
                            <div class="contact-info">
                                <h4>Phone</h4>
                                <p><a href="tel:01234567">+12 333 658 66 </a><br>
                                    <a href="tel:01234567">+12 366 666 66</a></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="single-contact-info">
                            <div class="contact-icon">
                                <i class="flaticon-paper-plane-1"></i>
                            </div>
                            <div class="contact-info">
                                <h4>Mail</h4>
                                <p><a href="#">demo@mail.com</a>
                                    <br> <a href="#"> mail.democo.info</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="contact-form-area section-space--ptb_120">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-12">
                            <div class="contact-form-wrap ml-lg-5">
                                <h3 class="title mb-40">Get In Touch With Us</h3>
                                <form id="contact-form" action="https://hasthemes.com/file/mail.php" method="post">
                                    <div class="contact-form__one row">
                                        <div class="contact-input col-lg-6">
                                            <label for="Name">Name</label>
                                            <div class="contact-inner">
                                                <input name="con_name" type="text" placeholder="Enter you name">
                                            </div>
                                        </div>

                                        <div class="contact-input col-lg-6">
                                            <label for="Phone">Phone</label>
                                            <div class="contact-inner">
                                                <input name="con_phone" type="text" placeholder="Your Phone Number">
                                            </div>
                                        </div>

                                        <div class="contact-input col-lg-6">
                                            <label for="Email">Email</label>
                                            <div class="contact-inner">
                                                <input name="con_email" type="email" placeholder="Your Email Address ">
                                            </div>
                                        </div>

                                        <div class="contact-input col-lg-6">
                                            <label for="subject">Subject</label>
                                            <div class="contact-inner">
                                                <input name="con_subject" type="text" placeholder="Enter you subject">
                                            </div>
                                        </div>
                                        
                                        <div class="contact-input col-lg-12">
                                            <label for="subject">Message</label>
                                            <div class="contact-inner">
                                                <textarea name="con_message" id="" cols="30" rows="10" placeholder="Enter you message"></textarea>
                                            </div>
                                        </div>

                                        <div class="submit-input col-lg-12">
                                            <button class="submit-btn" type="submit">Submit</button>
                                            <p class="form-messege"></p>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


@stop