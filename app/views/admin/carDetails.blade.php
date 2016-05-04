@extends('layouts.mobile')
@section('title')
List of Vehicles
@stop

@section('body')

<h3>View Vehicles Details</h3>
<?php 
$carId = substr($_SERVER['REQUEST_URI'], -1);

?>
<div id="carsContainer">
    
    <div id="mainContent">
        <input id="car_id" value="{{$carId}}" type="hidden">
        <table id="car_details" class="display" >
            <thead>
                <tr>
                    <th nowrap>ID</th>
                    <th>Name</th>
                    <th>Brand</th>
                    <th>Model</th>
                    <th>Registration</th>
                    <th>Police Number</th>
                    <th>Uber Number</th>
                </tr>
            </thead>
            <tbody>
                    <tr>
                        <th nowrap>{{$carDetails['id'] }}</th>
                        <th>{{$carDetails['name'] }}</th>
                        <th>{{$carDetails['brand'] }}</th>
                        <th>{{$carDetails['model'] }}</th>
                        <th>{{$carDetails['registration'] }}</th>
                        <th>{{$carDetails['police_number'] }}</th>
                        <th>{{$carDetails['uber_number'] }}</th>
                    </tr>
                </tbody>
        </table>

        <div class="row" style="margin-left: 200px;">
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
            <!--
            <div class="form-group" id="graph_loading" style="margin-left: 320px; ">
                <span><i class="fa fa-spin fa-spinner" ></i> Loading ...</span>
            </div>
            -->
        </div>

        <h3>View Vehicles Performance</h3>
        <br/>
         <table id="car_performance" class="display"  align="center">
                <thead>
                    <tr>
                        <th>Distance</th>
                        <th>Work Hours</th>
                        <th>Trip Cost</th>
                        <th>Parking / Toll</th>
                        <th>Date</th>
                    </tr>
                </thead> 
                <tfoot style="background-color: gainsboro;">
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                </tfoot>
         </table>
        
        <h3>Fuel Cost</h3>
        <br/>
        <table id="fuel_performance" class="display"  align="center">        
                <thead>
                    <tr>
                        <th>Fuel Cost</th>
                        <th>Liters</th>
                        <th>Price / Liter</th>
                        <th>Date</th>
                    </tr>
                </thead>        
                <tfoot style="background-color: gainsboro;">
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                </tfoot>
                
        </table>




    </div>
</div>


@stop

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="{{ URL::asset('public/js/partials/adminCarDetails.js')}}"></script>