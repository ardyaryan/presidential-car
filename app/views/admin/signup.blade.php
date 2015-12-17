@extends('layouts.adminMain')
@section('title')
Sign Up
@stop

@section('body')
<div id="signupContainer">
    <div id="mainContent">
        <h2>Sign Up New User:</h2>
        <div id="form">
            <form role="form" class="form-inline">
                <div class="form-group">
                    <label for="email">Email:</label><br/>
                    <input type="text" class="form-control" id="email" name="email">
                </div>

                <div class="form-group-btn">
                    <label for="first">First Name:</label><br/>
                    <input type="text" class="form-control" id="first" name="first">
                </div>

                <div class="form-group-btn">
                    <label for="last">Last Name:</label><br/>
                    <input type="text" class="form-control" id="last" name="last">
                </div>


                <div class="form-group">
                    <label for="client_name">User Role:</label><br/>
                    <select id="role_id" class="selectpicker form-control"  data-width="auto" name="role_id">
                      <option value="1">Admin</option>
                      <option value="2">Driver</option>
                    </select>
                </div>

                <div class="form-group-btn">
                    <label for="password">Password:</label><br/>
                    <input type="password" class="form-control" id="password" name="password">
                </div>

                <div class="form-group-btn">
                    <label for="password_2">Confirm Password:</label><br/>
                    <input type="password" class="form-control" id="password_2" name="password_2">
                </div>

                <br/>
                <div>
                    <button type="submit" class="btn btn-default" id="submit">Submit</button>
                    <div id="message" style="display: none"></div>
                </div>
            </form>
        </div>
    </div>
</div>
@stop

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="{{ URL::asset('public/js/partials/signup.js')}}"></script>