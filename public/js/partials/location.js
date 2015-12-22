$(document).ready(function () {

    $('#start_trip').on('click', function() {
        getUTCTime('start_time');
    });

    $('#end_trip').on('click', function() {
        getLocation();
        getUTCTime('end_time');
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
            $('#' + resource + '').val(data.date + ', ' + data.time);
        },
        error: function (data) {
            console.log(data);
        }
    });
}
