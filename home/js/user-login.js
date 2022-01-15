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
                    alert('Faild');
                }
            },
            error: function(errorData) {
                console.log(errorData);
            }
        });
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