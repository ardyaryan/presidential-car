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
                window.location.replace('admin/viewtrips');
            },
            error: function (data) {
                console.log(data);
            }
        });
    });


});