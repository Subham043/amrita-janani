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
    <h3>Get more things done with Loggin Amrita Janani.</h3>
    <p>Access to the most powerfull tool in amrita janani.</p>
    <div class="page-links">
        <a href="{{route('signin')}}" class="active">Login</a><a href="{{route('signup')}}">Register</a>
    </div>
    <form action="{{route('signin_authenticate')}}" method="post" id="loginForm">
      @csrf
    <div class="mb-2">
        <input class="form-control" type="email" name="email" id="email" placeholder="E-mail Address" value="{{old('email')}}" required>
        @error('email') 
            <div class="invalid-message">{{ $message }}</div>
        @enderror
        </div>
        <div class="mb-2">
        <input class="form-control" type="password" name="password" id="password" placeholder="Password" required>
        @error('password') 
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
        <input type="checkbox" id="chk1"><label for="chk1">Remmeber me</label>
        <div class="form-button">
            <button id="submitBtn" type="submit" class="ibtn">Login</button> <a href="{{route('forgot_password')}}">Forget password?</a>
        </div>
    </form>
    <!-- <div class="other-links">
        <span>Or login with</span><a href="#">Facebook</a><a href="#">Google</a><a href="#">Linkedin</a>
    </div> -->
</div>





@stop

@section('javascript')
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
  .addField('#password', [
    {
      rule: 'required',
      errorMessage: 'Password is required',
    }
  ])
  .addField('#captcha', [
    {
      rule: 'required',
      errorMessage: 'Captcha is required',
    }
  ])
//   .showErrors(errors:{ '#email': 'The email is invalid' })
  .onSuccess((event) => {
    // event.target.showErrors({ '#email': 'The email is invalid' })
    event.target.submit();
  });
</script>

@include('includes.main.captcha')

@stop