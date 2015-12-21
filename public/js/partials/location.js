function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(savePosition, positionError, {timeout:10000});
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

function savePosition(position) {
    //$.post("geocoordinates.php", {lat: position.coords.latitude, lng: position.coords.longitude});

    $.ajax({
        url : "getlocation",
        type: "POST",
        data : {
            lat: position.coords.latitude,
            lng: position.coords.longitude
        },
        success: function(data) {
            console.log(data);
        },
        error: function (data) {
            console.log(data);
        }
    });
}



