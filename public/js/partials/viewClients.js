$(document).ready(function(){


    $('#clients').DataTable({});

    getAllClients();

    $(document).on('click', '.btn.edit-client', function(){
        var clientId = $(this).attr('data-id');
        editClient(clientId);
    });

    $(document).on('click', '.btn.delete-client', function(){
        var clientId = $(this).attr('data-id');
        $('#delete_client_id').val(clientId);
        $('#deleteModal').modal('show');
    });


    $('#editModal').on('hidden.bs.modal', function () {
        $('#save_client').html('Save');
    });

    $('#save_client').on('click', function() {
        saveClient();
    });

    $('#save_new_client').on('click', function() {
        saveNewClient();
    });

    $('#add_client').on('click', function() {
        $('#addModal').modal('show');
    });

    $('#delete_client_req').on('click', function() {
        deleteClient();
    });

});


function getAllClients() {
    $('#clients').DataTable({
        'ajax': {
            "type": "POST",
            "url": 'getclients',
            "data": {},
            "dataSrc": ""
        },
        "destroy": true,
        'columns': [
            {"data" : "id"},
            {"data" : "name"},
            {"data" : "base"},
            {"data" : "price_per_km"},
            {"data" : "price_per_min"},
            {"data" : "currency"},
            {"data" : "us_dollar_exchange_rate"},
            {"mRender": function ( data, type, row ) {
                return '<a class="btn edit-client" data-id="' + row.id +'"><i class="fa fa-pencil-square-o"></i> Edit</a>';
                }
            },
            {"mRender": function ( data, type, row ) {
                return '<a class="btn delete-client" data-id="' + row.id +'" style="color:red;"><i class="fa fa-remove"></i> Delete</a>';
                }
            }
        ]
    });

    $('input[aria-controls="clients"]').prop('type', 'text');
}

function editClient(clientId) {

    var client = '';

    $.ajax({
        url : "getclientbyid",
        type: "POST",
        async: false,
        data : {
            client_id: clientId
        },
        beforeSend: function(){
            //$('#delete_trip_req').append(' <span class="fa fa-spin fa-spinner"></span>');
        },
        success: function(data) {
            if(data.success == true) {
                //console.log(data);
                client = data.client;
                $('#client_id').val(client.id);
                $('#name').val(client.name);
                $('#base').val(client.base);
                $('#price_per_km').val(client.price_per_km);
                $('#price_per_min').val(client.price_per_min);
                $('#currency').val(client.currency);
                $('#us_dollar_exchange_rate').val(client.us_dollar_exchange_rate);
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

function saveClient() {

    var buttonName  = ' Save';//($('#language_id').val() == 2) ? ' Enregistrer' : ' Save Trip';
    //var successMessage  = ($('#language_id').val() == 2) ? 'Enregistré!' : 'Your trip has been saved successfully, Refreshing...';
    //var errorMessage  = ($('#language_id').val() == 2) ? 'Erreur!' : 'There was a problem saving your trip!';
    var clientId = $('#client_id').val();
    var Name       = $('#name').val();
    var base       = $('#base').val();
    var pricePerKm = $('#price_per_km').val();
    var PricePerMin = $('#price_per_min').val();
    var currency   = $('#currency').val();
    var exchangeRate = $('#us_dollar_exchange_rate').val();


    $.ajax({
        url : "saveclient",
        type: "POST",
        data : {
            client_id: clientId,
            name: Name,
            base: base,
            price_per_km: pricePerKm,
            price_per_min: PricePerMin,
            currency: currency,
            us_dollar_exchange_rate: exchangeRate
        },
        beforeSend: function(){
            $('#save_client').html('<span class="fa fa-spinner fa-spin"></span>' + buttonName + '');
        },
        success: function(data) {

            if(data.success == false) {
                $('#save_client').html('<span class="fa fa-remove"></span>' + buttonName + '');
                //$('#alert').addClass('alert alert-danger');
                //$('#alert').html(errorMessage);
                //$('#alert').show();
            }else {
                $('#save_client').html('<span class="fa fa-check-square"></span>' + buttonName + '');
                //$('#alert').addClass('alert alert-success');
                //$('#alert').html(successMessage);
                //$('#alert').show();
                getAllClients();
                $('#editModal').modal('hide');
            }

        },
        error: function (data) {
            console.log(data);
        }
    });
}

function saveNewClient() {

    var buttonName  = ' Save';//($('#language_id').val() == 2) ? ' Enregistrer' : ' Save Trip';
    //var successMessage  = ($('#language_id').val() == 2) ? 'Enregistré!' : 'Your trip has been saved successfully, Refreshing...';
    //var errorMessage  = ($('#language_id').val() == 2) ? 'Erreur!' : 'There was a problem saving your trip!';
    var Name       = $('#new_name').val();
    var base       = $('#new_base').val();
    var pricePerKm = $('#new_price_per_km').val();
    var PricePerMin = $('#new_price_per_min').val();
    var currency   = $('#new_currency').val();
    var exchangeRate      = $('#new_us_dollar_exchange_rate').val();

    $.ajax({
        url : "savenewclient",
        type: "POST",
        data : {
            name: Name,
            base: base,
            price_per_km: pricePerKm,
            price_per_min: PricePerMin,
            currency: currency,
            us_dollar_exchange_rate: exchangeRate
        },
        beforeSend: function(){
            $('#save_new_client').html('<span class="fa fa-spinner fa-spin"></span>' + buttonName + '');
        },
        success: function(data) {

            if(data.success == false) {
                $('#save_new_client').html('<span class="fa fa-remove"></span>' + buttonName + '');
                //$('#alert').addClass('alert alert-danger');
                //$('#alert').html(errorMessage);
                //$('#alert').show();
            }else {
                $('#save_new_client').html('<span class="fa fa-check-square"></span>' + buttonName + '');
                //$('#alert').addClass('alert alert-success');
                //$('#alert').html(successMessage);
                //$('#alert').show();
                getAllClients();
                $('#addModal').modal('hide');
            }

        },
        error: function (data) {
            console.log(data);
        }
    });

}

function deleteClient() {

    var clientId = $('#delete_client_id').val();

    $.ajax({
        url : "deleteclient",
        type: "POST",
        data : {
            client_id: clientId
        },
        beforeSend: function(){
            $('#delete_client_req').append(' <span class="fa fa-spin fa-spinner"></span>');
        },
        success: function(data) {
            if(data.success == true) {
                $('#deleteModal').modal('hide');
                location.reload();
            }else {
                $('#delete_client_req').remove('<span class="fa fa-spin fa-spinner"></span>');
                $('#delete_client_req').append('<span class="fa fa-times"></span>');
            }
        },
        error: function (data) {
            console.log(data);
        }
    });
}