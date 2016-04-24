@extends('layouts.mobile')
@section('title')
Daily Trips
@stop

@section('body')
<?php
$tempTrip = \Session::get('temp_trip', null);
//print_r($tempTrip);
?>

<h3>{{(Session::get('lid') == 2) ? 'Commencez votre voyage' : 'Start Your Trip:' }}</h3>
<div>
    <input type="hidden" id="language_id" value="{{Session::get('lid')}}">
    <input type="hidden" id="temp_trip_id" value="@if(!empty($tempTrip['id'])) {{$tempTrip['id']}} @endif">
    <div class="input-group form-group">
        <span class="input-group-addon"><i class="fa fa-truck"></i>{{(Session::get('lid') == 2) ? ' Véhicule' : ' Vehicle' }}</span>
        <input type="text" class="form-control" id="car" name="car" value="{{$car['car_name'].' - '.$car['car_reg']}}" disabled>
        <span class="input-group-btn">
             <button type="button" id="change_car" class="btn btn-default" data-toggle="modal" data-target="#myModal" ><i class="fa fa-pencil"></i>{{(Session::get('lid') == 2) ? ' Changer' : ' Change' }}</button>
        </span>
    </div>
    <div class="input-group form-group" id="client_name_div">
        <span class="input-group-addon"><i class="fa fa-user"></i>{{(Session::get('lid') == 2) ? ' Client' : ' Client' }}</span>
        <select id="client_name" class="selectpicker form-group input-group" data-width="auto">
            @foreach($clients as $client)
                <option value=""> -- Select</option>
                <option value="{{$client['id']}}" @if(!empty($tempTrip['client_id']) && $tempTrip['client_id'] == $client['id']) selected @endif>{{$client['name']}}</option>
            @endforeach
        </select>
        <span class="input-group-btn">
            <button type="button" id="custom_customer" class="btn btn-default"><i class="fa fa-plus"></i>&nbsp;</button>
        </span>
    </div>

    <div style="display: none;" id="customer_details">
            <div class="input-group form-group" >
                <span class="input-group-addon" style="background-color:#A9F5A9"><i class="fa fa-usd"></i> Flat Price:</span>
                <input type="@if (!empty($tempTrip['trip_mode'])) text @else number @endif" class="form-control" id="flat_price" name="flat_price" value="@if (!empty($tempTrip['trip_mode']) ) {{$tempTrip['flat_price'] }} @endif">
            </div>

            <div class="input-group form-group" >
                <span class="input-group-addon" style="background-color:#F3F781"><i class="fa fa-usd"></i> Daily Price:</span>
                <input type="@if (!empty($tempTrip['daily_price'])) text @else number @endif" class="form-control" id="daily_price" name="daily_price" value="@if (!empty($tempTrip['daily_price'])) {{$tempTrip['daily_price'] }} @endif">
            </div>

            <div class="input-group form-group" >
                <span class="input-group-addon" style="background-color:#58FAF4"><i class="fa fa-usd"></i> Hourly Price:</span>
                <input type="@if (!empty($tempTrip['hourly_price'])) text @else number @endif" class="form-control" id="hourly_price" name="hourly_price" value="@if (!empty($tempTrip['hourly_price'])) {{$tempTrip['hourly_price'] }} @endif">
            </div>

            <div class="input-group form-group" >
                <span class="input-group-addon" style="background-color:#BCA9F5"><i class="fa fa-usd"></i> Base:</span>
                <input type="@if (!empty($tempTrip['base'])) text @else number @endif" class="form-control" id="base" name="base" value="@if (!empty($tempTrip['base'])) {{$tempTrip['base'] }} @endif">
            </div>
            <div class="input-group form-group" >
                <span class="input-group-addon" style="background-color:#BCA9F5"><i class="fa fa-usd"></i> Per Km:</span>
                <input type="@if (!empty($tempTrip['per_km'])) text @else number @endif" class="form-control" id="per_km" name="per_km" value="@if (!empty($tempTrip['per_km'])) {{$tempTrip['per_km'] }} @endif">
            </div>
            <div class="input-group form-group" >
                <span class="input-group-addon" style="background-color:#BCA9F5"><i class="fa fa-usd"></i> Per Min:</span>
                <input type="@if (!empty($tempTrip['per_min'])) text @else number @endif" class="form-control" id="per_min" name="per_min" value="@if (!empty($tempTrip['per_min'])) {{$tempTrip['per_min'] }} @endif">
            </div>
        </div>

    <div class="input-group form-group" id="">
        <span class="input-group-addon" style="width: 90%"><i class="fa fa-usd"></i> Extra Charge</span>
        <span class="input-group-btn">
            <button type="button" id="extra_charge" class="btn btn-default"><i class="fa fa-plus"></i>&nbsp;</button>
        </span>
    </div>

    <div style="display: none;" id="extra_charge_div">
        <div class="input-group form-group" >
            <span class="input-group-addon" ><i class="fa fa-truck"></i> Trip Mode:</span>
            <select id="trip_mode" class="selectpicker form-group input-group" data-width="auto">
                <option value="1" @if(!empty($tempTrip['trip_mode']) && $tempTrip['trip_mode'] == 1) selected @endif>On a Trip</option>
                <option value="2" @if(!empty($tempTrip['trip_mode']) && $tempTrip['trip_mode'] == 2) selected @endif>Free</option>
            </select>
         </div>
         <div class="input-group form-group" >
            <span class="input-group-addon" ><i class="fa fa-usd"></i> Toll Fee:</span>
            <input type="@if (!empty($tempTrip['toll_fee'])) text @else number @endif" class="form-control" id="toll_fee" name="toll_fee" value="@if (!empty($tempTrip['toll_fee'])) {{$tempTrip['toll_fee']}} @endif">
         </div>
         <div class="input-group form-group" >
            <span class="input-group-addon"><i class="fa fa-usd"></i> Parking:</span>
            <input type="@if (!empty($tempTrip['parking_fee'])) text @else number @endif" class="form-control" id="parking_fee" name="parking_fee" value="@if (!empty($tempTrip['parking_fee'])) {{$tempTrip['parking_fee'] }} @endif">
        </div>
    </div>

    <div class="input-group form-group">
        <span class="input-group-addon"><i class="fa fa-user"></i>{{(Session::get('lid') == 2) ? ' Le Nom' : ' Customer\'s Name' }}</span>
        <input type="text" class="form-control" id="customer_name" name="customer_name" value="@if (!empty($tempTrip['customer_name'])) {{$tempTrip['customer_name']}} @endif">
    </div>

    <div class="input-group form-group">
        <span class="input-group-addon"><i class="fa fa-envelope-o"></i> Email Address:</span>
        <input type="email" class="form-control" id="customer_email" name="customer_email" value="@if (!empty($tempTrip['customer_email'])) {{$tempTrip['customer_email']}} @endif">
    </div>

    <div class="input-group form-group">
        <span class="input-group-addon"><i class="fa fa-phone"></i> Cellphone Number:</span>
        <input type="@if (!empty($tempTrip['customer_phone'])) text @else number @endif" class="form-control" id="customer_phone" name="customer_phone" value="@if (!empty($tempTrip['customer_phone'])) {{$tempTrip['customer_phone']}} @endif">
    </div>

    <div class="input-group form-group">
        <span class="input-group-addon"><i class="fa fa-tachometer"></i>{{(Session::get('lid') == 2) ? ' Km de départ' : ' Start Km' }}</span>
        <input type="@if (!empty($tempTrip['departure_km'])) text @else number @endif" class="form-control" id="start_km" name="start_km" value="@if (!empty($tempTrip['departure_km'])) {{ $tempTrip['departure_km'] }} @endif">
    </div>

    <div class="input-group form-group">
        <span class="input-group-addon"><i id="start_address_icon" class="fa fa-map-marker"></i>{{(Session::get('lid') == 2) ? ' L\'adresse de départ' : ' Start Address' }}</span>
        <input type="text" class="form-control form-group" id="departure_address" name="departure_address" value="@if (!empty($tempTrip['departure_address'])) {{$tempTrip['departure_address']}} @endif">
    </div>

    <div class="input-group form-group">
        <span class="input-group-addon"><i class="fa fa-clock-o"></i>{{(Session::get('lid') == 2) ? ' Le temps de départ' : ' Start Time' }}</span>
        <input type="text" class="form-control" id="start_time" name="start_time" value="@if (!empty($tempTrip['departure_date_time'])) {{$tempTrip['departure_date_time'] }} @endif">
    </div>

    <div class=" form-group">
        <button id="start_trip" class="btn btn-success" style="width: 100%;" @if(!empty($tempTrip['departure_km'])) disabled @endif><i class="fa fa-play"></i>{{(Session::get('lid') == 2) ? ' Commencer' : ' Start Trip' }}</button>
    </div>

    <div class="input-group form-group">
        <span class="input-group-addon"><i class="fa fa-tachometer"></i>{{(Session::get('lid') == 2) ? ' Km de d\'arrivée' : '  End Km' }}</span>
        <input type="number" class="form-control" id="end_km" name="end_km" >
    </div>

    <div class="input-group form-group">
        <span class="input-group-addon"><i id="end_address_icon" class="fa fa-map-marker"></i>{{(Session::get('lid') == 2) ? ' L\'adresse de d\'arrivée' : ' End Address' }}</span>
        <input type="text" class="form-control form-group" id="destination_address" name="destination_address">
    </div>

    <div class="input-group form-group" >
        <span class="input-group-addon"><i class="fa fa-clock-o"></i>{{(Session::get('lid') == 2) ? ' Le temps d\'arrivée' : ' End Time' }}</span>
        <input type="text" class="form-control" id="end_time" name="end_time">
    </div>

    <div class=" form-group">
        <button id="end_trip" class="btn btn-danger form-group" style="width: 100%;" @if(empty($tempTrip['departure_km'])) disabled @endif><i class="fa fa-stop"></i>{{(Session::get('lid') == 2) ? ' Terminer' : ' End Trip' }}</button>
    </div>
    <!--
    <div class=" form-group">
        <button id="save_trip" class="btn btn-info form-group" style="width: 100%;" disabled><i class="fa fa-floppy-o"></i>{{(Session::get('lid') == 2) ? ' Enregistrer' : ' Save Trip' }}</button>
    </div>
    -->
    <div id="alert" style="display: none">
    </div>
</div>

<div id="myModal" class="modal fade" role="dialog" style="margin-top: 200px;">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><span class="fa fa-car"></span>{{(Session::get('lid') == 2) ? ' Changer le Véhicule' : ' Change Vehicle' }}</h4>
      </div>
      <input type="hidden" id="current_car_id" value="{{Session::get('car_id')}}" >
      <div class="modal-body" id="modal_body">
        <p><span class="fa fa-spin fa-spinner"></span>{{(Session::get('lid') == 2) ? ' Obtention les Véhicules disponible...' : ' Getting Available Cars...' }}</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">{{(Session::get('lid') == 2) ? 'Fermer' : 'Close' }}</button>
      </div>
    </div>

  </div>
</div>
@stop

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="{{ URL::asset('public/js/partials/driverNewTrip.js')}}"></script>