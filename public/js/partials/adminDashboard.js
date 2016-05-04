$(document).ready(function(){

    $('.datepicker').datepicker({
        dateFormat: 'yy-mm-dd',
        startDate: '-3d'
    });

    $('#driver_performance').DataTable({});
    
    $('form').on('submit', function(e) {
        e.preventDefault();

        if(validate()) {
            $('#graph_loading').show();
            setTimeout(function(){
                getTripsByDriver();
                getDriverPerformance();
            }, 500);
        }
        createReport();
    });

    $('#from').on('change', function(){
        $('#from').css('background-color', 'white');
    });
    $('#to').on('change', function(){
        $('#to').css('background-color', 'white');
    });

    getTripsByDriver();
    getDriverPerformance();

    $('#report_table').dataTable({'bPaginate': false, 'bFilter': false, 'bInfo': false });
    
    createReport();

    //  setTimeout(function() {loadPieChart();}, 1000);
});


function getTripsByDriver() {

    var from = $('#from').val();
    var to = $('#to').val();

    if( from != '' && to != '') {
        $('#time_range_span').html(from + ' <i class="fa fa-arrow-right"></i> ' + to);
    }

    var result = '';

    $.ajax({
        url : "gettripsbydriver",
        type: "POST",
        data : {
            from: from,
            to: to
        },
        beforeSend: function(){

        },
        success: function(data) {
            for(var i = 0; i < data.length; i ++) {
                data[i].x = new Date(data[i].x);
            }
            result = data;
            //console.log(result)
            $('#graph_loading').hide();
            renderChart(result);
        },
        error: function (data) {
            console.log(data);
        }
    });
    return result;
};


function renderChart(driver) {
    //console.log(driver);
    var datas = [];
    //var driver = drivers();

    for(var i = 0; i < driver.length ; i ++) {

        var specs ={ type: "line",showInLegend: true,lineThickness: 1, name: "Trips", markerType: "square", color: "#" + Math.floor(Math.random()*16777215).toString(16), dataPoints: driver};
        datas = [specs];//datas.concat([specs]);
    }

    var chart = new CanvasJS.Chart("chartContainer",
        {
            title: {
                text: "Daily Trips",
                fontSize: 30
            },
            animationEnabled: true,
            axisX: {
                labelFontSize: 15,
                gridColor: "Silver",
                tickColor: "silver",
                valueFormatString: "DD/MMM"

            },
            toolTip: {
                shared: true
            },
            theme: "theme2",
            axisY: {
                labelFontSize: 15,
                valueFormatString: "#0", //try properties here
                gridColor: "Silver",
                tickColor: "silver"
            },
            data: datas,
            legend: {
                verticalAlign: "center",
                horizontalAlign: "right"
            },

            legend: {
                fontSize: 18    ,
                cursor: "pointer",
                itemclick: function (e) {
                    if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                        e.dataSeries.visible = false;
                    } else {
                        e.dataSeries.visible = true;
                    }
                    chart.render();
                }
            }
        });
    chart.render();
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

function createReport() {

    var from = $('#from').val();
    var to = $('#to').val();

    $('#report_table').DataTable({
        'bPaginate': false,
        'bFilter': false,
        'bInfo': false,
        'ajax': {
            "type": "POST",
            "url": 'createreport',
            "data"   : {from: from, to: to},
            "dataSrc": ""
        },
        "destroy": true,
        'columns': [
            {"data" : "totalTripCounts"},
            {"data" : "totalTripCost"},
            {"data" : "totalTripkm"},
            {"data" : "totalTripTime"},
            {"data" : "totalFuelCost"},
            {"data" : "totalFuelAmount"},
            {"data" : "totalPayments"},
            {"data" : "totalOther"}
        ],
        "footerCallback": function ( row, data, start, end, display ) {
            if(typeof data[0] != 'undefined') {
                //console.log( data[0]);
                var dataPoints = [
                    { y : data[0].totalFuelCost, name : "Total Fuel Costs", legendMarkerType: "triangle"},
                    { y : data[0].totalPayments, name : "Total Payments", legendMarkerType: "triangle"},
                    { y : data[0].totalTripCost, name : "Total Trip Costs", legendMarkerType: "triangle"},
                    { y : data[0].totalOther, name : "Total Other Costs", legendMarkerType: "triangle"}
                ];
                loadPieChart(dataPoints);
            }
        }
    });

    $('input[aria-controls="report_table"]').prop('type', 'text');
}

function loadPieChart(dataPoints) {

    var chart = new CanvasJS.Chart("chartContainer2",
        {
            title:{
                text: "",
                fontFamily: "arial black"
            },
            animationEnabled: true,
            legend: {
                verticalAlign: "bottom",
                horizontalAlign: "center"
            },
            theme: "theme1",
            data: [
                {
                    type: "pie",
                    indexLabelFontFamily: "Garamond",
                    indexLabelFontSize: 20,
                    indexLabelFontWeight: "bold",
                    startAngle:0,
                    indexLabelFontColor: "MistyRose",
                    indexLabelLineColor: "darkgrey",
                    indexLabelPlacement: "inside",
                    toolTipContent: "{name}: {y} MAD",
                    showInLegend: true,
                    indexLabel: "#percent%",
                    dataPoints: dataPoints
                        /*
                        [
                        {  y: 338, name: "Fuel", legendMarkerType: "triangle"},
                        {  y: 418, name: "Trip Cost", legendMarkerType: "square"}
                    ]
                    */
                }
            ]
        });
    chart.render();
}

