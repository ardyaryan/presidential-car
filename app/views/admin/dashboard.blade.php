@extends('layouts.main')
@section('title')
Dashboard
@stop

@section('body')
<div id="dashboardContainer">
    <div id="mainContent">
        <h2>View Driver Activity</h2>

        <head>


        	<div id="chartContainer" style="height: 300px; width: 100%;">
        	</div>


    </div>
</div>
@stop

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="{{ URL::asset('public/js/partials/dashboard.js')}}"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/canvasjs/1.7.0/canvasjs.min.js"></script>