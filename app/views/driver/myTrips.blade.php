@extends('layouts.mobile')
@section('title')
Daily Trips
@stop

@section('body')
<h3>My Trips:</h3>
<div>
    @foreach ($myTrips as $myTrip)
    <div class="input-group form-group">
            <span class="input-group-addon"><i class="fa fa-location-arrow"></i> </span>
        <input type="text" class="form-control input-group" id="trip" name="trip" value="{{'Date: '.$myTrip['departure_date_time'].'  -  Distance: '.$myTrip['departure_km'].'Km -> '.$myTrip['arrival_km'].'Km  -  '.$myTrip['departure_address'].'  -  '.$myTrip['arrival_address']}}" disabled>
        <span class="input-group-btn">
             <button type="button" id="edit_trip" class="btn btn-default" data-toggle="modal" data-target="#editModal"><i class="fa fa-pencil"></i> &nbsp;</button>
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
        <h4 class="modal-title"><span class="fa fa-car"></span> Change Vehicle</h4>
      </div>
      <input type="hidden" id="current_car_id" value="{{''}}" >
      <div class="modal-body" id="modal_body">
        <p><span class="fa fa-check"></span> To be completed...</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
@stop

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="{{ URL::asset('public/js/partials/myTrips.js')}}"></script>