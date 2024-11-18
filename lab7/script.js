/* global $ */

$(document).ready(function() {

    $('#registerForm').submit(function(event) {
        event.preventDefault();
        const data = $(this).serialize();

        $.ajax({
            type: 'POST',
            url: 'register.php',
            data: data,
            dataType: 'json',
            success: function(response) {
                console.log(response)
                $('#registerMessage').text(response.message);
                if (response.success) {
                    window.location.href = 'profile.php';
                }
            },
            error: function() {
                $('#registerMessage').text("Помилка при реєстрації.");
            }
        });
    });


    $('#loginForm').submit(function(event) {
        event.preventDefault();
        const data = $(this).serialize();

        $.ajax({
            type: 'POST',
            url: 'login.php',
            data: data,
            dataType: 'json',
            success: function(response) {
                $('#loginMessage').text(response.message);
                if (response.success) {
                    window.location.href = 'profile.php';
                }
            },
            error: function() {
                $('#loginMessage').text("Помилка при вході.");
            }
        });
    });
});
