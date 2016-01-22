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
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
    </div>
</div>

<div id="editModal" class="modal fade" role="dialog" style="margin-top: 200px;">
  <div class="modal-dialog">


    <!-- Modal content-->
    <div class="modal-content">

          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title"><span id="edit_modal_header" class="fa fa-pencil"></span> Edit Driver</h4>
          </div>

          <input type="hidden" id="driver_id" >

          <div class="modal-body" id="modal_body">

              <div class="input-group form-group">
                  <span class="input-group-addon"><i class="fa fa-code"></i> Drive Code</span>
                  <input type="text" class="form-control input-group" id="code" name="code">
              </div>
              <div class="input-group form-group">
                  <span class="input-group-addon"><i class="fa fa-user"></i> First Name</span>
                  <input type="text" class="form-control input-group" id="first" name="first">
              </div>
              <div class="input-group form-group">
                  <span class="input-group-addon"><i class="fa fa-user"></i> Last Name</span>
                  <input type="text" class="form-control input-group" id="last" name="last">
              </div>
              <div class="input-group form-group">
                  <span class="input-group-addon"><i class="fa fa-car"></i> Car ID</span>
                  <input type="text" class="form-control input-group" id="car_id" name="car_id">
              </div>
              <div class="input-group form-group">
                    <span class="input-group-addon"><i class="fa fa-list-ol"></i> GSM Number</span>
                    <input type="text" class="form-control input-group" id="gsm_number" name="gsm_number">
              </div>
          </div>

          <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-default" id="save_driver">Save</button>
          </div>

    </div>

  </div>
</div>

@stop

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

<script src="{{ URL::asset('public/js/partials/viewDrivers.js')}}"></script>