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
    <h3>Reset password.</h3>
    <p>Access to the most powerfull tool in amrita janani.</p>
    <form action="{{route('resetPasswordRequest', $encryptedId)}}" method="post" id="loginForm">
    @csrf
        <div class="mb-2">
        <input class="form-control" type="text" name="otp" id="otp" placeholder="OTP" required>
        @error('otp') 
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
        <input class="form-control" type="password" name="cpassword" id="cpassword" placeholder="Confirm Password" required>
        @error('cpassword') 
            <div class="invalid-message">{{ $message }}</div>
        @enderror
        </div>
        <div class="form-button">
            <button id="submitBtn" type="submit" class="ibtn">Reset Password</button> <a href="{{route('signin')}}">Remember your password?</a>
        </div>
    </form>
    <!-- <div class="other-links">
        <span>Or login with</span><a href="#">Facebook</a><a href="#">Google</a><a href="#">Linkedin</a>
    </div> -->
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
  .addField('#password', [
    {
      rule: 'required',
      errorMessage: 'Password is required',
    },
    {
        rule: 'customRegexp',
        value: /^[a-z 0-9~%.:_\@\-\/\(\)\\\#\;\[\]\{\}\$\!\&\<\>\'\r\n+=,]+$/i,
        errorMessage: 'Password is invalid',
    },
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
  .onSuccess((event) => {
    event.target.submit();
  });
</script>
@stop