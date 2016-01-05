@extends('layouts.mobile')
@section('title')
Daily Trips
@stop

@section('body')
<h3>New Fill-Up:</h3>
<div>

    <div class="input-group form-group">
        <span class="input-group-addon"><i class="fa fa-truck"></i> Vehicle</span>
        <input type="text" class="form-control" id="car" name="car" value="{{$car['car_name'].' - '.$car['car_reg']}}" disabled>
        <span class="input-group-btn">
             <button type="button" id="change_car" class="btn btn-default" data-toggle="modal" data-target="#myModal" ><i class="fa fa-pencil"></i> Change</button>
        </span>
    </div>

    <div class="input-group form-group">
        <span class="input-group-addon"><i class="fa fa-clock-o"></i> Date & Time</span>
        <input type="text" class="form-control" id="date_and_time" name="date_and_time" placeholder=" - YYYY-MM-DD H:M:S">
        <div class="input-group-btn">
            <button id="get_time" class="btn btn-success"> Get Time</button>
        </div>
    </div>

    <div class="input-group form-group">
        <span class="input-group-addon"><i class="fa fa-sort-amount-desc"></i> Amount (Liter)</span>
        <input type="number" class="form-control" id="amount" name="amount" placeholder=" - 0.0">
    </div>

    <div class="input-group form-group">
        <span class="input-group-addon"><i class="fa fa-money"></i> Cost </span>
        <input type="number" class="form-control" id="cost" name="cost" placeholder=" - $ 0.00">
    </div>

    <div class=" form-group">
        <button id="save" class="btn btn-success" style="width: 100%;"><i class=""></i> Submit</button>
    </div>

    <div id="alert" style="display: none">
    </div>
</div>

<div id="myModal" class="modal fade" role="dialog" style="margin-top: 200px;">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><span class="fa fa-car"></span> Change Vehicle</h4>
      </div>
      <input type="hidden" id="current_car_id" value="{{Session::get('car_id')}}" >
      <div class="modal-body" id="modal_body">
        <p><span class="fa fa-spin fa-spinner"></span> Getting Available Cars...</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
@stop

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="{{ URL::asset('public/js/partials/myFuelTank.js')}}"></script>