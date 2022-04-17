$(document).ready(function() {
    $('#loginData').on('submit', function() {
        var userId = $('#userid').val();
        var password = $('#password').val();
        var user_data = { 'userId': userId, 'password': password };
        user_data = JSON.stringify(user_data);
        jQuery.ajax({
            type: "POST",
            url: "../new_form/ajax/google_sign_in.php",
            data: "userDataId=" + user_data,
            success: function(result) {

                console.log(result);
                var reponse = jQuery.parseJSON(result);
                console.log(reponse);
                if (reponse['STATUS'] == 'success') {
                    setCookie('userId', reponse['USER_ID'], 1);
                    setCookie('userName', reponse['USER_NAME'], 1);
                    setCookie('userMail', userId, 1);
                    setCookie('userImage', reponse['USER_IMAGE'], 1);
                    setCookie('systemId', reponse['SYSTEM_ID'], 1);
                    $('.login-modal-div').fadeOut();
                    $('.model-title').fadeOut();
                    $('.signed-in-user').fadeIn();
                    $('.userimage').attr('src', reponse['USER_IMAGE']);
                    $('.username').html(reponse['USER_NAME']);
                } else {
                    // alert('Faild');
                    $('.signin-error').html(reponse.message);

                }
            },
            error: function(errorData) {
                console.log(errorData);
            }
        });
        return false;
    });
    $('#signUpData').on('submit', function() {
       function validEmail(userSignUp){
            var emailURL = "http://apilayer.net/api/check?access_key=c5118f1f9827f42a5fc4b231932130a8&email="+$('#newuserid').val()+"&smtp=1&format=1";
            jQuery.ajax({
                type: "GET",
                url: emailURL,
                dataType: "json",
                success: function(result) {
                    if(result?.format_valid){
                       userSignUp()
                    }
                    else{
                   $('.signup-error').html("Invalid email");
                    }
                    
                },
                error: function(errorData) {
                    // console.log(errorData);
                   $('.signup-error').html("Invalid email");
                }
            });
       }
       $('#newpassword').prop('type','password');

       validEmail(userSignUp);
        return false;
    });
    $(document)
        .ajaxStart(function() {
            $('#AjaxLoader').show();
        })
        .ajaxStop(function() {
            $('#AjaxLoader').hide();
        });
});

function userSignUp(){
    var userName = $('#newUserName').val();
    var userId = $('#newuserid').val();
    var password = $('#newpassword').val();
    var user_data = { 'UserName': userName, 'userMail': userId, 'userId': userId, 'password': password, 'userImage': '' };
    user_data = JSON.stringify(user_data);
    jQuery.ajax({
        type: "POST",
        url: "../new_form/ajax/google_sign_in.php",
        data: "userSignUp=" + user_data,
        success: function(result) {

            // console.log(result);
            var reponse = jQuery.parseJSON(result);
            if (reponse['STATUS'] == 'success') {
                setCookie('userId', reponse['USER_ID'], 1);
                setCookie('userName', reponse['USER_NAME'], 1);
                setCookie('userMail', userId, 1);
                setCookie('userImage', reponse['USER_IMAGE'], 1);
                setCookie('systemId', reponse['SYSTEM_ID'], 1);
                $('.login-modal-div').fadeOut();
                $('.model-title').fadeOut();
                $('.signed-in-user').fadeIn();
                $('.userimage').attr('src', reponse['USER_IMAGE']);
                $('.username').html(reponse['USER_NAME']);
            } 
            else {
                $('.signup-error').html(reponse.message);
            }
        },
        error: function(errorData) {
            console.log(errorData);
        }
    });
}
