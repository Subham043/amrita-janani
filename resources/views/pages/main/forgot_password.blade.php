@extends('layouts.main.auth')

@section('css')
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.1/css/all.css"
        integrity="sha384-vp86vTRFVJgpjF9jiIGPEEqYqlDwgyBgEF109VFjmqGmIY/Y4HV4d3Gp2irVfcrp" crossorigin="anonymous">
<style>
    .just-validate-error-label, .invalid-message{
        color: #fff !important;
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

<div class="form-items">
    <h3>Forgot Password</h3>
    <p>To reset your password, enter the email address you use to sign in to Amrita Janani.</p>
    <form action="{{route('forgot_password_request')}}" method="post" id="loginForm">
        @csrf
        <div class="mb-2">
            <input class="form-control" type="email" name="email" id="email" placeholder="E-mail Address" value="{{old('email')}}" required>
            @error('email') 
                <div class="invalid-message">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-2">
          <div class="d-flex" style="align-items:center;">
              <p id="captcha_container">{!!captcha_img()!!} </p>
              <span class="btn-captcha" onclick="reload_captcha()" style="margin-left:10px;" title="reload captcha"><i class="fas fa-redo"></i></span>
          </div>
          <input class="form-control" type="text" name="captcha" id="captcha" placeholder="Captcha" required>
          @error('captcha') 
              <div class="invalid-message">{{ $message }}</div>
          @enderror
        </div>
        <div class="form-button">
            <button id="submitBtn" type="submit" class="ibtn">Submit</button> <a href="{{route('signin')}}">Remember your password?</a>
        </div>
    </form>
</div>





@stop

@section('javascript')
<script src="{{ asset('admin/js/pages/just-validate.production.min.js') }}"></script>
<script src="{{ asset('main/js/plugins/axios.min.js') }}"></script>
<script type="text/javascript">

// initialize the validation library
const validation = new JustValidate('#loginForm', {
      errorFieldCssClass: 'is-invalid',
      focusInvalidField: true,
      lockForm: true,
});
// apply rules to form fields
validation
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
  .addField('#captcha', [
    {
      rule: 'required',
      errorMessage: 'Captcha is required',
    }
  ])
  .onSuccess((event) => {
    event.target.submit();
  });
</script>
@include('includes.main.captcha')
@stop