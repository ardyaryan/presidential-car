@extends('layouts.mobile')
@section('title')
Daily Trips
@stop

@section('body')
<h3>Send Email/message:</h3>
<div>
    <div class="input-group form-group">
        <span class="input-group-addon"><i class="fa fa-envelope-o"></i> Email Address:</span>
        <input type="email" class="form-control" id="email" name="email" value="ardy.aryan@gmail.com">
    </div>

    <div class="input-group form-group">
        <span class="input-group-addon"><i class="fa fa-phone"></i> Cellphone Number:</span>
        <input type="number" class="form-control" id="phone" name="phone" value="6195071911">
    </div>

    <div class="input-group form-group">
        <span class="input-group-addon"><i class="fa fa-text-height"></i> Message:</span>
        <input type="text" class="form-control" id="text_message" name="text_message" value="This is a test message">
    </div>

    <div class=" form-group">
        <button id="send" class="btn btn-info form-group" style="width: 100%;">Send</button>
    </div>

    <div id="alert" style="display: none">
    </div>
</div>

@stop

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="{{ URL::asset('public/js/partials/sendEmail.js')}}"></script>