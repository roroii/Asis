$(document).ready(function() {

    See_Password();

});


function See_Password(){

    let password = document.getElementById("password");
    let password_confirm = document.getElementById("password-confirm");

    $('body').on('click', '.see_password', function(){

        password.type = "password";

        $(this).hide();
        $('.un_see_password').show();

    });

    $('body').on('click', '.un_see_password', function(){

        password.type = "text";

        $(this).hide();
        $('.see_password').show();

    });


    $('body').on('click', '.see_password_confirm', function(){

        password_confirm.type = "password";

        $(this).hide();
        $('.un_see_password_confirm').show();

    });

    $('body').on('click', '.un_see_password_confirm', function(){

        password_confirm.type = "text";

        $(this).hide();
        $('.see_password_confirm').show();

    });

}


