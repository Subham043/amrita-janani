@extends('layouts.main.index')

@section('css')
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.1/css/all.css"
        integrity="sha384-vp86vTRFVJgpjF9jiIGPEEqYqlDwgyBgEF109VFjmqGmIY/Y4HV4d3Gp2irVfcrp" crossorigin="anonymous">
<style>
    .contact-form__one .contact-input .contact-inner textarea {
        border-radius: 25px;
        border: 1px solid #ddd;
        padding: 10px 20px;
        width: 100%;
        font-style: italic;
    }

    .btn-captcha{
        background: #ffcc00;
        color: #000;
        border-radius: 5px;
        padding: 5px 15px;
        border: 1px solid #ddd;
        font-size: 10px;
        cursor: pointer;
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
                                <p>Devipuram<br/>
                                Via Nidanam Doddi, Sabbavaram (M),<br/>
                                Visakhapatnam District,<br/>
                                Andhra Pradesh - 531035<br/>
                                India</p>
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
                                <p><a href="tel:+919440845333">+91 94408 45333</a><br>
                                    <a href="tel:+918340005500">+91 83400 05500</a></p>
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
                                <p><a href="mailto:admin@amrita-janani.org">admin@amrita-janani.org</a></p>
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
                                <form id="contactForm">
                                    <div class="contact-form__one row">
                                        <div class="contact-input col-lg-6">
                                            <label for="Name">Name</label>
                                            <div class="contact-inner">
                                                <input name="name" id="name" type="text" placeholder="Enter you name">
                                            </div>
                                        </div>

                                        <div class="contact-input col-lg-6">
                                            <label for="Phone">Phone</label>
                                            <div class="contact-inner">
                                                <input name="phone" id="phone" type="text" placeholder="Your Phone Number (Optional)">
                                            </div>
                                        </div>

                                        <div class="contact-input col-lg-6">
                                            <label for="Email">Email</label>
                                            <div class="contact-inner">
                                                <input name="email" id="email" type="email" placeholder="Your Email Address ">
                                            </div>
                                        </div>

                                        <div class="contact-input col-lg-6">
                                            <label for="subject">Subject</label>
                                            <div class="contact-inner">
                                                <input name="subject" id="subject" type="text" placeholder="Enter you subject">
                                            </div>
                                        </div>
                                        
                                        <div class="contact-input col-lg-12">
                                            <label for="subject">Message</label>
                                            <div class="contact-inner">
                                                <textarea name="message" id="message" cols="30" rows="10" placeholder="Enter you message"></textarea>
                                            </div>
                                        </div>
                                        
                                        <div class="contact-input col-lg-12">
                                            <label for="captcha">Captcha</label>
                                            <div class="contact-inner">
                                                <div class="d-flex" style="align-items:center;">
                                                    <p id="captcha_container">{!!captcha_img()!!} </p>
                                                    <span class="btn-captcha" onclick="reload_captcha()" style="margin-left:10px;" title="reload captcha"><i class="fas fa-redo"></i></span>
                                                </div>
                                                <input name="captcha" id="captcha" type="text" placeholder="Enter you captcha">
                                            </div>
                                        </div>

                                        <div class="submit-input col-lg-12">
                                            <button class="submit-btn" type="submit" id="SubmitBtn">Submit</button>
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

@section('javascript')
<script src="{{ asset('main/js/plugins/just-validate.production.min.js') }}"></script>
<script src="{{ asset('main/js/plugins/axios.min.js') }}"></script>

<script type="text/javascript">

const validationModal = new JustValidate('#contactForm', {
    errorFieldCssClass: 'is-invalid',
});

validationModal
.addField('#name', [
{
    rule: 'required',
    errorMessage: 'Name is required',
},
{
    rule: 'customRegexp',
    value: /^[a-zA-Z\s]*$/,
    errorMessage: 'Name is invalid',
},
])
.addField('#captcha', [
{
    rule: 'required',
    errorMessage: 'Captcha is required',
}
])
.addField('#email', [
{
    rule: 'required',
    errorMessage: 'Email is required',
},
{
    rule: 'email',
    errorMessage: 'Email is invalid!',
},
])
.addField('#phone', [
{
    rule: 'customRegexp',
    value: /^[0-9]*$/,
    errorMessage: 'Phone is invalid',
},
])
.addField('#subject', [
{
    rule: 'required',
    errorMessage: 'Subject is required',
},
{
    rule: 'customRegexp',
    value: /^[a-z 0-9~%.:_\@\-\/\(\)\\\#\;\[\]\{\}\$\!\&\<\>\'\r\n+=,]+$/i,
    errorMessage: 'Subject is invalid',
},
])
.addField('#message', [
{
    rule: 'required',
    errorMessage: 'Message is required',
},
{
    rule: 'customRegexp',
    value: /^[a-z 0-9~%.:_\@\-\/\(\)\\\#\;\[\]\{\}\$\!\&\<\>\'\r\n+=,]+$/i,
    errorMessage: 'Message is invalid',
},
])
.onSuccess(async (event) => {
    event.target.preventDefault;
    const errorToast = (message) =>{
        iziToast.error({
            title: 'Error',
            message: message,
            position: 'bottomCenter',
            timeout:7000
        });
    }
    const successToast = (message) =>{
        iziToast.success({
            title: 'Success',
            message: message,
            position: 'bottomCenter',
            timeout:6000
        });
    }
    var submitBtn = document.getElementById('SubmitBtn')
    submitBtn.innerHTML = `
        <span class="d-flex align-items-center">
            <span class="spinner-border flex-shrink-0" role="status">
                <span class="visually-hidden"></span>
            </span>
            <span class="flex-grow-1 ms-2">
                &nbsp; Submiting...
            </span>
        </span>
        `
    submitBtn.disabled = true;
    try {
        var formData = new FormData();
        formData.append('name',document.getElementById('name').value)
        formData.append('subject',document.getElementById('subject').value)
        formData.append('email',document.getElementById('email').value)
        formData.append('phone',document.getElementById('phone').value)
        formData.append('message',document.getElementById('message').value)
        formData.append('captcha',document.getElementById('captcha').value)
        formData.append('refreshUrl','{{URL::current()}}')
        const response = await axios.post('{{route('contact_ajax')}}', formData)
        successToast(response.data.message)
        event.target.reset()
        await reload_captcha()
    } catch (error) {
        if(error?.response?.data?.form_error?.name){
            errorToast(error?.response?.data?.form_error?.name[0])
        }
        if(error?.response?.data?.form_error?.subject){
            errorToast(error?.response?.data?.form_error?.subject[0])
        }
        if(error?.response?.data?.form_error?.email){
            errorToast(error?.response?.data?.form_error?.email[0])
        }
        if(error?.response?.data?.form_error?.phone){
            errorToast(error?.response?.data?.form_error?.phone[0])
        }
        if(error?.response?.data?.form_error?.message){
            errorToast(error?.response?.data?.form_error?.message[0])
        }
        if(error?.response?.data?.form_error?.captcha){
            errorToast(error?.response?.data?.form_error?.captcha[0])
        }
        if(error?.response?.data?.error){
            errorToast(error?.response?.data?.error)
        }
    } finally{
        submitBtn.innerHTML =  `
            Submit
            `
        submitBtn.disabled = false;
    }
})

</script>

@include('includes.main.captcha')

@stop