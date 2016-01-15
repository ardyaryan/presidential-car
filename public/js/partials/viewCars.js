$(document).ready(function(){
    $('#cars').DataTable({});
    getAllCars();
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
            {"data" : "uber_number"}
        ]
    });
    $('input[aria-controls="cars"]').prop('type', 'text');
}
