@extends('layouts.mobile')
@section('title')
List of Vehicles
@stop

@section('body')

<h3>View Vehicles</h3>

<div id="carsContainer">
    <div id="mainContent">
        <table id="cars" class="display" >
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
            </table>
    </div>
</div>
@stop

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="{{ URL::asset('public/js/partials/viewCars.js')}}"></script>