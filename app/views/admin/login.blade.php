@extends('layouts.main')
@section('title')
Admin Login
@stop

@section('body')
<div id="container">
    <div id="mainContent">
        <h2>Admin Login</h2>
        <div id="form" align="right">
            {{Form::open(array('url' =>''))}}
                {{Form::label('email','Email')}}
                {{Form::text('email', '',  array('placeholder'=>'- Email'))}}<br/>
                {{Form::label('password','Password')}}
                {{Form::password('password', '',  array('placeholder'=>'- Password'))}}
                {{Form::submit('Login',array('id'=>'login'))}}
            {{Form::close()}}
        </div>
    </div>
</div>
@stop


<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="{{ URL::asset('public/js/partials/login.js')}}"></script>
