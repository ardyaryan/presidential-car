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
            /*
            $('#client_name').attr('disabled', true);
            $('#start_km').attr('disabled', true);
            $('#change_car').attr('disabled', true);
            $('#start_time').attr('disabled', true);
            */
            $('#start_trip').attr('disabled', true);
            $('#end_trip').attr('disabled', false);
        }
    });

    $('#end_trip').on('click', function() {
        if($('#end_km').val() == '' || (  parseInt($('#end_km').val()) <= parseInt($('#start_km').val()) ) ) {
            $('#end_km').css('background-color', '#FFB0A2');
            $('#end_km').addClass('error_placeholder');
        }else{
            getLocation();
            getUTCTime('end_time');
            $('#end_address_icon').removeClass();
            $('#end_address_icon').addClass('fa fa-spin fa-spinner');
            /*
            $('#end_km').attr('disabled', true);
            $('#destination_address').attr('disabled', true);
            $('#end_time').attr('disabled', true);
            */
            $('#end_trip').attr('disabled', true);
            $('#save_trip').attr('disabled', false);
        }
    });

    $('#save_trip').on('click', function() {
        if(!validate()) {
            return;
        }
        saveTrip();
        setTimeout(function(){ location.reload()}, 4000);
        $('#save_trip').attr('disabled', true);
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

    $('#custom_customer').on('click', function() {

        var buttClass = $('#custom_customer i').attr('class');
        if(buttClass == 'fa fa-plus') {
            $('#custom_customer i').removeClass('fa fa-plus');
            $('#custom_customer i').addClass('fa fa-minus');
            $('#customer_details').slideDown();
        } else {
            $('#custom_customer i').removeClass('fa fa-minus');
            $('#custom_customer i').addClass('fa fa-plus');
            $('#customer_details').slideUp();
        }
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
            if($('#start_km').val() != '' && $('#end_km').val() == '') {
                $('#departure_address').val(data);
                $('#start_address_icon').removeClass();
                $('#start_address_icon').addClass('fa fa-map-marker');
            }else if($('#start_km').val() != '' && $('#end_km').val() != '') {
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

    var buttonName  = ($('#language_id').val() == 2) ? ' Enregistrer' : ' Save Trip';
    var successMessage  = ($('#language_id').val() == 2) ? 'Enregistré!' : 'Your trip has been saved successfully, Refreshing...';
    var errorMessage  = ($('#language_id').val() == 2) ? 'Erreur!' : 'There was a problem saving your trip!';
    var client        = $('#client_name').val();
    var customerName  = $('#customer_name').val();

    var email       = $('#customer_email').val();
    var phone       = $('#customer_phone').val();
    var flatPrice   = $('#flat_price').val();
    var dailyPrice  = $('#daily_price').val();
    var hourlyPrice = $('#hourly_price').val();
    var base        = $('#base').val();
    var perKm       = $('#per_km').val();
    var perMin      = $('#per_min').val();

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
                customer_name: customerName,
                email: email,
                phone: phone,
                flat_price: flatPrice,
                daily_price: dailyPrice,
                hourly_price: hourlyPrice,
                base: base,
                per_km: perKm,
                per_min: perMin,
                departure_km: startKm,
                departure_date_time: startTime,
                arrival_km: endKm,
                arrival_date_time: endTime,
                departure_address: startAddr,
                arrival_address: endAddr
        },
        beforeSend: function(){
            $('#save_trip').html('<span class="fa fa-spinner fa-spin"></span>' + buttonName + '');
        },
        success: function(data) {

            if(data.success == false) {
                $('#save_trip').html('<span class="fa fa-remove"></span>' + buttonName + '');
                $('#alert').addClass('alert alert-danger');
                $('#alert').html(errorMessage);
                $('#alert').show();
            }else {
                $('#save_trip').html('<span class="fa fa-check-square"></span>' + buttonName + '');
                $('#alert').addClass('alert alert-success');
                $('#alert').html(successMessage);
                $('#alert').show();
            }

        },
        error: function (data) {
            console.log(data);
        }
    });
}

function getAvailableCars() {
    var replaceWord     = ($('#language_id').val() == 2) ? ' Remplacer' : ' Replace';
    var statusStatement = ($('#language_id').val() == 2) ? ' Pas des Véhicules Disponibles' : ' No Cars Available.';

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
                $('#modal_body').html('<p><span class="fa fa-exclamation-triangle"></span>' + statusStatement + '</p>');
            }else {
                var availableCars = data.available_cars;
                $('#modal_body').html('');
                for (var i = 0;  i < availableCars.length ; i++) {
                    $('#modal_body').append('<p class="replace-text"><span class="fa fa-car"></span> ' + availableCars[i].name + ' - ' + availableCars[i].registration + '<button type="button" id="replace_' + availableCars[i].car_id + '" data-id="' + availableCars[i].car_id + '" class="replace btn btn-default fa fa-refresh" onclick="replaceCar(' + availableCars[i].car_id +')"></button>' + replaceWord + '</p>');
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

function validate() {
    var clientName = $('#client_name').val();
    var email        = $('#customer_email').val();
    var phone        = $('#customer_phone').val();
    var flatPrice    = $('#flat_price').val();
    var dailyPrice   = $('#daily_price').val();
    var hourlyPrice  = $('#hourly_price').val();
    var base         = $('#base').val();
    var perKm        = $('#per_km').val();
    var perMin       = $('#per_min').val();

    var customContactCheck = false;
    if (email != '' && phone != '') {
        customContactCheck = true;
    }

    var customRateCheck = false;
    if (clientName == '') {
        if (flatPrice == '') {
            if (dailyPrice == '') {
                if (hourlyPrice == '') {
                    if (base == '' && perKm == '' && perMin == '') {
                        $('#client_name_div').css({border: 'solid', color :'#FFB0A2'});
                        customRateCheck = false;
                    } else {
                        customRateCheck = true;
                    }
                } else {
                    customRateCheck = true;
                }
            } else {
                customRateCheck = true;
            }
        } else {
            customRateCheck = true;
        }
    } else {
        $('#client_name_div').css({border: '', color :''});
        customRateCheck = true;
    }

    if (customContactCheck) {
        $('#customer_email, #customer_phone,#client_name').css('background-color', '');
        if (customRateCheck) {
            $('#flat_price, #daily_price, #daily_price, #hourly_price, #base, #per_km, #per_min').css('background-color', '');
            return true;
        } else {
            $('#flat_price, #daily_price, #daily_price, #hourly_price, #base, #per_km, #per_min').css('background-color', '#FFB0A2');
            return false;
        }
    } else {
        $('#customer_email, #customer_phone').css('background-color', '#FFB0A2');
        return false;
    }


}
