$(document).ready(function(){

    $('.datepicker').datepicker({
        dateFormat: 'yy-mm-dd',
        startDate: '-3d'
    });

    $('#daily_trips').DataTable({});
    $('#driver_daily_trips').DataTable({});
    
    getDailyTrips();
    getDriverDailyTrips();

    $('form#daily_trips_form').on('submit', function(e) {
        e.preventDefault();
        if(validate()) {
            getDailyTrips();
        }
    });
    
    $('form#daily_driver_trips_form').on('submit', function(e) {
        e.preventDefault();
        //if(validate()) {
            getDriverDailyTrips();
        //}
    });

    $('#start_date').on('change', function(){
        $('#start_date').css('background-color', 'white');
    });
    $('#end_date').on('change', function(){
        $('#end_date').css('background-color', 'white');
    });

    $('#editModal').on('hidden.bs.modal', function () {
        $('#edited_customer_name').css('background-color', '');
        $('#edited_start_km').css('background-color', '');
        $('#edited_end_km').css('background-color', '');
        $('#edited_start_time').css('background-color', 'A');
        $('#edited_end_time').css('background-color', '');
        $('#edited_departure_address').css('background-color', '');
        $('#edited_destination_address').css('background-color', '');
    });

    $('#delete_trip_req').on('click', function() {
        deleteTripRequest();
    });

    $('#accept_edited_trip').on('click', function() {
        saveEditedTrip();
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
            {"data" : "customer_email"},
            {"data" : "customer_phone"},
            {"data" : "departure_time"},
            {"data" : "arrival_time"},
            {"data" : "departure_address"},
            {"data" : "arrival_address"},
            {"data" : "departure_km"},
            {"data" : "arrival_km"},
            {"data" : "distance"},
            {"data" : "trip_time"},
            {"data" : "extra_charge"},
            {"data" : "extra_cost"},
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
        ],
        "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;

            // Remove the formatting to get integer data for summation

             var intVal = function ( i ) {
             return typeof i === 'string' ?
             i.replace(/[\$,]/g, '')*1 : typeof i === 'number' ? i : 0;};

             /* Total over all pages
             total = api.column(8).data().reduce( function (a, b) {return intVal(a) + intVal(b);}, 0 );
             */

            // Total over this page
            totalDistance = api.column( 13, { page: 'current'} ).data().reduce( function (a, b) {return intVal(a) + intVal(b);}, 0 );
            totalTripTime = api.column( 14, { page: 'current'} ).data().reduce( function (a, b) {return intVal(a) + intVal(b);}, 0 );
            totalClPT  = api.column( 15, { page: 'current'} ).data().reduce( function (a, b) {return intVal(a) + intVal(b);}, 0 );
            totalCoPt = api.column( 16, { page: 'current'} ).data().reduce( function (a, b) {return intVal(a) + intVal(b);}, 0 );
            totalTripCost = api.column( 17, { page: 'current'} ).data().reduce( function (a, b) {return intVal(a) + intVal(b);}, 0 );

            // Update footer
            $( api.column(13).footer() ).html( (Math.round(totalDistance * 100) /100 ) + ' KM'
                //'$'+pageTotal +' ( $'+ total +' total)'
            );
            $( api.column(14).footer() ).html(totalTripTime + ' Min'
                //'$'+pageTotal +' ( $'+ total +' total)'
            );
            $( api.column(15).footer() ).html(totalClPT
                //'$'+pageTotal +' ( $'+ total +' total)'
            );
            $( api.column(16).footer() ).html( (Math.round(totalCoPt * 100) /100 )
                //'$'+pageTotal +' ( $'+ total +' total)'
            );
            $( api.column(17).footer() ).html( (Math.round(totalTripCost * 100) /100 )
                //'$'+pageTotal +' ( $'+ total +' total)'
            );
        }
    });
    $('input[aria-controls="daily_trips"]').prop('type', 'text');

    //$('select[name=daily_trips_length]').addClass('form-control');
}

