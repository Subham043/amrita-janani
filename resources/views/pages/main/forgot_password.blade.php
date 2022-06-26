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
        <div class="form-button">
            <button id="submitBtn" type="submit" class="ibtn">Submit</button> <a href="{{route('signin')}}">Remember your password?</a>
        </div>
    </form>
</div>





@stop

@section('javascript')
<script src="{{ asset('admin/js/pages/just-validate.production.min.js') }}"></script>
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
  .onSuccess((event) => {
    event.target.submit();
  });
</script>
@stop