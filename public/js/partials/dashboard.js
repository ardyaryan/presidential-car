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
                renderChart();
            }, 500);
        }
    });

    $('#from').on('change', function(){
        $('#from').css('background-color', 'white');
    });
    $('#to').on('change', function(){
        $('#to').css('background-color', 'white');
    });

    renderChart();


});

var drivers = function getTripsByDriver() {

    var from = $('#from').val();
    var to = $('#to').val();

    if( from != '' && to != '') {
        $('#time_range_span').html(from + ' <i class="fa fa-arrow-right"></i> ' + to);
    }

    var result = '';

    $.ajax({
        url : "gettripsbydriver",
        type: "POST",
        async: false,
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
            $('#graph_loading').hide();
        },
        error: function (data) {
            console.log(data);
        }
    });
    return result;
};


function renderChart() {
    var datas = [];
    //var driver = drivers();
    var driver = [

        { x: new Date(2010,0,3), y: 650 },
        { x: new Date(2010,0,5), y: 700 },
        { x: new Date(2010,0,7), y: 710 },
        { x: new Date(2010,0,9), y: 658 },
        { x: new Date(2010,0,11), y: 734 },
        { x: new Date(2010,0,13), y: 963 },
        { x: new Date(2010,0,15), y: 847 },
        { x: new Date(2010,0,17), y: 853 },
        { x: new Date(2010,0,19), y: 869 },
        { x: new Date(2010,0,21), y: 943 },
        { x: new Date(2010,0,23), y: 970 }
    ];
    for(var i = 0; i < driver.length ; i ++) {

        var specs ={ type: "line",showInLegend: true,lineThickness: 1, name: "Trips", markerType: "square", color: "#"+Math.floor(Math.random()*16777215).toString(16), dataPoints: driver};
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
                //valueFormatString: "#0", //try properties here
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