function getDriverDailyTrips() {

    var day = $('#day').val();
    
    if( day != '') {
        //$('#time_range_span').html(day + ' <i class="fa fa-arrow-right"></i> ');
    }

    $('#driver_daily_trips').DataTable({
        'ajax': {
            "type"   : "POST",
            "url"    : 'getdriverdailytrips',
            "data"   : {day: day},
            "dataSrc": ""
        },
        "destroy": true,
        'columns': [
            {"data" : "id", "sClass": "center", "sWidth": "200px"},
            {"data" : "driver_name"},
            {"data" : "count"},
            {"data" : "start_km"},
            {"data" : "end_km"},
            {"data" : "total_km"},
            {"data" : "total_trip_km"},
            {"data" : "free_ride_km"},
            {"data" : "start_time"},
            {"data" : "end_time"},
            {"data" : "total_hours"},
            {"data" : "total_work_hours"},
            {"data" : "total_free_hours"},
            {"data" : "receipt"}
        ]/*
        ,"footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;

            // Remove the formatting to get integer data for summation

             var intVal = function ( i ) {
             return typeof i === 'string' ?
             i.replace(/[\$,]/g, '')*1 : typeof i === 'number' ? i : 0;};

             // Total over all pages
             //total = api.column(8).data().reduce( function (a, b) {return intVal(a) + intVal(b);}, 0 );
             //

            // Total over this page
        
            totalDistance = api.column( 13, { page: 'current'} ).data().reduce( function (a, b) {return intVal(a) + intVal(b);}, 0 );
            totalTripTime = api.column( 14, { page: 'current'} ).data().reduce( function (a, b) {return intVal(a) + intVal(b);}, 0 );
            totalClPT  = api.column( 15, { page: 'current'} ).data().reduce( function (a, b) {return intVal(a) + intVal(b);}, 0 );
            totalCoPt = api.column( 16, { page: 'current'} ).data().reduce( function (a, b) {return intVal(a) + intVal(b);}, 0 );
            totalTripCost = api.column( 17, { page: 'current'} ).data().reduce( function (a, b) {return intVal(a) + intVal(b);}, 0 );

            // Update footer
            $( api.column(13).footer() ).html( (Math.round(totalDistance * 100) /100 ) + ' KM'
                //'$'+pageTotal +' ( $'+ total +' total)'
            );
            $( api.column(14).footer() ).html(totalTripTime + ' Min'
                //'$'+pageTotal +' ( $'+ total +' total)'
            );
            $( api.column(15).footer() ).html(totalClPT
                //'$'+pageTotal +' ( $'+ total +' total)'
            );
            $( api.column(16).footer() ).html( (Math.round(totalCoPt * 100) /100 )
                //'$'+pageTotal +' ( $'+ total +' total)'
            );
            $( api.column(17).footer() ).html( (Math.round(totalTripCost * 100) /100 )
                //'$'+pageTotal +' ( $'+ total +' total)'
            );
            
        }*/
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
    //$('#editModal').modal('show');

    var driver = '';

    $.ajax({
        url : "geteditedtripbyid",
        type: "POST",
        async: false,
        data : {
            trip_id: tripId
        },
        beforeSend: function(){
            //$('#delete_trip_req').append(' <span class="fa fa-spin fa-spinner"></span>');
        },
        success: function(data) {
            if(data.success == true) {

                var editedTrip = data.trip.edited_trip;
                var originalTrip = data.trip.original_trip;
                $('#customer_name').val(originalTrip.customer_name);
                $('#customer_email').val(originalTrip.customer_email);
                $('#customer_phone').val(originalTrip.customer_phone);
                $('#start_km').val(originalTrip.departure_km);
                $('#end_km').val(originalTrip.arrival_km);
                $('#start_time').val(originalTrip.departure_date_time);
                $('#end_time').val(originalTrip.arrival_date_time);
                $('#departure_address').val(originalTrip.departure_address);
                $('#destination_address').val(originalTrip.arrival_address);

                $('#edited_customer_name').val(editedTrip.customer_name);
                if(originalTrip.customer_name != editedTrip.customer_name){
                    $('#edited_customer_name').css('background-color', '#FFAAAA')
                }
                $('#edited_customer_email').val(editedTrip.customer_email);
                if(originalTrip.customer_email != editedTrip.customer_email){
                    $('#edited_customer_email').css('background-color', '#FFAAAA')
                }
                $('#edited_customer_phone').val(editedTrip.customer_phone);
                if(originalTrip.customer_phone != editedTrip.customer_phone){
                    $('#edited_customer_phone').css('background-color', '#FFAAAA')
                }
                $('#edited_start_km').val(editedTrip.departure_km);
                if(originalTrip.departure_km != editedTrip.departure_km){
                    $('#edited_start_km').css('background-color', '#FFAAAA')
                }
                $('#edited_end_km').val(editedTrip.arrival_km);
                if(originalTrip.arrival_km != editedTrip.arrival_km){
                    $('#edited_end_km').css('background-color', '#FFAAAA')
                }
                $('#edited_start_time').val(editedTrip.departure_date_time);
                if(originalTrip.departure_date_time != editedTrip.departure_date_time){
                    $('#edited_start_time').css('background-color', '#FFAAAA')
                }
                $('#edited_end_time').val(editedTrip.arrival_date_time);
                if(originalTrip.arrival_date_time != editedTrip.arrival_date_time){
                    $('#edited_end_time').css('background-color', '#FFAAAA')
                }
                $('#edited_departure_address').val(editedTrip.departure_address);
                if(originalTrip.departure_address != editedTrip.departure_address){
                    $('#edited_departure_address').css('background-color', '#FFAAAA')
                }
                $('#edited_destination_address').val(editedTrip.arrival_address);
                if(originalTrip.arrival_address != editedTrip.arrival_address){
                    $('#edited_destination_address').css('background-color', '#FFAAAA')
                }

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


function saveEditedTrip() {

    var tripId = $('#edit_trip_id').val();
    var editedCustomerName = $('#edited_customer_name').val();
    var editedCustomerEmail = $('#edited_customer_email').val();
    var editedCustomerPhone = $('#edited_customer_phone').val();
    var edited_start_km = $('#edited_start_km').val();
    var edited_end_km = $('#edited_end_km').val();
    var edited_start_time = $('#edited_start_time').val();
    var edited_end_time = $('#edited_end_time').val();
    var edited_departure_address = $('#edited_departure_address').val();
    var edited_destination_address = $('#edited_destination_address').val();

    $.ajax({
        url : "saveeditedtrip",
        type: "POST",
        data : {
            trip_id: tripId,
            edited_customer_name: editedCustomerName,
            edited_customer_email: editedCustomerEmail,
            edited_customer_phome: editedCustomerPhone,
            edited_start_km: edited_start_km,
            edited_end_km: edited_end_km,
            edited_start_time: edited_start_time,
            edited_end_time: edited_end_time,
            edited_departure_address: edited_departure_address,
            edited_destination_address: edited_destination_address
        },
        beforeSend: function(){
            $('#accept_edited_trip').append(' <span class="fa fa-spin fa-spinner"></span>');
        },
        success: function(data) {
            if(data.success == true) {
                $('#editModal').modal('hide');
                location.reload();
            }else {
                $('#accept_edited_trip').remove('<span class="fa fa-spin fa-spinner"></span>');
                $('#accept_edited_trip').append('<span class="fa fa-times"></span>');
            }
        },
        error: function (data) {
            console.log(data);
        }
    });
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