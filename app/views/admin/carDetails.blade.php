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




        <table cellpadding="10"   style="width: 100%;">
                <thead style="background-color: white">
                    <th ><h4 style="margin-left: 20px;">Trpis made by Vehicle</h4></th>
                    <th><h4 style="margin-left: 20px;">Fuel Tanks fillups made by Vehicle</h4></th>
                </thead>
                <tr>
                    <td style="padding: 20;" valign="top">
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
                    </td>

                    <td style="padding: 20;" valign="top">
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
                    </td>
                </tr>
        </table>





    </div>
</div>


@stop

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="{{ URL::asset('public/js/partials/carDetails.js')}}"></script>