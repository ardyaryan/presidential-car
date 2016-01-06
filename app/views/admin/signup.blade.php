@extends('layouts.mobile')
@section('title')
Sign Up
@stop

@section('body')

<div id="signupContainer">
    <div id="mainContent">
        <h3>Sign Up:</h3>
        <div id="form">
            <form role="form" >

                <div class="input-group form-group">
                    <span class="input-group-addon"><i class="fa fa-envelope"></i> Email</span>
                    <input type="text" class="form-control" id="email" name="email">
                </div>

                <div class="input-group form-group">
                    <span class="input-group-addon"><i class="fa fa-user"></i> First Name</span>
                    <input type="text" class="form-control" id="first" name="first">
                </div>

                <div class="input-group form-group">
                    <span class="input-group-addon"><i class="fa fa-user"></i> Last Name</span>
                    <input type="text" class="form-control" id="last" name="last">
                </div>

                <div class="input-group form-group">
                    <span class="input-group-addon"><i class="fa fa-users"></i> User Role</span>
                    <select id="role_id" class="selectpicker form-group input-group"  data-width="auto" name="role_id">
                      <option value="1">Admin</option>
                      <option value="2">Driver</option>
                    </select>
                </div>

                <div id="driver_code_div" class="input-group form-group" style="display: none">
                    <span class="input-group-addon"><i class="fa fa-hashtag"></i> Driver Code</span>
                    <input type="text" class="form-control" id="driver_code" name="driver_code">
                </div>

                <div id="gsm_div"class="input-group form-group" style="display: none">
                    <span class="input-group-addon"><i class="fa fa-file-o"></i> GSM Number</span>
                    <input type="text" class="form-control" id="gsm" name="gsm">
                </div>

                <div class="input-group form-group">
                    <span class="input-group-addon"><i class="fa fa-language"></i> Language</span>
                    <select id="language_id" class="selectpicker form-group input-group"  data-width="auto" name="language_id">
                      <option value="2">French</option>
                      <option value="1">English</option>
                    </select>
                </div>

                <div class="input-group form-group">
                    <span class="input-group-addon"><i class="fa fa-globe"></i> Time Zone</span>
                    <select id="time_zone" class="selectpicker form-group input-group"  data-width="auto" name="time_zone">
                      <option value="0">Morocco</option>
                      <option value="-8">USA - CA</option>
                    </select>
                </div>


                <div class="input-group form-group">
                    <span class="input-group-addon"><i class="fa fa-key"></i> Password</span>
                    <input type="password" class="form-control" id="password" name="password">
                </div>

                <div class="input-group form-group">
                    <span class="input-group-addon"><i class="fa fa-key"></i> Confirm Password</span>
                    <input type="password" class="form-control" id="password_2" name="password_2">
                </div>

                <div>
                    <button id="submit" type="submit" class="btn btn-success form-group" style="width: 100%;"> Submit</button>
                    <div id="message" style="display: none"></div>
                </div>
            </form>
        </div>
    </div>
</div>
@stop

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="{{ URL::asset('public/js/partials/signup.js')}}"></script>