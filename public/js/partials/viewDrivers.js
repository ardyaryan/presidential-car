$(document).ready(function(){


    $('#drivers').DataTable({});

    getAllDrivers();

    $(document).on('click', '.btn.edit-driver', function(){
        var driverId = $(this).attr('data-id');
        editDriver(driverId);
    });

    $(document).on('click', '.btn.delete-driver', function(){
        var driverId = $(this).attr('data-id');
        $('#delete_driver_id').val(driverId);
        $('#deleteModal').modal('show');
    });


    $('#editModal').on('hidden.bs.modal', function () {
        $('#save_driver').html('Save');
    });

    $('#save_driver').on('click', function() {
        saveDriver();
    });

    $('#save_new_driver').on('click', function() {
        saveNewDriver();
    });

    $('#add_driver').on('click', function() {
        $('#addModal').modal('show');
    });

    $('#delete_driver_req').on('click', function() {
        deleteDriver();
    });

});


function getAllDrivers() {

    $('#drivers').DataTable({
        'ajax': {
            "type"   : "POST",
            "url"    : 'getdrivers',
            "data"   : {},
            "dataSrc": ""
        },
        "destroy": true,
        'columns': [
            {"data" : "id"},
            {"data" : "code"},
            {"data" : "name"},
            {"data" : "email"},
            {"data" : "gsm_number"},
            {"data" : "hours"},
            {"data" : "trips"},
            {"data" : "earning"},
            {"data" : "hour_per_trip"},
            {"data" : "earning_per_hour"},
            {"data" : "earning_per_trip"},
            {"mRender": function ( data, type, row ) {
                return '<a class="btn edit-driver" data-id="' + row.id +'"><i class="fa fa-pencil-square-o"></i> Edit</a>';
                }
            },
            {"mRender": function ( data, type, row ) {
                return '<a class="btn delete-driver" data-id="' + row.id +'" style="color:red;"><i class="fa fa-remove"></i> Delete</a>';
                }
            }
        ]
        ,
    "footerCallback": function ( row, data, start, end, display ) {
        var api = this.api(), data;

        // Remove the formatting to get integer data for summation

         var intVal = function ( i ) {
         return typeof i === 'string' ?
         i.replace(/[\$,]/g, '')*1 : typeof i === 'number' ? i : 0;};

         /* Total over all pages
         total = api.column(8).data().reduce( function (a, b) {return intVal(a) + intVal(b);}, 0 );
         */

        // Total over this page
        totalHours = api.column( 5, { page: 'current'} ).data().reduce( function (a, b) {return intVal(a) + intVal(b);}, 0 );
        totalTrips = api.column( 6, { page: 'current'} ).data().reduce( function (a, b) {return intVal(a) + intVal(b);}, 0 );
        totalCost  = api.column( 7, { page: 'current'} ).data().reduce( function (a, b) {return intVal(a) + intVal(b);}, 0 );
        totalHours = api.column( 8, { page: 'current'} ).data().reduce( function (a, b) {return intVal(a) + intVal(b);}, 0 );

        // Update footer
        $( api.column(5).footer() ).html( (Math.round(totalHours * 100) /100 )
            //'$'+pageTotal +' ( $'+ total +' total)'
        );
        $( api.column(6).footer() ).html(totalTrips
            //'$'+pageTotal +' ( $'+ total +' total)'
        );
        $( api.column(7).footer() ).html(totalCost
            //'$'+pageTotal +' ( $'+ total +' total)'
        );
        $( api.column(8).footer() ).html( (Math.round(totalHours * 100) /100 )
            //'$'+pageTotal +' ( $'+ total +' total)'
        );
    }
    }
    );

    $('input[aria-controls="drivers"]').prop('type', 'text');
}

function editDriver(driverId) {

    var driver = '';

    $.ajax({
        url : "getdriverbyid",
        type: "POST",
        data : {
            driver_id: driverId
        },
        beforeSend: function(){
            //$('#delete_trip_req').append(' <span class="fa fa-spin fa-spinner"></span>');
        },
        success: function(data) {
            if(data.success == true) {
                //console.log(data);
                driver = data.driver;
                $('#driver_id').val(driver.id);
                $('#code').val(driver.code);
                $('#first').val(driver.first);
                $('#last').val(driver.last);
                $('#email').val(driver.email);
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
    var email     = $('#email').val();
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
            email: email,
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

function saveNewDriver() {

    var buttonName  = ' Save';//($('#language_id').val() == 2) ? ' Enregistrer' : ' Save Trip';
    //var successMessage  = ($('#language_id').val() == 2) ? 'Enregistré!' : 'Your trip has been saved successfully, Refreshing...';
    //var errorMessage  = ($('#language_id').val() == 2) ? 'Erreur!' : 'There was a problem saving your trip!';
    var code       = $('#new_code').val();
    var first      = $('#new_first').val();
    var last       = $('#new_last').val();
    var email      = $('#new_email').val();
    var password   = $('#new_password').val();
    var carId      = $('#new_car_id').val();
    var gsmNumber  = $('#new_gsm_number').val();
    var timeZone   = $('#new_time_zone').val();
    var languageId = $('#new_language_id').val();


    $.ajax({
        url : "savenewdriver",
        type: "POST",
        data : {
            code: code,
            first: first,
            last: last,
            email: email,
            password: password,
            car_id: carId,
            gsm_number: gsmNumber,
            time_zone: timeZone,
            language_id : languageId
        },
        beforeSend: function(){
            $('#save_new_driver').html('<span class="fa fa-spinner fa-spin"></span>' + buttonName + '');
        },
        success: function(data) {

            if(data.success == false) {
                $('#save_new_driver').html('<span class="fa fa-remove"></span>' + buttonName + '');
                //$('#alert').addClass('alert alert-danger');
                //$('#alert').html(errorMessage);
                //$('#alert').show();
            }else {
                $('#save_new_driver').html('<span class="fa fa-check-square"></span>' + buttonName + '');
                //$('#alert').addClass('alert alert-success');
                //$('#alert').html(successMessage);
                //$('#alert').show();
                getAllDrivers();
                $('#addModal').modal('hide');
            }

        },
        error: function (data) {
            console.log(data);
        }
    });

}

function deleteDriver() {

    var driverId = $('#delete_driver_id').val();

    $.ajax({
        url : "deletedriver",
        type: "POST",
        data : {
            driver_id: driverId
        },
        beforeSend: function(){
            $('#delete_driver_req').append(' <span class="fa fa-spin fa-spinner"></span>');
        },
        success: function(data) {
            if(data.success == true) {
                $('#deleteModal').modal('hide');
                location.reload();
            }else {
                $('#delete_driver_req').remove('<span class="fa fa-spin fa-spinner"></span>');
                $('#delete_driver_req').append('<span class="fa fa-times"></span>');
            }
        },
        error: function (data) {
            console.log(data);
        }
    });
}