@extends('layouts.mobile')
@section('title')
List of Active Drivers
@stop

@section('body')

<h3>View Active Drivers</h3>
<div>
    <button type="button" id="add_driver" class="btn btn-success pull-left" style="margin-bottom: 20px;margin-left: -20px;"><i class="fa fa-plus"></i> Add Driver</button>
</div>
<div id="driversContainer">
    <div id="mainContent">
        <table id="drivers" class="display" >
                <thead>
                    <tr>
                        <th nowrap>Driver ID</th>
                        <th>Code</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Car ID</th>
                        <th>GSM Number</th>
                        <th>Total Hours</th>
                        <th>Total Trips</th>
                        <th>Total Cost</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tfoot style="background-color: gainsboro;">
                    <tr>
                        <th colspan="8" style="text-align:right">Total:</th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                </tfoot>
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
                    <span class="input-group-addon"><i class="fa fa-envelope-o"></i> Email</span>
                    <input type="text" class="form-control input-group" id="email" name="email">
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


<div id="addModal" class="modal fade" role="dialog" style="margin-top: 200px;">
  <div class="modal-dialog">


    <!-- Modal content-->
    <div class="modal-content">

          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title"><span id="edit_modal_header" class="fa fa-plus"></span> Add Driver</h4>
          </div>

          <input type="hidden" id="driver_id" >

          <div class="modal-body" id="modal_body">

              <div class="input-group form-group">
                  <span class="input-group-addon"><i class="fa fa-code"></i> Drive Code</span>
                  <input type="text" class="form-control input-group" id="new_code" name="new_code">
              </div>
              <div class="input-group form-group">
                  <span class="input-group-addon"><i class="fa fa-user"></i> First Name</span>
                  <input type="text" class="form-control input-group" id="new_first" name="new_first">
              </div>
              <div class="input-group form-group">
                  <span class="input-group-addon"><i class="fa fa-user"></i> Last Name</span>
                  <input type="text" class="form-control input-group" id="new_last" name="last">
              </div>
              <div class="input-group form-group">
                    <span class="input-group-addon"><i class="fa fa-envelope-o"></i> Email</span>
                    <input type="text" class="form-control input-group" id="new_email" name="new_email">
              </div>
              <div class="input-group form-group">
                    <span class="input-group-addon"><i class="fa fa-key"></i> Password</span>
                    <input type="text" class="form-control input-group" id="new_password" name="new_password">
              </div>
              <div class="input-group form-group">
                  <span class="input-group-addon"><i class="fa fa-car"></i> Car ID</span>
                  <input type="text" class="form-control input-group" id="new_car_id" name="new_car_id">
              </div>
              <div class="input-group form-group">
                    <span class="input-group-addon"><i class="fa fa-list-ol"></i> GSM Number</span>
                    <input type="text" class="form-control input-group" id="new_gsm_number" name="new_gsm_number">
              </div>
              <div class="input-group form-group">
                  <span class="input-group-addon"><i class="fa fa-language"></i> Language</span>
                  <select id="new_language_id" class="selectpicker form-group input-group"  data-width="auto" name="new_language_id">
                    <option value="2">French</option>
                    <option value="1">English</option>
                  </select>
              </div>
              <div class="input-group form-group">
                  <span class="input-group-addon"><i class="fa fa-globe"></i> Time Zone</span>
                  <select id="new_time_zone" class="selectpicker form-group input-group"  data-width="auto" name="new_time_zone">
                    <option value="0">Morocco</option>
                    <option value="-8">USA - CA</option>
                  </select>
              </div>
          </div>

          <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-default" id="save_new_driver">Save</button>
          </div>

    </div>

  </div>
</div>

<div id="deleteModal" class="modal fade" role="dialog" style="margin-top: 200px;">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><span id="edit_modal_header" class="fa fa-times"></span> Delete Driver</h4>
      </div>
      <input type="hidden" id="delete_driver_id" >
      <div class="modal-body" id="modal_body" >
            <p>Are you sure you want to delete this Driver?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" id="delete_driver_req" >Delete</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
      </div>
    </div>

  </div>
</div>
@stop

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

<script src="{{ URL::asset('public/js/partials/viewDrivers.js')}}"></script>