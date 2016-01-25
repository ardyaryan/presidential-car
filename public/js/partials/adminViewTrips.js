$(document).ready(function(){

    $('.datepicker').datepicker({
        dateFormat: 'yy-mm-dd',
        startDate: '-3d'
    });

    $('#daily_trips').DataTable({});

    getDailyTrips();

    $('form').on('submit', function(e) {
        e.preventDefault();
        if(validate()) {
            getDailyTrips();
        }
    });

    $('#start_date').on('change', function(){
        $('#start_date').css('background-color', 'white');
    });
    $('#end_date').on('change', function(){
        $('#end_date').css('background-color', 'white');
    });

    $('#deleteModal').on('hidden.bs.modal', function () {
        //$('#save_driver').html('Save');
    });

    $('#delete_trip_req').on('click', function() {
        deleteTripRequest();
    });

    $(document).on('click', '.btn.edit-trip', function(){
        var tripId = $(this).attr('data-id');
        editTrip(tripId);
    });

    $(document).on('click', '.btn.delete-trip', function(){
        var tripId = $(this).attr('data-id');
        deleteTrip(tripId);
    });

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
            {"data" : "trip_id", "sClass": "center", "sWidth": "200px"},
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
            {"data" : "date"},
            {"mRender": function ( data, type, row ) {
                    if(row.delete == true) {
                        return '<a class="btn delete-trip" data-id="' + row.trip_id +'" style="color:red;"><i class="fa fa-pencil-square-o"></i> Act</a>';
                    }else {
                        return '---';
                    }
                }
            },
            {"mRender": function ( data, type, row ) {
                    if(row.edit == true) {
                        return '<a class="btn edit-trip" data-id="' + row.trip_id +'" style="color:red;"><i class="fa fa-pencil-square-o"></i> View</a>';
                    }else {
                        return '---';
                    }
                }
            }
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

function deleteTrip(tripId) {
    $('#delete_trip_id').val(tripId);
    $('#deleteModal').modal('show');
}

function editTrip(tripId) {
    $('#edit_trip_id').val(tripId);
    $('#editModal').modal('show');
}


function deleteTripRequest() {

    var tripId = $('#delete_trip_id').val();

    $.ajax({
        url : "deletetrip",
        type: "POST",
        data : {
            trip_id: tripId
        },
        beforeSend: function(){
            $('#delete_trip_req').append(' <span class="fa fa-spin fa-spinner"></span>');
        },
        success: function(data) {
            if(data.success == true) {
                $('#deleteModal').modal('hide');
                location.reload();
            }else {
                $('#delete_trip_req').remove('<span class="fa fa-spin fa-spinner"></span>');
                $('#delete_trip_req').append('<span class="fa fa-times"></span>');
            }
        },
        error: function (data) {
            console.log(data);
        }
    });
}
