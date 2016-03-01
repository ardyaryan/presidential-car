@extends('layouts.mobile')
@section('title')
List of Vehicles
@stop

@section('body')

<h3>View Driver Details</h3>

<div id="carsContainer">
    <div id="mainContent">

        <table id="carDetails" class="display" >
                <thead>
                    <tr>
                        <th nowrap>Driver ID</th>
                        <th>User ID</th>
                        <th>CODE</th>
                        <th>Name</th>
                        <th>GSM Number</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th nowrap>{{$driverDetails['id'] }}</th>
                        <th>{{$driverDetails['user_id'] }}</th>
                        <th>{{$driverDetails['code'] }}</th>
                        <th>{{$driverDetails['first'].' '.$driverDetails['last'] }}</th>
                        <th>{{$driverDetails['gsm_number'] }}</th>
                    </tr>
                </tbody>
        </table>

        <table cellpadding="10"   style="width: 100%;">
                <thead style="background-color: white">
                    <th ><h4 style="margin-left: 20px;">Trips made by Driver</h4></th>
                    <th><h4 style="margin-left: 20px;">Fuel Tanks fillups made by Driver</h4></th>
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
                                        <th style="padding-left: 18px;">{{$trip['distance']}} Km</th>
                                        <th style="padding-left: 18px;">{{$trip['cost'] . ' ' . $trip['currency']}}</th>
                                        <th style="padding-left: 18px;">{{$trip['date']}}</th>
                                    </tr>
                                </tbody>
                                @endforeach
                                <tfoot style="background-color: gainsboro;">
                                <?php
                                    $totalDistance = 0;
                                    $totalCost = 0;
                                    foreach($trips as $trip) {
                                         $totalDistance = $trip['distance'] + $totalDistance;
                                         $totalCost = $trip['cost'] + $totalCost ;
                                    }
                                ?>

                                    <tr>
                                        <th>{{$totalDistance}} km</th>
                                        <th>{{$totalCost}} MAD</th>
                                        <th></th>
                                    </tr>
                                </tfoot>
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
                                <?php
                                    $totalFuelCost = 0;
                                    $totalLiter = 0
                                ?>
                                @foreach($fuelFillUps as $fuelFillUp)
                                     <?php
                                        $totalFuelCost = $fuelFillUp['cost'] + $totalFuelCost;
                                        $totalLiter = $fuelFillUp['amount'] + $totalLiter ;
                                     ?>
                                <tbody>
                                    <tr>
                                        <th style="padding-left: 18px;">{{$fuelFillUp['cost']}} MAD</th>
                                        <th style="padding-left: 18px;">{{$fuelFillUp['amount']}} Lit</th>
                                        <th style="padding-left: 18px;">{{round($fuelFillUp['price_per_liter'], 2)}} MAD  /Lit</th>
                                        <th style="padding-left: 18px;">{{$fuelFillUp['date_and_time']}}</th>
                                    </tr>
                                </tbody>
                                @endforeach
                                <tfoot style="background-color: gainsboro;">
                                    <tr>
                                        <th>{{$totalFuelCost}} MAD</th>
                                        <th>{{$totalLiter}} Lit</th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                        </table>
                    </td>
                </tr>
        </table>

    </div>
</div>


@stop

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="{{ URL::asset('public/js/partials/adminDriverDetails.js')}}"></script>