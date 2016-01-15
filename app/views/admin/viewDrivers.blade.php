@extends('layouts.mobile')
@section('title')
List of Active Drivers
@stop

@section('body')

<h3>View Active Drivers</h3>

<div id="driversContainer">
    <div id="mainContent">
        <table id="drivers" class="display" >
                <thead>
                    <tr>
                        <th nowrap>Driver ID</th>
                        <th>Code</th>
                        <th>Name</th>
                        <th>Car ID</th>
                        <th>GSM Number</th>
                    </tr>
                </thead>
            </table>
    </div>
</div>
@stop

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

<script src="{{ URL::asset('public/js/partials/viewDrivers.js')}}"></script>