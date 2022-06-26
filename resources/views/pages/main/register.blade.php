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
    <h3>Get more things done with Registering Amrita Janani.</h3>
    <p>Access to the most powerfull tool in amrita janani.</p>
    <div class="page-links">
        <a href="{{route('signin')}}">Login</a><a href="{{route('index')}}" class="active">Register</a>
    </div>
    <form action="{{route('signup_store')}}" method="post" id="loginForm">
        @csrf
        <div class="mb-2">
            <input class="form-control" type="text" name="name" id="name" placeholder="Name" value="{{old('name')}}" required>
            @error('name') 
                <div class="invalid-message">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-2">
        <input class="form-control" type="email" name="email" id="email" placeholder="E-mail Address" value="{{old('email')}}" required>
        @error('email') 
            <div class="invalid-message">{{ $message }}</div>
        @enderror
        </div>
        <div class="mb-2">
        <input class="form-control" type="text" name="phone" id="phone" placeholder="Phone Number" value="{{old('phone')}}" required>
        @error('phone') 
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
        <div class="mb-2">
        <input type="checkbox" id="chk1"><label for="chk1">Accept Terms & Condtions</label>
        </div>
        <div class="form-button">
            <button id="btnsubmit" type="submit" class="ibtn">Register</button> <a href="{{route('signin')}}">Already a registered user?</a>
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
      rule: 'required',
      errorMessage: 'Phone is required',
    },
    {
        rule: 'customRegexp',
        value: /^[0-9]*$/,
        errorMessage: 'Phone is invalid',
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