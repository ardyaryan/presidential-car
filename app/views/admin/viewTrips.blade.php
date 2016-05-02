@extends('layouts.mobile')
@section('title')
View Daily Trips
@stop

@section('body')


<h3>View Daily Trips</h3>
<div class="row">
    <form novalidate="novalidate" class="form-inline" id="daily_trips_form">
        <div class="form-group input-group col-sm-3  col-lg-offset-1 date">
            <input type="text" class="datepicker form-control" name="from" id="from" placeholder=" - From" data-provide="datepicker">
            <div class="input-group-addon">
                <span class="glyphicon glyphicon-th"></span>
            </div>
        </div>

        <div class="form-group input-group col-sm-3 col-lg-offset-1 date">
            <input type="text" class="datepicker form-control" name="to" id="to" placeholder=" - To" data-provide="datepicker" >
            <div class="input-group-addon">
                <span class="glyphicon glyphicon-th" ></span>
            </div>
        </div>
        <div class="input-group form-group col-sm-3">
            <button id="get_more_trips" class="btn btn-success" style="width: 40%; margin-top: 25px;"><i id="go_button_admin" class="fa fa-calendar"></i> GO!</button>
        </div>
    </form>
</div>

<div class="form-group" style="margin-left: -200px;">
    <span id="time_range_span" ><i id="trips_time_tag" class="fa fa-calendar-o" ></i> Today's Trips</span>
</div>

<div id="tripsContainer">
    <div id="mainContent" style="margin-left: -20%;">
        <table id="daily_trips" class="display"  align="center">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Driver</th>
                        <th>Vehicle</th>
                        <th>Client</th>
                        <th>Customer</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Departure<br>Time</th>
                        <th>Arrival<br>Time</th>
                        <th>Departure<br>Address</th>
                        <th>Arrival<br>Address</th>
                        <th>Departure<br>KM</th>
                        <th>Arrival<br>KM</th>
                        <th>Distance<br>KM</th>
                        <th>Trip Time<br>(min)</th>
                        <th>Parking/Toll<br>(for Client)</th>
                        <th>Parking/Toll<br> (for Company)</th>
                        <th>Trip Cost</th>
                        <th>Date</th>
                        <th>Delete</th>
                        <th>Edit</th>
                    </tr>
                </thead>
                <tfoot style="background-color: gainsboro;">
                    <tr>
                        <th colspan="13" style="text-align:right">Total:</th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>
    </div>
</div>

<h3>View Daily Driver Activity Breakdown</h3>
<div class="row">
    <form novalidate="novalidate" class="form-inline" id="daily_driver_trips_form">
        <div class="form-group input-group col-sm-3  col-lg-offset-1 date">
            <input type="text" class="datepicker form-control" name="day" id="day" placeholder=" - Day" data-provide="datepicker">
            <div class="input-group-addon">
                <span class="glyphicon glyphicon-th"></span>
            </div>
        </div>

        <div class="input-group form-group col-sm-3">
            <button id="get_driver_more_trips" class="btn btn-success" style="width: 40%; margin-top: 25px;"><i id="go_button_admin" class="fa fa-calendar"></i> Search</button>
        </div>
    </form>
</div>


<div id="vehiclesContainer">
    <div id="mainContent" style="margin-left: -20%;">
        <table id="driver_daily_trips" class="display"  align="center">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Driver</th>
                        <th>Number Of Trips</th>
                        <th>Start KM</th>
                        <th>End KM</th>
                        <th>Total KM</th>
                        <th>Total Trip KM</th>
                        <th>Free Ride KM</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                        <th>Total Hours</th>
                        <th>Total Work Hours</th>
                        <th>Total Free Hours</th>
                        <th>Receipt</th>
                    </tr>
                </thead>
                <!--
                <tfoot style="background-color: gainsboro;">
                    <tr>
                        <th colspan="1" style="text-align:right">Total:</th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                </tfoot>
                -->
            </table>
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

