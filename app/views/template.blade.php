@extends('layouts.main')
@section('title')
This is my Laravel Template
@stop

@section('body')
<div id="container">
    <div id="mainContent">
        <h1> Laravel Template</h1>
        <p> This is being loaded from template.blade.php</p>
        {{'<br/><br/><a href="http://localhost/laravel/administrator/"><-- Back</a>'}}
    </div>
</div>
@stop
