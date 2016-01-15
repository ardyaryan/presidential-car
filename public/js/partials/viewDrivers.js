$(document).ready(function(){

    $('#drivers').DataTable({});

    getAllDrivers();

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
            {"data" : "car_id"},
            {"data" : "gsm_number"}
        ]
    });
    $('input[aria-controls="drivers"]').prop('type', 'text');
}
