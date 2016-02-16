@extends('layouts.mobile')
@section('title')
List of Active Clients
@stop

@section('body')

<h3>View Active Clients</h3>
<div>
    <button type="button" id="add_client" class="btn btn-success pull-left" style="margin-bottom: 20px;margin-left: -20px;"><i class="fa fa-plus"></i> Add Client</button>
</div>
<div id="clientsContainer">
    <div id="mainContent">
        <table id="clients" class="display" >
                <thead>
                    <tr>
                        <th nowrap>Client ID</th>
                        <th>Name</th>
                        <th>Base Rate</th>
                        <th>Price Per Km</th>
                        <th>Price Per Min</th>
                        <th>Currency</th>
                        <th>US Dollar Exchange Rate</th>
                        <th>Delete</th>
                        <th>Edit</th>
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
            <h4 class="modal-title"><span id="edit_modal_header" class="fa fa-pencil"></span> Edit Client</h4>
          </div>

          <input type="hidden" id="client_id" >

          <div class="modal-body" id="modal_body">

              <div class="input-group form-group">
                  <span class="input-group-addon"><i class="fa fa-user"></i> Name</span>
                  <input type="text" class="form-control input-group" id="name" name="name">
              </div>
              <div class="input-group form-group">
                  <span class="input-group-addon"><i class="fa fa-money"></i> Base Rate</span>
                  <input type="text" class="form-control input-group" id="base" name="base">
              </div>
              <div class="input-group form-group">
                  <span class="input-group-addon"><i class="fa fa-money"></i> Price Per Km</span>
                  <input type="text" class="form-control input-group" id="price_per_km" name="price_per_km">
              </div>
              <div class="input-group form-group">
                    <span class="input-group-addon"><i class="fa fa-money"></i> Price Per Min</span>
                    <input type="text" class="form-control input-group" id="price_per_min" name="price_per_min">
              </div>
              <div class="input-group form-group">
                  <span class="input-group-addon"><i class="fa fa-money"></i> Currency</span>
                  <input type="text" class="form-control input-group" id="currency" name="currency">
              </div>
              <div class="input-group form-group">
                    <span class="input-group-addon"><i class="fa fa-list-ol"></i> US Dollar Exchange Rate</span>
                    <input type="text" class="form-control input-group" id="us_dollar_exchange_rate" name="us_dollar_exchange_rate">
              </div>
          </div>

          <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-default" id="save_client">Save</button>
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
            <h4 class="modal-title"><span id="edit_modal_header" class="fa fa-plus"></span> Add Client</h4>
          </div>

          <div class="modal-body" id="modal_body">

              <div class="input-group form-group">
                  <span class="input-group-addon"><i class="fa fa-user"></i> Client Name</span>
                  <input type="text" class="form-control input-group" id="new_name" name="new_name">
              </div>
              <div class="input-group form-group">
                  <span class="input-group-addon"><i class="fa fa-money"></i> Base Rate</span>
                  <input type="text" class="form-control input-group" id="new_base" name="new_base">
              </div>
              <div class="input-group form-group">
                    <span class="input-group-addon"><i class="fa fa-money"></i> Price Per Km</span>
                    <input type="text" class="form-control input-group" id="new_price_per_km" name="new_price_per_km">
              </div>
              <div class="input-group form-group">
                    <span class="input-group-addon"><i class="fa fa-money"></i> Price Per Min</span>
                    <input type="text" class="form-control input-group" id="new_price_per_min" name="new_price_per_min">
              </div>
              <div class="input-group form-group">
                  <span class="input-group-addon"><i class="fa fa-money"></i> Currency</span>
                  <input type="text" class="form-control input-group" id="new_currency" name="new_currency">
              </div>
              <div class="input-group form-group">
                    <span class="input-group-addon"><i class="fa fa-usd"></i> US Dollar Exchange Rate</span>
                    <input type="text" class="form-control input-group" id="new_us_dollar_exchange_rate" name="new_us_dollar_exchange_rate">
              </div>

          </div>

          <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-default" id="save_new_client">Save</button>
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
        <h4 class="modal-title"><span id="edit_modal_header" class="fa fa-times"></span> Delete Client</h4>
      </div>
      <input type="hidden" id="delete_client_id" >
      <div class="modal-body" id="modal_body" >
            <p>Are you sure you want to delete this Client?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" id="delete_client_req" >Delete</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
      </div>
    </div>

  </div>
</div>
@stop

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

<script src="{{ URL::asset('public/js/partials/viewClients.js')}}"></script>