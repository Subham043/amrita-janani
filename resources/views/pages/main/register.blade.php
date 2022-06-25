@extends('layouts.main.auth')

@section('css')


@stop

@section('content')

<div class="form-items">
    <h3>Get more things done with Registering Amrita Janani.</h3>
    <p>Access to the most powerfull tool in amrita janani.</p>
    <div class="page-links">
        <a href="{{route('signin')}}" class="active">Login</a><a href="{{route('index')}}">Register</a>
    </div>
    <form>
        <input class="form-control" type="text" name="name" placeholder="Name" required>
        <input class="form-control" type="email" name="username" placeholder="E-mail Address" required>
        <input class="form-control" type="text" name="phone" placeholder="Phone Number" required>
        <input class="form-control" type="password" name="password" placeholder="Password" required>
        <input class="form-control" type="password" name="cpassword" placeholder="Confirm Password" required>
        <input type="checkbox" id="chk1"><label for="chk1">Remmeber me</label>
        <div class="form-button">
            <button id="submit" type="submit" class="ibtn">Register</button> <a href="{{route('signin')}}">Already a registered user?</a>
        </div>
    </form>
    <!-- <div class="other-links">
        <span>Or login with</span><a href="#">Facebook</a><a href="#">Google</a><a href="#">Linkedin</a>
    </div> -->
</div>





@stop