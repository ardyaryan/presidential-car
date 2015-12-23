$(document).ready(function () {

    $('#start_trip').on('click', function() {
        if($('#start_km').val() == '') {
            $('#start_km').css('background-color', '#FFB0A2');
            $('#start_km').addClass('error_placeholder');
        }else {
            getLocation();
            getUTCTime('start_time');
            $('#client_name').attr('disabled', true);
            $('#start_km').attr('disabled', true);
            $('#departure_address').attr('disabled', true);
            $('#start_time').attr('disabled', true);
            $('#start_trip').attr('disabled', true);

        }
    });

    $('#end_trip').on('click', function() {
        if($('#end_km').val() == '') {
            $('#end_km').css('background-color', '#FFB0A2');
            $('#end_km').addClass('error_placeholder');
        }else{
            getLocation();
            getUTCTime('end_time');
            $('#end_km').attr('disabled', true);
            $('#destination_address').attr('disabled', true);
            $('#end_time').attr('disabled', true);
            $('#end_trip').attr('disabled', true);
            $('#water_bottle').attr('disabled', true);
            setTimeout(function(){ saveTrip()}, 1000);
            //saveTrip();
        }
    });

    $('#start_km').on('keyup', function(){
        $('#start_km').css('background-color', 'white');
    });

    $('#end_km').on('keyup', function(){
        $('#end_km').css('background-color', 'white');
    });

    $('#change_car').on('click', function(){
        $('#car').attr('disabled', false);
    });

    $('#car').on('blur', function(){
        $('#car').attr('disabled', true);
    });
});

function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showLocation, positionError, {timeout:10000});
    } else {
        //Geolocation is not supported by this browser
    }
}

// handle the error here
function positionError(error) {
    var errorCode = error.code;
    var message = error.message;

    alert(message);
}

function showLocation(position) {

    $.ajax({
        url : "getlocation",
        type: "POST",
        data : {
            lat: position.coords.latitude,
            lng: position.coords.longitude
        },
        success: function(data) {
            if($('#departure_address').val() == '') {
                $('#departure_address').val(data);
            }else {
                $('#destination_address').val(data);
            }

        },
        error: function (data) {
            console.log(data);
        }
    });
}

function getUTCTime(resource) {

    $.ajax({
        url : "gettime",
        type: "POST",
        success: function(data) {
            $('#' + resource + '').val(data.date + ' ' + data.time);
        },
        error: function (data) {
            console.log(data);
        }
    });
}

function saveTrip() {

    var client      = $('#client_name').val();
    var waterBottle = $('#water_bottle').val();
    var startKm     = $('#start_km').val();
    var endKm       = $('#end_km').val();
    var startAddr   = $('#departure_address').val();
    var endAddr     = $('#destination_address').val();
    var startTime   = $('#start_time').val();
    var endTime     = $('#end_time').val();

    $.ajax({
        url : "savenewtrip",
        type: "POST",
        data : {
                client_id: client,
                departure_km: startKm,
                departure_date_time: startTime,
                arrival_km: endKm,
                arrival_date_time: endTime,
                departure_address: startAddr,
                arrival_address: endAddr,
                water_bottle: waterBottle
        },
        beforeSend: function(){
            $('#end_trip').html('<span class="fa fa-spinner fa-spin"></span> End Trip');
        },
        success: function(data) {

            if(data.success == false) {
                $('#end_trip').html('<span class="fa fa-remove"></span> End Trip');
                $('#alert').addClass('alert alert-danger');
                $('#alert').html('There was a problem saving your trip!');
                $('#alert').show();
            }else {
                $('#end_trip').html('<span class="fa fa-check-square"></span> End Trip');
                $('#alert').addClass('alert alert-success');
                $('#alert').html('Your trip has been saved successfully.');
                $('#alert').show();
            }

        },
        error: function (data) {
            console.log(data);
        }
    });
};