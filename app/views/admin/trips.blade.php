@extends('layouts.main')
@section('title')
Admin Login
@stop

@section('body')
<div id="tripsContainer">
    <div id="mainContent">
        <h2>Enter New Trips</h2>
        <div id="form">
            <form role="form">
              <div class="form-group">
                <label for="email">Client Name:</label>
                <input type="text" class="form-control" id="client_name">
                <label for="email">Departure Hour:</label>
                <select  class="form-control" id="departure_hour">
                    <option value="1">1</option>
                    <option value="2">2</option>
                </select>
              </div>

              <div class="input-group">
                  <!--<span class="input-group-addon">Label 2</span>-->
                  <label for="email">Departure Hour:</label>
                  <select id="departure_hour" class="selectpicker form-control">
                      <option value="1">1</option>
                      <option value="2">2</option>
                      <option value="3">3</option>
                      <option value="4">4</option>
                  </select>
              </div>

              <div class="form-group">
                <label for="pwd">Password:</label>
                <input type="password" class="form-control" id="pwd">
              </div>
              <div class="checkbox">
                <label><input type="checkbox"> Remember me</label>
              </div>
              <button type="submit" class="btn btn-default">Submit</button>
            </form>
        </div>
    </div>
</div>
@stop

