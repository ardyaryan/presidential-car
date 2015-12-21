@extends('layouts.mobile')
@section('title')
Daily Trips
@stop

@section('body')

<button onclick="getLocation();">Get My Location</button>


@stop

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="{{ URL::asset('public/js/partials/location.js')}}"></script>