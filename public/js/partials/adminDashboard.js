$(document).ready(function(){

    $('.datepicker').datepicker({
        dateFormat: 'yy-mm-dd',
        startDate: '-3d'
    });

    $('form').on('submit', function(e) {
        e.preventDefault();

        if(validate()) {
            $('#graph_loading').show();
            setTimeout(function(){
                getTripsByDriver();
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
    console.log(driver);
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