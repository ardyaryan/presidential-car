@extends('layouts.mobile')
@section('title')
Daily Trips
@stop

@section('body')
<h3>{{(Session::get('lid') == 2) ? 'Commencez votre voyage' : 'Start Your Trip:' }}</h3>
<div>
    <input type="hidden" id="language_id" value="{{Session::get('lid')}}">
    <div class="input-group form-group">
        <span class="input-group-addon"><i class="fa fa-truck"></i>{{(Session::get('lid') == 2) ? ' Véhicule' : ' Vehicle' }}</span>
        <input type="text" class="form-control" id="car" name="car" value="{{$car['car_name'].' - '.$car['car_reg']}}" disabled>
        <span class="input-group-btn">
             <button type="button" id="change_car" class="btn btn-default" data-toggle="modal" data-target="#myModal" ><i class="fa fa-pencil"></i>{{(Session::get('lid') == 2) ? ' Changer' : ' Change' }}</button>
        </span>
    </div>
    <div class="input-group form-group">
        <span class="input-group-addon"><i class="fa fa-user"></i>{{(Session::get('lid') == 2) ? ' Client' : ' Client' }}</span>
        <select id="client_name" class="selectpicker form-group input-group" data-width="auto">
            @foreach($clients as $client)
                <option value="{{$client['id']}}">{{$client['name']}}</option>
            @endforeach
        </select>
    </div>

    <div class="input-group form-group">
        <span class="input-group-addon"><i class="fa fa-user"></i>{{(Session::get('lid') == 2) ? ' Le Nom' : ' Customer\'s Name' }}</span>
        <input type="text" class="form-control" id="customer_name" name="customer_name">
    </div>

    <div class="input-group form-group">
        <span class="input-group-addon"><i class="fa fa-tachometer"></i>{{(Session::get('lid') == 2) ? ' Km de départ' : ' Start Km' }}</span>
        <input type="number" class="form-control" id="start_km" name="start_km">
    </div>

    <div class="input-group form-group">
        <span class="input-group-addon"><i id="start_address_icon" class="fa fa-map-marker"></i>{{(Session::get('lid') == 2) ? ' L\'adresse de départ' : ' Start Address' }}</span>
        <input type="text" class="form-control form-group" id="departure_address" name="departure_address">
    </div>

    <div class="input-group form-group">
        <span class="input-group-addon"><i class="fa fa-clock-o"></i>{{(Session::get('lid') == 2) ? ' Le temps de départ' : ' Start Time' }}</span>
        <input type="text" class="form-control" id="start_time" name="start_time" >
    </div>

    <div class=" form-group">
        <button id="start_trip" class="btn btn-success" style="width: 100%;"><i class="fa fa-play"></i>{{(Session::get('lid') == 2) ? ' Commencer' : ' Start Trip' }}</button>
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
        <button id="end_trip" class="btn btn-danger form-group" style="width: 100%;" disabled><i class="fa fa-stop"></i>{{(Session::get('lid') == 2) ? ' Terminer' : ' End Trip' }}</button>
    </div>

    <div class=" form-group">
        <button id="save_trip" class="btn btn-info form-group" style="width: 100%;" disabled><i class="fa fa-floppy-o"></i>{{(Session::get('lid') == 2) ? ' Enregistrer' : ' Save Trip' }}</button>
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