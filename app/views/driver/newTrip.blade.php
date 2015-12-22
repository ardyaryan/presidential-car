@extends('layouts.mobile')
@section('title')
Daily Trips
@stop

@section('body')
<div>
    <input type="text" class="form-control" id="client_name" name="client_name" placeholder=" - Client Name" style="margin-bottom: 10px">
    <div class="input-group" style="margin-bottom: 10px">
        <input type="text" class="form-control" id="departure_address" name="departure_address" placeholder=" - Start Address">
        <span class="input-group-btn">
             <button class="btn btn-info" type="button" onclick="getLocation();">Get Location</button>
        </span>
    </div>

    <div class="input-group" style="margin-bottom: 10px">
        <input type="text" class="form-control" id="start_time" name="start_time" placeholder=" - Start Time">
        <span class="input-group-btn">
             <button id="start_trip" class="btn btn-success" style="width: 105px;">Start Trip</button>
        </span>
    </div>
    <input type="text" class="form-control" id="destination_address" name="destination_address" placeholder=" - End Address" style="margin-bottom: 10px">
    <div class="input-group" style="margin-bottom: 10px">
        <input type="text" class="form-control" id="end_time" name="end_time" placeholder=" - End Time">
        <span class="input-group-btn">
             <button id="end_trip" class="btn btn-danger" style="width: 105px;">End Trip</button>
        </span>
    </div>
</div>
@stop

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="{{ URL::asset('public/js/partials/trips.js')}}"></script>
<script src="{{ URL::asset('public/js/partials/location.js')}}"></script>