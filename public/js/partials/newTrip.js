$(document).ready(function () {

    $('#start_trip').on('click', function() {
        if($('#start_km').val() == '') {
            $('#start_km').css('background-color', '#FFB0A2');
            $('#start_km').addClass('error_placeholder');
        }else {
            getLocation();
            getUTCTime('start_time');
            $('#start_address_icon').removeClass();
            $('#start_address_icon').addClass('fa fa-spin fa-spinner');
            $('#client_name').attr('disabled', true);
            $('#start_km').attr('disabled', true);
            $('#change_car').attr('disabled', true);
            $('#start_time').attr('disabled', true);
            $('#start_trip').attr('disabled', true);
            $('#end_trip').attr('disabled', false);
        }
    });

    $('#end_trip').on('click', function() {
        if($('#end_km').val() == '') {
            $('#end_km').css('background-color', '#FFB0A2');
            $('#end_km').addClass('error_placeholder');
        }else{
            getLocation();
            getUTCTime('end_time');
            $('#end_address_icon').removeClass();
            $('#end_address_icon').addClass('fa fa-spin fa-spinner');
            $('#end_km').attr('disabled', true);
            $('#destination_address').attr('disabled', true);
            $('#end_time').attr('disabled', true);
            $('#end_trip').attr('disabled', true);
            $('#water_bottle').attr('disabled', true);
            setTimeout(function(){ saveTrip()}, 1000);
            setTimeout(function(){ location.reload()}, 4000);
        }
    });

    $('#start_km').on('keyup', function(){
        $('#start_km').css('background-color', 'white');
    });

    $('#end_km').on('keyup', function(){
        $('#end_km').css('background-color', 'white');
    });

    $('#myModal').on('shown.bs.modal', function(e) {
        getAvailableCars();
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
            console.log($('#start_trip').attr('disabled'));
            console.log($('#end_trip').attr('disabled'));
            if($('#start_trip').attr('disabled') == 'disabled' && typeof($('#end_trip').attr('disabled')) == 'undefined') {
                $('#departure_address').val(data);
                $('#start_address_icon').removeClass();
                $('#start_address_icon').addClass('fa fa-map-marker');
            }else if($('#start_trip').attr('disabled') == 'disabled' && ($('#end_trip').attr('disabled')) == 'disabled') {
                $('#end_address_icon').removeClass();
                $('#end_address_icon').addClass('fa fa-map-marker');
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
                $('#alert').html('Your trip has been saved successfully, Refreshing...');
                $('#alert').show();
            }

        },
        error: function (data) {
            console.log(data);
        }
    });
}

function getAvailableCars() {

    var currentCarId = $('#current_car_id').val();

    $.ajax({
        url : "getavailablecars",
        type: "POST",
        data : {
            current_car_id: currentCarId
        },
        beforeSend: function(){
            //$('#modal_body').html('<p><span class="fa fa-spin fa-spinner"></span> Getting Available Cars...</p>');
        },
        success: function(data) {

            if(data.success == false) {
                $('#modal_body').html('<p><span class="fa fa-exclamation-triangle"></span> No Cars Available.</p>');
            }else {
                var availableCars = data.available_cars;
                $('#modal_body').html('');
                for (var i = 0;  i < availableCars.length ; i++) {
                    $('#modal_body').append('<p class="replace-text"><span class="fa fa-car"></span> ' + availableCars[i].name + ' - ' + availableCars[i].registration + '<button type="button" id="replace_' + availableCars[i].car_id + '" data-id="' + availableCars[i].car_id + '" class="replace btn btn-default fa fa-refresh" onclick="replaceCar(' + availableCars[i].car_id +')"></button> Replace</p>');
                }
            }
        },
        error: function (data) {
            console.log(data);
        }
    });
}

function replaceCar(carId) {
    $.ajax({
        url : "replacecar",
        type: "POST",
        data : {
            new_car_id: carId
        },
        beforeSend: function(){
            var button = $('#replace_' + carId);
            button.after('<i id="temp_spinner" style="margin-left: 12px;" class="fa fa-spin fa-spinner"></i>');
            button.remove();
        },
        success: function(data) {
            if(data.success == false) {
                $('#temp_spinner').removeClass();
                $('#temp_spinner').addClass('fa fa-exclamation');
            }else {
                $('#temp_spinner').removeClass();
                $('#temp_spinner').addClass('fa fa-check');
                $('#myModal').modal('hide');
                $('#car').val(data.new_car.name + ' - ' + data.new_car.registration);
            }
        },
        error: function (data) {
            console.log(data);
        }
    });
}
