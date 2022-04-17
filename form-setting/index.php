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
    <style>
       
         .error-image{
             width: 100%;
           height: auto;
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
        <div class="menu-items">
             <a href="../responses/">responses</a>
        </div>
        <div class="menu-items active-menu-bar">
             <a href="../form-setting/">settings</a>
        </div>
        <div class="menu-items">
        <a href="https://wa.me/?text=http://www.aapkaman.in/simliFY/updated/iform/form/" target="_blank">Share</a>
        </div>
    </div>       
    <div class="wrapper">
        <div class="heading">
           <h2 class="form-heading"><?php echo $form_data["FORM_HEADING"]; ?></h2>
           <h4 class="form-heading"><?php echo $form_data["FORM_SUB_HEADING"]; ?></h4>
           
        </div>
        <form id="newForm">
          <img class="error-image" src="../images/work-in-progress.jpeg">
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