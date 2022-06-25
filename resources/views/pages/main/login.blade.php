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