<div id="editModal" class="modal fade" role="dialog" style="margin-top: 200px;">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><span id="edit_modal_header" class="fa fa-pencil"></span> Edit Trip</h4>
      </div>
      <input type="hidden" id="edit_trip_id" >
      <div class="modal-body" id="modal_body" >
            <p>Editing trip will be reviewed by the administration</p>

            <div class="form-group">
                <span class="input-group-addon"><i class="fa fa-user"></i> Customer's Name</span>
                <input type="text" class="form-control input-group" id="customer_name" name="customer_name">
                <span class="input-group-addon"><i class="fa fa-user"></i> Edited</span>
                <input type="text" class="form-control input-group" id="edited_customer_name" name="edited_customer_name">
            </div>
            <div class="form-group">
                <span class="input-group-addon"><i class="fa fa-envelope"></i> Customer's Email</span>
                <input type="text" class="form-control input-group" id="customer_email" name="customer_email">
                <span class="input-group-addon"><i class="fa fa-envelope"></i> Edited</span>
                <input type="text" class="form-control input-group" id="edited_customer_email" name="edited_customer_email">
            </div>
            <div class="form-group">
                <span class="input-group-addon"><i class="fa fa-phone"></i> Customer's Phone</span>
                <input type="text" class="form-control input-group" id="customer_phone" name="customer_phone">
                <span class="input-group-addon"><i class="fa fa-phone"></i> Edited</span>
                <input type="text" class="form-control input-group" id="edited_customer_phone" name="edited_customer_phone">
            </div>
            <div class="form-group">
                <span class="input-group-addon"><i class="fa fa-tachometer"></i> Start Km</span>
                <input type="text" class="form-control input-group" id="start_km" name="start_km">
                <span class="input-group-addon"><i class="fa fa-tachometer"></i> Edited</span>
                <input type="text" class="form-control input-group" id="edited_start_km" name="edited_start_km">
            </div>
            <div class="form-group">
                <span class="input-group-addon"><i class="fa fa-tachometer"></i> End Km</span>
                <input type="text" class="form-control input-group" id="end_km" name="end_km">
                <span class="input-group-addon"><i class="fa fa-tachometer"></i> Edited</span>
                <input type="text" class="form-control input-group" id="edited_end_km" name="edited_end_km">
            </div>
            <div class="form-group">
                <span class="input-group-addon"><i class="fa fa-clock-o"></i> Start Time</span>
                <input type="text" class="form-control input-group" id="start_time" name="start_time">
                <span class="input-group-addon"><i class="fa fa-clock-o"></i> Edited</span>
                <input type="text" class="form-control input-group" id="edited_start_time" name="edited_start_time">
            </div>
            <div class="form-group">
                <span class="input-group-addon"><i class="fa fa-clock-o"></i> End Time</span>
                <input type="text" class="form-control input-group" id="end_time" name="end_time">
                <span class="input-group-addon"><i class="fa fa-clock-o"></i> Edited</span>
                <input type="text" class="form-control input-group" id="edited_end_time" name="edited_end_time">
            </div>
            <div class="form-group">
                <span class="input-group-addon"><i class="fa fa-map-marker"></i> Start Address</span>
                <input type="text" class="form-control input-group" id="departure_address" name="departure_address">
                <span class="input-group-addon"><i class="fa fa-map-marker"></i> Edited</span>
                <input type="text" class="form-control input-group" id="edited_departure_address" name="edited_departure_address">
            </div>
            <div class="form-group">
                <span class="input-group-addon"><i class="fa fa-map-marker"></i> End Address</span>
                <input type="text" class="form-control input-group" id="destination_address" name="destination_address">
                <span class="input-group-addon"><i class="fa fa-map-marker"></i> Edited</span>
                <input type="text" class="form-control input-group" id="edited_destination_address" name="edited_destination_address">
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-default" id="accept_edited_trip">Accept</button>
      </div>
    </div>

  </div>
</div>
@stop

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

<script src="{{ URL::asset('public/js/partials/adminViewTrips.js')}}"></script>