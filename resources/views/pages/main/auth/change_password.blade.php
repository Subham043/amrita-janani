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
                    <div class="row align-items-center">
                        <div class="col-lg-12">
                            <div class="contact-form-wrap ml-lg-5">
                                <h3 class="title mb-40">Change Profile Password</h3>
                                <form id="contactForm">
                                    <div class="contact-form__one row">
                                        <div class="contact-input col-lg-12">
                                            <label for="opassword">Old Password</label>
                                            <div class="contact-inner">
                                                <input name="opassword" id="opassword" type="password" placeholder="Enter current password">
                                            </div>
                                        </div>

                                        <div class="contact-input col-lg-12">
                                            <label for="password">New Password</label>
                                            <div class="contact-inner">
                                                <input name="password" id="password" type="password" placeholder="Enter new password">
                                            </div>
                                        </div>

                                        <div class="contact-input col-lg-12">
                                            <label for="cpassword">Confirm Password</label>
                                            <div class="contact-inner">
                                                <input name="cpassword" id="cpassword" type="password" placeholder="Confirm password">
                                            </div>
                                        </div>

                                        
                                        <div class="submit-input col-lg-12">
                                            <button class="submit-btn" type="submit" id="SubmitBtn">Update</button>
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
.addField('#password', [
    {
      rule: 'required',
      errorMessage: 'Password is required',
    }
  ])
  .addField('#cpassword', [
    {
      rule: 'required',
      errorMessage: 'Confirm Password is required',
    },
    {
        validator: (value, fields) => {
        if (fields['#password'] && fields['#password'].elem) {
            const repeatPasswordValue = fields['#password'].elem.value;

            return value === repeatPasswordValue;
        }

        return true;
        },
        errorMessage: 'Password and Confirm Password must be same',
    },
  ])
  .addField('#opassword', [
    {
      rule: 'required',
      errorMessage: 'Old Password is required',
    }
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
        formData.append('opassword',document.getElementById('opassword').value)
        formData.append('password',document.getElementById('password').value)
        formData.append('cpassword',document.getElementById('cpassword').value)
        const response = await axios.post('{{route('change_profile_password')}}', formData)
        successToast(response.data.message)
        event.target.reset()
    } catch (error) {
        if(error?.response?.data?.form_error?.opassword){
            errorToast(error?.response?.data?.form_error?.opassword[0])
        }
        if(error?.response?.data?.form_error?.password){
            errorToast(error?.response?.data?.form_error?.password[0])
        }
        if(error?.response?.data?.form_error?.cpassword){
            errorToast(error?.response?.data?.form_error?.cpassword[0])
        }
        if(error?.response?.data?.error){
            errorToast(error?.response?.data?.error)
        }
    } finally{
        submitBtn.innerHTML =  `
            Update
            `
        submitBtn.disabled = false;
    }
})

</script>

@include('pages.main.content.common.search_js', ['search_url'=>route('content_search_query')])
@include('pages.main.content.common.dashboard_search_handler', ['search_url'=>route('content_dashboard')])
@stop