$(document).ready(function () {

    $('.datepicker').datepicker({
        dateFormat: 'yy-mm-dd',
        startDate: '-3d'
    });

    $('#editModal').on('hidden.bs.modal', function() {
        $('#modal_body').hide();
        $('#edit_modal_header').removeClass();
        $('#edit_modal_header').addClass('fa fa-spin fa-spinner');
    });

    $('#delete_trip_req').on('click', function() {
        var tripId = $('#delete_trip_id').val();
        requestDeletion(tripId);
    });

    $('#edit_trip_req').on('click', function() {
        var tripId = $('#trip_id').val();
        requestRevision(tripId);
    });

    $('#get_more_trips').on('click', function() {
        $('#get_more_trips').attr('disabled', true);
        showMyTrips();
    });

    showMyTrips();
});

function editTripModal(tripId) {

    $.ajax({
        url : "gettrip",
        type: "POST",
        data : {
            trip_id: tripId
        },
        beforeSend: function(){
            //$('#modal_body').html('<p><span class="fa fa-spin fa-spinner"></span> Getting Available Cars...</p>');
        },
        success: function(data) {
            $('#trip_id').val(tripId);
            $('#client').val(data.client_name);
            $('#customer_name').val(data.customer_name);
            $('#start_km').val(data.departure_km);
            $('#end_km').val(data.arrival_km);
            $('#start_time').val(data.departure_date_time);
            $('#end_time').val(data.arrival_date_time);
            $('#departure_address').val(data.departure_address);
            $('#destination_address').val(data.arrival_address);
            $('#edit_modal_header').removeClass();
            $('#edit_modal_header').addClass('fa fa-car');
            $('#modal_body').show();
            return data;
        },
        error: function (data) {
            console.log(data);
        }
    });
}

function pluckTripId(tripId) {
    $('#delete_trip_id').val(tripId);
}

function requestDeletion(tripId) {

    $.ajax({
        url : "requestdeletion",
        type: "POST",
        data : {
            trip_id: tripId
        },
        beforeSend: function(){
            $('#delete_trip_req').append(' <span class="fa fa-spin fa-spinner"></span>');
        },
        success: function(data) {
            if(data.success == true) {
                $('#deleteModal').modal('hide');
                location.reload();
            }else {
                $('#delete_trip_req').remove('<span class="fa fa-spin fa-spinner"></span>');
                $('#delete_trip_req').append('<span class="fa fa-times"></span>');
            }
        },
        error: function (data) {
            console.log(data);
        }
    });
}

function requestRevision(tripId) {

    var car = $('#car').val();
    var client = $('#client').val();
    var customerName = $('#customer_name').val();
    var startKm = $('#start_km').val();
    var endKm = $('#end_km').val();
    var startTime = $('#start_time').val();
    var endTime = $('#end_time').val();
    var departureAddress = $('#departure_address').val();
    var destinationAddress = $('#destination_address').val();

    $.ajax({
        url : "requestrevision",
        type: "POST",
        data : {
            trip_id: tripId,
            car : car,
            client : client,
            customer_name : customerName,
            start_km : startKm,
            end_km : endKm,
            start_time : startTime,
            end_time : endTime,
            departure_address : departureAddress,
            destination_address : destinationAddress
        },
        beforeSend: function(){
            $('#edit_trip_req').append(' <span class="fa fa-spin fa-spinner"></span>');
        },
        success: function(data) {
            if(data.success == true) {
                $('#editModal').modal('hide');
                location.reload();
            }else {
                $('#edit_trip_req').remove('<span class="fa fa-spin fa-spinner"></span>');
                $('#edit_trip_req').append('<span class="fa fa-times"></span>');
            }
        },
        error: function (data) {
            console.log(data);
        }
    });
}

function showMyTrips() {

    var from = $('#from').val();
    var to = $('#to').val();

    if ( from != '' && to != '') {
        $('#time_range_span').html(from + ' <i class="fa fa-arrow-right"></i> ' + to);
    }

    $.ajax({
        url : "showmytrips",
        type: "POST",
        data : {
            from: from,
            to: to
        },
        beforeSend: function(){
            $('#trips_time_tag').removeClass();
            $('#trips_time_tag').addClass('fa fa-spin fa-spinner');
            $('#trips_body').html('');
        },
        success: function(data) {
            if(data.success == true) {
                $('#trips_time_tag').removeClass();
                $('#trips_time_tag').addClass('fa fa-calendar-o');
                var myTrips = data.my_trips;
                var car = data.car;
                $('#car').val(car.name + ' - '+ car.registration);
                $('#get_more_trips').attr('disabled', false);

                for(var i = 0 ; i < myTrips.length; i ++) {

                   if(myTrips[i].delete_req != null) {
                       var bgColor = 'style="background-color: #E6BEBE"';
                       var disabled = 'disabled';
                   }else if (myTrips[i].edit_req != null )  {
                       var bgColor = 'style="background-color: #BEE6CE"';
                       var disabled = 'disabled';
                   }else {
                       var bgColor = '';
                       var disabled = '';
                   }

                   $('#trips_body').append('<div class="input-group form-group">' +
                   '<span class="input-group-addon"><i class="fa fa-location-arrow"></i></span>' +
                   '<input type="text" class="form-control input-group" id="trip" name="trip" value="Trip ID:' +  myTrips[i].id + ' - Date: ' + myTrips[i].departure_date_time + ' - Cost: ' + parseFloat(Math.round(myTrips[i].trip_cost * 100) / 100).toFixed(2) + ' ' + myTrips[i].currency + ' " ' + bgColor + ' disabled>' +
                   '<span class="input-group-btn">' +
                   '<button type="button" id="edit_trip" class="btn btn-default" data-toggle="modal" onclick="editTripModal(' + myTrips[i].id + ')" data-target="#editModal" ' + disabled + ' ><i class="fa fa-pencil"></i>&nbsp;</button>' +
                   '<button type="button" id="delete_trip" class="btn btn-default" data-toggle="modal" onclick="pluckTripId(' + myTrips[i].id+  ')" data-target="#deleteModal" ' + disabled + '> <i class="fa fa-times" style="color: red"></i>&nbsp;</button>' +
                   '</span>' +
                   '</div>');
                }
            }else {
                console.log(data);
            }
        },
        error: function (data) {
            console.log(data);
        }
    });
}