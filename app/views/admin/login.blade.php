@extends('layouts.mobile')
@section('title')
Admin Login
@stop

@section('body')

<div id="container">
    <div id="mainContent">
        <h2>User Login</h2>
        <form role="form">
        <div id="form">
              <div class="form-group">
                <label for="email">Email address:</label>
                <input type="email" class="form-control" name="email" id="email">
              </div>
              <div class="form-group">
                <label for="pwd">Password:</label>
                <input type="password" class="form-control" name="password" id="password">
              </div>
        </div>

        <div class=" form-group">
                <button iype="submit" id="login" class="btn btn-success" style="width: 100%;"><i id="login_icon" class=""></i> Log in</button>
        </div>

        </form>
    </div>
</div>
@stop


<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="{{ URL::asset('public/js/partials/login.js')}}"></script>
