@extends('layouts.mobile')
@section('title')
Dashboard
@stop

@section('body')
<div id="dashboardContainer">
    <div class="row" style="margin-left: 200px;">
        <form novalidate="novalidate" class="form-inline">
            <div class="form-group input-group col-sm-3  col-lg-offset-1 date">
                <input type="text" class="datepicker form-control" name="from" id="from" placeholder=" - From" data-provide="datepicker">
                <div class="input-group-addon">
                    <span class="glyphicon glyphicon-th"></span>
                </div>
            </div>

            <div class="form-group input-group col-sm-3 col-lg-offset-1 date">
                <input type="text" class="datepicker form-control" name="to" id="to" placeholder=" - To" data-provide="datepicker" >
                <div class="input-group-addon">
                    <span class="glyphicon glyphicon-th" ></span>
                </div>
            </div>
            <div class="input-group form-group col-sm-3">
                <button id="get_more_trips" class="btn btn-success" style="width: 40%; margin-top: 25px;"><i id="go_button_admin" class="fa fa-calendar"></i> GO!</button>
            </div>
        </form>

        <div class="form-group" id="graph_loading" style="margin-left: 320px; ">
            <span><i class="fa fa-spin fa-spinner" ></i> Loading ...</span>
        </div>
    </div>


    <div id="mainContent">
        <head></head>
        <div id="chartContainer" style="height: 300px; width: 100%;">
        </div>
    </div>



    <table cellpadding="10"   style="width: 100%;    margin-left: -170px;">
                    <thead style="background-color: white">
                        <th><h4 style="margin-left: 20px;">Costs</h4></th>
                        <th><h4 style="margin-left: 20px;">Report Table</h4></th>
                    </thead>
                    <tr>
                        <td style="padding: 20;" valign="top">
                            <div id="chartContainer2" style="height: 300px; width: 400px;"></div>
                        </td>

                        <td style="padding: 20;" valign="top">
                            <table id="report_table" class="display" style="width: 200px;">
                                    <thead>
                                        <tr>
                                            <th>Total Count</th>
                                            <th >Total Cost</th>
                                            <th>Total Km</th>
                                            <th>Total Time</th>
                                            <th>Total Fuel Cost</th>
                                            <th>Total Fuel Consumption</th>
                                            <th>Total Payments</th>
                                            <th>Total Other Payments</th>
                                        </tr>
                                    </thead>
                            </table>
                        </td>
                    </tr>
            </table>

</div>
@stop

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="{{ URL::asset('public/js/partials/adminDashboard.js')}}"></script>
