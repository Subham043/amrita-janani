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
    <h3>Verify Email.</h3>
    <p>Enter the OTP sent to the registered email address.</p>
    <form action="{{route('requestVerifyRegisteredUser', $encryptedId)}}" method="post" id="loginForm">
    @csrf
        <div class="mb-2">
        <input class="form-control" type="text" name="otp" id="otp" placeholder="OTP" required>
        @error('otp') 
            <div class="invalid-message">{{ $message }}</div>
        @enderror
        </div>
        
        <div class="form-button">
            <button id="submitBtn" type="submit" class="ibtn">Verify</button>
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
  .addField('#otp', [
    {
      rule: 'required',
      errorMessage: 'OTP is required',
    },
    {
        rule: 'customRegexp',
        value: /^[0-9]*$/,
        errorMessage: 'OTP is invalid',
    },
  ])
  .onSuccess((event) => {
    event.target.submit();
  });
</script>
@stop