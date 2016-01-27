$(document).ready(function(){
    $('#cars').DataTable({});

    getAllCars();

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

    $('#save_car').on('click', function() {
        saveCar();
    });

    $('#save_new_car').on('click', function() {
        saveNewCar();
    });

    $('#add_car').on('click', function() {
        $('#addModal').modal('show');
    });

    $('#delete_car_req').on('click', function() {
        deleteCar();
    });
});

function getAllCars() {

    $('#cars').DataTable({
        'ajax': {
            "type"   : "POST",
            "url"    : 'getcars',
            "data"   : {},
            "dataSrc": ""
        },
        "destroy": true,
        'columns': [
            {"data" : "id"},
            {"data" : "name"},
            {"data" : "brand"},
            {"data" : "model"},
            {"data" : "registration"},
            {"data" : "police_number"},
            {"data" : "uber_number"},
            {"mRender": function ( data, type, row ) {
                return '<a class="btn edit-car" data-id="' + row.id +'"><i class="fa fa-pencil-square-o"></i> Edit</a>';
            }
            },
            {"mRender": function ( data, type, row ) {
                return '<a class="btn delete-car" data-id="' + row.id +'" style="color:red;"><i class="fa fa-remove"></i> Delete</a>';
            }
            }
        ]
    });
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

function saveCar() {

    var buttonName  = ' Save';//($('#language_id').val() == 2) ? ' Enregistrer' : ' Save Trip';
    //var successMessage  = ($('#language_id').val() == 2) ? 'Enregistré!' : 'Your trip has been saved successfully, Refreshing...';
    //var errorMessage  = ($('#language_id').val() == 2) ? 'Erreur!' : 'There was a problem saving your trip!';
    var carId  = $('#car_id').val();
    var name  = $('#name').val();
    var brand     = $('#brand').val();
    var model     = $('#model').val();
    var registration     = $('#registration').val();
    var policeNumber     = $('#police_number').val();
    var uberNumber     = $('#uber_number').val();


    $.ajax({
        url : "savecar",
        type: "POST",
        data : {
            car_id: carId,
            name: name,
            brand: brand,
            model: model,
            registration: registration,
            police_number: policeNumber,
            uber_number: uberNumber
        },
        beforeSend: function(){
            $('#save_car').html('<span class="fa fa-spinner fa-spin"></span>' + buttonName + '');
        },
        success: function(data) {

            if(data.success == false) {
                $('#save_car').html('<span class="fa fa-remove"></span>' + buttonName + '');
                //$('#alert').addClass('alert alert-danger');
                //$('#alert').html(errorMessage);
                //$('#alert').show();
            }else {
                $('#save_car').html('<span class="fa fa-check-square"></span>' + buttonName + '');
                //$('#alert').addClass('alert alert-success');
                //$('#alert').html(successMessage);
                //$('#alert').show();
                getAllCars();
                $('#editModal').modal('hide');
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

    var carId = $('#delete_car_id').val();

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