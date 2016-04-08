$(document).ready(function () {

    $('#send').on('click', function() {
        sendEmail();
        //setTimeout(function(){ location.reload()}, 4000);
        $('#send').attr('disabled', true);
    });


});


function sendEmail() {
    var buttonName = ' Send'
    var email   = $('#email').val();
    var phone   = $('#phone').val();
    var message = $('#text_message').val();

    $.ajax({
        url : "sendemail",
        type: "POST",
        data : {
                email: email,
                phone: phone,
                message: message
        },
        beforeSend: function(){
            $('#send').html('<span class="fa fa-spinner fa-spin"></span>' + buttonName + '');
        },
        success: function(data) {

            if(data.success == false) {
                $('#send').html('<span class="fa fa-remove"></span>' + buttonName + '');
                $('#alert').addClass('alert alert-danger');
                $('#alert').html('there was an error');
                $('#alert').show();
            }else {
                $('#send').html('<span class="fa fa-check-square"></span>' + buttonName + '');
                $('#alert').addClass('alert alert-success');
                $('#alert').html('message/ email sent successfully');
                $('#alert').show();
            }

        },
        error: function (data) {
            console.log(data);
        }
    });
}
