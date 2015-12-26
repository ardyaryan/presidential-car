@extends('layouts.mobile')
@section('title')
Daily Trips
@stop

@section('body')
<h3>My Trips:</h3>
<div class="input-group form-group" >
    <span ><i class="fa fa-square" style="color: #E6BEBE; margin-left: 15px;"></i> Pending Deletion</span>
    <span ><i class="fa fa-square" style="color: #BEE6CE; margin-left: 15px;"></i> Pending Revision</span>
</div>
<div>
    @foreach ($myTrips as $myTrip)
    <div class="input-group form-group">
            <span class="input-group-addon"><i class="fa fa-location-arrow"></i> </span>
        <input type="text" class="form-control input-group" id="trip"  @if ($myTrip['delete_req'] != null) {{'style="background-color: #E6BEBE"'}}@elseif ($myTrip['edit_req'] != null) {{'style="background-color: #BEE6CE"'}}@endif  name="trip" value="{{'Date: '.$myTrip['departure_date_time'].'  -  Distance: '.$myTrip['departure_km'].'Km - '.$myTrip['arrival_km'].'Km  -  '.$myTrip['departure_address'].'  -  '.$myTrip['arrival_address']}}" disabled>
        <span class="input-group-btn">
             <button type="button" id="edit_trip" class="btn btn-default" data-toggle="modal" onclick="editTripModal({{$myTrip['id']}})" data-target="#editModal"
             @if ($myTrip['delete_req'] != null || $myTrip['edit_req'] != null) {{'disabled'}} @endif
             ><i class="fa fa-pencil"></i>&nbsp;</button>
             <button type="button" id="delete_trip" class="btn btn-default" data-toggle="modal" onclick="pluckTripId({{$myTrip['id']}})" data-target="#deleteModal"
             @if ($myTrip['delete_req'] != null || $myTrip['edit_req'] != null) {{'disabled'}} @endif
             ><i class="fa fa-times" style="color: red"></i>&nbsp;</button>
        </span>
    </div>
    @endforeach
</div>

<div id="editModal" class="modal fade" role="dialog" style="margin-top: 200px;">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><span id="edit_modal_header" class="fa fa-spin fa-spinner"></span> Edit Trip</h4>
      </div>
      <input type="hidden" id="trip_id" >
      <div class="modal-body" id="modal_body" style="display: none">
            <p>Editing trip will be reviewed by the administration</p>

            <div class="input-group form-group">
                <span class="input-group-addon"><i class="fa fa-truck"></i> Vehicle</span>
                <input type="text" class="form-control input-group" id="car" name="car" value="{{$car['name'].' - '.$car['registration']}}">
            </div>
            <div class="input-group form-group">
                <span class="input-group-addon"><i class="fa fa-user"></i> Client</span>
                <input type="text" class="form-control input-group" id="client" name="client">
            </div>
            <div class="input-group form-group">
                <span class="input-group-addon"><i class="fa fa-flask"></i> Water</span>
                <input type="text" class="form-control input-group" id="water" name="water">
            </div>
            <div class="input-group form-group">
                <span class="input-group-addon"><i class="fa fa-tachometer"></i> Start Km</span>
                <input type="text" class="form-control input-group" id="start_km" name="start_km">
            </div>
            <div class="input-group form-group">
                <span class="input-group-addon"><i class="fa fa-tachometer"></i> End Km</span>
                <input type="text" class="form-control input-group" id="end_km" name="end_km">
            </div>
            <div class="input-group form-group">
                <span class="input-group-addon"><i class="fa fa-clock-o"></i> Start Time</span>
                <input type="text" class="form-control input-group" id="start_time" name="start_time">
            </div>
            <div class="input-group form-group">
                <span class="input-group-addon"><i class="fa fa-clock-o"></i> End Time</span>
                <input type="text" class="form-control input-group" id="end_time" name="end_time">
            </div>
            <div class="input-group form-group">
                <span class="input-group-addon"><i class="fa fa-map-marker"></i> Start Address</span>
                <input type="text" class="form-control input-group" id="departure_address" name="departure_address">
            </div>
            <div class="input-group form-group">
                <span class="input-group-addon"><i class="fa fa-map-marker"></i> End Address</span>
                <input type="text" class="form-control input-group" id="destination_address" name="destination_address">
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" id="edit_trip_req">Save</button>
      </div>
    </div>

  </div>
</div>

<div id="deleteModal" class="modal fade" role="dialog" style="margin-top: 200px;">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><span id="edit_modal_header" class="fa fa-times"></span> Delete Trip</h4>
      </div>
      <input type="hidden" id="delete_trip_id" >
      <div class="modal-body" id="modal_body" >
            <p>Deleting a trip will be reviewed by the administration</p>
            <p>Are you sure you want to delete this trip?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" id="delete_trip_req" >Delete</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
      </div>
    </div>

  </div>
</div>

@stop

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="{{ URL::asset('public/js/partials/myTrips.js')}}"></script>