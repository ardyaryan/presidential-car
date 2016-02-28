$(document).ready(function(){

    $('form').on('submit', function(e) {
        e.preventDefault();
        var email = $('#email').val();
        var password = $('#password').val();
        $.ajax({
            url : "admin/login",
            type: "POST",
            data : {
                email:email,
                password: password
            },
            beforeSend: function(){
                $('#login_icon').removeClass();
                $('#login_icon').addClass('fa fa-spinner fa-spin');
            },
            success: function(data) {
                if(data.success) {
                    console.log(data.payload.role);
                    if(data.payload.role == 'admin') {
                        location.replace(data.payload.role +'/dashboard');
                    }else if(data.payload.role == 'driver') {
                        location.replace(data.payload.role +'/newtrip');
                    }
                }else {
                    window.location.replace('');
                }

            },
            error: function (data) {
                console.log(data);
            }
        });
    });


});