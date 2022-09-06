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
            <div class="col-lg-12 mt-5">
                <div class="mission-wrap mr-lg-5">
                    <div class="section-title-wrap text-left">
                        <h5 class="section-title-normal mb-30">Terms and Conditions:</h5>
                    </div>

                    <div class="target-content">
                        <p>The information on this website is intended purely for private and non-commercial use.</p>
                        <p>Commercial use of any information (full or partial), provided in this website without prior consent of Devipuram Trust® is strictly prohibited.</p>
                        <p>All future communications with you will be made to the email ID provided during the registration.</p>
                        <p>AmritaJanani holds all the rights to revoke/reject access to any user.</p>
                    </div>

                </div>
            </div>
            <div class="col-lg-12 mt-5">
                <div class="mission-wrap mr-lg-5">
                    <div class="section-title-wrap text-left">
                        <h5 class="section-title-normal mb-30">Privacy Policy:</h5>
                    </div>

                    <div class="target-content">
                        <p>We value your privacy.</p>
                        <p>The information shared by you to create an account will only be used by AmritaJanani and Devipuram teams to communicate with you on the relevant topics.</p>
                        <p>The information provided by you will not be shared with any third-party individual or entity for any commercial or non-commercial purposes.</p>
                    </div>

                </div>
            </div>
            
        </div>
    </div>
</div>
<!--=========== Causes Details Area End ==========-->




@stop