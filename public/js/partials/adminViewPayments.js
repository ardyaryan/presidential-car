$(document).ready(function(){
    $('#payments').DataTable({});

    $('.datepicker').datepicker({
        dateFormat: 'yy-mm-dd',
        startDate: '-3d'
    });
    
    getAllPayments();

    $(document).on('click', '.btn.edit-car', function(){
        var carId = $(this).attr('data-id');
        editCar(carId);
    });

    $(document).on('click', '.btn.delete-car', function(){
        var driverId = $(this).attr('data-id');
        $('#delete_car_id').val(driverId);
        $('#deleteModal').modal('show');
    });


    $('#editModal').on('hidden.bs.modal', function () {
        $('#save_car').html('Save');
    });

    $('#save_new_payment').on('click', function() {
        savePayment();
    });

    $('#save_new_car').on('click', function() {
        saveNewCar();
    });

    $('#add_payment').on('click', function() {
        getDrivers();
        $('#addModal').modal('show');
    });

    $('#delete_car_req').on('click', function() {
        deleteCar();
    });

    $('form').on('submit', function(e) {
        e.preventDefault();
        if(validate()) {
            getAllPayments();
        }
    });

    $('#from').on('change', function(){
        $('#from').css('background-color', 'white');
    });
    $('#to').on('change', function(){
        $('#to').css('background-color', 'white');
    });
});

function getAllPayments() {

    var carId = $('#delete_car_id').val();

    var from = $('#from').val();
    var to = $('#to').val();

    if( from != '' && to != '') {
        $('#time_range_span').html(from + ' <i class="fa fa-arrow-right"></i> ' + to);
    }
    
    var domain = window.location.origin;
    if(domain == 'http://localhost') {
        domain = domain + '/presidential-car';
    }
    $('#payments').DataTable({
        'ajax': {
            "type"   : "POST",
            "url"    : 'getpayments',
            "data"   : {from: from, to: to},
            "dataSrc": ""
        },
        "destroy": true,
        'columns': [
            {"data" : "id"},
            {"data" : "amount"},
            {"data" : "other"},
            {"data" : "currency"},
            {"mRender": function ( data, type, row ) {
                return '<a href="' + domain + '/admin/driverdetails/' + row.id +'">' + row.driver_name + '</a>';
                }
            },
            {"data" : "created_at"}
        ],
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
                totalAmount = api.column(1, { page: 'current'} ).data().reduce( function (a, b) {return intVal(a) + intVal(b);}, 0 );
                totalOther  = api.column(2, { page: 'current'} ).data().reduce( function (a, b) {return intVal(a) + intVal(b);}, 0 );

                $( api.column(1).footer() ).html( (Math.round(totalAmount * 100) /100 )
                    //'$'+pageTotal +' ( $'+ total +' total)'
                );
                $( api.column(2).footer() ).html( (Math.round(totalAmount * 100) /100 )
                    //'$'+pageTotal +' ( $'+ total +' total)'
                );

            }
        }
    );
    $('input[aria-controls="cars"]').prop('type', 'text');
}


