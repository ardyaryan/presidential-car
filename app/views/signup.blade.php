@extends('layouts.main')
@section('title')
Sign up
@stop

@section('body')
<div id="container">
    <div id="mainContent">
        <h1> Sign Up here :</h1>
        <p> This is being loaded from signup.blade.php</p>
        <div id="form" align="right">
        {{Form::open(array('url' =>'administrator/signup'))}}
            {{Form::label('name','Name')}}
            {{Form::text('name','',  array('placeholder'=>'- Name')) }}<br/>
            {{Form::label('email','Email')}}
            {{Form::text('email', '',  array('placeholder'=>'- Email'))}}<br/>
            {{Form::label('description','Description')}}
            {{Form::text('description', '',  array('placeholder'=>'- Description'))}}
            {{Form::submit('Sign Up',array('id'=>'signup'))}}
        {{Form::close()}}
        </div>
        {{'<br/><br/><a href="http://localhost/laravel/administrator/"><-- Back</a>'}}
    </div>
</div>
@stop
