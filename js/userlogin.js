$(document).ready(function() {


    if ($.cookie("userName")) {
        console.log('user logged in');
        $('#userimage').attr('src', getCookie("userImage"));
        $('#username').html(getCookie("userName"));
    } else {
        window.location.replace("../home/");
        console.log('user did not log in');
        //  $('.login-status').fadeOut();
    }

    $('.logout').on('click', function(e) {
        signOut();
        eraseCookie('userName');
        eraseCookie('userMail');
        eraseCookie('userImage');
        //  $('.login-ui').fadeIn();
        //  $('.login-status').fadeOut();

    });

});
// Get Cookie
function getCookie(key) {
    var keyValue = $.cookie(key);
    return keyValue ? keyValue : null;
}
// Erase Cookie
function eraseCookie(key) {
    var keyValue = getCookie(key);
    setCookie(key, keyValue, '-1');
}
// Set Cookie 
function setCookie(key, value, expiry) {
    var expires = new Date();
    expires.setTime(expires.getTime() + (expiry * 24 * 60 * 60 * 1000));
    document.cookie = key + '=' + value + ';path=/' + ';expires=' + expires.toUTCString();
}
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
        setCookie('userName', profile.getName(), 1);
        setCookie('userMail', profile.getEmail(), 1);
        setCookie('userImage', profile.getImageUrl(), 1);
        // $('.login-ui').fadeOut();
        // $('.login-status').fadeIn();
        $('#userimage').attr('src', profile.getImageUrl());
        $('#username').html(profile.getName());
    }
}

function signOut() {
    // gapi.auth2.init({
    //     client_id: '1082811644666-99350d7ukavs0p44n69830h07m27ur2b.apps.googleusercontent.com'
    // });
    var auth2 = gapi.auth2.getAuthInstance();
    auth2.signOut().then(function() {
        window.location.replace("../login/login_page.php");
        console.log('User signed out.');
    });
}