function editCar(carId) {

    var car = '';

    $.ajax({
        url : "getcarbyid",
        type: "POST",
        async: false,
        data : {
            car_id: carId
        },
        beforeSend: function(){
            //$('#delete_trip_req').append(' <span class="fa fa-spin fa-spinner"></span>');
        },
        success: function(data) {
            if(data.success == true) {
                //console.log(data);
                var car = data.car;
                $('#car_id').val(car.id);
                $('#name').val(car.name);
                $('#brand').val(car.brand);
                $('#model').val(car.model);
                $('#registration').val(car.registration);
                $('#police_number').val(car.police_number);
                $('#uber_number').val(car.uber_number);

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

function savePayment() {

    var buttonName  = ' Save';//($('#language_id').val() == 2) ? ' Enregistrer' : ' Save Trip';
    //var successMessage  = ($('#language_id').val() == 2) ? 'Enregistré!' : 'Your trip has been saved successfully, Refreshing...';
    //var errorMessage  = ($('#language_id').val() == 2) ? 'Erreur!' : 'There was a problem saving your trip!';
    var amount   = $('#new_amount').val();
    var other    = $('#new_other').val();
    var currency = $('#new_currency option:first').val();
    var driver   = $('#driver_list option:first').val();

    $.ajax({
        url : "savepayment",
        type: "POST",
        data : {
            amount: amount,
            other: other,
            currency: currency,
            driver: driver
        },
        beforeSend: function(){
            $('#save_new_payment').html('<span class="fa fa-spinner fa-spin"></span>' + buttonName + '');
        },
        success: function(data) {

            if(data.success == false) {
                $('#save_new_payment').html('<span class="fa fa-remove"></span>' + buttonName + '');
                //$('#alert').addClass('alert alert-danger');
                //$('#alert').html(errorMessage);
                //$('#alert').show();
            }else {
                $('#save_new_payment').html('<span class="fa fa-check-square"></span>' + buttonName + '');
                //$('#alert').addClass('alert alert-success');
                //$('#alert').html(successMessage);
                //$('#alert').show();
                getAllPayments();
                $('#addModal').modal('hide');
            }

        },
        error: function (data) {
            console.log(data);
        }
    });
}

function saveNewCar() {

    var buttonName  = ' Save';//($('#language_id').val() == 2) ? ' Enregistrer' : ' Save Trip';
    //var successMessage  = ($('#language_id').val() == 2) ? 'Enregistré!' : 'Your trip has been saved successfully, Refreshing...';
    //var errorMessage  = ($('#language_id').val() == 2) ? 'Erreur!' : 'There was a problem saving your trip!';
    var name       = $('#new_name').val();
    var brand      = $('#new_brand').val();
    var model       = $('#new_model').val();
    var registration = $('#new_registration').val();
    var policeNumber   = $('#new_police_number').val();
    var uberNumber      = $('#new_uber_number').val();


    $.ajax({
        url : "savenewcar",
        type: "POST",
        data : {
            name: name,
            brand: brand,
            model: model,
            registration: registration,
            police_number: policeNumber,
            uber_number: uberNumber
        },
        beforeSend: function(){
            $('#save_new_car').html('<span class="fa fa-spinner fa-spin"></span>' + buttonName + '');
        },
        success: function(data) {

            if(data.success == false) {
                $('#save_new_car').html('<span class="fa fa-remove"></span>' + buttonName + '');
                //$('#alert').addClass('alert alert-danger');
                //$('#alert').html(errorMessage);
                //$('#alert').show();
            }else {
                $('#save_new_car').html('<span class="fa fa-check-square"></span>' + buttonName + '');
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

function deleteCar() {



    $.ajax({
        url : "deletecar",
        type: "POST",
        data : {
            car_id: carId
        },
        beforeSend: function(){
            $('#delete_car_req').append(' <span class="fa fa-spin fa-spinner"></span>');
        },
        success: function(data) {
            if(data.success == true) {
                $('#deleteModal').modal('hide');
                location.reload();
            }else {
                $('#delete_car_req').remove('<span class="fa fa-spin fa-spinner"></span>');
                $('#delete_car_req').append('<span class="fa fa-times"></span>');
            }
        },
        error: function (data) {
            console.log(data);
        }
    });
}

function getDrivers() {

    $.ajax({
        url : "getdrivers",
        type: "POST",
        data : {},
        beforeSend: function(){
            //$('#driver_list').append($("<option></option>").text('Loading ...'));
            //$('#driver_list').append("<option><span class='fa fa-spin fa-spinner'></span> Loading ...</option>");
            //$('#driver_list').selectpicker('refresh');
        },
        success: function(data) {

            var driver = jQuery.parseJSON(data);
            for(var i=0 ; i < driver.length ; i++) {
                //$('#driver_list').append('<option value="' + driver[i].user_id +'">' + driver[i].name + '</option>')
                $('#driver_list').append($("<option></option>")
                        .attr("value",driver[i].id )
                        .text(driver[i].name));
            }
            $('#driver_list').selectpicker('refresh');
            $('#add_driver_select').removeClass('fa-spin fa-spinner');
        },
        error: function (data) {
            console.log(data);
        }
    });
}

function validate() {
    if($('#from').val() == '') {
        $('#from').css('background-color', '#FFB0A2');
        return false;
    }else if($('#to').val() == '') {
        $('#to').css('background-color', '#FFB0A2');
        return false;
    }else {
        return true;
    }
}