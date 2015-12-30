@extends('layouts.mobile')
@section('title')
List of Active Drivers
@stop

@section('body')
<div id="driversContainer">
    <div id="mainContent">
        <h2>Active Drivers</h2>

        <table id="drivers"  width="100%">
            <thead>
                <tr>
                    <th>Driver Code</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>GSM Number</th>
                    <th>Date Assigned</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
@stop

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="{{ URL::asset('public/js/partials/viewDrivers.js')}}"></script>