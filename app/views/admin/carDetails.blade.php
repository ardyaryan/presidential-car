@extends('layouts.mobile')
@section('title')
List of Vehicles
@stop

@section('body')

<h3>View Vehicles Details</h3>

<div id="carsContainer">
    <div id="mainContent">
        <table id="carDetails" class="display" >
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

        <h3>Trpis made by Vehicle</h3>

        <table id="carTrips" class="display" >
                <thead>
                    <tr>
                        <th>Distance</th>
                        <th>Cost</th>
                        <th>Date</th>
                    </tr>
                </thead>
                @foreach($trips as $trip)
                <tbody>
                    <tr>
                        <th>{{$trip['distance'] }} Km</th>
                        <th>{{$trip['cost'] .' '. $trip['currency'] }}</th>
                        <th>{{$trip['date'] }}</th>
                    </tr>
                </tbody>
                @endforeach
        </table>
        
        <h3>Fuel Tanks fillups made by Vehicle</h3>

        <table id="carFuelFillUps" class="display" >
                <thead>
                    <tr>
                        <th>Cost</th>
                        <th>Amount</th>
                        <th>Price/Liter</th>
                        <th>Date</th>
                    </tr>
                </thead>
                @foreach($fuelFillUps as $fuelFillUp)
                <tbody>
                    <tr>
                        <th>{{$fuelFillUp['cost']}}</th>
                        <th>{{$fuelFillUp['amount']}}</th>
                        <th>{{$fuelFillUp['price_per_liter']}}</th>
                        <th>{{$fuelFillUp['date_and_time']}}</th>
                    </tr>
                </tbody>
                @endforeach
        </table>
    </div>
</div>


@stop

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="{{ URL::asset('public/js/partials/carDetails.js')}}"></script>