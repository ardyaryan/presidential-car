$(document).ready(function(){

    $('form').on('submit', function(e) {

        var form = $(this);
        e.preventDefault();
        if(validate()) {
            $.ajax({
                url : "newtrip",
                type: "POST",
                data : form.serialize(),
                beforeSend: function(){
                    $('#submit').html('<span class="fa fa-spinner fa-spin"></span> Submit');
                },
                success: function(data) {
                    //window.location.replace('admin/trips');
                    $('#submit').html('<span class="fa fa-check"></span> Submit');
                },
                error: function (data) {
                    console.log(data);
                }
            });
        }
    });

    $('#client_name').on('keyup', function(){
        $('#client_name').css('background-color', 'white');
    });
    $('#departure_address').on('keyup', function(){
        $('#departure_address').css('background-color', 'white');
    });
    $('#arrival_address').on('keyup', function(){
        $('#arrival_address').css('background-color', 'white');
    });
    $('#price_per_trip').on('keyup', function(){
        $('#price_per_trip').css('background-color', 'white');
    });

});

function validate() {
    if($('#client_name').val() == '') {
        $('#client_name').css('background-color', '#FFB0A2');
        return false;
    }else if($('#departure_address').val() == '') {
        $('#departure_address').css('background-color', '#FFB0A2');
        return false;
    }else if($('#arrival_address').val() == '') {
        $('#arrival_address').css('background-color', '#FFB0A2');
        return false;
    }else if($('#price_per_trip').val() == '') {
        $('#price_per_trip').css('background-color', '#FFB0A2');
        return false;
    }else {
        return true;
    }
}