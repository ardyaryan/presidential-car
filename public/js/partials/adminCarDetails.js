$(document).ready(function(){


    $('#car_details').DataTable({'bPaginate': false, 'bFilter': false, 'bInfo': false });
    
    $('#car_performance').DataTable({});
    
    $('#fuel_performance').DataTable({});

    getCarDetails();
    getFuel();
    
    $('.datepicker').datepicker({
        dateFormat: 'yy-mm-dd',
        startDate: '-3d'
    });

    $('form').on('submit', function(e) {
        e.preventDefault();

        if(validate()) {
            //$('#graph_loading').show();
            setTimeout(function(){
                getCarDetails();
                getFuel();

            }, 500);
        }
        createReport();
    });

    $(document).on('click', '.btn.edit-driver', function(){
        var driverId = $(this).attr('data-id');
        editDriver(driverId);
    });

    $(document).on('click', '.btn.delete-driver', function(){
        var driverId = $(this).attr('data-id');
        $('#delete_driver_id').val(driverId);
        $('#deleteModal').modal('show');
    });


    $('#editModal').on('hidden.bs.modal', function () {
        $('#save_driver').html('Save');
    });

    $('#save_driver').on('click', function() {
        saveDriver();
    });

    $('#save_new_driver').on('click', function() {
        saveNewDriver();
    });

    $('#add_driver').on('click', function() {
        $('#addModal').modal('show');
    });

    $('#delete_driver_req').on('click', function() {
        deleteDriver();
    });

});

function getCarDetails() {
    var from = $('#from').val();
    var to = $('#to').val();
    var carId = $('#car_id').val();
    
    if( from != '' && to != '') {
        $('#time_range_span').html(from + ' <i class="fa fa-arrow-right"></i> ' + to);
    }
    
    $('#car_performance').DataTable({
        'ajax': {
            "type": "POST",
            "url": 'get',
            "data"   : {from: from, to: to, car_id: carId},
            "dataSrc": ""
        },
        "destroy": true,
        'columns': [
            {"data" : "distance"},
            {"data" : "hours"},
            {"data" : "cost"},
            {"data" : "parking_toll"},
            {"data" : "date"}
        ],
        "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;

            // Remove the formatting to get integer data for summation

             var intVal = function ( i ) {
             return typeof i === 'string' ?
             i.replace(/[\$,]/g, '')*1 : typeof i === 'number' ? i : 0;};

             // Total over all pages
             //total = api.column(8).data().reduce( function (a, b) {return intVal(a) + intVal(b);}, 0 );
             

            // Total over this page
            totalTripsNumber = api.column( 0, { page: 'current'} ).data().reduce( function (a, b) {return intVal(a) + intVal(b);}, 0 );
            totalKm = api.column( 1, { page: 'current'} ).data().reduce( function (a, b) {return intVal(a) + intVal(b);}, 0 );
            totalTripKM  = api.column( 2, { page: 'current'} ).data().reduce( function (a, b) {return intVal(a) + intVal(b);}, 0 );
            totalTripPer = api.column( 3, { page: 'current'} ).data().reduce( function (a, b) {return intVal(a) + intVal(b);}, 0 );
            totalFreeKM = api.column( 4, { page: 'current'} ).data().reduce( function (a, b) {return intVal(a) + intVal(b);}, 0 );
            

            // Update footer
            $( api.column(0).footer() ).html(totalTripsNumber + ' KM'
                //'$'+pageTotal +' ( $'+ total +' total)'
            );
            $( api.column(1).footer() ).html(totalKm
                //'$'+pageTotal +' ( $'+ total +' total)'
            );
            $( api.column(2).footer() ).html(totalTripKM + ' MAD'
                //'$'+pageTotal +' ( $'+ total +' total)'
            );
            $( api.column(3).footer() ).html( totalTripPer + ' MAD'
                //'$'+pageTotal +' ( $'+ total +' total)'
            );
            $( api.column(4).footer() ).html(totalFreeKM
                //'$'+pageTotal +' ( $'+ total +' total)'
            );
    
        }
    });

    $('input[aria-controls="report_table"]').prop('type', 'text');
}

function getFuel() {
    
    var from = $('#from').val();
    var to = $('#to').val();
    var carId = $('#car_id').val();
    
    if( from != '' && to != '') {
        //$('#time_range_span').html(from + ' <i class="fa fa-arrow-right"></i> ' + to);
    }
    
    $('#fuel_performance').DataTable({
        'ajax': {
            "type": "POST",
            "url": 'getfuel',
            "data"   : {from: from, to: to, car_id: carId},
            "dataSrc": ""
        },
        "destroy": true,
        'columns': [
            {"data" : "cost"},
            {"data" : "amount"},
            {"data" : "price_per_liter"},
            {"data" : "date_and_time"}
        ],
        "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;

            // Remove the formatting to get integer data for summation

             var intVal = function ( i ) {
             return typeof i === 'string' ?
             i.replace(/[\$,]/g, '')*1 : typeof i === 'number' ? i : 0;};

             // Total over all pages
             //total = api.column(8).data().reduce( function (a, b) {return intVal(a) + intVal(b);}, 0 );
             

            // Total over this page
            totalTripsNumber = api.column( 0, { page: 'current'} ).data().reduce( function (a, b) {return intVal(a) + intVal(b);}, 0 );
            totalKm = api.column( 1, { page: 'current'} ).data().reduce( function (a, b) {return intVal(a) + intVal(b);}, 0 );
            totalTripKM  = api.column( 2, { page: 'current'} ).data().reduce( function (a, b) {return intVal(a) + intVal(b);}, 0 );

            // Update footer
            $( api.column(0).footer() ).html(totalTripsNumber + ' MAD'
                //'$'+pageTotal +' ( $'+ total +' total)'
            );
            $( api.column(1).footer() ).html(totalKm + ' Liters'
                //'$'+pageTotal +' ( $'+ total +' total)'
            );
            $( api.column(2).footer() ).html(totalTripKM + ' MAD'
                //'$'+pageTotal +' ( $'+ total +' total)'
            );
    
        }
    });

    $('input[aria-controls="report_table"]').prop('type', 'text');
}


function validate() {
    if($('#from').val() == '') {
        $('#from').css('background-color', '#FFB0A2');
        return false;
    }else if($('#to').val() == '') {
        $('#to').css('background-color', '#FFB0A2');
        return false;
    }else {
        return true;
    }
}