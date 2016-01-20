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
            {"data" : "gsm_number"},
            {"mRender": function ( data, type, row ) {
                return '<a class="btn" data-id="' + row.id +'"><i class="fa fa-pencil-square-o"></i> Edit</a>';}
            }
        ]
    });
    $('input[aria-controls="drivers"]').prop('type', 'text');
}
