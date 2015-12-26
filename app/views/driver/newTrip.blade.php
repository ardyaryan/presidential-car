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
             <button type="button" id="change_car" class="btn btn-default" data-toggle="modal" data-target="#myModal" ><i class="fa fa-pencil"></i> Change</button>
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
        <span class="input-group-addon"><i class="fa fa-tachometer"></i> Start Km</span>
        <input type="number" class="form-control" id="start_km" name="start_km" placeholder=" - Start Km">
    </div>

    <div class="input-group form-group">
        <span class="input-group-addon"><i class="fa fa-map-marker"></i> Start Address</span>
        <input type="text" class="form-control form-group" id="departure_address" name="departure_address" placeholder=" - Start Address">
    </div>

    <div class="input-group form-group">
        <span class="input-group-addon"><i class="fa fa-clock-o"></i> Start Time</span>
        <input type="text" class="form-control" id="start_time" name="start_time" placeholder=" - Start Time">
        <span class="input-group-btn">
             <button id="start_trip" class="btn btn-success" style="width: 105px;">Start Trip</button>
        </span>
    </div>

    <div class="input-group form-group">
        <span class="input-group-addon"><i class="fa fa-tachometer"></i> End Km</span>
        <input type="number" class="form-control" id="end_km" name="end_km" placeholder=" - End Km">
    </div>

    <div class="input-group form-group">
        <span class="input-group-addon"><i class="fa fa-map-marker"></i> End Address</span>
        <input type="text" class="form-control form-group" id="destination_address" name="destination_address" placeholder=" - End Address">
    </div>


    <div class="input-group form-group" >
        <span class="input-group-addon"><i class="fa fa-clock-o"></i> End Time</span>
        <input type="text" class="form-control" id="end_time" name="end_time" placeholder=" - End Time">
        <span class="input-group-btn">
             <button id="end_trip" class="btn btn-danger form-group" style="width: 105px;">End Trip</button>
        </span>
    </div>
    <div id="alert" style="display: none">
    </div>
</div>

<div id="myModal" class="modal fade" role="dialog" style="margin-top: 200px;">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><span class="fa fa-car"></span> Change Vehicle</h4>
      </div>
      <input type="hidden" id="current_car_id" value="{{Session::get('car_id')}}" >
      <div class="modal-body" id="modal_body">
        <p><span class="fa fa-spin fa-spinner"></span> Getting Available Cars...</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
@stop

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="{{ URL::asset('public/js/partials/newTrip.js')}}"></script>