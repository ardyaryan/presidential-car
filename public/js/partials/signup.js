$(document).ready(function(){

    $('form').on('submit', function(e) {

        var form = $(this);
        e.preventDefault();
        if(validate() && checkPasswords()) {
            $.ajax({
                url : "admin/newuser",
                type: "POST",
                data : form.serialize(),
                beforeSend: function(){
                    $('#submit').html('<span class="fa fa-spinner fa-spin"></span> Submit');
                },
                success: function(data) {

                    if(data.success == false) {
                        $('#submit').html('<span class="fa fa-remove"></span> Submit');
                        $('#message').append(data.message + '<br/>');
                        $('#message').show();
                    }else {
                        $('#message').html(data.message);
                        $('#submit').html('<span class="fa fa-check"></span> Submit');
                        $('#message').show();
                    }
                },
                error: function (data) {
                    console.log(data);
                }
            });
        }else {
            console.log('failed validation')
        }
    });

    $('#first').on('keyup', function(){
        $('#first').css('background-color', 'white');
    });
    $('#last').on('keyup', function(){
        $('#last').css('background-color', 'white');
    });
    $('#email').on('keyup', function(){
        $('#email').css('background-color', 'white');
    });
    $('#password').on('keyup', function(){
        $('#password').css('background-color', 'white');
    });
    $('#password_2').on('keyup', function(){
        $('#password_2').css('background-color', 'white');
    });

    $('#role_id').on('change', function(){
        if($('#role_id').val() == 2 ) {
            $('#driver_code_div').fadeIn();
            $('#gsm_div').fadeIn();
        }else {
            $('#driver_code_div').fadeOut();
            $('#gsm_div').fadeOut();
        }
    });
});

function validate() {
    if($('#email').val() == '') {
        $('#email').css('background-color', '#FFB0A2');
        return false;
    }else if($('#first').val() == '') {
        $('#first').css('background-color', '#FFB0A2');
        return false;
    }else if($('#last').val() == '') {
        $('#last').css('background-color', '#FFB0A2');
        return false;
    }else if($('#password').val() == '') {
        $('#password').css('background-color', '#FFB0A2');
        return false;
    }else if($('#password_2').val() == '') {
        $('#password_2').css('background-color', '#FFB0A2');
        return false;
    }else {
        return true;
    }
}

function checkPasswords() {

    if($('#password_2').val() != $('#password').val()) {
        $('#password').css('background-color', '#FFDF00');
        $('#password_2').css('background-color', '#FFDF00');
        return false;
    }else {
        return true;
    }
}