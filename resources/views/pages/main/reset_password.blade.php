@extends('layouts.main.auth')

@section('css')


@stop

@section('content')

<div class="form-items">
    <h3>Reset password.</h3>
    <p>Access to the most powerfull tool in amrita janani.</p>
    <form>
        <input class="form-control" type="text" name="otp" placeholder="OTP" required>
        <input class="form-control" type="password" name="password" placeholder="Password" required>
        <input class="form-control" type="password" name="cpassword" placeholder="Confirm Password" required>
        <div class="form-button">
            <button id="submit" type="submit" class="ibtn">Reset Password</button> <a href="{{route('signin')}}">Remember your password?</a>
        </div>
    </form>
    <!-- <div class="other-links">
        <span>Or login with</span><a href="#">Facebook</a><a href="#">Google</a><a href="#">Linkedin</a>
    </div> -->
</div>





@stop