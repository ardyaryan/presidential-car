@extends('layouts.mobile')
@section('title')
View Daily Trips
@stop

@section('body')


<h3>View Daily Trips</h3>
<div class="row">
    <form novalidate="novalidate" class="form-inline">
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
    <div id="mainContent">
        <table id="daily_trips" class="display" >
                <thead>
                    <tr>
                        <th nowrap>Trip ID</th>
                        <th>Driver</th>
                        <th>Car</th>
                        <th>Client</th>
                        <th>Customer</th>
                        <th>Departure Time</th>
                        <th>Arrival Time</th>
                        <th>Departure Address</th>
                        <th>Arrival Address</th>
                        <th>Distance</th>
                        <th>Cost</th>
                        <th>Date</th>
                    </tr>
                </thead>
            </table>
    </div>
</div>
@stop

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

<script src="{{ URL::asset('public/js/partials/adminViewTrips.js')}}"></script>