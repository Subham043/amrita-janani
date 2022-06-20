@extends('layouts.admin.auth')



@section('content')

<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6 col-xl-5">
        <div class="card mt-4">
        
            <div class="card-body p-4"> 
                <div class="text-center mt-2">
                    <h5 class="text-primary">Reset Password !</h5>
                    <p class="text-muted">Enter the following details to reset password.</p>
                </div>
                <div class="p-2 mt-4">
                    <form id="loginForm" method="post" action="{{route('requestResetPassword', $encryptedId)}}">
                    @csrf
                        <div class="mb-3">
                            <label for="otp" class="form-label">OTP</label>
                            <input type="text" class="form-control" id="otp" name="otp" placeholder="Enter otp">
                            @error('otp') 
                                <div class="invalid-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="password">Password</label>
                            <div class="position-relative auth-pass-inputgroup mb-3">
                                <input type="password" class="form-control pe-5" placeholder="Enter password" id="password" name="password">
                                <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted" type="button" id="password-addon"><i class="ri-eye-fill align-middle"></i></button>
                            </div>
                            @error('password') 
                                <div class="invalid-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="cpassword" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" id="cpassword" name="cpassword" placeholder="Enter the password again">
                            @error('cpassword') 
                                <div class="invalid-message">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mt-4">
                            <button class="btn btn-success w-100" type="submit">Reset</button>
                        </div>

                    </form>
                </div>
            </div>
            <!-- end card body -->
        </div>
        <!-- end card -->

    </div>
</div>

@stop

@section('javascript')
<!-- password-addon init -->
<script src="{{ asset('admin/js/pages/password-addon.init.js') }}"></script>
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
  .addField('#otp', [
    {
      rule: 'required',
      errorMessage: 'OTP is required',
    },
    {
      rule: 'number',
      errorMessage: 'OTP must be a number!',
    },
    {
      rule: 'minLength',
      value: 4,
    },
    {
      rule: 'maxLength',
      value: 4,
    },
  ])
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
  .onSuccess((event) => {
    event.target.submit();
  });
</script>

@stop