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
            {"data" : "code"},
            {"data" : "first"},
            {"data" : "last"},
            {"data" : "gsm_number"},
            {"data" : "created_at"}
        ]
    });
}
