@extends('layouts.mobile')
@section('title')
Daily Trips
@stop

@section('body')
<h3>My Trips:</h3>
<div class="form-group">
    <span ><i class="fa fa-square" style="color: #E6BEBE; margin-left: 15px;"></i> Pending Deletion</span>
    <span ><i class="fa fa-square" style="color: #BEE6CE; margin-left: 15px;"></i> Pending Revision</span>

    <div class="input-group col-sm-3 col-md-offset-5 col-lg-offset-5 date">
        <input type="text" class="datepicker form-control" name="from" id="from" placeholder=" - From" data-provide="datepicker">
        <div class="input-group-addon">
            <span class="glyphicon glyphicon-th"></span>
        </div>
    </div>

    <div class="input-group col-sm-3 col-md-offset-5 col-lg-offset-5 date">
        <input type="text" class="datepicker form-control" name="to" id="to" placeholder=" - To" data-provide="datepicker" >
        <div class="input-group-addon">
            <span class="glyphicon glyphicon-th" ></span>
        </div>
    </div>
</div>

<div class=" form-group">
    <button id="get_more_trips" class="btn btn-success" style="width: 100%;"><i id="go_button" class="fa fa-calendar"></i> GO!</button>
</div>

<div class="form-group">
    <span ><i id="trips_time_tag" class="fa fa-calendar-o" ></i> Today's Trips</span>
</div>
<div id="trips_body">
<!-- filled by JS -->
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
                <input type="text" class="form-control input-group" id="car" name="car">
            </div>
            <div class="input-group form-group">
                <span class="input-group-addon"><i class="fa fa-user"></i> Client</span>
                <input type="text" class="form-control input-group" id="client" name="client">
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