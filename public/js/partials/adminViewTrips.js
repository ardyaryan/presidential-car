$(document).ready(function(){

    $('.datepicker').datepicker({
        dateFormat: 'yy-mm-dd',
        startDate: '-3d'
    });

    $('#daily_trips').DataTable({});

    $('form').on('submit', function(e) {
        e.preventDefault();
        var startDate = $('#start_date').val();
        var endDate = $('#end_date').val();
        if(validate()) {
            getDailyTrips(startDate, endDate);
        }
    });

    $('#start_date').on('change', function(){
        $('#start_date').css('background-color', 'white');
    });
    $('#end_date').on('change', function(){
        $('#end_date').css('background-color', 'white');
    });

    getDailyTrips();

});


function getDailyTrips() {

    var from = $('#from').val();
    var to = $('#to').val();

    if( from != '' && to != '') {
        $('#time_range_span').html(from + ' <i class="fa fa-arrow-right"></i> ' + to);
    }

    $('#daily_trips').DataTable({
        'ajax': {
            "type"   : "POST",
            "url"    : 'gettrips',
            "data"   : {from: from, to: to},
            "dataSrc": ""
        },
        "destroy": true,
        'columns': [
            {"data" : "trip_id"},
            {"data" : "driver"},
            {"data" : "car"},
            {"data" : "client"},
            {"data" : "customer"},
            {"data" : "departure_time"},
            {"data" : "arrival_time"},
            {"data" : "departure_address"},
            {"data" : "arrival_address"},
            {"data" : "distance"},
            {"data" : "cost"},
            {"data" : "date"}
        ]
    });
    $('input[aria-controls="daily_trips"]').prop('type', 'text');
    //$('select[name=daily_trips_length]').addClass('form-control');
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