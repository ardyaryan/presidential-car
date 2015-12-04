@extends('layouts.main')
@section('title')
Admin Login
@stop

@section('body')

<div id="container">
    <div id="mainContent">
        <h2>Admin Login</h2>
        <div id="form">
            <form role="form">
              <div class="form-group">
                <label for="email">Email address:</label>
                <input type="email" class="form-control" name="email" id="email">
              </div>
              <div class="form-group">
                <label for="pwd">Password:</label>
                <input type="password" class="form-control" name="password" id="password">
              </div>
              <button type="submit" id="login" class="btn btn-default">Submit</button>
            </form>
        </div>
    </div>
</div>
@stop


<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="{{ URL::asset('public/js/partials/login.js')}}"></script>
