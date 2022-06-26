@extends('layouts.main.auth')

@section('css')


@stop

@section('content')

<div class="form-items">
    <h3>Get more things done with Loggin Amrita Janani.</h3>
    <p>Access to the most powerfull tool in amrita janani.</p>
    <div class="page-links">
        <a href="{{route('signin')}}" class="active">Login</a><a href="{{route('signup')}}">Register</a>
    </div>
    <form>
        <input class="form-control" type="text" name="username" placeholder="E-mail Address" required>
        <input class="form-control" type="password" name="password" placeholder="Password" required>
        <input type="checkbox" id="chk1"><label for="chk1">Remmeber me</label>
        <div class="form-button">
            <button id="submit" type="submit" class="ibtn">Login</button> <a href="{{route('forgot_password')}}">Forget password?</a>
        </div>
    </form>
    <!-- <div class="other-links">
        <span>Or login with</span><a href="#">Facebook</a><a href="#">Google</a><a href="#">Linkedin</a>
    </div> -->
</div>





@stop

@section('javascript')
<script type="text/javascript">
    $(function () {
        $('#email').focus();

    });

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