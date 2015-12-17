@extends('layouts.adminMain')
@section('title')
View Daily Trips
@stop

@section('body')
<div id="tripsContainer">
    <div id="mainContent">
        <h2>View Daily Trips</h2>

        <div id="form">
            <form role="form" class="form-inline">
              <div class="input-group date" data-provide="datepicker">
                  <input type="text" class="form-control" name="start_date" id="start_date">
                  <div class="input-group-addon">
                     <span class="glyphicon glyphicon-th"></span>
                  </div>
              </div>
              <div class="input-group date" data-provide="datepicker">
                    <input type="text" class="form-control" name="end_date" id="end_date">
                    <div class="input-group-addon">
                       <span class="glyphicon glyphicon-th"></span>
                    </div>

               </div>
               <button type="submit" class="btn btn-default" id="search">Search</button>
            </form>

        </div>

        <table id="daily_trips" class="display"  width="100%">
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
<script src="{{ URL::asset('public/js/partials/viewTrips.js')}}"></script>