$(document).ready(function(){

    $('#daily_trips').DataTable({});

    $('form').on('submit', function(e) {
        e.preventDefault();
        var startDate = $('#start_date').val();
        var endDate = $('#end_date').val();
        if(validate()) {
            getDailyTrips(startDate, endDate);
        };

    });

    $('#start_date').on('change', function(){
        $('#start_date').css('background-color', 'white');
    });
    $('#end_date').on('change', function(){
        $('#end_date').css('background-color', 'white');
    });
});


function getDailyTrips(startDate, endDate) {

    $('#daily_trips').DataTable({
        'ajax': {
            "type"   : "POST",
            "url"    : 'gettrips',
            "data"   : {start_date: startDate, end_date: endDate},
            "dataSrc": ""
        },
        "destroy": true,
        'columns': [
            {"data" : "client_name"},
            {"data" : "date"},
            {"data" : "departure_hour"},
            {"data" : "departure_minute"},
            {"data" : "departure_ampm"},
            {"data" : "arrival_hour"},
            {"data" : "arrival_minute"},
            {"data" : "arrival_ampm"},
            {"data" : "departure_address"},
            {"data" : "arrival_address"},
            {"data" : "water_bottle"},
            {"data" : "price_per_trip"}
        ]
    });
}

function validate() {
    if($('#start_date').val() == '') {
        $('#start_date').css('background-color', '#FFB0A2');
        return false;
    }else if($('#end_date').val() == '') {
        $('#end_date').css('background-color', '#FFB0A2');
        return false;
    }else {
        return true;
    }
}