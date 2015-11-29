@extends('layouts.main')
@section('title')
This is my Laravel Template
@stop

@section('body')
<div id="container">
    <div id="mainContent">
        <h1> Thank You!</h1>
        <p> Your information has been stored in the database.</p>
        {{'<br/><br/><a href="http://localhost/laravel/administrator/"><-- Back</a>'}}
    </div>
</div>
@stop
