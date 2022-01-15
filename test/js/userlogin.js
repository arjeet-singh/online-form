$(document).ready(function() {
    if ($.cookie("userName")) {
        $('.login-ui').fadeOut();
        console.log('user logged in');
        //    console.log($.cookie("userName"););
        //    console.log($.cookie("userMail"););
        //    console.log($.cookie("userImage"););

        $('#userimage').attr('src', $.cookie("userImage"));
        $('#username').html($.cookie("userName"));
    } else {
        //  $('.login-status').fadeOut();
    }

    $('.logout').on('click', function(e) {
        signOut();
        $.removeCookie("userName");
        $.removeCookie("userMail");
        $.removeCookie("userImage");
        //  $('.login-ui').fadeIn();
        //  $('.login-status').fadeOut();

    });
});


clicked = false;

function activeClick() {
    clicked = true;
}

function onSignIn(googleUser) {
    if (clicked) {
        console.log('Auto calling Login');
        // Useful data for your client-side scripts:
        var profile = googleUser.getBasicProfile();
        console.log("ID: " + profile.getId()); // Don't send this directly to your server!
        console.log('Full Name: ' + profile.getName());
        console.log('Given Name: ' + profile.getGivenName());
        console.log('Family Name: ' + profile.getFamilyName());
        console.log("Image URL: " + profile.getImageUrl());
        console.log("Email: " + profile.getEmail());

        // The ID token you need to pass to your backend:
        var id_token = googleUser.getAuthResponse().id_token;
        console.log("ID Token: " + id_token);
        $.cookie("userName", profile.getName(), { expires: 10 });
        $.cookie("userMail", profile.getEmail(), { expires: 10 });
        $.cookie("userImage", profile.getImageUrl(), { expires: 10 });
        // $('.login-ui').fadeOut();
        // $('.login-status').fadeIn();
        $('#userimage').attr('src', profile.getImageUrl());
        $('#username').html(profile.getName());
    }
}

function signOut() {
    var auth2 = gapi.auth2.getAuthInstance();
    auth2.signOut().then(function() {
        console.log('User signed out.');
    });
}