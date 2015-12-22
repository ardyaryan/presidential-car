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
            success: function(data) {
                if(data.success) {
                    console.log(data.payload.role);
                    if(data.payload.role == 'admin') {
                        window.location.replace(data.payload.role +'/dashboard');
                    }else if(data.payload.role == 'driver') {
                        window.location.replace(data.payload.role +'/location');
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