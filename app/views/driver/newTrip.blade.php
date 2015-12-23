@extends('layouts.mobile')
@section('title')
Daily Trips
@stop

@section('body')
<h3>Start Your Trip:</h3>
<div>

    <div class="input-group form-group">
        <span class="input-group-addon"><i class="fa fa-truck"></i> Vehicle</span>
        <input type="text" class="form-control" id="car" name="car" value="{{$car['car_name'].' - '.$car['car_reg']}}" disabled>
        <span class="input-group-btn">
             <button id="change_car" class="btn btn-default" style="width: 105px;"><i class="fa fa-pencil"></i> Change</button>
        </span>
    </div>
    <div class="input-group form-group">
        <span class="input-group-addon"><i class="fa fa-user"></i> Client</span>
        <select id="client_name" class="selectpicker form-group input-group" data-width="auto">
            <option value="1">Uber</option>
            <option value="2">Client 1</option>
            <option value="3">Client 2</option>
        </select>

    </div>
    <div class="input-group form-group">
        <span class="input-group-addon"><i class="fa fa-flask"></i> Water</span>
        <select id="water_bottle" class="selectpicker form-group input-group" data-width="auto">
            <option value="0">0</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
            <option value="7">7</option>
            <option value="8">8</option>
            <option value="9">9</option>
            <option value="10">10</option>
        </select>
    </div>

    <div class="input-group form-group">
        <span class="input-group-addon" style="background-color: #449d44"><i class="fa fa-play" style="color:white"></i></span>
        <input type="number" class="form-control" id="start_km" name="start_km" placeholder=" - Start Km">
    </div>

    <input type="text" class="form-control form-group" id="departure_address" name="departure_address" placeholder=" - Start Address">

    <div class="input-group form-group">
        <input type="text" class="form-control" id="start_time" name="start_time" placeholder=" - Start Time">
        <span class="input-group-btn">
             <button id="start_trip" class="btn btn-success" style="width: 105px;">Start Trip</button>
        </span>
    </div>

    <div class="input-group form-group">
        <span class="input-group-addon" style="background-color: #c9302c"><i class="fa fa-stop" style="color:white"></i></span>
        <input type="number" class="form-control" id="end_km" name="end_km" placeholder=" - End Km">
    </div>

    <input type="text" class="form-control form-group" id="destination_address" name="destination_address" placeholder=" - End Address">
    <div class="input-group form-group" >
        <input type="text" class="form-control" id="end_time" name="end_time" placeholder=" - End Time">
        <span class="input-group-btn">
             <button id="end_trip" class="btn btn-danger form-group" style="width: 105px;">End Trip</button>
        </span>
    </div>
    <div id="alert" style="display: none">
    </div>
</div>
@stop

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="{{ URL::asset('public/js/partials/trips.js')}}"></script>
<script src="{{ URL::asset('public/js/partials/newTrip.js')}}"></script>