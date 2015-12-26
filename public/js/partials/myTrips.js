$(document).ready(function () {

    $('#editModal').on('hidden.bs.modal', function() {
        $('#modal_body').hide()
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
            $('#water').val(data.water_bottle);
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
    var water = $('#water').val();
    var startKm = $('#start_km').val();
    var endKm = $('#end_km').val();
    var startTime = $('#start_time').val();
    var endTime = $('#end_time').val();
    var departureAddress = $('#departure_address').val();
    var destinationAddress = $('#destination_address').val();
    var water = $('#water').val();

    $.ajax({
        url : "requestrevision",
        type: "POST",
        data : {
            trip_id: tripId,
            car : car,
            client : client,
            start_km : startKm,
            end_km : endKm,
            start_time : startTime,
            end_time : endTime,
            departure_address : departureAddress,
            destination_address : destinationAddress,
            water : water
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
