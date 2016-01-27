@extends('layouts.mobile')
@section('title')
List of Vehicles
@stop

@section('body')

<h3>View Vehicles</h3>
<div>
    <button type="button" id="add_car" class="btn btn-success pull-left" style="margin-bottom: 20px;margin-left: -20px;"><i class="fa fa-plus"></i> Add Car</button>
</div>
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
                        <th>Edit</th>
                        <th>Delete</th>
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
            <h4 class="modal-title"><span id="edit_modal_header" class="fa fa-pencil"></span> Edit Car</h4>
          </div>

          <input type="hidden" id="car_id" >

          <div class="modal-body" id="modal_body">

              <div class="input-group form-group">
                  <span class="input-group-addon"><i class="fa"></i> Name</span>
                  <input type="text" class="form-control input-group" id="name" name="name">
              </div>
              <div class="input-group form-group">
                  <span class="input-group-addon"><i class="fa"></i> Brand</span>
                  <input type="text" class="form-control input-group" id="brand" name="brand">
              </div>
              <div class="input-group form-group">
                    <span class="input-group-addon"><i class="fa"></i> Model</span>
                    <input type="text" class="form-control input-group" id="model" name="model">
              </div>
              <div class="input-group form-group">
                  <span class="input-group-addon"><i class="fa"></i> Registration</span>
                  <input type="text" class="form-control input-group" id="registration" name="registration">
              </div>
              <div class="input-group form-group">
                    <span class="input-group-addon"><i class="fa"></i> Police Number</span>
                    <input type="text" class="form-control input-group" id="police_number" name="police_number">
              </div>
              <div class="input-group form-group">
                   <span class="input-group-addon"><i class="fa"></i> Uber Number</span>
                   <input type="text" class="form-control input-group" id="uber_number" name="uber_number">
              </div>
          </div>

          <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-default" id="save_car">Save</button>
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
            <h4 class="modal-title"><span id="edit_modal_header" class="fa fa-plus"></span> Add Car</h4>
          </div>

          <input type="hidden" id="car_id" >

          <div class="modal-body" id="modal_body">
              <div class="input-group form-group">
                  <span class="input-group-addon"><i class="fa "></i> Name</span>
                  <input type="text" class="form-control input-group" id="new_name" name="new_name">
              </div>
            <div class="input-group form-group">
                <span class="input-group-addon"><i class="fa "></i> Brand</span>
                <input type="text" class="form-control input-group" id="new_brand" name="new_brand">
            </div>
            <div class="input-group form-group">
                  <span class="input-group-addon"><i class="fa "></i> Model</span>
                  <input type="text" class="form-control input-group" id="new_model" name="new_model">
            </div>
            <div class="input-group form-group">
                <span class="input-group-addon"><i class="fa "></i> Registration</span>
                <input type="text" class="form-control input-group" id="new_registration" name="new_registration">
            </div>
            <div class="input-group form-group">
                  <span class="input-group-addon"><i class="fa"></i> Police Number</span>
                  <input type="text" class="form-control input-group" id="new_police_number" name="new_police_number">
            </div>
            <div class="input-group form-group">
                 <span class="input-group-addon"><i class="fa"></i> Uber Number</span>
                 <input type="text" class="form-control input-group" id="new_uber_number" name="new_uber_number">
            </div>
          </div>

          <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-default" id="save_new_car">Save</button>
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
        <h4 class="modal-title"><span id="edit_modal_header" class="fa fa-times"></span> Delete Car</h4>
      </div>
      <input type="hidden" id="delete_car_id" >
      <div class="modal-body" id="modal_body" >
            <p>Are you sure you want to delete this Car?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" id="delete_car_req" >Delete</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
      </div>
    </div>

  </div>
</div>
@stop

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="{{ URL::asset('public/js/partials/viewCars.js')}}"></script>