<?php
  
  include'../connection/connection.php';
  if(isset($_COOKIE['userName'])) {
    $userMail = $_COOKIE["userId"];
    $systemId = $_COOKIE["systemId"];
    $userdatab = mysqli_fetch_assoc($conn->query("SELECT * FROM IFORM_USER WHERE USER_ID ='$userMail'"));
    if($userdatab["SYSTEM_ID"] == $systemId){
       // echo "<script> alert('Matched'); </script>";
    }
    else{
        //echo "<script> alert('".$userMail."Not Matched ".$userdatab["SYSTEM_ID"]."');  </script>";
    }
 }
 else{
   // echo "<script> alert('Not Matched 2'); </script>"; 
 }
    $form_id = $_GET["id"];
    //    error_log(print_r($form_id));
    $form_data = mysqli_fetch_assoc($conn->query("SELECT * FROM IFORM_FORM_DATA WHERE FORM_ID = '$form_id'"));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="google-signin-client_id" content="1082811644666-99350d7ukavs0p44n69830h07m27ur2b.apps.googleusercontent.com">
    <title>From</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://kit.fontawesome.com/480a62ecd0.js" crossorigin="anonymous"></script>
    <script src="https://apis.google.com/js/platform.js" async defer></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
    <link rel="stylesheet" href="css/form_style.css?t=32">
    <link rel="stylesheet" href="../css/page_head.css?t=34">
    <link rel="stylesheet" href="../css/form-menu-bar.css?s=24">
    <script src="js/form_main.js"></script>
    <script src="js/valid_user_js.js"></script>
    <script> 
    let form_id =  '<?php echo $form_id; ?>';
    </script>
    <script src="../js/form-menu-bar.js"> </script>
    <script>
              function signOut() {
        var auth2 = gapi.auth2.getAuthInstance();
        auth2.signOut().then(function () {
        console.log('User signed out.');
        });
      }
      $('.log-out-btn').on('click', function(e) {
        signOut();
    });
    </script>
    </script>
    <style>
        .hold{
              border: solid red 4px;
        }
        .hide{
            display: none;
         }
         .drop-box{
             width: 100%;
             margin: 10px 0px;
             padding: 20px 0px;
             border: 1px dashed red;
         }
         .response-head, .response-data{
             padding: 15px;
         }
         .response-table{
             width: 100%;
         }
         tr,th,td{
             border-collapse: collapse;
         }
         tr{
             border-bottom: 1px solid teal;
             
         }
         th, td{
             padding: 10px;
             text-align: center;
             border-bottom: 1px solid teal;
         }
    </style>
</head>


<body>
   <?php include'../pages/page_head.html'; ?>
   <!-- <div class="form-setting-block">
         <div class="status">
             <p id="formStatus">Saved</p>
         </div>
     </div> -->
     <div class="menu-btn-container">
     <div class="menu-sub-btn">
         <p><i class="fas menu-btn-sub-bar fa-caret-down"></i></p>
         </div>
     </div>
     <div class="form-menu-bar">
     <div class="menu-items">
             <a href="../new_form/saved_form.php">home</a>
        </div>
         <div class="menu-items">
             <a href="../saved-from/">form</a>
        </div>
        <div class="menu-items">
             <a href="../form/form-view.php">view</a>
        </div>
        <div class="menu-items active-menu-bar">
             <a href="../responses/">responses</a>
        </div>
        <div class="menu-items">
             <a href="../form-setting/">settings</a>
        </div>
        <div class="menu-items">
        <a href="https://wa.me/?text=http://www.aapkaman.in/simliFY/iform/form/" target="_blank">Share</a>
        </div>
    </div>       
    <div class="wrapper">
        <div class="heading">
           <h2 class="form-heading"><?php echo $form_data["FORM_HEADING"]; ?></h2>
           <h4 class="form-heading"><?php echo $form_data["FORM_SUB_HEADING"]; ?></h4>
           
        </div>
        <?php 
          $responses = mysqli_fetch_assoc($conn->query("SELECT COUNT(RESPONSE_ID) FROM IFORM_RESPONSES WHERE FORM_ID = '$form_id' GROUP BY FORM_ID"));
          $response_data = $conn->query("SELECT * FROM IFORM_RESPONSES WHERE FORM_ID = '$form_id' ORDER BY RESPONSE_DATE DESC");
        //   $response_data = $conn->query("SELECT IFORM_RESPONSES.RESPONSE_ID,IFORM_RESPONSES.RESPONSE_DATE,IFORM_USER.USER_ID,IFORM_USER.USER_NAME FROM IFORM_RESPONSES,IFORM_USER WHERE IFORM_RESPONSES.FORM_ID = '$form_id' && IFORM_RESPONSES.USER_ID = IFORM_USER.USER_ID");
        //   $form_data = mysqli_fetch_assoc($conn->query("SELECT * FROM IFORM_FORM_DATA WHERE FORM_ID = '$form_id'"));
        ?>
        <form id="newForm">
          <div class="response-block">
              <div class="response-head">
              <h2><?php if($responses["COUNT(RESPONSE_ID)"]){ echo $responses["COUNT(RESPONSE_ID)"]; } else{ echo 0; }?> responses</h2>
              </div>
              <div class="response-data">
                  <table class="response-table">
                      <tr><th>SN</th><th>Name</th><th>Time</th></tr>
                    <?php $c=1;
                       while($r_data = $response_data->fetch_assoc()){
                           $userId = $r_data["USER_ID"];
                           $user_data = mysqli_fetch_assoc($conn->query("SELECT * FROM IFORM_USER WHERE USER_ID = '$userId'"));
                          ?>    
                        <tr><td><a href="response-data.php?id=<?php echo $r_data["RESPONSE_ID"]; ?>"><?php echo $c; ?></a></td><td><a href="response-data.php?id=<?php echo $r_data["RESPONSE_ID"]; ?>"><?php echo $user_data["USER_NAME"]; ?></a></td><td><?php echo $r_data["RESPONSE_DATE"]; ?></td></tr>
                     <?php $c++; }
                    ?>
                    </table>
              </div>
          </div>
            
               
        </form>
    </div>

  <div class="form-tool-section">
      <div class="tools-container">
          <a href="../new_form/"><p class="addNewQuestion event-btn noselect">New Form <i class="fas fa-plus"></i></p></a>
      </div>
  </div>
</body>
<script src="../js/userlogin.js"></script>
</html>