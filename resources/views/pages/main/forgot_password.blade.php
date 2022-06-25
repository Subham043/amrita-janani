@extends('layouts.main.auth')

@section('css')


@stop

@section('content')

<div class="form-items">
    <h3>Forgot Password</h3>
    <p>To reset your password, enter the email address you use to sign in to Amrita Janani.</p>
    <form>
        <input class="form-control" type="email" name="email" placeholder="E-mail Address" required>
        <div class="form-button">
            <button id="submit" type="submit" class="ibtn">Submit</button> <a href="{{route('signin')}}">Remember your password?</a>
        </div>
    </form>
    <!-- <div class="other-links">
        <span>Or login with</span><a href="#">Facebook</a><a href="#">Google</a><a href="#">Linkedin</a>
    </div> -->
</div>





@stop