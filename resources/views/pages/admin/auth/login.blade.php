@extends('layouts.admin.auth')



@section('content')

<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6 col-xl-5">
        <div class="card mt-4">
        
            <div class="card-body p-4"> 
                <div class="text-center mt-2">
                    <h5 class="text-primary">Welcome Back !</h5>
                    <p class="text-muted">Sign in to continue to Amrita Janani Admin Panel.</p>
                </div>
                <div class="p-2 mt-4">
                    <form id="loginForm" method="post" action="{{route('authenticate')}}">
                    @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{old('email')}}" placeholder="Enter email">
                            @error('email') 
                                <div class="invalid-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <div class="float-end">
                                <a href="{{route('forgotPassword')}}" class="text-muted">Forgot password?</a>
                            </div>
                            <label class="form-label" for="password">Password</label>
                            <div class="position-relative auth-pass-inputgroup mb-3">
                                <input type="password" class="form-control pe-5" placeholder="Enter password" id="password" name="password">
                                <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted" type="button" id="password-addon"><i class="ri-eye-fill align-middle"></i></button>
                            </div>
                            @error('password') 
                                <div class="invalid-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="auth-remember-check">
                            <label class="form-check-label" for="auth-remember-check">Remember me</label>
                        </div>
                        
                        <div class="mt-4">
                            <button class="btn btn-success w-100" type="submit">Sign In</button>
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