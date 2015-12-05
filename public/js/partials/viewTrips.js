$(document).ready(function(){

    $(document).ready(function() {
       // $('#daily_trips').DataTable();
    });

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
    $.ajax({
        url : "gettrips",
        type: "POST",
        data : {start_date: startDate, end_date: endDate},
        beforeSend: function(){
            $('#search').html('<span class="fa fa-spinner fa-spin"></span> Search');
        },
        success: function(data) {
            //window.location.replace('admin/trips');
            $('#Search').html('<span class="fa fa-check"></span> Search');
            $('#daily_trips').DataTable({'ajax': 'data/' + data});
            console.log(data.payload);
        },
        error: function (data) {
            console.log(data);
        }
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