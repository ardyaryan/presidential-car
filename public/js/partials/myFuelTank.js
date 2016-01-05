$(document).ready(function () {

    $('#get_time').on('click', function() {
        getUTCTime('date_and_time');
    });

    $('#save').on('click', function() {
        if($('#date_and_time').val() == '') {
            $('#date_and_time').css('background-color', '#FFB0A2');
            $('#date_and_time').addClass('error_placeholder');
        }else if($('#amount').val() == '') {
            $('#amount').css('background-color', '#FFB0A2');
            $('#amount').addClass('error_placeholder');
        }else if($('#cost').val() == '') {
            $('#cost').css('background-color', '#FFB0A2');
            $('#cost').addClass('error_placeholder');
        }else {
            save();
            $('#save').attr('disabled', true);
        }
    });

    $('#myModal').on('shown.bs.modal', function(e) {
        getAvailableCars();
    });

    $('#amount').on('keyup', function(){
        $('#amount').css('background-color', 'white');
    });

    $('#cost').on('keyup', function(){
        $('#cost').css('background-color', 'white');
    });
});

// handle the error here
function positionError(error) {
    var errorCode = error.code;
    var message = error.message;

    //alert(message);
}

function getUTCTime(resource) {

    $.ajax({
        url : "gettime",
        type: "POST",
        success: function(data) {
            $('#' + resource + '').val(data.date + ' ' + data.time);
            $('#' + resource + '').css('background-color', 'white');
        },
        error: function (data) {
            console.log(data);
        }
    });
}

function save() {

    var amount      = $('#amount').val();
    var cost        = $('#cost').val();
    var dateAndTime = $('#date_and_time').val();

    if( amount == '' || cost == '' || dateAndTime == '') {

    }

    $.ajax({
        url : "savefuelfillup",
        type: "POST",
        data : {
            amount: amount,
            cost: cost,
            date_and_time: dateAndTime
        },
        beforeSend: function(){
            $('#save').html('<span class="fa fa-spinner fa-spin"></span> Saving ...');
        },
        success: function(data) {

            if(data.success == false) {
                console.log(data);
            }else {
                $('#save').html('<span class="fa fa-check-square"></span> Saved!');
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