function getDriverPerformance() {

    var from = $('#from').val();
    var to = $('#to').val();

    if( from != '' && to != '') {
        $('#time_range_span').html(from + ' <i class="fa fa-arrow-right"></i> ' + to);
    }

    $('#driver_performance').DataTable({
        'ajax': {
            "type"   : "POST",
            "url"    : 'getdriverperformance',
            "data"   : {from: from, to: to, page : 'dashboard'},
            "dataSrc": ""
        },
        "destroy": true,
        'columns': [
            {"data" : "driver_name"},
            {"data" : "cars"},
            {"data" : "count"},
            {"data" : "total_km"},
            {"data" : "total_trip_km"},
            {"data" : "total_trip_km_percent"},
            {"data" : "free_ride_km"},
            {"data" : "free_ride_km_percent"},
            {"data" : "total_hours"},
            {"data" : "total_work_hours"},
            {"data" : "total_work_hours_percent"},
            {"data" : "total_free_hours"},
            {"data" : "total_free_hours_percent"},
            {"data" : "hours_per_trip"},
            {"data" : "km_per_trip"},
            {"data" : "receipt"}
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
            totalTripsNumber = api.column( 2, { page: 'current'} ).data().reduce( function (a, b) {return intVal(a) + intVal(b);}, 0 );
            totalKm = api.column( 3, { page: 'current'} ).data().reduce( function (a, b) {return intVal(a) + intVal(b);}, 0 );
            totalTripKM  = api.column( 4, { page: 'current'} ).data().reduce( function (a, b) {return intVal(a) + intVal(b);}, 0 );
            totalTripPer = api.column( 5, { page: 'current'} ).data().reduce( function (a, b) {return intVal(a) + intVal(b);}, 0 );
            totalFreeKM = api.column( 6, { page: 'current'} ).data().reduce( function (a, b) {return intVal(a) + intVal(b);}, 0 );
            totalFreePer = api.column( 7, { page: 'current'} ).data().reduce( function (a, b) {return intVal(a) + intVal(b);}, 0 );
            totalHours = api.column( 8, { page: 'current'} ).data().reduce( function (a, b) {return intVal(a) + intVal(b);}, 0 );
            totalWorkHours = api.column( 9, { page: 'current'} ).data().reduce( function (a, b) {return intVal(a) + intVal(b);}, 0 );
            totalWorkHoursPer = api.column( 10, { page: 'current'} ).data().reduce( function (a, b) {return intVal(a) + intVal(b);}, 0 );
            totalFreeHours = api.column( 11, { page: 'current'} ).data().reduce( function (a, b) {return intVal(a) + intVal(b);}, 0 );
            totalFreeHoursPer = api.column( 12, { page: 'current'} ).data().reduce( function (a, b) {return intVal(a) + intVal(b);}, 0 );
            hourPerTrip = api.column( 13, { page: 'current'} ).data().reduce( function (a, b) {return intVal(a) + intVal(b);}, 0 );
            kmPerTrip = api.column( 14, { page: 'current'} ).data().reduce( function (a, b) {return intVal(a) + intVal(b);}, 0 );
            totalReciept = api.column( 15, { page: 'current'} ).data().reduce( function (a, b) {return intVal(a) + intVal(b);}, 0 );
            

            // Update footer
            $( api.column(2).footer() ).html(totalTripsNumber
                //'$'+pageTotal +' ( $'+ total +' total)'
            );
            $( api.column(3).footer() ).html(totalKm + ' KM'
                //'$'+pageTotal +' ( $'+ total +' total)'
            );
            $( api.column(4).footer() ).html(totalTripKM + ' KM'
                //'$'+pageTotal +' ( $'+ total +' total)'
            );
            $( api.column(5).footer() ).html( totalTripPer + ' %'
                //'$'+pageTotal +' ( $'+ total +' total)'
            );
            $( api.column(6).footer() ).html(totalFreeKM + ' KM'
                //'$'+pageTotal +' ( $'+ total +' total)'
            );
            $( api.column(7).footer() ).html(totalFreePer + ' %'
                //'$'+pageTotal +' ( $'+ total +' total)'
            );
            $( api.column(8).footer() ).html(totalHours
                //'$'+pageTotal +' ( $'+ total +' total)'
            );
            $( api.column(9).footer() ).html(totalWorkHours
                //'$'+pageTotal +' ( $'+ total +' total)'
            );
            $( api.column(10).footer() ).html(totalWorkHoursPer + ' %'
                //'$'+pageTotal +' ( $'+ total +' total)'
            );
            $( api.column(11).footer() ).html(totalFreeHours
                //'$'+pageTotal +' ( $'+ total +' total)'
            );
            $( api.column(12).footer() ).html(totalFreeHoursPer + ' %'
                //'$'+pageTotal +' ( $'+ total +' total)'
            );
            $( api.column(13).footer() ).html(hourPerTrip
                //'$'+pageTotal +' ( $'+ total +' total)'
            );
            $( api.column(14).footer() ).html(kmPerTrip
                //'$'+pageTotal +' ( $'+ total +' total)'
            );
            $( api.column(15).footer() ).html(totalReciept
                //'$'+pageTotal +' ( $'+ total +' total)'
            );
    
        }
        
    });
    $('input[aria-controls="daily_trips"]').prop('type', 'text');

    //$('select[name=daily_trips_length]').addClass('form-control');
}

function getTimeAsSeconds(time){
    var timeArray = time.split(':');
    return Number(timeArray [0]) * 3600 + Number(timeArray [1]) * 60 + Number(timeArray[2]);
}