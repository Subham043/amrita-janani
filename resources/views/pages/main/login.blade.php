@extends('layouts.main.auth')

@section('css')
<style>
    .just-validate-error-label, .invalid-message{
        color: #fff !important;
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
//   .showErrors(errors:{ '#email': 'The email is invalid' })
  .onSuccess((event) => {
    // event.target.showErrors({ '#email': 'The email is invalid' })
    event.target.submit();
  });
</script>

@stop