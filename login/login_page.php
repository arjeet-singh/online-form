<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="google-signin-client_id" content="1082811644666-99350d7ukavs0p44n69830h07m27ur2b.apps.googleusercontent.com">
    <title>Login</title>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://kit.fontawesome.com/480a62ecd0.js" crossorigin="anonymous"></script>
    <script src="https://apis.google.com/js/platform.js" async defer></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
    
    <link rel="stylesheet" href="login-modal-style.css?rel=32">
 
 
<script>
    $(document).ready(function(){
       
        if($.cookie("userName")){
            $('.login-ui').fadeOut();
            console.log('user logged in');
           $('#userimage').attr('src',$.cookie("userImage"));
          
           $('#username').html($.cookie("userName"));
           
        }
        else{
            $('.login-status').fadeOut();
        }
        
      $('.logout').on('click',function(e){
         signOut();
        eraseCookie('userId');
        eraseCookie('userName');
        eraseCookie('userMail');
        eraseCookie('userImage');
        eraseCookie('systemId');
        $('.login-ui').fadeIn();
        $('.login-status').fadeOut();
        
    });
});
</script>
<script>
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
    var clicked = false;
    function activeClick(){
        clicked = true;
    }
      function onSignIn(googleUser) {
          if(clicked){
            console.log('Auto calling Login');
        // Useful data for your client-side scripts:
        var profile = googleUser.getBasicProfile();
        var userId = profile.getId();
        var userName = profile.getName();
        var userImage = profile.getImageUrl();
        var userMail = profile.getEmail();
        console.log("ID: " + profile.getId()); // Don't send this directly to your server!
        console.log('Full Name: ' + profile.getName());
        console.log('Given Name: ' + profile.getGivenName());
        console.log('Family Name: ' + profile.getFamilyName());
        console.log("Image URL: " + profile.getImageUrl());
        console.log("Email: " + profile.getEmail());

        // The ID token you need to pass to your backend:
        var id_token = googleUser.getAuthResponse().id_token;
        console.log("ID Token: " + id_token);
        var userDatalogin = { 'userId':userId,
                             'UserName':userName,
                            'userImage':userImage,
                            'userMail':userMail,
                            'systemId':id_token} ;
        // userDatalogin['userId'] = userId;
        // userDatalogin['UserName'] = userName;
        // userDatalogin['userImage'] = userImage;
        // userDatalogin['userMail'] = userMail;
        console.log(userDatalogin);
        var userdata = JSON.stringify(userDatalogin);
        //console.log('After JSON : '+userdata);
        jQuery.ajax({
                type: "POST",
                url: "../new_form/ajax/google_sign_in.php",
                data: "userDatalogin=" + userdata,
                success: function(result) {

                    console.log(result);
                    var reponse = jQuery.parseJSON(result);
                    console.log(reponse);
                    if(reponse['STATUS'] == 'success'){
                        setCookie('userId', reponse['USER_ID'], 1);
                        setCookie('userName', profile.getName(), 1);
                        setCookie('userMail', profile.getEmail(), 1);
                        setCookie('userImage', profile.getImageUrl(), 1);
                        setCookie('systemId', reponse['SYSTEM_ID'], 1);
                        $('.login-ui').fadeOut();
                        $('.login-status').fadeIn();
                        $('#userimage').attr('src',profile.getImageUrl());
                        $('#username').html(profile.getName());
                    }
                    else{
                        alert('Faild');
                    }
                },
                error: function(errorData) {
                    console.log(errorData);
                }
            });

        }
      }
      function signOut() {
        var auth2 = gapi.auth2.getAuthInstance();
        auth2.signOut().then(function () {
        console.log('User signed out.');
        });
      }
   
    </script>
</head>
<body>
    <div class="login-modal-div">
        <div class="login-div">
            <div class="model-head">
            <p class="noselect delete-btn"><i class="fas fa-times font-awesome-kit"></i></p>
            </div>
            <div class="login-data-modal login-ui">
                <div class="model-title">
                    <p class="modal-title-text">
                        Sign-In
                    </p>
                </div>
                <div class="login-inputs">
                    <form id="loginData">
                        <div class="input-container">
                        <label for="userid">User Id</label>
                        <input id="userid" type="text" name="userid" class="text-input-field" placeholder="User Id" required>
                        </div>
                        <div class="input-container">
                        <label for="password">Password</label>
                        <input id="password" type="password" name="password" class="text-input-field" placeholder="Password" required>
                        </div>
                        <div class="input-container">
                            <input class="submit text-input-field" type="submit" name="login" value="Sign In">
                        </div>
                        <p class="new-user">New User ? <a href="#">Sign-Up</a></p>
                        <div class="sign-up-api">
                           <div class="g-signin2 google-sign-in" onclick="activeClick()" data-onsuccess="onSignIn"></div>
                            <a class="lodin-api-link google-api" href="#">Facebook</a>
                        </div>
                    </form>
                </div>
            </div>
            <div class="login-data-modal login-status">
                <h1>You are logged in</h1>
                <div id="userlogindata" class="user-data">
                    <img id="userimage">
                    <p id="username"></p>
                </div>
                <a class="lodin-api-link logout" href="#">Log-out</a>
            </div>
        </div>
    </div>
</body>
</html>