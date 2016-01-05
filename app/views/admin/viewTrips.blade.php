@extends('layouts.mobile')
@section('title')
View Daily Trips
@stop

@section('body')


<h3>View Daily Trips</h3>
<div class="form-group">
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
    <button id="get_more_trips" class="btn btn-success" style="width: 80%;"><i id="go_button_admin" class="fa fa-calendar"></i> GO!</button>
</div>

<div class="form-group">
    <span id="time_range_span" ><i id="trips_time_tag" class="fa fa-calendar-o" ></i> Today's Trips</span>
</div>





<div id="tripsContainer">
    <div id="mainContent">
        <table id="daily_trips" class="display" >
                <thead>
                    <tr>
                        <th>Client Name</th>
                        <th>Date</th>
                        <th>Departure Hour</th>
                        <th>Departure Minute</th>
                        <th>Departure AM/PM</th>
                        <th>Arrival Hour</th>
                        <th>Arrival Minute</th>
                        <th>Arrival AM/PM</th>
                        <th>Departure Address</th>
                        <th>Arrival Address</th>
                        <th>Water Bottles</th>
                        <th>Price/Trip</th>
                    </tr>
                </thead>
            </table>
    </div>
</div>
@stop

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="{{ URL::asset('public/js/partials/adminViewTrips.js')}}"></script>