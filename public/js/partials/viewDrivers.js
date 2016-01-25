$(document).ready(function(){


    $('#drivers').DataTable({});

    getAllDrivers();

    $('.btn.edit-driver').on('click',function(){
        var driverId = $(this).attr('data-id');
        editDriver(driverId);
    });


    $('#editModal').on('hidden.bs.modal', function () {
        $('#save_driver').html('Save');
    });

    $('#save_driver').on('click', function() {
        saveDriver();
    });


});


function getAllDrivers() {

    $('#drivers').DataTable({
        'ajax': {
            "type"   : "POST",
            "url"    : 'getdrivers',
            "data"   : {},
            "dataSrc": "",
            "async"  : false
        },
        "destroy": true,
        'columns': [
            {"data" : "id"},
            {"data" : "code"},
            {"data" : "name"},
            {"data" : "car_id"},
            {"data" : "gsm_number"},
            {"mRender": function ( data, type, row ) {
                return '<a class="btn edit-driver" data-id="' + row.id +'"><i class="fa fa-pencil-square-o"></i> Edit</a>';
                }
            }
        ]
    });
    $('input[aria-controls="drivers"]').prop('type', 'text');

    $('.btn.edit-driver').on('click',function(){
        var driverId = $(this).attr('data-id');
        editDriver(driverId);
    });
}

function editDriver(driverId) {

    var driver = '';

    $.ajax({
        url : "getdriverbyid",
        type: "POST",
        async: false,
        data : {
            driver_id: driverId
        },
        beforeSend: function(){
            //$('#delete_trip_req').append(' <span class="fa fa-spin fa-spinner"></span>');
        },
        success: function(data) {
            if(data.success == true) {
                console.log(data);
                driver = data.driver;
                $('#driver_id').val(driver.id);
                $('#code').val(driver.code);
                $('#first').val(driver.first);
                $('#last').val(driver.last);
                $('#car_id').val(driver.car_id);
                $('#gsm_number').val(driver.gsm_number);

                $('#editModal').modal('show');
                //location.reload();
            }else {
                //$('#delete_trip_req').remove('<span class="fa fa-spin fa-spinner"></span>');
                //$('#delete_trip_req').append('<span class="fa fa-times"></span>');
            }
        },
        error: function (data) {
            console.log(data);
        }
    });

}

function saveDriver() {

    var buttonName  = ' Save';//($('#language_id').val() == 2) ? ' Enregistrer' : ' Save Trip';
    //var successMessage  = ($('#language_id').val() == 2) ? 'Enregistré!' : 'Your trip has been saved successfully, Refreshing...';
    //var errorMessage  = ($('#language_id').val() == 2) ? 'Erreur!' : 'There was a problem saving your trip!';
    var driverId = $('#driver_id').val();
    var code  = $('#code').val();
    var first     = $('#first').val();
    var last     = $('#last').val();
    var carId     = $('#car_id').val();
    var gsmNumber     = $('#gsm_number').val();


    $.ajax({
        url : "savedriver",
        type: "POST",
        data : {
            driver_id: driverId,
            code: code,
            first: first,
            last: last,
            car_id: carId,
            gsm_number: gsmNumber
        },
        beforeSend: function(){
            $('#save_driver').html('<span class="fa fa-spinner fa-spin"></span>' + buttonName + '');
        },
        success: function(data) {

            if(data.success == false) {
                $('#save_driver').html('<span class="fa fa-remove"></span>' + buttonName + '');
                //$('#alert').addClass('alert alert-danger');
                //$('#alert').html(errorMessage);
                //$('#alert').show();
            }else {
                $('#save_driver').html('<span class="fa fa-check-square"></span>' + buttonName + '');
                //$('#alert').addClass('alert alert-success');
                //$('#alert').html(successMessage);
                //$('#alert').show();
                getAllDrivers();
                $('#editModal').modal('hide');
            }

        },
        error: function (data) {
            console.log(data);
        }
    });
}